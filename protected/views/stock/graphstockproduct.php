<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Detail of Product');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Stock'),
    'subtitle' => Yii::t('app', 'Detail of Product')
));

?>
<?php
/*
if(Yii::app()->user->getChoosedPeriod() == 0)
{
    for ($i = 0; $i < 5; $i++) {
        $days[] = $stock->amount + 0;
    }
}
else
{
for ($i = 0; $i < 5; $i++) {
    $days[] = $stock->amount + 0;
}


foreach ($stockrotations as $stockrotation) {

    $tag = floor($stockrotation->sim_time / 1440);
    for ($d = $tag; $d >= 0; $d--) {
        $days[$d] = $days[$d] - $stockrotation->amount;
    }

}
}
*/


$results['name'] = $product->number;

$results['data'][] = $stock->amount + 0;

$periods[] = 0;

$lastvalue=$stock->amount ;
for ($f = 0; $f <= count($stockrotations) - 1; $f++) {

    $results['data'][] = $stockrotations[$f]->amount +$lastvalue;
    $lastvalue=$stockrotations[$f]->amount +$lastvalue;

    $periods[] = $stockrotations[$f]->sim_time + 0;
}


$this->widget(
    'yiiwheels.widgets.highcharts.WhHighCharts',
    array(
        'pluginOptions' => array(
            'chart' => array(
                'type' => 'area',
            ),
            'title' => array('text' => $product->description),
            'xAxis' => array(
                'categories' => $periods,
                'title' => array('text' => Yii::t('app', 'Minutes'))
            ),
            'yAxis' => array(
                'title' => array('text' => Yii::t('app', 'Pieces'))
            ),
            'series' => array($results)
        )
    )
);
?>