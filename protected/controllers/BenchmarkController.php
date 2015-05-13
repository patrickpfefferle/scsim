<?php

class BenchmarkController extends Controller
{

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('result', 'sale', 'sellWish', 'deliveryReliability', 'idleTime', 'idleTimeCosts', 'overallResult', 'stockCosts', 'productivity', 'workload', 'capacityRatio', 'profitUnit'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionOverallResult()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        $this->render('overallresult', array('groups' => $groups, 'max_period' => $max_period));
    }

    public function actionResult()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        $this->render('result', array('groups' => $groups, 'max_period' => $max_period));
    }

    public function actionProfitUnit()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        $this->render('profitUnit', array('groups' => $groups, 'max_period' => $max_period));
    }

    public function actionDeliveryReliability()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        $this->render('deliveryreliability', array('groups' => $groups, 'max_period' => $max_period));
    }

    public function actionWorkload()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        $this->render('workload', array('groups' => $groups, 'max_period' => $max_period));
    }

    public function actionCapacityRatio()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        $this->render('capacityratio', array('groups' => $groups, 'max_period' => $max_period));
    }

    public function actionProductivity()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        $this->render('productivity', array('groups' => $groups, 'max_period' => $max_period));
    }

    public function actionIdleTime()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        $this->render('idletime', array('groups' => $groups, 'max_period' => $max_period));
    }

    public function actionIdleTimeCosts()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        $this->render('idletimecosts', array('groups' => $groups, 'max_period' => $max_period));
    }

    public function actionStockValue()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        $this->render('stockvalue', array('groups' => $groups, 'max_period' => $max_period));
    }

    public function actionStockCosts()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        $this->render('stockcosts', array('groups' => $groups, 'max_period' => $max_period));
    }

    public function actionSale()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        $this->render('sale', array('groups' => $groups, 'max_period' => $max_period));
    }

    public function actionSellWish()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        $this->render('sellwish', array('groups' => $groups, 'max_period' => $max_period));
    }
}