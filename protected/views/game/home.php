<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Dashboard');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Dashboard'),
    'subtitle' => Yii::t('app', '')
));


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
    <div class="span6 borBox wellLight">
        <?php

        $groups = Group::model()->findAllByAttributes(array('id' => Yii::app()->user->getChoosedGroup()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        for ($i = 0; $i <= count($groups) - 1; $i++) {

            $results[$i]['name'] = $groups[$i]->groupname;

            $simresults = SimResult::model()->findAllByAttributes(array('group_id' => $groups[$i]->id), array('order' => 'period ASC'));

            for ($f = 0; $f <= count($simresults) - 1; $f++) {
                $results[$i]['data'][$f] = round($simresults[$f]->summary, 2);
            }
        }

        if ($max_period <= 3) {
            $max_period = 3;
        }

        for ($i = 1; $i <= $max_period; $i++) {
            $periods[] = $i;
        }

        $this->widget(
            'yiiwheels.widgets.highcharts.WhHighCharts',
            array(
                'pluginOptions' => array(
                    'chart' => array(
                        'type' => 'column',
                    ),
                    'title' => array('text' => Yii::t('app', 'Result')),
                    'xAxis' => array(
                        'categories' => $periods,
                        'title' => array('text' => Yii::t('app', 'Period'))
                    ),
                    'yAxis' => array(
                        'title' => array('text' => Yii::t('app', '€'))
                    ),
                    'series' => $results
                )
            )
        );
        ?>
    </div>

    <div class="span6 borBox wellLight">
        <?php
        $groups = Group::model()->findAllByAttributes(array('id' => Yii::app()->user->getChoosedGroup()));
        $max_period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_results')->where('game_id=:game_id', array(':game_id' => Yii::app()->user->getChoosedGame()))->queryScalar();
        for ($i = 0; $i <= count($groups) - 1; $i++) {

            $results[$i]['name'] = $groups[$i]->groupname;

            $simresults = SimResult::model()->findAllByAttributes(array('group_id' => $groups[$i]->id), array('order' => 'period ASC'));

            for ($f = 0; $f <= count($simresults) - 1; $f++) {
                $results[$i]['data'][$f] = round($simresults[$f]->delivery_reliability, 2);
            }
        }

        if ($max_period <= 3) {
            $max_period = 3;
        }

        for ($i = 1; $i <= $max_period; $i++) {
            $periods[] = $i;
        }

        $this->widget(
            'yiiwheels.widgets.highcharts.WhHighCharts',
            array(
                'pluginOptions' => array(
                    'chart' => array(
                        'type' => 'column',
                    ),
                    'title' => array('text' => Yii::t('app', 'Delivery reliability')),
                    'xAxis' => array(
                        'categories' => $periods,
                        'title' => array('text' => Yii::t('app', 'Period')),
                    ),
                    'yAxis' => array(
                        'title' => array('text' => Yii::t('app', 'Percent'))
                    ),
                    'series' => $results
                )
            )
        );?>
    </div>
</div>


