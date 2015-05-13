<?php

/**
 * Class to generate normally derivated random numbers
 *
 * @author   Andreas Vratny <andreas@vratny.de>
 * @author   Marius Heinemann-Grüder <marius.hg@live.de>
 * @version  0.1
 * @access   public
 */
class ProductionOrderComponent extends CComponent
{
    /**
     * Init this component
     */
    public function init()
    {


    }

    public function newProductionOrderInput($productionOrders)
    {
        $errors = "";
        $valid = true;

        $ps = SimPeriodStatus::getCurrentPeriodSet();


        for ($i = 0; $i <= count($productionOrders) - 1; $i++) {

            if (!empty($productionOrders[$i]->cd_product_id)) {

                $product = cdProduct::model()->findByAttributes(array('number' => $productionOrders[$i]->cd_product_id));
            }
                if (!empty($product)) {
                    $productionOrders[$i]->cd_product_id = $product->id;
                }
                $productionOrders[$i]->group_id = Yii::app()->user->getChoosedGroup();
                $productionOrders[$i]->order_period = $ps->period;

                if ($i == 0) {
                    $valid = $productionOrders[$i]->validate();
                } else {
                    $valid_new = $productionOrders[$i]->validate();
                    $valid = $valid && $valid_new;
                }

            if (!$valid) {
                $errors = $productionOrders[$i]->getErrors();
                break;
            }

        }
        if ($valid) {
            $groupId = Yii::app()->user->getChoosedGroup();
            $period = SimPeriodStatus::getCurrentPeriod($groupId);

            // Produktionsaufträge der aktuellen Periode finden und löschen
            ProductionOrder::model()->deleteAllByAttributes(array('group_id' => $groupId, 'order_period' => $period));

            $number = 0;
            foreach ($productionOrders as $productionOrder) {
                $number++;
                $productionOrder->color_gantt = Yii::app()->color->getRandomColor();
                $productionOrder->order_number = $number;
                $productionOrder->save();
            }
            $ps->production_orders_set = 1;
            $ps->save();

        }
        return $errors;
    }

}