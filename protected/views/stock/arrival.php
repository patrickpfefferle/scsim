<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Stock');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Stock'),
    'subtitle' => Yii::t('app', 'Arrival Parts')
));

?>

<?php
function getDayString($periodtime)
{
    $periode = floor($periodtime);
    $tage = $periodtime - floor($periodtime);
    $tage = floor($tage * 5)+1;
    if($tage==6)
    {
        $periode=$periode+1;
        $tage=0;
    }
    return Yii::t('app','{period}-{day}-0-0', array('{period}'=>$periode,'{day}'=>$tage));
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
                    <?php echo Yii::t('app', 'Finished'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Material costs'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Order costs'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Entire costs'); ?><br>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Piece costs'); ?><br>
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
                        echo getDayString($order->order_period + $order->calculated_delivery_time);
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        echo Yii::app()->numberFormatter->formatCurrency($order->unit_price * $order->amount, Yii::t('app', '€'));
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        echo Yii::app()->numberFormatter->formatCurrency($order->delivery_costs, Yii::t('app', '€'));
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        echo Yii::app()->numberFormatter->formatCurrency($order->end_price, Yii::t('app', '€'));
                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        echo Yii::app()->numberFormatter->formatCurrency($order->end_price / $order->amount, Yii::t('app', '€'));
                        ?>
                    </td>
                </tr>
            <?php } ?>


            </tbody>
        </table>
    </div>
</div>