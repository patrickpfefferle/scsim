<?php
/* @var $machine CdMachine */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Result');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Result'),
    'subtitle' => Yii::t('app', 'overview')
));

$group_id = Yii::app()->user->getChoosedGroup();

?>

<div class="row-fluid">
<div class="span12">
<table class="table table-bordered">
<thead>
<tr>
    <th style="background-color: #044796; color: white;">
        <?php echo Yii::t('app', 'Description'); ?>
    </th>
    <th style="background-color: #044796; color: white;"><?php echo Yii::t('app', 'Current result'); ?> </th>
    <th style="background-color: #044796; color: white;"><?php echo Yii::t('app', 'Avarage of all periods'); ?></th>
    <th style="background-color: #044796; color: white;"><?php echo Yii::t('app', 'Sum of all periods'); ?></th>
</tr>
</thead>
<tbody>


<tr>
    <td><?php echo Yii::t('app', 'Normal capacity') ?></td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        echo Yii::app()->format->formatNumber($simresult->normal_capacity);
        echo ' ' . Yii::t('app', 'minutes');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT AVG(normal_capacity) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', 'minutes');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT SUM(normal_capacity) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', 'minutes');
        ?> </td>
</tr>


<tr>
    <td><?php echo Yii::t('app', 'Possible capacity') ?></td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        echo Yii::app()->format->formatNumber($simresult->possible_capacity);
        echo ' ' . Yii::t('app', 'minutes');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT AVG(possible_capacity) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', 'minutes');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT SUM(possible_capacity) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', 'minutes');
        ?> </td>
</tr>

<tr>
    <td><?php echo Yii::t('app', 'Capacity ration') ?></td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 2, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        echo Yii::app()->format->formatNumber($simresult->capacity_ratio);
        echo ' ' . Yii::t('app', '%');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 2, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT AVG(capacity_ratio) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', '%');
        ?> </td>
    <td>-</td>
</tr>

<tr>
    <td><?php echo Yii::t('app', 'Productive time') ?></td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        echo Yii::app()->format->formatNumber($simresult->productive_time);
        echo ' ' . Yii::t('app', 'minutes');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT AVG(productive_time) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', 'minutes');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT SUM(productive_time) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', 'minutes');
        ?> </td>
</tr>



<tr>
    <td><?php echo Yii::t('app', 'Efficiency') ?></td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 2, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        echo Yii::app()->format->formatNumber($simresult->efficiency);
        echo ' ' . Yii::t('app', '%');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 2, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT AVG(efficiency) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', '%');
        ?> </td>
    <td>-</td>
</tr>

<tr>
    <td><?php echo Yii::t('app', 'Sales') ?></td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        echo Yii::app()->format->formatNumber($simresult->sales);
        echo ' ' . Yii::t('app', 'products');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT AVG(sales) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', 'products');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT SUM(sales) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', 'products');
        ?> </td>
</tr>

<tr>
    <td><?php echo Yii::t('app', 'Sales Quantity') ?></td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        echo Yii::app()->format->formatNumber($simresult->sales_quantity);
        echo ' ' . Yii::t('app', 'products');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT AVG(sales_quantity) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', 'products');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT SUM(sales_quantity) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', 'products');
        ?> </td>
</tr>

<tr>
    <td><?php echo Yii::t('app', 'Delivery reliability') ?></td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 2, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        echo Yii::app()->format->formatNumber($simresult->delivery_reliability);
        echo ' ' . Yii::t('app', '%');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 2, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT AVG(delivery_reliability) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', '%');
        ?> </td>
    <td>-</td>
</tr>

<tr>
    <td><?php echo Yii::t('app', 'Idle time') ?></td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        echo Yii::app()->format->formatNumber($simresult->idle_time);
        echo ' ' . Yii::t('app', 'minutes');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT AVG(idle_time) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', 'minutes');
        ?> </td>
    <td><?php
        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
        $value = Yii::app()->db->createCommand("SELECT SUM(idle_time) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->format->formatNumber($value);
        echo ' ' . Yii::t('app', 'minutes');
        ?> </td>
</tr>

<tr>
    <td><?php echo Yii::t('app', 'Idle time costs') ?></td>
    <td><?php
        echo Yii::app()->numberFormatter->formatCurrency($simresult->idle_time_costs, Yii::t('app', '€'));
        ?> </td>
    <td><?php
        $value = Yii::app()->db->createCommand("SELECT AVG(idle_time_costs) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
        ?> </td>
    <td><?php
        $value = Yii::app()->db->createCommand("SELECT SUM(idle_time_costs) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
        ?> </td>
</tr>

<tr>
    <td><?php echo Yii::t('app', 'Stock value') ?></td>
    <td><?php
        echo Yii::app()->numberFormatter->formatCurrency($simresult->stock_value, Yii::t('app', '€'));
        ?> </td>
    <td><?php
        $value = Yii::app()->db->createCommand("SELECT AVG(stock_value) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
        ?> </td>
    <td><?php
        $value = Yii::app()->db->createCommand("SELECT SUM(stock_value) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
        ?> </td>
</tr>


<tr>
    <td><?php echo Yii::t('app', 'Storage costs') ?></td>
    <td><?php
        echo Yii::app()->numberFormatter->formatCurrency($simresult->storage_costs, Yii::t('app', '€'));
        ?> </td>
    <td><?php
        $value = Yii::app()->db->createCommand("SELECT AVG(storage_costs) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
        ?> </td>
    <td><?php
        $value = Yii::app()->db->createCommand("SELECT SUM(storage_costs) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
        ?> </td>
</tr>


<tr>
    <th style="background-color: #044796; color: white;" colspan="4"><?php echo Yii::t('app','Normal sale'); ?> </th>
</tr>

<tr>
    <td><?php echo Yii::t('app', 'Sales price') ?></td>
    <td><?php
        echo Yii::app()->numberFormatter->formatCurrency($simresult->normal_sale_price, Yii::t('app', '€'));
        ?> </td>
    <td><?php
        $value = Yii::app()->db->createCommand("SELECT AVG(normal_sale_price) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
        ?> </td>
    <td>- </td>
</tr>

<tr>
    <td><?php echo Yii::t('app', 'Profit') ?></td>
    <td><?php
        echo Yii::app()->numberFormatter->formatCurrency($simresult->normal_sale_profit, Yii::t('app', '€'));
        ?> </td>
    <td><?php
        $value = Yii::app()->db->createCommand("SELECT AVG(normal_sale_profit) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
        ?> </td>
    <td><?php
        $value = Yii::app()->db->createCommand("SELECT SUM(normal_sale_profit) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
        ?> </td>
</tr>

<tr>
    <td><?php echo Yii::t('app', 'Profit/Units') ?></td>
    <td><?php
        echo Yii::app()->numberFormatter->formatCurrency($simresult->normal_sale_profit_unit, Yii::t('app', '€'));
        ?> </td>
    <td><?php
        $value = Yii::app()->db->createCommand("SELECT AVG(normal_sale_profit_unit) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
        ?> </td>
    <td><?php
        $value = Yii::app()->db->createCommand("SELECT SUM(normal_sale_profit_unit) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
        ?> </td>
</tr>

<tr>
    <th><?php echo Yii::t('app', 'Summary') ?></th>
    <th><?php
        echo Yii::app()->numberFormatter->formatCurrency($simresult->summary, Yii::t('app', '€'));
        ?> </th>
    <th><?php
        $value = Yii::app()->db->createCommand("SELECT AVG(summary) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
        ?> </th>
    <th><?php
        $value = Yii::app()->db->createCommand("SELECT SUM(summary) as 'sum' FROM sim_results WHERE group_id=" . $group_id)->queryScalar();
        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
        ?> </th>
</tr>


</tbody>
</table>
</div>
</div>