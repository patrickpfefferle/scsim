<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Inventory');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Inventory'),
    'subtitle' => Yii::t('app', '')
));

?>

<?php
function getChangeIcon($current, $old)
{
    $change = $current - $old;
    if ($old == 0) {
        $percent = 0;
    } else {
        $percent = $change / ($old / 100);
    }

    if ($percent < 0) {
        if ($percent * -1 < 1) {
            //Keine oder geringe Änderung
            return CHtml::image(Yii::app()->request->baseUrl . '/img/same.png', 'IMAGE', array('align' => 'right'));
        } else {
            //Tendenz nach unten
            return CHtml::image(Yii::app()->request->baseUrl . '/img/down.png', 'IMAGE', array('align' => 'right'));
        }
    } else {
        if ($percent < 1) {
            //Keine oder geringe Änderung
            return CHtml::image(Yii::app()->request->baseUrl . '/img/same.png', 'IMAGE', array('align' => 'right'));
        } else {
            //Tendenz nach oben
            return CHtml::image(Yii::app()->request->baseUrl . '/img/up.png', 'IMAGE', array('align' => 'right'));
        }
    }
}

?>
<div class="row-fluid">
    <div class="span12 borBox wellLight btn-dashboard">
        <div class="row-fluid">
            <div class="span6 tLeft">
                <h2><?php echo Yii::t('app', 'Overall stock value'); ?></h2>

                <h3><?php echo Yii::app()->numberFormatter->formatCurrency($currentstockvalue, Yii::t('app', '€')); ?></h3>
            </div>
            <div class="span3 tRight">
                <h3><?php
                    Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                    echo Yii::app()->format->formatNumber($currentstockamount);
                    ?></h3>

                <h4><?php echo Yii::t('app', 'Overall stock amount'); ?></h4>
            </div>
            <div class="span3 tRight">
                <h3><?php
                    Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                    echo Yii::app()->format->formatNumber($zerostock);
                    ?></h3>

                <h4><?php echo Yii::t('app', 'Zero stock products'); ?></h4>
            </div>
        </div>
    </div>
</div>

<br>
<div class="row-fluid">
    <div class="span12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    <?php echo Yii::t('app', 'Article'); ?>
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Current stock amount'); ?><br>
                    (<?php echo Yii::t('app', 'Old stock amount'); ?>)
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Start stock amount'); ?><br>
                    (<?php echo Yii::t('app', 'Quantity/StartQuantity'); ?>)
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Current stock value per piece'); ?><br>
                    (<?php echo Yii::t('app', 'Old stock value per piece'); ?>)
                </th>
                <th style="text-align: center">
                    <?php echo Yii::t('app', 'Current stock value'); ?><br>
                    (<?php echo Yii::t('app', 'Old stock value'); ?>)
                </th>

            </tr>
            </thead>
            <tbody>

            <?php foreach ($stocks as $stock) { ?>
                <?php
                $oldstock = Stock::model()->findByAttributes(array('cd_product_id' => $stock->cd_product_id, 'group_id' => Yii::app()->user->ChoosedGroup, 'period' => Yii::app()->user->ChoosedPeriod - 1));
                if (empty($oldstock)) {
                    $oldstock = $stock;
                }

                $startstock = Stock::model()->findByAttributes(array('cd_product_id' => $stock->cd_product_id, 'group_id' => Yii::app()->user->ChoosedGroup, 'period' => '0'));
                if (empty($startstock)) {
                    $startstock = $stock;
                }
                ?>
                <tr>
                    <td>
                        <?php
                        switch ($stock->cdProduct->kind) {
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
                        echo CHtml::link($stock->cdProduct->number, array('stock/graphstockproduct', 'id' => $stock->cdProduct->id));                        ?>
                    </td>
                    <td style="text-align: center">
                        <?php if ($stock->amount <= 0) {
                            echo CHtml::image(Yii::app()->request->baseUrl . '/img/sign_warning.png', 'IMAGE', array('align' => 'left'));
                        } ?>
                        <b>
                            <?php
                            Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                            echo Yii::app()->format->formatNumber($stock->amount);
                            ?>
                        </b>
                        (<?php
                        echo Yii::app()->format->formatNumber($oldstock->amount);
                        ?>)
                        <?php echo ' ' . getChangeIcon($stock->amount, $oldstock->amount); ?>
                    </td>
                    <td style="text-align: center">
                        <?php
                        Yii::app()->format->numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                        echo Yii::app()->format->formatNumber($stock->cdProduct->start_amount);
                        Yii::app()->format->numberFormat = array('decimals' => 2, 'decimalSeparator' => ',', 'thousandSeparator' => '.');
                        if ($startstock->amount == 0) {
                            echo ' (- %)';
                        } else
                            echo ' (' . Yii::app()->format->formatNumber($stock->amount / ($startstock->amount / 100)) . '%)';
                        ?>
                    </td>
                    <td style="text-align: center">
                        <b>
                            <?php
                            echo Yii::app()->numberFormatter->formatCurrency($stock->price, Yii::t('app', '€'));
                            ?>
                        </b>
                        (<?php echo Yii::app()->numberFormatter->formatCurrency($oldstock->price, Yii::t('app', '€')); ?>
                        )
                        <?php echo ' ' . getChangeIcon($stock->price, $oldstock->price); ?>
                    </td>
                    <td style="text-align: center">
                        <b>
                            <?php
                            echo Yii::app()->numberFormatter->formatCurrency($stock->price * $stock->amount, Yii::t('app', '€'));
                            ?>
                        </b>
                        (<?php echo Yii::app()->numberFormatter->formatCurrency($oldstock->price * $oldstock->amount, Yii::t('app', '€')); ?>
                        )
                        <?php echo ' ' . getChangeIcon($stock->price * $stock->amount, $oldstock->price * $oldstock->amount); ?>
                    </td>
                </tr>
            <?php } ?>


            </tbody>
        </table>
    </div>
</div>