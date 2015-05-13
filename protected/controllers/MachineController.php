<?php

class MachineController extends Controller
{

    public function actionIndex()
    {
        $machines=CdMachine::model()->findAll('admin_id=:admin_id order by ident+0<>0 DESC, ident+0, ident;',array(':admin_id'=>Yii::app()->user->id));
        $this->render('index', array('machines'=>$machines));
    }

    public function actionIdleTime()
    {
        /*$machinedatas=SimMachineData::model()->findAllByAttributes(array('group_id'=>Yii::app()->user->getChoosedGroup(),'period'=>Yii::app()->user->getChoosedPeriod()));
        $this->render('idletime', array('machinedatas'=>$machinedatas));*/

        $machines=CdMachine::model()->findAll('cd_gameset_id=:cd_gameset_id order by ident+0<>0 DESC, ident+0, ident;',array(':cd_gameset_id'=>Yii::app()->user->GameSet));
        $this->render('idletime', array('machines'=>$machines));
    }


}