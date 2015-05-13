<?php
/* @var $machine CdMachine */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Production orders');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Production orders'),
    'subtitle' => Yii::t('app', 'ready')
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
                    <?php echo Yii::t('app', 'Order id'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Product'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Amount'); ?>
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
                            echo $po->order_period.'-'.$po->order_number;
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
                           echo $po->cdProduct->number." - ".$po->cdProduct->description;
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
                            echo $po->order_period;
                        ?>
                    </td>
                    <td style="text-align: center; background-color: <?php echo '#'.$po->color_gantt ?>">
                        <?php

                        ?>
                    </td>


                </tr>
            <?php } ?>


            </tbody>
        </table>
    </div>
</div>