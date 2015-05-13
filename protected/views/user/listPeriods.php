<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Choose Period');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Choose'),
    'subtitle' => Yii::t('app', 'current period')
));

foreach ($model as $period) {
    ?>
    <div class="wellDark borBox" style="margin: 0px; margin-bottom: 10px; padding: 20px">
        <b>           <?php
            echo CHtml::image(Yii::app()->request->baseUrl . '/img/component_blue_32.png', '').'  ';


                echo ' ['.Yii::t('app','Period:').' '.$period->period.']';


            ?>
        </b>
        <div class="btn-group sharp pull-right">
            <?php
            echo CHtml::link(
                '<button class="btn btn-info" type="button">' . Yii::t('app', 'use this') . ' <i class="icon-white icon-arrow-right"></i></button>', array('user/choosePeriod', 'period' => $period->period));
            ?>
        </div>
    </div>
<?php
}
?>
