<?php
/* @var $machine CdMachine */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Result');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Idle time'),
    'subtitle' => Yii::t('app', 'overview')
));

$group_id = Yii::app()->user->getChoosedGroup();
$period= Yii::app()->user->getChoosedPeriod();

?>

<div class="row-fluid">
    <div class="span12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    <?php echo Yii::t('app', 'Work place'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Setup events'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Idle time'); ?>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Wage idle time costs'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Wage costs'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Machine idle time costs'); ?><br>
                </th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($machines as $machine) { ?>
                <?php $machinedata = SimMachineData::model()->findByAttributes(array('cd_machine_id' => $machine->id, 'group_id' => Yii::app()->user->getChoosedGroup(), 'period' => Yii::app()->user->getChoosedPeriod())) ?>
                <tr>
                    <td>
                        <?php
                        echo CHtml::image(Yii::app()->request->baseUrl . '/img/welding_machine.png', 'IMAGE') . " " .$machine->ident . ' - ' . $machine->description;
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                        $value = Yii::app()->db->createCommand("SELECT Count(*) as 'sum' FROM sim_production_orders WHERE group_id=" . $group_id. " and period=".$period. " and cd_machine_id=".$machine->id ." and set_up_time>0")->queryScalar();
                        echo Yii::app()->format->formatNumber($value);
                       // echo ' ' . Yii::t('app', '');
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                        $value = $machinedata->idle_time;
                        echo Yii::app()->format->formatNumber($value);
                        echo ' ' . Yii::t('app', 'minutes');
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        $value=$machine->wage_shift_one*$machinedata->idle_time_shift_1+$machine->wage_shift_two*$machinedata->idle_time_shift_2+$machine->wage_shift_three*$machinedata->idle_time_shift_3+$machine->wage_overtime*$machinedata->idle_time_overtime;
                        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        $value=$machine->wage_shift_one*$machinedata->production_time_shift_1+$machine->wage_shift_two*$machinedata->production_time_shift_2+$machine->wage_shift_three*$machinedata->production_time_shift_3+$machine->wage_overtime*$machinedata->production_time_overtime;
                        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        $value=$machine->fixed_costs*$machinedata->idle_time;
                        echo Yii::app()->numberFormatter->formatCurrency($value, Yii::t('app', '€'));
                        ?>
                    </td>

                </tr>
            <?php } ?>


            </tbody>
        </table>
    </div>
</div>