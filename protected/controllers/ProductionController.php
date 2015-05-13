<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11.08.14
 * Time: 16:24
 */
class ProductionController extends Controller
{

    public function actionGanttMain()
    {

        // $poorders = SimProductionOrder::model()->findAllByAttributes(array('group_id' => Yii::app()->user->getChoosedGroup(), 'period' => Yii::app()->user->getChoosedPeriod()));
        //  $operating_data = SimOperatingData::model()->findAllByAttributes(array('group_id' => Yii::app()->user->getChoosedGroup(), 'period' => Yii::app()->user->getChoosedPeriod())
        $this->render('ganttmain');
    }

    public function actionGantt($day=1)
    {

        $this->layout = 'none';

        $game = Game::model()->findByPk(Yii::app()->user->getChoosedGame());
        $machines = CdMachine::model()->findAllByAttributes(array('cd_gameset_id' => $game->cd_gameset_id), array('order' => ' LENGTH(ident), ident asc'));
        $this->render('gantt', array('machines' => $machines, 'day' => $day));
    }

    public function actionHoverId($id)
    {
        $this->layout = 'none';
        $sim_operating_data= SimOperatingData::model()->findByPk($id);

        $production_order= ProductionOrder::model()->findByPk($sim_operating_data->production_order_id);
        $sim_production_order= SimProductionOrder::model()->findByPk($sim_operating_data->sim_production_order_id);
        $cd_product=CdProduct::model()->findByPk($production_order->cd_product_id);

        $this->render('hover',array('sim_operating_data'=>$sim_operating_data,'production_order'=>$production_order,'cd_product'=>$cd_product,'sim_production_order'=>$sim_production_order));
    }


}