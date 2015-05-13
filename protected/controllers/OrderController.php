<?php

class OrderController extends Controller
{

    public function accessRules()
    {
        return array(

            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('new', 'testSteps'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
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
        $orders=Order::model()->findAllByAttributes(array('group_id' => Yii::app()->user->getChoosedGroup(), 'order_period'=>Yii::app()->user->getChoosedPeriod()),array('order'=>'id asc'));
        $this->render('inputdata',array('orders'=>$orders));
    }


    public function actionNew()
    {
        $this->needChoosedGame();

        $parts = CdProduct::model()->findAllByAttributes(array('kind' => 'k', 'cd_gameset_id' => Yii::app()->user->GameSet));

        $ps = $period_status = SimPeriodStatus::getCurrentPeriodSet();

        /*
        if (SimPeriodStatus::isReadytoSimulate()) {
            $this->redirect(array('simulation/simulate'));
        }

        if ($ps->orders_set == true) {
            $this->redirect(array('productionOrder/new'));
        }*/

        $orders = array();

        if (!empty($_POST['Order'])) {

            for ($i = 0; $i <= count($_POST['Order']) - 1; $i++) {
                if (!empty($_POST['Order'][$i]['cd_product_id'])) {

                    $order = new Order();
                    $order->attributes = $_POST['Order'][$i];
                    $orders[] = $order;

                }
            }

            $errors = Yii::app()->order->newOrderInput($orders);

            if (empty($errors)) {
                $this->redirect(array('productionOrder/new'));
            } else {
                foreach ($errors as $error) {
                    foreach ($error as $e) {

                        Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', $e));
                    }

                }
                // Restore cd_product_id from POST
                // Yii::log("Restoring orders from POST");
                for ($i = 0; $i <= count($_POST['Order']) - 1; $i++) {
                    if (!empty($_POST['Order'][$i]['cd_product_id'])) {
                        $orders[$i]->cd_product_id = $_POST['Order'][$i]['cd_product_id'];
                    }
                }
            }
        } else {
            // Check if there are entities in db
            $existingEntities = Order::model()->findAllByAttributes(array('order_period' => $ps->period, 'group_id' => Yii::app()->user->getChoosedGroup()));
            foreach($existingEntities as $existingEntity) {
                /** @var Order $order */
                $order = $existingEntity;
                $product = CdProduct::model()->findByPk($existingEntity->cd_product_id);
                // $order->attributes = array('cd_product_id' => '21 K', 'amount' => '12', 'order_type' => 'Normal');
                $order->cd_product_id = $product->number;
                $orders[] = $order;
                // replace id with name of CDProduct
            }
        }
/*
        // TODO: disable TESTING!!
        if (false && count($orders) == 0) {
            $order = new Order();
            $order->attributes = array('cd_product_id' => '21 K', 'amount' => '12', 'order_type' => 'Normal');
            $orders[] = $order;
            $order = new Order();
            $order->attributes = array('cd_product_id' => '32 K', 'amount' => '2', 'order_type' => 'Eil');
            $orders[] = $order;
        } */
        $this->render('new', array('parts' => $parts, 'orders' => $orders));


    }
}