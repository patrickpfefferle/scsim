<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Stock');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Stock'),
    'subtitle' => Yii::t('app', 'Missing Parts')
));

?>

<?php
function getDayString($periodtime)
{
    $periode = floor($periodtime);
    $tage = $periodtime - floor($periodtime);
    $tage = floor($tage * 5) + 1;
    if ($tage == 6) {
        $periode = $periode + 1;
        $tage = 0;
    }
    return Yii::t('app', '{period}-{day}-0-0', array('{period}' => $periode, '{day}' => $tage));
}

?>


<div class="row-fluid">
    <div class="span12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    <?php echo Yii::t('app', 'Order number'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Order mode'); ?><br>
                </th>
                <th>
                    <?php echo Yii::t('app', 'Article'); ?>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Quantity'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Lower quantile'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Upper quantile'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Inward stock movement'); ?><br>
                </th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($orders as $order) { ?>
                <tr>
                    <td>
                        <?php
                        echo $order->order_period . '-' . $order->id;
                        ?>
                    </td>
                    <td>
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
                        $output = $order->order_period + $order->cdProduct->delivery_time - $order->cdProduct->delivery_deviation;
                        echo getDayString($output) .  '<span style="font-size:11px">' . Yii::t('app', ' (+1 day to warehouse)') . '</span>';
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        $output = $order->order_period + $order->cdProduct->delivery_time + $order->cdProduct->delivery_deviation;
                        echo getDayString($output) .  '<span style="font-size:11px">' . Yii::t('app', ' (+1 day to warehouse)') . '</span>';
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                     //   echo getDayString($order->order_period + $order->calculated_delivery_time);
                          echo   getDayString($order->order_period +  $order->cdProduct->delivery_time) .  '<span style="font-size:11px">' . Yii::t('app', ' (+1 day to warehouse)') . '</span>';
                        ?>
                    </td>
                </tr>
            <?php } ?>


            </tbody>
        </table>
    </div>
</div>