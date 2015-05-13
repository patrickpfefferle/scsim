<?php

class GameController extends Controller
{

    public function actionHome()
    {
        $this->needChoosedGame();
        $currentstockvalue = Yii::app()->db->createCommand("SELECT SUM(price*amount) as 'sum' FROM stocks WHERE group_id=" . Yii::app()->user->ChoosedGroup . " and period=" . Yii::app()->user->ChoosedPeriod)->queryScalar();
        $currentstockamount = Yii::app()->db->createCommand("SELECT SUM(amount) as 'sum' FROM stocks WHERE group_id=" . Yii::app()->user->ChoosedGroup . " and period=" . Yii::app()->user->ChoosedPeriod)->queryScalar();
        $zerostock = Yii::app()->db->createCommand("SELECT Count(*) as 'sum' FROM stocks WHERE group_id=" . Yii::app()->user->ChoosedGroup . " and period=" . Yii::app()->user->ChoosedPeriod . " and amount=0")->queryScalar();


        $this->render('home',array('currentstockvalue' => $currentstockvalue, 'currentstockamount' => $currentstockamount, 'zerostock' => $zerostock));


    }


    public function actionResult()
    {
        $simresult=SimResult::model()->findByAttributes(array('group_id'=>Yii::app()->user->getChoosedGroup(),'period'=>Yii::app()->user->getChoosedPeriod()));
        $this->render('result', array('simresult'=>$simresult));
    }


}