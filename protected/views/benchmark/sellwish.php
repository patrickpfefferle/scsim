<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Benchmark of group sell wishes');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Sell wishes'),
    'subtitle' => Yii::t('app', 'Benchmark of group sell wishes')
));

?>
<?php


for ($i = 0; $i <= count($groups) - 1; $i++) {

    $results[$i]['name'] = $groups[$i]->groupname;

    $simresults = SimResult::model()->findAllByAttributes(array('group_id' => $groups[$i]->id),array('order'=>'period ASC'));

    for ($f = 0; $f <= count($simresults) - 1; $f++) {
        $results[$i]['data'][$f] = round($simresults[$f]->sales, 0);
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
                'type' => 'spline',
            ),
            'title' => array('text' => ''),
            'xAxis' => array(
                'categories' => $periods,
                'title' => array('text' => Yii::t('app', 'Period'))
            ),
            'yAxis' => array(
                'title' => array('text' => Yii::t('app', 'Quantity'))
            ),
            'series' => $results
        )
    )
);
?>