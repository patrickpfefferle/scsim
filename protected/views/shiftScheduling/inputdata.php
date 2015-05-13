<?php
/* @var $machine CdMachine */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'shift scheduling');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Input data'),
    'subtitle' => Yii::t('app', 'shift scheduling')
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
                    <?php echo Yii::t('app', 'Machine'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Shift amount'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Overtime'); ?>
                </th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($shifts as $shift) { ?>
                <tr>
                    <td>
                        <?php
                        echo CHtml::image(Yii::app()->request->baseUrl . '/img/welding_machine.png', 'IMAGE') . " " .$shift->machine->ident . ' - ' . $shift->machine->description;
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                        echo Yii::app()->format->formatNumber($shift->shift_amount);
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                        echo Yii::app()->format->formatNumber($shift->overtime).' '.Yii::t('app','minutes');
                        ?>
                    </td>


                </tr>
            <?php } ?>


            </tbody>
        </table>
    </div>
</div>