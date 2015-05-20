<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 07.08.14
 * Time: 12:08
 */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Upload File Documents');
?>

<section style="height: 892px;" class="span10 content borBox">
    <div class="row-fluid">

        <?php $this->widget('application.components.amai.AmaiPageHeader', array(
            'header' => Yii::t('app', 'Upload'),
            'subtitle' => Yii::t('app', ' simulation data')
        )); ?>

        <?php
        $form = $this->beginWidget(
            'CActiveForm',
            array(
                'id' => 'upload-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
            )
        );
        ?>

        <div class="form sharp">
            <?php


            echo $form->fileField($model, 'inputFile');

            echo $form->error($model, 'inputFile', array('class'=>'span12 sharp error'));
            echo "<br>";
            echo "<br>";
            ?>
            <div class="span12 noFM" align="center">
            <?php
            echo CHtml::submitButton('Submit', array('class' => 'btn sharp btn-primary'));
            ?>
            </div>
            <?php
            $this->endWidget();
            ?>
        </div>
</section>
