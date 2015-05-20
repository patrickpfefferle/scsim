<?php


/**
 *
 * @author   Andreas Vratny <andreas@vratny.de>
 * @author   Marius Heinemann-Grüder <marius.hg@live.de>
 * @version  1.2
 * @access   public
 */
class AdminController extends Controller
{

    /* Controller action to execute the view on the inventory
     *
     * @author   Andreas Vratny <andreas@vratny.de>
     * @version  1.0
     * @access  public
     */
    public function actionUserIndex($prename = '', $lastname = '', $email = '', $organisation = '', $status = '')
    {
        // Where Bedinungen bauen
        $where = ' ';
        if (!empty($prename)) {
            $where .= 'prename like "%' . $prename . '%" and ';
        }
        if (!empty($lastname)) {
            $where .= 'lastname like "%' . $lastname . '%" and ';
        }
        if (!empty($email)) {
            $where .= 'email like "%' . $email . '%" and ';
        }
        if (!empty($organisation)) {
            $where .= 'organisation like "%' . $organisation . '%" and ';
        }
        if (!empty($status)) {
            if ($status == 'Administrator') {
                $where .= 'is_admin=1 and ';
            }
            if ($status == 'Moderator') {
                $where .= 'is_mod=1 and ';
            }
            if ($status == 'User') {
                $where .= 'is_admin=0 and is_mod=0 and ';
            }

        }


        if (Yii::app()->user->isMod) {
            $sql = 'SELECT * FROM users as u where' . $where . ' u.id in (Select user_id from user2games as u2g where u2g.game_id in (Select id from games as g where g.admin_id=' . Yii::app()->user->id . '))';
        }
        if (Yii::app()->user->isAdmin) {
            $sql = 'SELECT * FROM users as u where' . $where . ' id>-1';
        }
        $command = Yii::app()->db->createCommand($sql);
        $users = $command->queryAll();

        $this->render('userindex', array('users' => $users));

    }

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

    
    public function actionUserdelete($id)
    {
        $user = User::model()->findByPk($id);
        if (!empty($user)) {
            $user->delete();
        }
        $this->redirect(array('admin/userindex'));
    }

    public function actionGamedelete($id)
    {
        $game = Game::model()->findByPk($id);
        if (!empty($game)) {
            $game->delete();
        }
        $this->redirect(array('admin/showgames'));
    }

    public function actionUserblock($id)
    {
        $user = User::model()->findByPk($id);
        if (!empty($user)) {
            if ($user->blocked == 1) {
                $user->blocked = 0;
            } else {
                $user->blocked = 1;
            }
            $user->save();
        }
        $this->redirect(array('admin/userindex'));
    }

    public function actionManageuser($id)
    {
        $model = User::model()->findByPk($id);

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'manageuser-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];


            // $model->valid_until=null; //TODO: BUG bezüglich Zeit!
            if ($model->validate()) {
                if ($model->save()) {
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, Yii::t('app', 'Data successfully changed!'));
                    $this->redirect(array('admin/userindex'));
                } else {
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Problem while saving!'));
                }
            } else {

                var_dump($model->getErrors());
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Please check the errors below!'));
            }
        }
        $this->render('manageuser', array('model' => $model));

    }

    public function actionShowgames()
    {
        $model = Game::model()->findAllByAttributes(array('admin_id' => Yii::app()->user->id));

        $this->render('showgames', array('model' => $model));
    }

    public function actionShowgame($id)
    {
        $game = Game::model()->findByPk($id);
        $groups = Group::model()->findAllByAttributes(array('game_id' => $game->id));
        $this->render('showgame', array('game' => $game, 'groups' => $groups));
    }

    public function actionRemovegroupuser($userid, $groupid)
    {
        $user2game = User2game::model()->findByAttributes(array('user_id' => $userid, 'group_id' => $groupid));
        if (!empty($user2game)) {
            $user2game->group_id = new CDbExpression('NULL');
            $user2game->save(false);
        }
        $group = Group::model()->findByPk($groupid);
        if (!empty($group)) {
            $group->user_count = $group->user_count - 1;
            $group->save();
        }
        $this->redirect(array('admin/showgame', 'id' => $user2game['game_id']));
    }

    public function actionNewgame()
    {
        $model = new CreateGame();

        if (isset($_POST['CreateGame'])) {
            $model->attributes = $_POST['CreateGame'];
            if ($model->validate()) {
                $model->create();
                $this->redirect(array('admin/showgames'));
            }
        }
        $this->render('newgame', array('model' => $model));
    }

    public function actionResetperiod($groupId,$nextview='admin/showgame')
    {
        // Aktuelle Periode herausfinden
        $period = SimPeriodStatus::getCurrentPeriod($groupId);

        $sim_ps=SimPeriodStatus::model()->findByAttributes(array('group_id'=>$groupId,'period'=>$period));
        $repeat=false;
        if($sim_ps->simulated!=1)
        {
            $repeat=true;
        }

        if ($period >= 1) {

            // Alle Bestellungen dieser Periode löschen
            Order::model()->deleteAllByAttributes(array('group_id' => $groupId, 'order_period' => $period));

            // Alle Schichtplanungen dieser Periode löschen
            ShiftScheduling::model()->deleteAllByAttributes(array('group_id' => $groupId, 'period' => $period));

            // Produktionsaufträge der aktuellen Periode finden
            ProductionOrder::model()->deleteAllByAttributes(array('group_id' => $groupId, 'order_period' => $period));


            // Alle sim_machine_datas dieser Periode löschen
            SimMachineData::model()->deleteAllByAttributes(array('group_id' => $groupId, 'period' => $period));

            // Warteliste dieser Periode löschen
            SimWaitingProduct::model()->deleteAllByAttributes(array('group_id' => $groupId, 'period' => $period));

            // Lageränderungen dieser Periode löschen
            StockRotation::model()->deleteAllByAttributes(array('group_id' => $groupId, 'period' => $period));

            // Operating Data der Simulation zurücksetzen
            SimOperatingData::model()->deleteAllByAttributes(array('group_id' => $groupId, 'period' => $period));

            // Lager dieser Periode löschen
            Stock::model()->deleteAllByAttributes(array('group_id' => $groupId, 'period' => $period));

            //Simulationslog löschen
            SimLog::model()->deleteAllByAttributes(array('group_id' => $groupId, 'period' => $period));

            //Debuglog löschen
            SimDebugLog::model()->deleteAllByAttributes(array('group_id' => $groupId, 'period' => $period));

            //SimSellings löschen
            SimSelling::model()->deleteAllByAttributes(array('group_id' => $groupId, 'period' => $period));

            //SimResults löschen
            SimResult::model()->deleteAllByAttributes(array('group_id' => $groupId, 'period' => $period));

            //SimProduction Orders löschen
            SimProductionOrder::model()->deleteAllByAttributes(array('group_id' => $groupId, 'period' => $period));

            // Sim-Production Orders löschen, die aus vorherigen Perioden noch nicht fertiggestellt wurden
            $sim_pos = SimProductionOrder::model()->findAllByAttributes(array('group_id' => $groupId, 'period' => $period));

            foreach ($sim_pos as $sim_po) {
                $sim_po->period = $period - 1;
                $sim_po->finished = 0;
                $sim_po->costs = 0;
                // TODO: production_start and _end doesn't exist!
                /*
                $sim_po->production_start = 0;
                $sim_po->production_end = 0;*/

                $sim_po->save();
            }

            // Periodenstatus um eine Periode zurücksetzen
            SimPeriodStatus::model()->deleteAllByAttributes(array('group_id' => $groupId, 'period' => $period));
        }


        if (Yii::app()->user->getChoosedGroup() == $groupId) {
            Yii::app()->user->setChoosedPeriod(SimPeriodStatus::getLastPlayedPeriod($groupId));
        }

        if($repeat)
        {
            $this->redirect(array('admin/resetperiod', 'groupId' => $groupId, 'nextview'=>$nextview));
        }

        // Redirect zur Gruppenübersicht
        $group = Group::model()->findByPk($groupId);
        $this->redirect(array($nextview, 'id' => $group->game_id));

    }

}