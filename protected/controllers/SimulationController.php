<?php

class SimulationController extends Controller
{
    //Is Simulation in Debugmode?
    private $debug = false;
    private $ajaxBackgroundSimulation = true;

    public function actionUpload()
    {
        Yii::beginProfile('Upload JSON');
        $model = new File;
        if (isset($_POST['File'])) {

            $model->attributes = $_POST['File'];
            $model->inputFile = CUploadedFile::getInstance($model, 'inputFile');
            if ($model->validate()) {
                $plain_path = realpath(Yii::app()->request->baseUrl . 'sim_data');
                $path = $plain_path . '/' . 'simulation_input_data_group_' . Yii::app()->user->getChoosedGroup() . '.txt';
                $model->inputFile->saveAs($path);
                $content = file_get_contents($path);
                unlink($path);
                $decoded_content = json_decode(utf8_encode($content), true);

                $errorcode = json_last_error();
                switch ($errorcode) {
                    case JSON_ERROR_DEPTH:
                        Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Maximum stack depth exceeded'));
                        $this->render('upload', array('model' => $model));
                        return;
                        break;
                    case JSON_ERROR_CTRL_CHAR:
                        Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Unexcepted control character found in your JSON'));
                        $this->render('upload', array('model' => $model));
                        return;
                        break;
                    case JSON_ERROR_SYNTAX:
                        Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Syntax error, your JSON is invalid'));
                        $this->render('upload', array('model' => $model));
                        return;
                        break;
                    case JSON_ERROR_UTF8:
                        Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'UTF-8 encoding error in your JSON'));
                        $this->render('upload', array('model' => $model));
                        return;
                        break;
                    case JSON_ERROR_STATE_MISMATCH:
                        Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Error in JSON. State mismatch'));
                        $this->render('upload', array('model' => $model));
                        return;
                        break;
                    case JSON_ERROR_NONE:
                        break;
                }
                if ($errorcode > 0) {
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Unknown JSON error'));
                    $this->render('upload', array('model' => $model));
                    return;
                }


                if ($decoded_content['type'] == 'simulation_input_data') {

                    $orders = array();

                    foreach ($decoded_content['orders'] as $decoded_order) {


                        $order = new Order();
                        $order->amount = $decoded_order['amount'];
                        $order->order_type = $decoded_order['order_type'];
                        $order->cd_product_id = $decoded_order['product_number'];
                        $orders[] = $order;
                    }

                    $errors = Yii::app()->order->newOrderInput($orders);

                    if (!empty($errors)) {
                        foreach ($errors as $error) {
                            foreach ($error as $e) {
                                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', $e));
                            }

                        }
                    }

                    $productionOrders = array();

                    foreach ($decoded_content['production_orders'] as $decoded_production_order) {
                        $productionOrder = new ProductionOrder();
                        $productionOrder->cd_product_id = $decoded_production_order['product_number'];
                        $productionOrder->amount = $decoded_production_order['amount'];
                        $productionOrders[] = $productionOrder;

                    }

                    $errors = Yii::app()->productionOrder->newProductionOrderInput($productionOrders);

                    if (!empty($errors)) {
                        foreach ($errors as $error) {
                            foreach ($error as $e) {
                                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', $e));
                            }

                        }
                    }

                    $shiftSchedulings = array();

                    foreach ($decoded_content['shift_schedulings'] as $decoded_shift_scheduling) {


                        $shiftScheduling = new ShiftScheduling();

                        $shiftScheduling->shift_amount = $decoded_shift_scheduling['shift_amount'];
                        $shiftScheduling->overtime = $decoded_shift_scheduling['overtime'];
                        $machine = CdMachine::model()->findByAttributes(array('ident' => $decoded_shift_scheduling['machine_ident'], 'cd_gameset_id' => Yii::app()->user->GameSet));
                        if (!empty($machine)) {

                            $shiftScheduling->cd_machine_id = $machine->id;
                        } else {
                            $shiftScheduling->cd_machine_id = $decoded_shift_scheduling['machine_ident'];
                        }


                        $shiftSchedulings[] = $shiftScheduling;
                    }

                    $errors = Yii::app()->shiftScheduling->newShiftSchedulingInput($shiftSchedulings);

                    if (!empty($errors)) {
                        foreach ($errors as $error) {
                            foreach ($error as $e) {
                                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', $e));
                            }

                        }
                    }


                } else {
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'No simluation input data found!'));
                }

                if (empty($errors)) {
                    $this->redirect(array('simulation/ajaxsimulate'));
                }
            }
        }
        Yii::endProfile('Upload JSON');
        $this->render('upload', array('model' => $model));
    }

    public function actionDownload()
    {
        Yii::beginProfile('Download JSON');
        $simulationOutput = array();

        // Grunddaten setzen
        $simulationOutput['game'] = Yii::app()->user->ChoosedGame;
        $simulationOutput['group'] = Yii::app()->user->ChoosedGroup;
        $simulationOutput['period'] = Yii::app()->user->ChoosedPeriod;


        // Lagerdaten für JSON-Output berechnen &  setzen
        $startStock = Stock::model()->findAllByAttributes(array('group_id' => Yii::app()->user->ChoosedGroup, 'period' => '0'));
        $stock = Stock::model()->findAllByAttributes(array('group_id' => Yii::app()->user->ChoosedGroup, 'period' => Yii::app()->user->ChoosedPeriod));
        $totalStockValue = Yii::app()->db->createCommand("SELECT SUM(price*amount) as 'sum' FROM stocks WHERE group_id=" . Yii::app()->user->ChoosedGroup . " and period=" . Yii::app()->user->ChoosedPeriod)->queryScalar();

        for ($i = 0; $i <= count($stock) - 1; $i++) {
            $product = CdProduct::model()->findByPk($stock[$i]->cd_product_id);
            $outputStock = array();
            if (!empty($product)) {
                $outputStock['product_number'] = $product->number;
            }
            $outputStock['amount'] = $stock[$i]->amount;
            $outputStock['start_amount'] = $startStock[$i]->amount;

            if ($startStock[$i]->amount == 0) {
                $change_rate = 0;
            } else {
                $change_rate = $stock[$i]->amount / $startStock[$i]->amount / 100;
            }

            $outputStock['change_rate'] = $change_rate;
            $outputStock['price'] = $stock[$i]->price;
            $outputStock['stock_value'] = $stock[$i]->amount * $stock[$i]->price;


            $simulationOutput['stock'][$i] = $outputStock;
        }

        $simulationOutput['total_stock_value'] = $totalStockValue;


        // Eingetroffene Bestellungen setzen
        $ao = Order::model()->findAllByAttributes(array('group_id' => Yii::app()->user->ChoosedGroup, 'delivery_period' => Yii::app()->user->ChoosedPeriod, 'delivered' => 1));

        for ($i = 0; $i <= count($ao) - 1; $i++) {

            $product = CdProduct::model()->findByPk($ao[$i]->cd_product_id);

            $arrived_order['order_period'] = $ao[$i]->order_period;
            $arrived_order['order_type'] = $ao[$i]->order_type;
            $arrived_order['product_number'] = $product->number;
            $arrived_order['amount'] = $ao[$i]->amount;
            $arrived_order['delivery_time'] = $ao[$i]->calculated_delivery_time * 1440;
            $arrived_order['material_costs'] = $ao[$i]->total_price;
            $arrived_order['delivery_costs'] = $ao[$i]->delivery_costs;
            $arrived_order['entire_costs'] = $ao[$i]->end_price;
            $arrived_order['piece_costs'] = $ao[$i]->unit_price;

            $simulationOutput['arrived_orders'][$i] = $arrived_order;
        }


        // Ausstehende Bestellungen setzen
        $oo = Order::model()->findAllByAttributes(array('group_id' => Yii::app()->user->ChoosedGroup, 'delivered' => 0));

        for ($i = 0; $i <= count($oo) - 1; $i++) {

            $product = CdProduct::model()->findByPk($oo[$i]->cd_product_id);

            $outstanding_order['order_period'] = $oo[$i]->order_period;
            $outstanding_order['order_type'] = $oo[$i]->order_type;
            $outstanding_order['product_number'] = $product->number;
            $outstanding_order['amount'] = $oo[$i]->amount;

            $simulationOutput['outstanding_orders'][$i] = $outstanding_order;
        }

        // Idle-Time setzen

        $idle_times = SimMachineData::model()->findAllByAttributes(array('group_id' => Yii::app()->user->ChoosedGroup, 'period' => Yii::app()->user->ChoosedPeriod));

        for ($i = 0; $i <= count($idle_times) - 1; $i++) {
            $idle_time['idle_time_shift_1'] = $idle_times[$i]->idle_time_shift_1;
            $idle_time['idle_time_shift_2'] = $idle_times[$i]->idle_time_shift_2;
            $idle_time['idle_time_shift_3'] = $idle_times[$i]->idle_time_shift_3;
            $idle_time['total_idle_time_shift'] = $idle_times[$i]->idle_time_shift_1 + $idle_times[$i]->idle_time_shift_2 + $idle_times[$i]->idle_time_shift_3;
        }

        // Fehlende Arbeitszeit pro Maschine setzen

        // Fehlendes Material pro Maschine setzen

        // Ausstehende Fertigungsaufträge setzen

        // Fertiggestellte Fertigungsaufträge setzen

        /*
                $command = Yii::app()->db->createCommand();
                $command->select('DISTINCT(production_order_id)');
                $command->from('sim_production_orders');
                $command->where('group_id=:group_id and finish_period=:finish_period', array(':group_id' => Yii::app()->user->ChoosedGroup, 'finish_period' => Yii::app()->user->ChoosedPeriod));
                $distinct_simpo = $command->queryAll();
        */

        $command = Yii::app()->db->createCommand();
        $command->select('*');
        $command->from('production_orders');
        $command->where('id in (SELECT Distinct(production_order_id) FROM sim_production_orders where group_id=:group_id and finish_period=:finish_period) or order_period=:order_period and group_id=:group_id', array('group_id' => Yii::app()->user->ChoosedGroup, 'finish_period' => Yii::app()->user->ChoosedPeriod, 'order_period' => Yii::app()->user->ChoosedPeriod));
        $po = $command->queryAll();


        for ($i = 0; $i <= count($po) - 1; $i++) {

            $product = CdProduct::model()->findByPk($po[$i]['cd_product_id']);

            $sim_po = SimProductionOrder::model()->findAllByAttributes(array('production_order_id' => $po[$i]['id']));

            $cycle_time = 0;
            $set_up_time = 0;
            $costs = 0;

            for ($f = 0; $f <= count($sim_po) - 1; $f++) {

                /*
                                $sim_od = SimOperatingData::model()->findAllByAttributes(array('sim_production_order_id' => $sim_po[$f]->id));


                                for ($x = 0; $x <= count($sim_od) - 1; $x++) {

                                    $operating_data['simtime_start'] = $sim_od[$x]->simtime_start;
                                    $operating_data['simtime_end'] = $sim_od[$x]->simtime_end;
                                    $operating_data['day'] = $sim_od[$x]->day;
                                    $operating_data['day_start'] = $sim_od[$x]->day_start;
                                    $operating_data['day_end'] = $sim_od[$x]->day_end;
                                    $operating_data['shift'] = $sim_od[$x]->shift;
                                    $operating_data['shift_costs'] = $sim_od[$x]->shift_costs;
                                    $operating_data['machine_costs'] = $sim_od[$x]->machine_costs;
                                    $operating_data['costs'] = $sim_od[$x]->costs;

                                    $simulationOutput['output_production_order'][$i]['output_batch'][$f]['operating_data'][$x] = $operating_data;
                                }

                                $machine = CdMachine::model()->findByAttributes(array('id' => $sim_po[$f]->cd_machine_id));

                                $output_batch['machine_ident'] = $machine->ident;
                                $output_batch['machine_description'] = $machine->description;
                 */
                $output_batch['amount'] = $sim_po[$f]->amount;
                $output_batch['cycle_time'] = $sim_po[$f]->cycle_time;
                $output_batch['elapsed_cycle_time'] = $sim_po[$f]->elapsed_cycle_time;
                $output_batch['set_up_time'] = $sim_po[$f]->set_up_time;
                $output_batch['costs'] = $sim_po[$f]->costs;
                $output_batch['production_number'] = $sim_po[$f]->production_number;

                $cycle_time += $output_batch['cycle_time'];
                $set_up_time += $output_batch['set_up_time'];
                $costs += $output_batch['costs'];

                $simulationOutput['output_production_order'][$i]['output_batch'][$f] = $output_batch;
            }

            $output_production_order['order_period'] = $po[$i]['order_period'];
            $output_production_order['production_number'] = $po[$i]['order_number'];
            $output_production_order['product_number'] = $product['number'];
            $output_production_order['amount'] = $po[$i]['amount'];
            $output_production_order['cycle_time'] = $cycle_time;
            $output_production_order['set_up_time'] = $set_up_time;
            $output_production_order['costs'] = $costs;
            $output_production_order['average_unit_costs'] = $output_production_order['costs'] / $output_production_order['amount'];


            $simulationOutput['output_production_order'][$i] = $output_production_order;
        }

        // Verkäufe setzen


        // Betriebsergebnis setzen


        echo "<pre>";
        echo json_encode($simulationOutput, JSON_PRETTY_PRINT);
        echo " </pre > ";
        Yii::endProfile('Download JSON');
    }

    public function actionAjaxsimulate()
    {
        if ($this->ajaxBackgroundSimulation == false) {
            $this->redirect(array('simulation/simulate'));
        } else {
            $this->layout = 'simulation';
            $this->render('ajaxsimulate');
        }
    }

    public function actionSimprogress($group_id)
    {
        $text = 'width:';
        $currentPeriod = Yii::app()->db->createCommand()->select('max(period)')->from('sim_debug_logs')->where('group_id=:group_id', array(':group_id' => $group_id))->queryScalar();
        $currentSimTime = Yii::app()->db->createCommand()->select('max(simtime)')->from('sim_debug_logs')->where('group_id=:group_id and period=:period', array(':group_id' => $group_id, ':period' => $currentPeriod))->queryScalar();
        if (SimPeriodStatus::getIsInSimulation(Yii::app()->user->getChoosedGroup())) {
            $text .= floor($currentSimTime / 72);
        } else $text .= 100;

        $text .= '%';
        echo $text;
    }

    public function actionSimstatus($layout = false)
    {
        $group = Group::model()->findByPk(Yii::app()->user->getChoosedGroup());
        $period_status = SimPeriodStatus::getCurrentPeriodSet($group->id);

        $maxperiod = SimLog::model()->findByAttributes(array('group_id' => $group->id), array('order' => 'period desc', 'limit' => 1));

        if ($layout == false) {
            $this->layout = 'none';
        }
        $logs = SimLog::model()->findAllByAttributes(array('group_id' => $group->id, 'period' => $period_status->period));
        $ready_log = SimLog::model()->findByAttributes(array('group_id' => $group->id, 'period' => $maxperiod->period, 'log_id' => 'sim_ready', 'status' => '1'));
        if (empty($ready_log)) {
            $ready = false;
        } else $ready = true;
        echo $this->render('simstatus', array('logs' => $logs, 'ready' => $ready, 'group_id' => $group->id, 'period' => $period_status->period, 'layout' => $layout));
    }


    public function actionSimulate()
    {

        Yii::beginProfile('1. Simulation starten - Periode prüfen - Simulationsstatus setzen');
        //Da wir jetzt simulieren und nicht wollen, dass die Simulation durch schließen des Browsers abbricht
        //müssen wir das PHP mitteilen
        ignore_user_abort(true);

        global $group;
        $group = Group::model()->findByPk(Yii::app()->user->getChoosedGroup());

        Yii::app()->user->setChoosedPeriod(SimPeriodStatus::getLastPlayedPeriod($group->id));
        if (SimPeriodStatus::getLastPlayedPeriod($group->id) == 0) {
            Yii::app()->user->setChoosedPeriod(1);
        }

        //Hier wird die Session geschlossen! ACHTUNG ZUGRIFF AUF SESSION VOR DIESER ZEILE!
        session_write_close();

        // Aktuelle Periode holen
        $period_status = SimPeriodStatus::getCurrentPeriodSet($group->id);

        // Simulation ausführen
        try {
            $this->simulate($group, $period_status);
        } catch (Exception $e) {
            // mark that the simulation has finished
            $period_status->simulated = 1;
            $period_status->save(false);
            throw $e;
        }
        $period_status->simulated = 1;
        $period_status->save(false);


        //Sicherheitshalber wieder auf Abbrüche des Users reagieren:
        ignore_user_abort(false);
    }

    private function simulate($group, $period_status)
    {

        //Bei einem Fehler würde das Script endlos laufen, das wollen wir nicht. Deshalb setzen wir ein Limit in Sekunden
        set_time_limit(600); //10 Minuten... in der Zeit schaffen wir jede einfache Simulation ;)

        //Prüfen ob ein Spiel gewählt wurde
        $this->needChoosedGame();

        //Spiel ermitteln
        global $game;
        $game = Game::model()->findByPk(Yii::app()->user->getChoosedGame());

        //Gruppe ermitteln
        global $group;
        $group = Group::model()->findByPk(Yii::app()->user->getChoosedGroup());

        //Prüfen ob alle Daten da sind
        if (!SimPeriodStatus::isReadytoSimulate($group->id)) {
            Yii::log('Not ready to simulate (Group ' . $group->id . ')', 'info', 'simulation');
            $this->redirect(array('order/new'));
            return false;
        }


        //Prüfen ob die Simulation bereits gestartet wurde und danach in der Datenbank vermerken, dass diese jetzt gestartet ist.

        if ($period_status->simulation_started == 1) {
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Other teammember has already started simulation!'));
            $this->redirect(array('site/index'));
            return;
        }
        $period_status->simulation_started = 1;
        $period_status->save(false);

        Yii::endProfile('1. Simulation starten - Periode prüfen - Simulationsstatus setzen');

        Yii::beginProfile('2. Maschinen erstellen');
        //uas cdMachines die sim_machines für diese Periode erstellen
        SimLog::createLog($period_status->period, $group->id, 'maschine_create', 0, 'Create machines to simulate');
        $cdMachines = CdMachine::model()->findAllByAttributes(array('cd_gameset_id' => $game->cd_gameset_id));
        foreach ($cdMachines as $m) {
            $sim_machine_data = new SimMachineData();
            $sim_machine_data->cd_machine_id = $m->id;
            $sim_machine_data->group_id = $group->id;
            $sim_machine_data->period = $period_status->period;
            $sim_machine_data->idle_time = 0;
            $sim_machine_data->production_time = 0;
            $sim_machine_data->set_up_time = 0;
            $sim_machine_data->clearing_time = 0;
            $sim_machine_data->save(false);
        }
        SimLog::createLog($period_status->period, $group->id, 'maschine_create', 1, 'Create machines to simulate');
        Yii::endProfile('2. Maschinen erstellen');

        Yii::beginProfile('3. Lager vorbereiten');
        SimLog::createLog($period_status->period, $group->id, 'prepare_stock', 0, 'Prepare Stock for the new period');
        //Lager vorbereiten
        $prevStocks = Stock::model()->findAllByAttributes(array('group_id' => $group->id, 'period' => $period_status->period - 1));
        foreach ($prevStocks as $prevStock) {
            $newStock = new Stock();
            $newStock->attributes = $prevStock->attributes;
            $newStock->price = $prevStock->price;
            $newStock->period = $period_status->period;
            $newStock->save();
        }
        SimLog::createLog($period_status->period, $group->id, 'prepare_stock', 1, 'Prepare Stock for the new period');
        Yii::endProfile('3. Lager vorbereiten');

        Yii::beginProfile('4. Produktionsaufträge splitten');
        SimLog::createLog($period_status->period, $group->id, 'split_porders', 0, 'Split production orders');
        //Produktionsaufträge generieren
        $productionOrders = ProductionOrder::model()->findAllByAttributes(array('group_id' => $group->id, 'order_period' => $period_status->period), array('order' => 'id asc'));
        foreach ($productionOrders as $po) {


            $usedWorkflow = CdWorkflow::model()->findByAttributes(array('output_product_id' => $po->cd_product_id));

            if (empty($usedWorkflow)) {
                echo "Please check your Workflow! You haven´t got a Workflow for the product: " . $po->number;
                die();
            }
            $steps = CdStep::model()->findAllByAttributes(array('cd_workflow_id' => $usedWorkflow->id));

            // Miniproduktionsaufträge für die einzelnen Maschinen anlegen
            foreach ($steps as $step) {
                $po_number = 0;
                $restmenge = $po->amount;
                while ($restmenge > 0) {
                    $po_number++;
                    $spo = new SimProductionOrder();
                    $spo->period = $period_status->period;
                    $spo->cd_workflow_id = $usedWorkflow->id;
                    $spo->cd_step_id = $step->id;
                    $spo->cd_machine_id = $step->cd_machine_id;
                    $spo->production_order_id = $po->id;
                    $spo->sequence = $step->sequence;
                    $spo->group_id = $group->id;
                    $spo->finished = 0;
                    $spo->color_gantt = $po->color_gantt;
                    $spo->production_number = $po_number;

                    if ($restmenge >= 10) {
                        $spo->amount = 10;
                        $restmenge = $restmenge - 10;
                    } else {
                        $spo->amount = $restmenge;
                        $restmenge = 0;
                    }
                    $spo->cycle_time = $step->cycle_time * $spo->amount;
                    $spo->save(false);
                }
            }

        }
        SimLog::createLog($period_status->period, $group->id, 'split_porders', 1, 'Split production orders');
        Yii::endProfile('4. Produktionsaufträge splitten');

        //Simulationsklasse holen
        /** @var SimFrame $sim */
        $sim = new SimFrame();


        //Der Sauberkeit geschuldet werden hier die Events definiert

        $event_order_arrive = 'orderarrive';
        $event_auftrag_fertig = 'auftragfertig';
        $event_auftrag_teil_fertig = 'auftragteilfertig';
        $event_auftrag_einlasten = 'auftrageinlasten';
        $event_shift_start = 'shiftstart';
        $event_shift_end = 'shiftend';
        $event_einlagern = 'einlagern';
        $event_endofday = 'endofday';

        // TODO: Könnte man sich sparen, wenn man die oben angelegten SimMachineData direkt in ein Array speichert
        //Jetzt brauchen wir alle Maschinen die für dieses Spiel verfügbar sind und von uns als MachineData bereitgestellt wurden
        $machines = SimMachineData::model()->findAllByAttributes(array('period' => $period_status->period, 'group_id' => $group->id));

        //Tagesevents setzen
        for ($i = 1; $i <= 5; $i++) {

            $newEvent = new SimEvent();
            $newEvent->setExecutionTime($i * 1440);
            $newEvent->setTypeOfEvent($event_endofday);
            $newEvent->setValue('day', $i);
            $newEvent->setValue('period', $period_status->period);
            $newEvent->addObject($group);

            $sim->addEvent($newEvent);
        }

        $stockcache = new StockCache;
        //Sellwishes festlegen für Eventbased Handling
        $p_products = CdProduct::model()->findAllByAttributes(array('cd_gameset_id' => $game->cd_gameset_id, 'kind' => 'p'));
        foreach ($p_products as $product) {
            $sale = CdSellingforecast::model()->findByAttributes(array('cd_gameset_id' => $game->cd_gameset_id, 'cd_product_id' => $product->id, 'period' => $period_status->period));
            if (!empty($sale)) {
                $stockcache->addItem2Sale($sale->cd_product_id, $sale->solid_sales);
            }
        }
        Yii::beginProfile('5. Schichtevents erstellen');
        //Für jede Maschine den Schichtanfang und das Schichtende definieren
        foreach ($machines as $m) {
            $shift_sheduling = ShiftScheduling::model()->findByAttributes(array('cd_machine_id' => $m->cd_machine_id, 'group_id' => $group->id, 'period' => $period_status->period));

            if ($shift_sheduling->shift_amount == 0) {
                continue;
            }
            // Schicht 1
            if ($shift_sheduling->shift_amount >= 1) {
                for ($i = 0; $i <= 4; $i++) {
                    //Start definieren
                    $newEvent = new SimEvent();
                    $newEvent->setExecutionTime($i * 1440);
                    $newEvent->setTypeOfEvent($event_shift_start);
                    $newEvent->addObject($m);
                    $newEvent->addObject($group);
                    $newEvent->setValue('shift', '1');
                    $newEvent->setValue('day', $i + 1);
                    $newEvent->setValue('shiftend', $i * 1440 + 480);
                    $sim->addEvent($newEvent);
                    //Ende definieren
                    $newEvent = new SimEvent();
                    $newEvent->setExecutionTime($i * 1440 + 480);
                    $newEvent->setTypeOfEvent($event_shift_end);
                    $newEvent->addObject($m);
                    $newEvent->addObject($group);
                    $newEvent->setValue('shift', '1');
                    $newEvent->setValue('day', $i + 1);
                    $sim->addEvent($newEvent);
                    $newEvent->executeLast();
                }
            }
            if ($shift_sheduling->shift_amount == 1 && $shift_sheduling->overtime > 0) {
                for ($i = 0; $i <= 4; $i++) {
                    //Start definieren
                    $newEvent = new SimEvent();
                    $newEvent->setExecutionTime($i * 1440 + 480);
                    $newEvent->setTypeOfEvent($event_shift_start);
                    $newEvent->addObject($m);
                    $newEvent->addObject($group);
                    $newEvent->setValue('shift', '1overtime');
                    $newEvent->setValue('day', $i + 1);
                    $newEvent->setValue('shiftend', $i * 1440 + 480 + $shift_sheduling->overtime);
                    $sim->addEvent($newEvent);
                    //Ende definieren
                    $newEvent = new SimEvent();
                    $newEvent->setExecutionTime($i * 1440 + 480 + $shift_sheduling->overtime);
                    $newEvent->setTypeOfEvent($event_shift_end);
                    $newEvent->addObject($m);
                    $newEvent->addObject($group);
                    $newEvent->setValue('shift', '1overtime');
                    $newEvent->setValue('day', $i + 1);
                    $sim->addEvent($newEvent);
                    $newEvent->executeLast();
                }
            }

            // Schicht 2
            if ($shift_sheduling->shift_amount >= 2) {
                for ($i = 0; $i <= 4; $i++) {
                    //Start definieren
                    $newEvent = new SimEvent();
                    $newEvent->setExecutionTime($i * 1440 + 480);
                    $newEvent->setTypeOfEvent($event_shift_start);
                    $newEvent->addObject($m);
                    $newEvent->addObject($group);
                    $newEvent->setValue('shift', '2');
                    $newEvent->setValue('day', $i + 1);
                    $newEvent->setValue('shiftend', $i * 1440 + 960);
                    $sim->addEvent($newEvent);
                    //Ende definieren
                    $newEvent = new SimEvent();
                    $newEvent->setExecutionTime($i * 1440 + 960);
                    $newEvent->setTypeOfEvent($event_shift_end);
                    $newEvent->addObject($m);
                    $newEvent->addObject($group);
                    $newEvent->setValue('shift', '2');
                    $newEvent->setValue('day', $i + 1);
                    $sim->addEvent($newEvent);
                    $newEvent->executeLast();
                }
            }
            if ($shift_sheduling->shift_amount == 2 && $shift_sheduling->overtime > 0) {
                for ($i = 0; $i <= 4; $i++) {
                    //Start definieren
                    $newEvent = new SimEvent();
                    $newEvent->setExecutionTime($i * 1440 + 960);
                    $newEvent->setTypeOfEvent($event_shift_start);
                    $newEvent->addObject($m);
                    $newEvent->addObject($group);
                    $newEvent->setValue('shift', '2overtime');
                    $newEvent->setValue('day', $i + 1);
                    $newEvent->setValue('shiftend', $i * 1440 + 960 + $shift_sheduling->overtime);
                    $sim->addEvent($newEvent);
                    //Ende definieren
                    $newEvent = new SimEvent();
                    $newEvent->setExecutionTime($i * 1440 + 960 + $shift_sheduling->overtime);
                    $newEvent->setTypeOfEvent($event_shift_end);
                    $newEvent->addObject($m);
                    $newEvent->addObject($group);
                    $newEvent->setValue('shift', '2overtime');
                    $newEvent->setValue('day', $i + 1);
                    $sim->addEvent($newEvent);
                    $newEvent->executeLast();
                }
            }

            //Schicht 3
            if ($shift_sheduling->shift_amount == 3) {
                for ($i = 0; $i <= 4; $i++) {
                    //Start definieren
                    $newEvent = new SimEvent();
                    $newEvent->setExecutionTime($i * 1440 + 960);
                    $newEvent->setTypeOfEvent($event_shift_start);
                    $newEvent->addObject($m);
                    $newEvent->addObject($group);
                    $newEvent->setValue('shift', '3');
                    $newEvent->setValue('day', $i + 1);
                    $newEvent->setValue('shiftend', $i * 1440 + 1440);
                    $sim->addEvent($newEvent);
                    //Ende definieren
                    $newEvent = new SimEvent();
                    $newEvent->setExecutionTime($i * 1440 + 1440);
                    $newEvent->setTypeOfEvent($event_shift_end);
                    $newEvent->addObject($m);
                    $newEvent->addObject($group);
                    $newEvent->setValue('shift', '3');
                    $newEvent->setValue('day', $i + 1);
                    $sim->addEvent($newEvent);
                    $newEvent->executeLast();
                }
            }

        }
        Yii::endProfile('5. Schichtevents erstellen');

        Yii::beginProfile('6. Events für Bestellungen generieren');
        //Events für Bestellungen generieren
        SimLog::createLog($period_status->period, $group->id, 'events_creation', 0, 'Create events for orders');
        $orders = Order::model()->findAllByAttributes(array('group_id' => $group->id, 'delivered' => false));
        foreach ($orders as $order) {
            if ($period_status->period + 0.8 >= $order->order_period + $order->calculated_delivery_time) {
                $zeitpunkt = ($order->calculated_delivery_time - floor($order->calculated_delivery_time)) * 7200;
                if ($zeitpunkt <= 5760) {
                    $z1 = 5761;
                }
                if ($zeitpunkt <= 4320) {
                    $z1 = 4321;
                }
                if ($zeitpunkt <= 2880) {
                    $z1 = 2881;
                }
                if ($zeitpunkt <= 1440) {
                    $z1 = 1441;
                }
                if ($zeitpunkt <= 1440) {
                    $z1 = 1441;
                }
                if ($period_status->period >= floor($order->calculated_delivery_time + $order->order_period)) {
                    $z1 = 1;
                }

                $newEvent = new SimEvent();
                $newEvent->setExecutionTime($z1);
                $newEvent->setTypeOfEvent($event_order_arrive);
                $newEvent->addObject($order);
                $newEvent->addObject($group);
                $sim->addEvent($newEvent);
            }
        }
        SimLog::createLog($period_status->period, $group->id, 'events_creation', 1, 'Create events for orders');
        Yii::endProfile('6. Events für Bestellungen generieren');

        //*************Cache initialisieren ***************************
        Yii::beginProfile('7. Cache initialisieren');

        $stockcache->loadFromDatabase($group->id, $period_status->period);
        $machinecache = new MachineCache();
        $sim->addObject($stockcache);
        $sim->addObject($machinecache);

        $waitproductcache = new WaitProductCache();
        $sim->addObject($waitproductcache);
        Yii::endProfile('7. Cache initialisieren');

        function onEvent($event, $simtime, $sim)
        {
            // Hier wird auf Events reagiert

            //Die Gruppeninformation auslesen
            $group = $event->getObject('Group');

            //StockCache erhalten
            $stockcache = $sim->getObject('StockCache');

            //MachineCache erhalten
            $machinecache = $sim->getObject('MachineCache');

            //Waitproductcache erhalten
            $waitproductcache = $sim->getObject('WaitProductCache');

            /**
             * Event Maschine Schicht startet
             */
            if ($event->getTypeOfEvent() == 'shiftstart') {
                Yii::beginProfile('Shift start');
                $sim_machine = $event->getObject('SimMachineData');

                $newEvent = new SimEvent();
                $newEvent->setExecutionTime($simtime);
                $newEvent->setTypeOfEvent('auftrageinlasten');
                $newEvent->addObject($sim_machine);
                $newEvent->addObject($group);
                $newEvent->setValue('shift', $event->getValue('shift'));
                $newEvent->setValue('shiftend', $event->getValue('shiftend'));
                $newEvent->setValue('day', $event->getValue('day'));
                $sim->addEvent($newEvent);

                // if ($this->debug == true)
                SimDebugLog::Log(array('group_id' => $group->id, 'period' => $sim_machine->period, 'sim_machine_id' => $sim_machine->id, 'simtime' => $simtime, 'text' => 'Shift: ' . $event->getValue('shift') . 'starts at day: ' . $event->getValue('day')));
                Yii::endProfile('Shift start');
            }

            /**
             * Ein Tag geht zu ende
             */
            if ($event->getTypeOfEvent() == 'endofday') {
                $day = $event->getValue('day');
                $period = $event->getValue('period');
                foreach ($stockcache->items2sale as $pid => $amount) {
                    $possiblesellings = ($stockcache->getMaxItemsSale($pid) * $day) - $stockcache->itemsSold[$pid];
                    if ($possiblesellings > 0 && $stockcache->getAmount($pid)>0) {
                        if($possiblesellings>=$stockcache->getAmount($pid))
                        {
                            $truesell=$stockcache->getAmount($pid);
                        } else $truesell=$possiblesellings;
                        $stockRotation = new StockRotation();
                        $stockRotation->amount = -$truesell;
                        $stockRotation->period = $period;
                        $stockRotation->sim_time = $simtime;
                        $stockRotation->group_id = $group->id;
                        $stockRotation->cd_product_id = $pid;
                        $stockRotation->save();
                        $stockcache->removeAmount($pid, $truesell);
                        $stockcache->sellItem($pid,$truesell);
                    }
                }
                $stockcache->addLagerwert();
            }


            /**
             * Eine Schicht geht zu ende
             */
            if ($event->getTypeOfEvent() == 'shiftend') {

                Yii::beginProfile('Shift end');
                $sim_machine = $event->getObject('SimMachineData');
                // if ($this->debug == true)
                SimDebugLog::Log(array('group_id' => $group->id, 'period' => $sim_machine->period, 'sim_machine_id' => $sim_machine->id, 'simtime' => $simtime, 'text' => 'Shift: ' . $event->getValue('shift') . 'ends at day: ' . $event->getValue('day')));
               // $stockcache->addLagerwert();
                Yii::endProfile('Shift end');

            }

            /**
             *  Auftrag einlasten
             */
            if ($event->getTypeOfEvent() == 'auftrageinlasten') {
                Yii::beginProfile('Auftrag einlasten');

                $sim_machine = $event->getObject('SimMachineData');

                //Wir brauchen einen Auftrag zum abarbeiten
                if (!$sim_machine->hasStillWork()) {
                    Yii::endProfile('Auftrag einlasten');
                    return;
                }

                //Prüfen ob an diesem Tag noch Zeit verfügbar ist
                $time_left = $event->getValue('shiftend') - $simtime;
                if ($time_left <= 1) {
                    Yii::endProfile('Auftrag einlasten');
                    return;
                }

                Yii::beginProfile('getOrder2Work');
                $sim_production_order = $sim_machine->getOrder2Work($machinecache, $stockcache, $waitproductcache, $sim_machine->period, $sim_machine->group_id, $simtime);
                Yii::endProfile('getOrder2Work');

                if (empty($sim_production_order)) {
                    //Wir haben keinen Auftrag zum bearbeiten!
                    //In einer Minute erneut versuchen!
                    $newEvent = new SimEvent();

                    // Nächste Zeit mit einem Event suchen
                    $newExecTime = $simtime + 10;
                    foreach ($sim->_eventList as $e) {
                        if ($e->_typeOfEvent == 'auftragfertig' || $e->_typeOfEvent == 'orderarrive' || $e->_typeOfEvent == 'einlagern') {
                            $newExecTime = $e->_executionTime + 1;
                            break;
                        }
                    }

                    $newEvent->setExecutionTime($newExecTime);
                    $newEvent->setTypeOfEvent('auftrageinlasten');
                    $newEvent->addObject($sim_machine);
                    $newEvent->addObject($group);
                    $newEvent->setValue('shift', $event->getValue('shift'));
                    $newEvent->setValue('shiftend', $event->getValue('shiftend'));
                    $newEvent->setValue('day', $event->getValue('day'));
                    $sim->addEvent($newEvent);
                    Yii::endProfile('Auftrag einlasten');
                    return;
                }

                Yii::beginProfile('Rüstkosten berechnen');
                $issame = $machinecache->isSameItem($sim_machine->id, $sim_production_order);
                //Rüstkosten berechnen falls nötig
                if (!$issame) {
                    //Rüstkosten berechnen
                    $cd_step = CdStep::model()->findByAttributes(array('cd_workflow_id' => $sim_production_order->cd_workflow_id, 'sequence' => $sim_production_order->sequence));

                    $sim_production_order->set_up_time = $cd_step->set_up_time;
                    $sim_production_order->save();

                }
                $machinecache->setLastSimPo($sim_machine->id, $sim_production_order);
                Yii::endProfile('Rüstkosten berechnen');
                //$AnzahlFertig = SimProductionOrder::model()->count('group_id=:group_id and cd_workflow_id=:cd_workflow_id and sequence=:sequence and finished=true', array('group_id' => $group->id, 'cd_workflow_id' => $sim_production_order->cd_workflow_id, 'sequence' => $sim_production_order->sequence));
                //if ($AnzahlFertig == 0) {}

                Yii::beginProfile('BDE Daten schreiben');
                //TODO: Clearing Time noch setzen
                $command = Yii::app()->db->createCommand();
                $command->select('SUM(day_end-day_start) AS sum');
                $command->from('sim_operating_datas');
                $command->where('sim_production_order_id=:sim_production_order_id', array(':sim_production_order_id' => $sim_production_order->id));
                $elapsed = $command->queryScalar();


                $time_needed = $sim_production_order->cycle_time + $sim_production_order->set_up_time + $sim_production_order->clearing_time - $elapsed;
                $time_left = $event->getValue('shiftend') - $simtime;

                $newEvent = new SimEvent();

                $newEvent->addObject($sim_machine);
                $newEvent->addObject($group);
                $newEvent->setValue('shift', $event->getValue('shift'));
                $newEvent->setValue('shiftend', $event->getValue('shiftend'));
                $newEvent->setValue('day', $event->getValue('day'));


                $sim_operating_data = new SimOperatingData();
                $sim_operating_data->cd_machine_id = $sim_production_order->cd_machine_id;
                $sim_operating_data->group_id = $sim_production_order->group_id;
                $sim_operating_data->period = $sim_machine->period;
                $sim_operating_data->simtime_start = $simtime;
                $sim_operating_data->day = $event->getValue('day');
                $sim_operating_data->day_start = $simtime - (1440 * ($event->getValue('day') - 1));
                $sim_operating_data->shift = $event->getValue('shift');
                $sim_operating_data->production_order_id = $sim_production_order->production_order_id;
                $sim_operating_data->sim_production_order_id = $sim_production_order->id;
                $sim_operating_data->save();
                $newEvent->addObject($sim_operating_data);
                $newEvent->addObject($sim_production_order);
                Yii::endProfile('BDE Daten schreiben');

                if ($time_left >= $time_needed) {

                    // geschafft
                    $newEvent->setExecutionTime($simtime + $time_needed);
                    $newEvent->setTypeOfEvent('auftragfertig');
                } elseif ($time_left >= 1) {
                    // nicht geschafft

                    $newEvent->setExecutionTime($event->getValue('shiftend'));
                    $newEvent->setTypeOfEvent('auftragteilfertig');
                }

                $sim->addEvent($newEvent);

                $po = ProductionOrder::model()->findByPk($sim_production_order->production_order_id);
                // TODO: if ($this->debug == true)
                SimDebugLog::Log(array('group_id' => $group->id, 'period' => $sim_machine->period, 'sim_machine_id' => $sim_machine->id, 'simtime' => $simtime, 'production_order_id' => $sim_production_order->production_order_id, 'sim_production_order_id' => $sim_production_order->id, 'sim_operating_data_id' => $sim_operating_data->id, 'cd_product_id' => $po->cd_product_id, 'cd_workflow_id' => $sim_production_order->cd_workflow_id, 'sequence' => $sim_production_order->sequence, 'cd_step_id' => $sim_production_order->cd_step_id, 'text' => 'Auftrag einlasten -> timeleft:' . $time_left . ' timeneeded:' . $time_needed));
                Yii::endProfile('Auftrag einlasten');

            }

            /**
             * Event Maschine hat Auftrag fertig
             */
            if ($event->getTypeOfEvent() == 'auftragfertig') {
                Yii::beginProfile('Auftrag fertig');
                $sim_production_order = $event->getObject('SimProductionOrder');
                $sim_machine = $event->getObject('SimMachineData');
                $sim_operating_data = $event->getObject('SimOperatingData');

                $sim_production_order->finished = 1;
                $sim_production_order->elapsed_cycle_time = $sim_production_order->cycle_time;
                $sim_production_order->status = 'finished';
                $sim_production_order->finish_period = $sim_machine->period;
                $sim_production_order->save();

                $sim_operating_data->simtime_end = $simtime;
                $sim_operating_data->day_end = $simtime - (1440 * ($event->getValue('day') - 1));

                $duration = $sim_operating_data->day_end - $sim_operating_data->day_start;
                $cd_machine = CdMachine::model()->findByPk($sim_machine->cd_machine_id);
                $sim_operating_data->machine_costs = ($cd_machine->running_costs + $cd_machine->fixed_costs) * $duration;
                if ($event->getValue('shift') == '1') {
                    $sim_operating_data->shift_costs = $cd_machine->wage_shift_one * $duration;
                }
                if ($event->getValue('shift') == '2') {
                    $sim_operating_data->shift_costs = $cd_machine->wage_shift_two * $duration;
                }
                if ($event->getValue('shift') == '3') {
                    $sim_operating_data->shift_costs = $cd_machine->wage_shift_three * $duration;
                }
                if ($event->getValue('shift') == '1overtime') {
                    $sim_operating_data->shift_costs = $cd_machine->wage_overtime * $duration;
                }
                if ($event->getValue('shift') == '2overtime') {
                    $sim_operating_data->shift_costs = $cd_machine->wage_overtime * $duration;
                }
                $sim_operating_data->costs = $sim_operating_data->shift_costs + $sim_operating_data->machine_costs;
                $sim_operating_data->save();


                $command = Yii::app()->db->createCommand();
                $command->select('SUM(costs) AS sum');
                $command->from('sim_operating_datas');
                $command->where('sim_production_order_id=:sim_production_order_id', array(':sim_production_order_id' => $sim_production_order->id));
                $sod_sum = $command->queryScalar();


                $sim_production_order->costs = $sod_sum;
                $sim_production_order->save();


                $max_sim_production_order = SimProductionOrder::model()->findByAttributes(array('group_id' => $group->id, 'period' => $sim_machine->period, 'cd_workflow_id' => $sim_production_order->cd_workflow_id), array('order' => 'sequence desc', 'limit' => 1));

                if ($max_sim_production_order->sequence == $sim_production_order->sequence) {

                    $newEvent = new SimEvent();
                    $newEvent->setExecutionTime($simtime);
                    $newEvent->setTypeOfEvent('einlagern');
                    $newEvent->addObject($sim_machine);
                    $newEvent->addObject($group);
                    $newEvent->addObject($sim_production_order);
                    $newEvent->addObject($sim_operating_data);
                    $sim->addEvent($newEvent);

                }

                if ($simtime < $event->getValue('shiftend')) {
                    $newEvent = new SimEvent();
                    $newEvent->setExecutionTime($simtime);
                    $newEvent->setTypeOfEvent('auftrageinlasten');
                    $newEvent->addObject($sim_machine);
                    $newEvent->addObject($group);
                    $newEvent->setValue('shift', $event->getValue('shift'));
                    $newEvent->setValue('shiftend', $event->getValue('shiftend'));
                    $newEvent->setValue('day', $event->getValue('day'));
                    $sim->addEvent($newEvent);
                }


                $po = ProductionOrder::model()->findByPk($sim_production_order->production_order_id);
                SimDebugLog::Log(array('group_id' => $group->id, 'period' => $sim_machine->period, 'sim_machine_id' => $sim_machine->id, 'simtime' => $simtime, 'production_order_id' => $sim_production_order->production_order_id, 'sim_production_order_id' => $sim_production_order->id, 'sim_operating_data_id' => $sim_operating_data->id, 'cd_product_id' => $po->cd_product_id, 'cd_workflow_id' => $sim_production_order->cd_workflow_id, 'sequence' => $sim_production_order->sequence, 'cd_step_id' => $sim_production_order->cd_step_id, 'text' => 'Auftrag fertig'));
                Yii::endProfile('Auftrag fertig');

            }

            /**
             * Event Maschine hat Auftrag zum Teil fertig
             */
            if ($event->getTypeOfEvent() == 'auftragteilfertig') {

                Yii::beginProfile('Auftrag Teilfertig');
                $sim_production_order = $event->getObject('SimProductionOrder');
                $sim_machine = $event->getObject('SimMachineData');
                $sim_operating_data = $event->getObject('SimOperatingData');

                $sim_operating_data->simtime_end = $simtime;
                $sim_operating_data->day_end = $simtime - (1440 * ($event->getValue('day') - 1));
                $sim_operating_data->save();

                $sim_production_order->status = 'incomplete wait';
                $sim_production_order->elapsed_cycle_time = $sim_production_order->elapsed_cycle_time + $sim_operating_data->simtime_end - $sim_operating_data->simtime_start;
                $sim_production_order->save();


                $duration = $sim_operating_data->day_end - $sim_operating_data->day_start;
                $cd_machine = CdMachine::model()->findByPk($sim_machine->cd_machine_id);
                $sim_operating_data->machine_costs = ($cd_machine->running_costs + $cd_machine->fixed_costs) * $duration;
                if ($event->getValue('shift') == '1') {
                    $sim_operating_data->shift_costs = $cd_machine->wage_shift_one * $duration;
                }
                if ($event->getValue('shift') == '2') {
                    $sim_operating_data->shift_costs = $cd_machine->wage_shift_two * $duration;
                }
                if ($event->getValue('shift') == '3') {
                    $sim_operating_data->shift_costs = $cd_machine->wage_shift_three * $duration;
                }
                if ($event->getValue('shift') == '1overtime') {
                    $sim_operating_data->shift_costs = $cd_machine->wage_overtime * $duration;
                }
                if ($event->getValue('shift') == '2overtime') {
                    $sim_operating_data->shift_costs = $cd_machine->wage_overtime * $duration;
                }
                $sim_operating_data->costs = $sim_operating_data->shift_costs + $sim_operating_data->machine_costs;
                $sim_operating_data->save(false);

                $command = Yii::app()->db->createCommand();
                $command->select('SUM(costs) AS sum');
                $command->from('sim_operating_datas');
                $command->where('sim_production_order_id=:sim_production_order_id', array(':sim_production_order_id' => $sim_operating_data->sim_production_order_id));
                $sod_sum = $command->queryScalar();
                $sim_production_order = SimProductionOrder::model()->findByPk($sim_operating_data->sim_production_order_id);
                $sim_production_order->costs = $sod_sum;
                $sim_production_order->save(false);


                $po = ProductionOrder::model()->findByPk($sim_production_order->production_order_id);
                // TODO: Wenn kein Logeintrag existiert wird kein Fortschritt protokolliert!! if ($this->debug == true)
                SimDebugLog::Log(array('group_id' => $group->id, 'period' => $sim_machine->period, 'sim_machine_id' => $sim_machine->id, 'simtime' => $simtime, 'production_order_id' => $sim_production_order->production_order_id, 'sim_production_order_id' => $sim_production_order->id, 'sim_operating_data_id' => $sim_operating_data->id, 'cd_product_id' => $po->cd_product_id, 'cd_workflow_id' => $sim_production_order->cd_workflow_id, 'sequence' => $sim_production_order->sequence, 'cd_step_id' => $sim_production_order->cd_step_id, 'text' => 'Auftrag teilfertig'));

                Yii::endProfile('Auftrag Teilfertig');
            }

            /**
             * Eine Bestellung trifft ein
             */
            if ($event->getTypeOfEvent() == 'orderarrive') {

                Yii::beginProfile('Bestellung trifft ein');
                $period_status = SimPeriodStatus::getCurrentPeriodSet($group->id);

                $order = $event->getObject('Order');
                $order->delivered = true;
                $order->delivery_period = $period_status->period;
                $order->save(false);

                if ($order->amount <= 0) {
                    $order->amount = 1;
                }

                $stockcache->addAmountWithPriceChange($order->cd_product_id, $order->amount, $order->end_price / $order->amount);

                $stockRotation = new StockRotation();
                $stockRotation->amount = $order->amount;
                $stockRotation->period = $period_status->period;
                $stockRotation->sim_time = $simtime;
                $stockRotation->group_id = $group->id;
                $stockRotation->cd_product_id = $order->cd_product_id;
                $stockRotation->save();

                // if ($this->debug == true)
                SimDebugLog::Log(array('group_id' => $group->id, 'order_id' => $order->id, 'period' => $period_status->period, 'simtime' => $simtime, 'cd_product_id' => $order->cd_product_id, 'text' => 'Order arrive'));

                Yii::endProfile('Bestellung trifft ein');
            }

            if ($event->getTypeOfEvent() == 'einlagern') {

                Yii::beginProfile('Einlagern');
                $sim_production_order = $event->getObject('SimProductionOrder');

                /*
                                $criteria = new CDbCriteria;
                                $criteria->select = 'SUM(costs) as sum';
                                $criteria->condition = 'sim_production_order_id=' . $sim_production_order->id;
                                $sod_sum1 = SimOperatingData::model()->findAll($criteria);

                                */


                $production_order = ProductionOrder::model()->findByPk($sim_production_order->production_order_id);

                $workflow = CdWorkflow::model()->findByAttributes(array('output_product_id' => $production_order->cd_product_id));
                $steps = CdStep::model()->findAllByAttributes(array('cd_workflow_id' => $workflow->id));

                $sum_part_price = 0;

                foreach ($steps as $step) {

                    $input_parts = CdInputpart::model()->findAllByAttributes(array('cd_step_id' => $step->id));

                    foreach ($input_parts as $input_part) {
                        $sum_part_price += $input_part->amount * $stockcache->getPrice($input_part->cd_product_id);
                    }
                }

                $command = Yii::app()->db->createCommand();
                $command->select('SUM(costs) AS sum');
                $command->from('sim_production_orders');
                $command->where('production_order_id=:production_order_id and production_number=:production_number and finished=true', array(':production_order_id' => $production_order->id, ':production_number' => $sim_production_order->production_number));
                $sod_sum = $command->queryScalar() / $sim_production_order->amount;

                $stockcache->addAmountWithPriceChange($production_order->cd_product_id, $sim_production_order->amount, ($sum_part_price + $sod_sum));

                $period_status = SimPeriodStatus::getCurrentPeriodSet($group->id);
                $stockRotation = new StockRotation();
                $stockRotation->amount = $sim_production_order->amount;
                $stockRotation->period = $period_status->period;
                $stockRotation->sim_time = $simtime;
                $stockRotation->group_id = $group->id;
                $stockRotation->cd_product_id = $production_order->cd_product_id;
                $stockRotation->save();

                // if ($this->debug == true)
                SimDebugLog::Log(array('group_id' => $group->id, 'period' => $period_status->period, 'simtime' => $simtime, 'production_order_id' => $sim_production_order->production_order_id, 'sim_production_order_id' => $sim_production_order->id, 'cd_product_id' => $production_order->cd_product_id, 'cd_workflow_id' => $sim_production_order->cd_workflow_id, 'sequence' => $sim_production_order->sequence, 'cd_step_id' => $sim_production_order->cd_step_id, 'text' => 'Einlagern'));
                Yii::endProfile('Einlagern');

            }

        }

        //Wir simulieren hier immer maximal eine Periode, also 7200 Minuten
        $sim->setEventCallBackFunction('onEvent');
        SimLog::createLog($period_status->period, $group->id, 'sim_ready', 0, 'Simulation in progress...');

        Yii::beginProfile('8. Simulationskern');
        $sim->startSimulate(7200); //TODO: nochmals prüfen ob Zeit stimmt
        Yii::endProfile('8. Simulationskern');

        SimLog::createLog($period_status->period, $group->id, 'sim_ready', 1, 'Simulation ready');

        Yii::beginProfile('9. Abschließende Funktionen - Simulationsende');
        //******************Cache in DB schreiben ***********************

        //Fertige Produktionsaufträge ermitteln
        $pos = ProductionOrder::model()->findAllByAttributes(array('group_id' => $group->id, 'ready_period' => '-1'));
        foreach ($pos as $po) {
            $value = Yii::app()->db->createCommand("SELECT Count(*) as 'count' FROM sim_production_orders WHERE finished<>1 and production_order_id=" . $po->id)->queryScalar();
            if ($value == 0) {
                $po->ready_period = $period_status->period;
                $po->save(false);
            }
        }

        //SimMachineDatas schreiben
        $sim_machines = SimMachineData::model()->findAllByAttributes(array('group_id' => $group->id, 'period' => $period_status->period));
        foreach ($sim_machines as $m) {
            $shift_sheduling = ShiftScheduling::model()->findByAttributes(array('group_id' => $group->id, 'period' => $period_status->period, 'cd_machine_id' => $m->cd_machine_id));
            $m->production_time_shift_1 = Yii::app()->db->createCommand("SELECT SUM(day_end-day_start) as 'sum' FROM sim_operating_datas WHERE group_id=" . $group->id . " and period=" . $period_status->period . " and shift='1' " . " and cd_machine_id=" . $m->cd_machine_id)->queryScalar();
            $m->production_time_shift_2 = Yii::app()->db->createCommand("SELECT SUM(day_end-day_start) as 'sum' FROM sim_operating_datas WHERE group_id=" . $group->id . " and period=" . $period_status->period . " and shift='2' " . " and cd_machine_id=" . $m->cd_machine_id)->queryScalar();
            $m->production_time_shift_3 = Yii::app()->db->createCommand("SELECT SUM(day_end-day_start) as 'sum' FROM sim_operating_datas WHERE group_id=" . $group->id . " and period=" . $period_status->period . " and shift='3' " . " and cd_machine_id=" . $m->cd_machine_id)->queryScalar();
            $m->production_time_overtime = Yii::app()->db->createCommand("SELECT SUM(day_end-day_start) as 'sum' FROM sim_operating_datas WHERE group_id=" . $group->id . " and period=" . $period_status->period . " and cd_machine_id=" . $m->cd_machine_id . " and (shift='1overtime'" . " or shift='2overtime') ")->queryScalar();

            $m->set_up_time = Yii::app()->db->createCommand("SELECT SUM(set_up_time) as 'sum' FROM sim_production_orders WHERE group_id=" . $group->id . " and period=" . $period_status->period . " and cd_machine_id=" . $m->cd_machine_id)->queryScalar();
            $m->clearing_time = Yii::app()->db->createCommand("SELECT SUM(clearing_time) as 'sum' FROM sim_production_orders WHERE group_id=" . $group->id . " and period=" . $period_status->period . " and cd_machine_id=" . $m->cd_machine_id)->queryScalar();

            $m->production_time = $m->production_time_shift_1 + $m->production_time_shift_2 + $m->production_time_shift_3 + $m->production_time_overtime;

            if ($shift_sheduling->shift_amount >= 3) {
                $m->idle_time_shift_3 = 480 * 5 - $m->production_time_shift_3;
            } else $m->idle_time_shift_3 = 0;
            if ($shift_sheduling->shift_amount >= 2) {
                $m->idle_time_shift_2 = 480 * 5 - $m->production_time_shift_2;
            } else $m->idle_time_shift_2 = 0;
            if ($shift_sheduling->shift_amount >= 1) {
                $m->idle_time_shift_1 = 480 * 5 - $m->production_time_shift_1;
            } else $m->idle_time_shift_1 = 0;
            if ($shift_sheduling->shift_amount = 0)
                $m->idle_time_shift_1 = 0;
            $m->idle_time_shift_2 = 0;
            {
                $m->idle_time_shift_3 = 0;
            }
            if ($shift_sheduling->overtime > 0) {
                $m->idle_time_overtime = $shift_sheduling->overtime * 5 - $m->production_time_overtime;
            }

            $m->idle_time = $m->idle_time_shift_1 + $m->idle_time_shift_2 + $m->idle_time_shift_3 + $m->idle_time_overtime;

            //Kosten an der Maschine
            $cdMachine = CdMachine::model()->findByPk($m->cd_machine_id);

            $m->costs_idle_time_shift_1 = $m->idle_time_shift_1 * ($cdMachine->wage_shift_one + $cdMachine->fixed_costs);
            $m->costs_idle_time_shift_2 = $m->idle_time_shift_2 * ($cdMachine->wage_shift_two + $cdMachine->fixed_costs);
            $m->costs_idle_time_shift_3 = $m->idle_time_shift_3 * ($cdMachine->wage_shift_three + $cdMachine->fixed_costs);
            $m->costs_idle_time_overtime = $m->idle_time_overtime * ($cdMachine->wage_overtime + $cdMachine->fixed_costs);
            $m->costs_idle_time = $m->costs_idle_time_shift_1 + $m->costs_idle_time_shift_2 + $m->costs_idle_time_shift_3 + $m->costs_idle_time_overtime;

            $m->costs_production_time_shift_1 = $m->production_time_shift_1 * ($cdMachine->wage_shift_one + $cdMachine->fixed_costs + $cdMachine->running_costs);
            $m->costs_production_time_shift_2 = $m->production_time_shift_2 * ($cdMachine->wage_shift_two + $cdMachine->fixed_costs + $cdMachine->running_costs);
            $m->costs_production_time_shift_3 = $m->production_time_shift_3 * ($cdMachine->wage_shift_three + $cdMachine->fixed_costs + $cdMachine->running_costs);
            $m->costs_production_time_overtime = $m->production_time_overtime * ($cdMachine->wage_overtime + $cdMachine->fixed_costs + $cdMachine->running_costs);
            $m->costs_production_time = $m->costs_production_time_shift_1 + $m->costs_production_time_shift_2 + $m->costs_production_time_shift_3 + $m->costs_production_time_overtime;


            $m->save();

        }

        //Verkäufe buchen

        /*$p_products = CdProduct::model()->findAllByAttributes(array('cd_gameset_id' => $game->cd_gameset_id, 'kind' => 'p'));
        foreach ($p_products as $product) {
            $sale = CdSellingforecast::model()->findByAttributes(array('cd_gameset_id' => $game->cd_gameset_id, 'cd_product_id' => $product->id, 'period' => $period_status->period));
            if (!empty($sale)) {
                $amount = $stockcache->getAmount($product->id);
                if ($amount >= ($sale->solid_sales)) {
                    $stockcache->removeAmount($product->id, $sale->solid_sales);
                    $stockRotation = new StockRotation();
                    $stockRotation->amount = -$sale->solid_sales;
                    $stockRotation->period = $period_status->period;
                    $stockRotation->sim_time = 7200;
                    $stockRotation->group_id = $group->id;
                    $stockRotation->cd_product_id = $product->id;
                    $stockRotation->save();
                    SimSelling::addComputerSelling($product->id, $group->id, $period_status->period, $sale->solid_sales, 200, $sale->solid_sales);

                    //Wir haben noch Teile auf Lager, deshalb können wir unter Umständen einen Additional Sale ausführen
                    if ($sale->additional_sales > 0) {
                        $amount = $stockcache->getAmount($product->id);
                        if ($amount >= $sale->additional_sales) {
                            $stockcache->removeAmount($product->id, $sale->solid_sales);
                            $stockRotation = new StockRotation();
                            $stockRotation->amount = -$sale->solid_sales;
                            $stockRotation->period = $period_status->period;
                            $stockRotation->sim_time = 7200;
                            $stockRotation->group_id = $group->id;
                            $stockRotation->cd_product_id = $product->id;
                            $stockRotation->save();
                            SimSelling::addComputerSelling($product->id, $group->id, $period_status->period, $sale->additional_sales, 200, $sale->additional_sales, 'additional sale');
                        } else {
                            $stockcache->removeAmount($product->id, $amount);
                            $stockRotation = new StockRotation();
                            $stockRotation->amount = -$amount;
                            $stockRotation->period = $period_status->period;
                            $stockRotation->sim_time = 7200;
                            $stockRotation->group_id = $group->id;
                            $stockRotation->cd_product_id = $product->id;
                            $stockRotation->save();
                            SimSelling::addComputerSelling($product->id, $group->id, $period_status->period, $amount, 200, $sale->additional_sales, 'additional sale');
                        }
                    }

                } else {
                    $stockRotation = new StockRotation();
                    $stockRotation->amount = -$amount;
                    $stockRotation->period = $period_status->period;
                    $stockRotation->sim_time = 7200;
                    $stockRotation->group_id = $group->id;
                    $stockRotation->cd_product_id = $product->id;
                    $stockRotation->save();
                    $stockcache->removeAmount($product->id, $amount);
                    SimSelling::addComputerSelling($product->id, $group->id, $period_status->period, $amount, 200, $sale->solid_sales);
                }
            }
        }
*/
        foreach ($stockcache->items2sale as $pid => $amount) {
            SimSelling::addComputerSelling($product->id, $group->id, $period_status->period, $stockcache->itemsSold[$pid], 200, $stockcache->getMaxItemsSale($pid) * 5);
        }

        $stockcache->saveToDatabase($group->id, $period_status->period);
        $waitproductcache->saveToDatabase();

        $simresult = new SimResult();
        $simresult->period = $period_status->period;
        $simresult->group_id = $group->id;
        $simresult->game_id = Yii::app()->user->getChoosedGame();

        //NormalKapazität berechnen
        //Fragen ob das nicht immer eine Konstante ist?
        $simresult->normal_capacity = 33600;

        //KannKapazität berechnen
        $shifts = ShiftScheduling::model()->findAllByAttributes(array('group_id' => $group->id, 'period' => $period_status->period));
        $possibleCapacity = 0;
        foreach ($shifts as $shift) {
            $possibleCapacity = $possibleCapacity + ($shift->shift_amount * 480 * 5) + ($shift->overtime * 5);
        }
        $simresult->possible_capacity = $possibleCapacity;

        //Kann/Normal
        $simresult->capacity_ratio = $possibleCapacity / ($simresult->normal_capacity / 100);

        //Produktivzeit
        $gesamtprductiontime = Yii::app()->db->createCommand("SELECT SUM(production_time) as 'sum' FROM sim_machine_datas WHERE group_id=" . $group->id . " and period=" . $period_status->period)->queryScalar();
        $simresult->productive_time = $gesamtprductiontime;

        //Auslastung
        $simresult->efficiency = $simresult->productive_time / ($simresult->possible_capacity / 100);

        //Vertriebswunsch
        $simresult->sales = Yii::app()->db->createCommand("SELECT SUM(solid_sales) as 'sum' FROM cd_sellingforecasts WHERE cd_gameset_id=" . $game->cd_gameset_id . " and period=" . $period_status->period)->queryScalar();

        //Absatz
        $simresult->sales_quantity = Yii::app()->db->createCommand("SELECT SUM(amount) as 'sum' FROM sim_sellings WHERE group_id=" . $group->id . " and period=" . $period_status->period . " and selling_type='solid sale'")->queryScalar();

        //Liefertreue
        $simresult->delivery_reliability = Yii::app()->db->createCommand("SELECT AVG(delivery_reliability) as 'sum' FROM sim_sellings WHERE group_id=" . $group->id . " and period=" . $period_status->period . " and selling_type='solid sale'")->queryScalar();

        //Leerzeit
        $gesamtIdleTime = Yii::app()->db->createCommand("SELECT SUM(idle_time) as 'sum' FROM sim_machine_datas WHERE group_id=" . $group->id . " and period=" . $period_status->period)->queryScalar();
        $simresult->idle_time = $gesamtIdleTime;

        //Leerzeitenkosten
        $simresult->idle_time_costs = Yii::app()->db->createCommand("SELECT SUM(costs_idle_time) as 'sum' FROM sim_machine_datas WHERE group_id=" . $group->id . " and period=" . $period_status->period)->queryScalar();

        //Produktivkosten
        $simresult->productive_time_costs=Yii::app()->db->createCommand("SELECT SUM(costs_production_time) as 'sum' FROM sim_machine_datas WHERE group_id=" . $group->id . " and period=" . $period_status->period)->queryScalar();

        //Bestellkosten
        $simresult->order_costs=Yii::app()->db->createCommand("SELECT SUM(end_price) as 'sum' FROM orders WHERE group_id=" . $group->id . " and order_period=" . $period_status->period)->queryScalar();

        //Lagerwert Durchschnitt
        $simresult->stock_value = $stockcache->getLagerwert();
        //   $currentstockvalue = Yii::app()->db->createCommand("SELECT SUM(price*amount) as 'sum' FROM stocks WHERE group_id=" . Yii::app()->user->ChoosedGroup . " and period=" . Yii::app()->user->ChoosedPeriod)->queryScalar();

        if ($simresult->stock_value > 250000) {
            $normalCosts = 250000 * 0.006;
            $additional = 5000;
            $overCosts = ($simresult->stock_value - 250000) * 0.012;
            $simresult->storage_costs = $overCosts + $additional + $normalCosts;
        } else {
            $simresult->storage_costs = $simresult->stock_value * 0.006;
        }

        $simresult->normal_sale_price = 200;

        $stockvalue=0;
        foreach ($stockcache->items2sale as $pid => $amount) {
            $sp=Stock::model()->findByAttributes(array('cd_product_id'=>$pid));
            $stockvalue=  $stockvalue+$sp->price;
        }
       $stockvalue=$stockvalue/count($stockcache->items2sale);

        $simresult->normal_sale_profit =  ($simresult->normal_sale_price - $stockvalue) * $simresult->sales_quantity - $simresult->storage_costs - $simresult->idle_time_costs ;

        if ($simresult->sales_quantity == 0) {
            $simresult->normal_sale_profit_unit = 0;
        } else {
            $simresult->normal_sale_profit_unit = $simresult->normal_sale_profit / $simresult->sales_quantity;
        }

        $simresult->summary = $simresult->normal_sale_profit; //Minus und Plus andere Ein und Verkäufe

        $simresult->save();


        //Wenn wir mit dem simulieren fertig sind, muss das auch im Status vermerkt werden

        Yii::endProfile('9. Abschließende Funktionen - Simulationsende');

    }
}
