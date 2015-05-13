<?php
class MachineItem
{
    public $id;
    public $cd_workflow_id;
    public $production_order_id;
    public $sequence;
}

class MachineCache
{

    private $_Items;

    public function setLastSimPo($sim_machine_id, $sim_production_order)
    {
        $aItem = new MachineItem();
        $aItem->id=$sim_machine_id;
        $aItem->cd_workflow_id=$sim_production_order->cd_workflow_id;
        $aItem->sequence=$sim_production_order->sequence;
        $aItem->production_order_id=$sim_production_order->production_order_id;
        $this->_Items[$sim_machine_id]=$aItem;
    }

    public function isSameItem($sim_machine_id, $sim_production_order)
    {
        $aItem=@$this->_Items[$sim_machine_id];
        if(empty($aItem))
        {
            return false;
        }

        return ($this->_Items[$sim_machine_id]->cd_workflow_id==$sim_production_order->cd_workflow_id && $this->_Items[$sim_machine_id]->sequence==$sim_production_order->sequence);
    }

    public function getLastProductionOrderId($sim_machine_id)
    {
        return @$this->_Items[$sim_machine_id]->production_order_id;
    }


}


