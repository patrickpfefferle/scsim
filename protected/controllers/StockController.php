<?php

/**
 * AmaiNavBar provides php access to the header menu of amai template
 *
 * @author   Andreas Vratny <andreas@vratny.de>
 * @author   Marius Heinemann-Grüder <marius.hg@live.de>
 * @version  1.2
 * @access   public
 */
class StockController extends Controller
{

    /* Controller action to execute the view on the inventory
     *
     * @author   Andreas Vratny <andreas@vratny.de>
     * @version  1.0
     * @access  public
     */
    public function actionInventory()
    {
        $this->needChoosedGame();
        $stocks = Stock::model()->findAll('group_id=:group_id and period=:period', array('group_id' => Yii::app()->user->ChoosedGroup, 'period' => Yii::app()->user->ChoosedPeriod));

        $currentstockvalue = Yii::app()->db->createCommand("SELECT SUM(price*amount) as 'sum' FROM stocks WHERE group_id=" . Yii::app()->user->ChoosedGroup . " and period=" . Yii::app()->user->ChoosedPeriod)->queryScalar();
        $currentstockamount = Yii::app()->db->createCommand("SELECT SUM(amount) as 'sum' FROM stocks WHERE group_id=" . Yii::app()->user->ChoosedGroup . " and period=" . Yii::app()->user->ChoosedPeriod)->queryScalar();
        $zerostock = Yii::app()->db->createCommand("SELECT Count(*) as 'sum' FROM stocks WHERE group_id=" . Yii::app()->user->ChoosedGroup . " and period=" . Yii::app()->user->ChoosedPeriod . " and amount=0")->queryScalar();


        $this->render('inventory', array('stocks' => $stocks, 'currentstockvalue' => $currentstockvalue, 'currentstockamount' => $currentstockamount, 'zerostock' => $zerostock));

    }

    public function actionArrival()
    {
        $this->needChoosedGame();
        $orders = Order::model()->findAllByAttributes(array('group_id' => Yii::app()->user->ChoosedGroup, 'delivery_period' => Yii::app()->user->ChoosedPeriod, 'delivered' => 1));
        $this->render('arrival', array('orders' => $orders));
    }

    public function actionMissing()
    {
        $this->needChoosedGame();
        $orders = Order::model()->findAllByAttributes(array('group_id' => Yii::app()->user->ChoosedGroup, 'delivered' => 0));
        $this->render('missing', array('orders' => $orders));
    }

    public function actionGraphstockproduct($id)
    {
        $this->needChoosedGame();
        $product = CdProduct::model()->findByPk($id);
        if (Yii::app()->user->ChoosedPeriod > 0)
            $Stock = Stock::model()->findByAttributes(array('cd_product_id' => $id, 'group_id' => Yii::app()->user->ChoosedGroup, 'period' => Yii::app()->user->ChoosedPeriod - 1));
        else
            $Stock = Stock::model()->findByAttributes(array('cd_product_id' => $id, 'group_id' => Yii::app()->user->ChoosedGroup, 'period' => Yii::app()->user->ChoosedPeriod));
        $stockrotations = StockRotation::model()->findAllByAttributes(array('cd_product_id' => $id, 'group_id' => Yii::app()->user->ChoosedGroup, 'period' => Yii::app()->user->ChoosedPeriod), array ('group'=>'sim_time ASC'));
        $this->render('graphstockproduct', array('stock' => $Stock, 'stockrotations' => $stockrotations, 'product' => $product));
    }


}