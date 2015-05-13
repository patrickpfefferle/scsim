<?php

/**
 * Class to generate normally derivated random numbers
 *
 * @author   Andreas Vratny <andreas@vratny.de>
 * @author   Marius Heinemann-Grüder <marius.hg@live.de>
 * @version  0.1
 * @access   public
 */
class OrderComponent extends CComponent
{
    /**
     * Init this component
     */
    public function init()
    {


    }

    public function newOrderInput($orders)
    {
        $errors = "";
        $valid = true;

        $ps = SimPeriodStatus::getCurrentPeriodSet();

        for ($i = 0; $i <= count($orders) - 1; $i++) {


            $product = "";
            if (!empty($orders[$i]->cd_product_id)) {
                $product = CdProduct::model()->findByName($orders[$i]->cd_product_id);
            }
            if (!empty($product)) {
                $orders[$i]->cd_product_id = $product->id;

                if (strtolower($orders[$i]->order_type) == 'eil') {
                    $orders[$i]->delivery_costs = $product->delivery_costs * 10;
                    $orders[$i]->calculated_delivery_time = $product->delivery_time / 2;
                } else if (strtolower($orders[$i]->order_type) == 'normal') {
                    $orders[$i]->delivery_costs = $product->delivery_costs;

                    // TODO: Mit Robert bzgl. Sigma sprechen, evtl. delivery_deviation/2 oder delivery_deviation*2
                    $randomNumber = round(Yii::app()->random->getRandomByPolar(($product->delivery_deviation))[0], 1);

                    $orders[$i]->calculated_delivery_time = $product->delivery_time + $randomNumber;
                }

                $orders[$i]->unit_price = $product->value;
                $orders[$i]->total_price = ($product->value * $orders[$i]->amount);
                $orders[$i]->end_price = ($product->value * $orders[$i]->amount) + $orders[$i]->delivery_costs;

            }

            $orders[$i]->group_id = Yii::app()->user->getChoosedGroup();
            $orders[$i]->delivered = 0;
            $orders[$i]->order_period = $ps->period;

            if ($i == 0) {
                $valid = $orders[$i]->validate();
            } else {
                $valid_new = $orders[$i]->validate();
                $valid = $valid && $valid_new;
            }

            if (!$valid) {
                $errors = $orders[$i]->getErrors();
                break;
            }

        }

        if ($valid) {
            $groupId = Yii::app()->user->getChoosedGroup();

            // Alle Bestellungen dieser Periode löschen
            Order::model()->deleteAllByAttributes(array('group_id' => $groupId, 'order_period' => $ps->period));

            foreach ($orders as $order) {
                $order->save();
            }
            $ps->orders_set = 1;
            $ps->save();
        }

        return $errors;
    }

}