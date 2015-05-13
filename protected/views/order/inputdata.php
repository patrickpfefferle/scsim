<?php
/* @var $machine CdMachine */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'orders');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Input data'),
    'subtitle' => Yii::t('app', 'orders')
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
                    <?php echo Yii::t('app', 'Product'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Amount'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Delivery type'); ?>
                </th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($orders as $order) { ?>
                <tr>
                    <td>
                        <?php
                        switch ($order->cdProduct->kind) {
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
                        echo $order->cdProduct->number. " - " . $order->cdProduct->description;
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                        echo Yii::app()->format->formatNumber($order->amount);
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        if ($order->order_type == 'Eil') {
                            echo CHtml::image(Yii::app()->request->baseUrl . '/img/box_closed.png', 'IMAGE');
                        } else {
                            echo CHtml::image(Yii::app()->request->baseUrl . '/img/box_white_closed.png', 'IMAGE');
                        }
                        echo ' ';
                        echo Yii::t('app', $order->order_type);
                        ?>
                    </td>


                </tr>
            <?php } ?>


            </tbody>
        </table>
    </div>
</div>