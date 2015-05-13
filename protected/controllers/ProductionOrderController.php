<?php

class ProductionOrderController extends Controller
{

    public function accessRules()
    {
        return array(

            array('allow',
                'actions' => array('new'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionHome()
    {
        $this->render('home');
    }

    public function actionInputdata()
    {
        $orders=ProductionOrder::model()->findAllByAttributes(array('group_id' => Yii::app()->user->getChoosedGroup(), 'order_period'=>Yii::app()->user->getChoosedPeriod()),array('order'=>'id asc'));
        $this->render('inputdata',array('orders'=>$orders));
    }


    public function actionNew()
    {
        $this->needChoosedGame();

        $partsAndProducts = CdProduct::model()->findAllByAttributes(array('kind' => array('e', 'p'), 'cd_gameset_id' => Yii::app()->user->GameSet));

        $ps = $period_status = SimPeriodStatus::getCurrentPeriodSet();

        /*
        if (SimPeriodStatus::isReadytoSimulate()) {
            $this->redirect(array('simulation/simulate'));
        }

        if ($ps->orders_set == false) {
            $this->redirect(array('order/new'));
        } else if ($ps->production_orders_set == true) {
            $this->redirect(array('shiftScheduling/new'));
        }*/

        $productionOrders = array();

        if (!empty($_POST['ProductionOrder'])) {

            for ($i = 0; $i <= count($_POST['ProductionOrder']) - 1; $i++) {

                if (!empty($_POST['ProductionOrder'][$i]['cd_product_id'])) {
                    $productionOrder = new ProductionOrder();
                    $productionOrder->attributes = $_POST['ProductionOrder'][$i];
                    $productionOrders[] = $productionOrder;
                }
            }

            $errors = Yii::app()->productionOrder->newProductionOrderInput($productionOrders);


            if (empty($errors)) {
                $this->redirect(array('shiftScheduling/new'));
            } else {
                foreach ($errors as $error) {
                    foreach ($error as $e) {

                        Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', $e));
                    }

                }
                // Restore cd_product_id from POST
                Yii::log("Restoring production orders from POST");
                for ($i = 0; $i <= count($_POST['ProductionOrder']) - 1; $i++) {
                    if (!empty($_POST['ProductionOrder'][$i]['cd_product_id'])) {
                        $productionOrders[$i]->cd_product_id = $_POST['ProductionOrder'][$i]['cd_product_id'];
                        // Yii::log("restored idx ".$i." with value ".$productionOrders[$i]->cd_product_id);
                    }
                }
            }
        } else {
            // Check if there are entities in db
            $existingEntities = ProductionOrder::model()->findAllByAttributes(array('order_period' => $ps->period, 'group_id' => Yii::app()->user->getChoosedGroup()));
            foreach ($existingEntities as $existingEntity) {
                /** @var Order $order */
                $order = $existingEntity;
                $product = CdProduct::model()->findByPk($existingEntity->cd_product_id);
                // $order->attributes = array('cd_product_id' => '21 K', 'amount' => '12', 'order_type' => 'Normal');
                $order->cd_product_id = $product->number;
                $productionOrders[] = $order;
                // replace id with name of CDProduct
            }
        }
/*
        // TODO: disable TESTING!!
        if (false && count($productionOrders) == 0) {
            $order = new ProductionOrder();
            $order->attributes = array('cd_product_id' => '10 E', 'amount' => '5');
            $productionOrders[] = $order;
            $order = new ProductionOrder();
            $order->attributes = array('cd_product_id' => '20 E', 'amount' => '10');
            $productionOrders[] = $order;
            $order = new ProductionOrder();
            $order->attributes = array('cd_product_id' => '50 E', 'amount' => '1');
            $productionOrders[] = $order;
            for ($i = 0; $i < 10; $i++) {
                $order = new ProductionOrder();
                $order->attributes = array('cd_product_id' => '30 E', 'amount' => '1');
                $productionOrders[] = $order;
            }
        }
*/
        $this->render('new', array('partsAndProducts' => $partsAndProducts, 'productionOrders' => $productionOrders));
    }


    public function actionReady()
    {
        $group = Yii::app()->user->getChoosedGroup();
        $period = Yii::app()->user->getChoosedPeriod();
        $poorders = ProductionOrder::model()->findAllByAttributes(array('group_id' => $group, 'ready_period' => $period));
        $this->render('ready', array('poorders' => $poorders));
    }

    public function actionNotReady()
    {
        $group = Yii::app()->user->getChoosedGroup();
        $period = Yii::app()->user->getChoosedPeriod();
        $poorders = ProductionOrder::model()->findAllByAttributes(array('group_id' => $group, 'ready_period' => '-1'));
        $this->render('notready', array('poorders' => $poorders));
    }

    public function actionWaitmaterial()
    {
        $this->render('waitmaterial');
    }

    public function actionDetailView($id)
    {
        //TODO: Mache es noch ....
    }
}