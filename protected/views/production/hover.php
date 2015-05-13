<div
    style="text-align: center; border: solid #0650A7 1px; margin: 0px; background: #0650A7; color: white"><?php echo Yii::t('app', 'Further informations'); ?> </div>
<table>
    <tr>
        <td><b><?php echo Yii::t('app', 'End product:') ?></b></td>
        <td style="min-width: 20px"></td>
        <td>
            <?php
            switch ($cd_product->kind) {
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
            ?>
            <?php echo $cd_product->number ?>


        </td>
    </tr>
    <tr>
        <td><b><?php echo Yii::t('app', 'Description:') ?></b></td>
        <td style="min-width: 20px"></td>
        <td><?php echo $cd_product->description ?> </td>
    </tr>
    <tr>
        <td><b><?php echo Yii::t('app', 'Order period:') ?></b></td>
        <td style="min-width: 20px"></td>
        <td><?php echo $production_order->order_period ?> </td>
    </tr>
    <tr>
        <td><b><?php echo Yii::t('app', 'Total order amount:') ?></b></td>
        <td style="min-width: 20%"></td>
        <td>
            <?php Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
            echo Yii::app()->format->formatNumber($production_order->amount);
            echo ' ' . Yii::t('app', 'pieces');
            ?>
        </td>
    </tr>
    <tr>
        <td><b><?php echo Yii::t('app', 'Single order amount:') ?></b></td>
        <td style="min-width: 20px"></td>
        <td>
            <?php
            $one_piece_time=$sim_production_order->cycle_time/$sim_production_order->amount;
            $correct_piece=($sim_operating_data->day_end-$sim_operating_data->day_start-$sim_production_order->set_up_time) / $one_piece_time;

            Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
            echo Yii::app()->format->formatNumber($correct_piece);
            echo ' ' . Yii::t('app', 'pieces');
            ?>
        </td>
    </tr>
    <tr>
        <td><b><?php echo Yii::t('app', 'Total setup time:') ?></b></td>
        <td style="min-width: 20px"></td>
        <td><?php Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
            echo Yii::app()->format->formatNumber($sim_production_order->set_up_time);
            echo ' ' . Yii::t('app', 'minutes');
            ?>
        </td>
    </tr>
    <tr>
        <td><b><?php echo Yii::t('app', 'Cycle time:') ?></b></td>
        <td style="min-width: 20px"></td>
        <td>
            <?php Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
            echo Yii::app()->format->formatNumber($sim_operating_data->day_end-$sim_operating_data->day_start);
            echo ' ' . Yii::t('app', 'minutes');
            ?>
        </td>
    </tr>

    <tr>
        <td><b><?php echo Yii::t('app', 'Total costs:') ?></b></td>
        <td style="min-width: 20px"></td>
        <td><?php
            echo Yii::app()->numberFormatter->formatCurrency($sim_operating_data->costs, Yii::t('app', '€'));
            ?>
        </td>
    </tr>

</table>