<?php


class WaitProductItem
{
    public $missing_product_id;
    public $output_product_id;
    public $cd_machine_id;
    public $production_order_id;
    public $sim_production_order_id;
    public $amount;
    public $period;
    public $group_id;
}

class WaitProductCache
{
    private $_Items;

    public function waitForProduct($missing_product_id, $output_product_id, $cd_machine_id, $production_order_id, $sim_production_order_id, $amount, $period, $group_id)
    {
        $item = new WaitProductItem();
        $item->missing_product_id = $missing_product_id;
        $item->output_product_id = $output_product_id;
        $item->cd_machine_id = $cd_machine_id;
        $item->production_order_id = $production_order_id;
        $item->sim_production_order_id = $sim_production_order_id;
        $item->amount = $amount;
        $item->period = $period;
        $item->group_id = $group_id;
        $this->_Items[$missing_product_id . '-' . $sim_production_order_id] = $item;
    }

    public function unwaitForProduct($missing_product_id, $sim_production_order_id)
    {
        unset($this->_Items[$missing_product_id . '-' . $sim_production_order_id]);
    }

    public function saveToDatabase()
    {
        if (!empty($this->_Items)) {
            foreach ($this->_Items as $key => $item) {
                $simWaitProduct = new SimWaitingProduct();
                $simWaitProduct->missing_product_id = $item->missing_product_id;
                $simWaitProduct->output_product_id = $item->output_product_id;
                $simWaitProduct->cd_machine_id = $item->cd_machine_id;
                $simWaitProduct->production_order_id = $item->production_order_id;
                $simWaitProduct->sim_production_order_id = $item->sim_production_order_id;
                $simWaitProduct->amount = $item->amount;
                $simWaitProduct->period = $item->period;
                $simWaitProduct->group_id = $item->group_id;
                $simWaitProduct->save(false);
            }
        }
    }
}