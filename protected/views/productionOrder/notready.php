<?php
/* @var $machine CdMachine */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Production orders');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Production orders'),
    'subtitle' => Yii::t('app', 'not ready')
));

$group_id = Yii::app()->user->getChoosedGroup();
$period = Yii::app()->user->getChoosedPeriod();

?>

<div class="row-fluid">
    <div class="span12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    <?php echo Yii::t('app', 'Order id'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Product'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Amount'); ?>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Amount finished'); ?>
                </th>

                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Time need'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Amount on machine'); ?>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Order period'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Gantt color'); ?><br>
                </th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($poorders as $po) { ?>
                <tr>
                    <td>
                        <?php
                        echo $po->order_period . '-' . $po->order_number;
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        switch ($po->cdProduct->kind) {
                            case 'k':
                                echo CHtml::image(Yii::app()->request->baseUrl . '/img/bullet_square_yellow.png', 'IMAGE');
                                break;
                            case 'p':
                                echo CHtml::image(Yii::app()->request->baseUrl . '/img/bullet_square_grey.png', 'IMAGE');
                                break;
                            case 'e':
                                echo CHtml::image(Yii::app()->request->baseUrl . '/img/bullet_square_green.png', 'IMAGE');
                                break;
                        }
                        echo $po->cdProduct->number . " - " . $po->cdProduct->description;
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                        $value = $po->amount;
                        echo Yii::app()->format->formatNumber($value);
                        echo ' ' . Yii::t('app', 'pieces');
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                        $value = Yii::app()->db->createCommand("SELECT Sum(amount) as 'count' FROM sim_production_orders WHERE finished=1 and sequence=(SELECT MAX(SEQUENCE) From sim_production_orders where production_order_id=" . $po->id . ") and production_order_id=" . $po->id)->queryScalar();
                        $afin = $value;
                        echo Yii::app()->format->formatNumber($value);
                        echo ' ' . Yii::t('app', 'pieces');
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                        $value = Yii::app()->db->createCommand("SELECT Sum(cycle_time)-Sum(elapsed_cycle_time) as 'count' FROM sim_production_orders WHERE production_order_id=" . $po->id)->queryScalar();
                        $tfin = $value;
                        echo Yii::app()->format->formatNumber($value);
                        echo ' ' . Yii::t('app', 'minutes');
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                        if ($afin == 0) {
                            $value = 0;
                            $t=0;
                        } else{
                            $value = 10;
                            $t = $tfin / $afin * 10;
                        }
                        echo Yii::app()->format->formatNumber($value);

                        echo ' ' . Yii::t('app', 'pieces') . ' (' . $t . ' ' . Yii::t('app', 'minutes') . ')';
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        echo $po->order_period;
                        ?>
                    </td>
                    <td style="text-align: center; background-color: <?php echo '#' . $po->color_gantt ?>">
                        <?php

                        ?>
                    </td>


                </tr>
            <?php } ?>


            </tbody>
        </table>
    </div>
</div>