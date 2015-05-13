<?php

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'SCSIM HOME');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'SCSIM Phönix'),
    'subtitle' => Yii::t('app', 'Tool for advanced training of supply chains.')
));

?>

<table style="width: 100%" border="0px">

    <tr style="height: 100px">
        <td style="text-align: center"><?php echo CHtml::image(Yii::app()->request->baseUrl . '/img/keyboard_key_1.png', 'IMAGE').'  '. Yii::t('app',"Please start with register yourself...") ?> </td>
        <td style="text-align: center" ><?php echo CHtml::image(Yii::app()->request->baseUrl . '/img/keyboard_key_2.png', 'IMAGE').'  '. Yii::t('app',"Login and choose your game...") ?></td>
        <td style="text-align: center"><?php echo CHtml::image(Yii::app()->request->baseUrl . '/img/keyboard_key_3.png', 'IMAGE').'  '. Yii::t('app',"Calculate and simulate...") ?></td>
    </tr>
    <tr style="height: 100px">
        <td></td>
        <td></td>
        <td</td>
    </tr>
    <tr style="height: 100px">
        <td style="text-align: center"> <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/img/logo_fhkarlsruhe.jpg', 'IMAGE'),'http://www.hs-karlsruhe.de/'); ?></td>
        <td style="text-align: center"> <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/img/dgp-logo.jpg', 'IMAGE'),'http://www.dgp-ka.de/start.html'); ?></td>
        <td style="text-align: center"> <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/img/BlueRain-Banner 250x65.png', 'IMAGE'),'http://www.bluerain.de/'); ?></td>
    </tr>
</table>