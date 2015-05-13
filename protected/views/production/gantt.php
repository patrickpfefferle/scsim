<?php


$items = array();
foreach ($machines as $machine) {
    $items[$machine->id] = array('name' => $machine->description, 'machine_id' => $machine->id, 'ident' => $machine->ident);
    $operating_data = SimOperatingData::model()->findAllByAttributes(array('cd_machine_id' => $machine->id, 'group_id' => Yii::app()->user->getChoosedGroup(), 'period' => Yii::app()->user->getChoosedPeriod(), 'day' => $day), array('order' => 'simtime_start asc'));
    if (empty($operating_data)) {
        $items[$machine->id]['od'] = array();
    } else {
        foreach ($operating_data as $od) {
            $sim_po = SimProductionOrder::model()->findByPk($od->sim_production_order_id);
            $po = ProductionOrder::model()->findByPk($sim_po->production_order_id);
            $product = CdProduct::model()->findByPk($po->cd_product_id);
            $items[$machine->id]['od'][] = array('sod_id'=>$od->id,'day_start' => $od->day_start, 'day_end' => $od->day_end, 'id' => $sim_po->id, 'color' => $sim_po->color_gantt , 'simpo' => $sim_po, 'po'=>$po, 'product'=>$product);
        }
    }

}


$this->widget('application.components.gantt.Gantt', array(
    'items' => $items,
));

?>



