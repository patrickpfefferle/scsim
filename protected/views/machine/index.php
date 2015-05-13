<?php
/* @var $machine CdMachine */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Machines');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Machines'),
    'subtitle' => Yii::t('app', 'overview')
));

?>

<div class="row-fluid">
    <div class="span12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    <?php echo Yii::t('app', '#'); ?>
                </th>
                <th><?php echo Yii::t('app', 'Description'); ?> </th>
                <th><?php echo Yii::t('app', 'Running costs'); ?></th>
                <th><?php echo Yii::t('app', 'Fixed costs'); ?></th>
                <th><?php echo Yii::t('app', 'Cost price'); ?></th>
                <th><?php echo Yii::t('app', 'Replacement time'); ?></th>
                <th><?php echo Yii::t('app', 'Replacement deviation'); ?></th>
                <th><?php echo Yii::t('app', 'Options'); ?></th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($machines as $machine) { ?>
                <tr>
                    <td><?php echo CHtml::image(Yii::app()->request->baseUrl . '/img/welding_machine.png', 'IMAGE') . " " . $machine->ident ?></td>
                    <td><?php echo $machine->description ?> </td>
                    <td style="text-align: right"><?php echo Yii::app()->numberFormatter->formatCurrency($machine->running_costs, Yii::t('app', '€/min ')); ?> </td>
                    <td style="text-align: right"><?php echo Yii::app()->numberFormatter->formatCurrency($machine->fixed_costs ,Yii::t('app', '€/min ')); ?></td>
                    <td style="text-align: right"><?php echo Yii::app()->numberFormatter->formatCurrency($machine->cost_price, Yii::t('app', '€ ')); ?></td>
                    <td style="text-align: right"><?php echo $machine->replacement_time ?> <?php echo Yii::t('app', 'periods'); ?></td>
                    <td style="text-align: right"><?php echo $machine->replacement_deviation ?> <?php echo Yii::t('app', 'periods'); ?></td>
                    <td>
                        <div class="btn-group sharp" data-toggle="radio">
                            <?php
                            echo CHtml::link('<button class="btn btn-mini btn-success"><i class="icon-white icon-eye-open"></i></button>', array('machine/view', 'id' => $machine->id));
                            ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>


            </tbody>
        </table>
    </div>
</div>