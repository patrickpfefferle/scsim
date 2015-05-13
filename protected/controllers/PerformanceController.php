<?php

class PerformanceController extends Controller
{
    //Is Simulation in Debugmode?
    private $debug = false;
    private $findAllCount = 10000;
    private $cd_machine_id = 36;
    private $group_id = 202;
    private $period = 0;


    private function resetDummies($insertProdOrders) {
        // WARN: Delete all data
        SimProductionOrder::model()->deleteAllByAttributes(array('group_id' => $this->group_id, 'period' => $this->period));

        Yii::beginProfile('Inserting '.$insertProdOrders.' dummy sim prod orders');

        // # id, period, cd_machine_id, group_id, amount, production_order_id, finished, finish_period, cycle_time, elapsed_cycle_time, costs, set_up_time, clearing_time, cd_workflow_id, cd_step_id, production_number, sequence, color_gantt, status, created
        // 48868, 0, 36, 202,                           10,            1800,     0,            1,          60,         60,                0,           30, ,                    19, 37, 1, 1, 79352e, finished, 2014-09-10 16:24:55


        for($i=0;$i<$insertProdOrders;$i++) {
            $spo = new SimProductionOrder();
            $spo->period = $this->period;
            $spo->cd_workflow_id = 19; // $usedWorkflow->id;
            $spo->cd_step_id = 37; // $step->id;
            $spo->cd_machine_id = 33; // $step->cd_machine_id;
            $spo->production_order_id = 1800;// $po->id;
            $spo->sequence = 0; // $step->sequence;
            $spo->group_id = $this->group_id; // $group->id;
            $spo->finished = 0;
            $spo->color_gantt = ''; // $po->color_gantt;
            $spo->production_number = 1; // $po_number;

            $spo->cycle_time = 10 * 10;
            $spo->save(false);
        }
        Yii::endProfile('Inserting '.$insertProdOrders.' dummy sim prod orders');
    }


    public function actionIndex()
    {
        set_time_limit(600);

        $group_id = $this->group_id;
        $period = $this->period;
        $cd_machine_id = $this->cd_machine_id;

        $dependency = null; // new CDbCacheDependency('SELECT 1');
        $obj = SimProductionOrder::model()->cache(100000, $dependency);

        $this->resetDummies(200);

        Yii::beginProfile('Find all dummy sim prod orders with cache');

        for($i=0;$i<$this->findAllCount;$i++) {
            $data = $obj->findAll('group_id=:group_id and cd_machine_id=:machine_id and finished=false order by id asc', array('group_id' => $group_id, 'machine_id' => $cd_machine_id));
            // $data = $obj->findAll();
        }
        Yii::endProfile('Find all dummy sim prod orders with cache');



        // SimProductionOrder::model()->findAll('group_id=:group_id and cd_machine_id=:machine_id and finished=false and status="incomplete wait" order by id asc', array('group_id' => $group_id, 'machine_id' => $cd_machine_id));
    }

    function actionIndex2() {

        $this->resetDummies(200);

        Yii::beginProfile('Find all dummy sim prod orders without cache');
        for($i=0;$i<$this->findAllCount;$i++) {
            SimProductionOrder::model()->findAll('group_id=:group_id and cd_machine_id=:machine_id and finished=false order by id asc', array('group_id' => $this->group_id, 'machine_id' => $this->cd_machine_id));
            // $data = SimProductionOrder::model()->findAll();
        }
        Yii::endProfile('Find all dummy sim prod orders without cache');
    }
}
