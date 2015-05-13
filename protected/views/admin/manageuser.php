<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Manage User');

?>
<section style="height: 892px;" class="span10 content borBox">
    <div class="row-fluid">

        <?php $this->widget('application.components.amai.AmaiPageHeader', array(
            'header' => Yii::t('app', 'Manage ') . $model->email,
            'subtitle' => Yii::t('app', '')
        )); ?>

        <div class="form">


            <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                'id' => 'manageuser-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <div class="form sharp">
                <?php echo $form->textFieldControlGroup($model, 'prename'); ?>
                <?php echo $form->textFieldControlGroup($model, 'lastname'); ?>
                <?php echo $form->textFieldControlGroup($model, 'ident'); ?>
                <?php echo $form->emailFieldControlGroup($model, 'email'); ?>
                <?php echo $form->textFieldControlGroup($model, 'organisation'); ?>
                <hr>
                <?php // echo $form->textFieldControlGroup($model, 'valid_until'); ?>
                <?php

                $from = date('Y');
                $to = date('Y') + 10;
                $range = $from . ":" . $to;
                ?>

                <div class="control-group">
                    <?php
                    echo $form->label($model, 'valid_until', array('class' => 'control-label'));
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'valid_until',
                        'language' => $_SESSION['lang'],
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeYear' => true,
                            'yearRange' => $range,

                        ),
                        'htmlOptions' => array(
                            'size' => '10',
                            'maxlength' => '10',
                            'style' => 'margin-left: 10px'
                        ),

                    ));
                    ?>
                </div>
                <?php echo $form->checkBoxControlGroup($model, 'is_admin'); ?>
                <?php echo $form->checkBoxControlGroup($model, 'is_mod'); ?>
                <?php echo $form->checkBoxControlGroup($model, 'blocked'); ?>
                <hr>
                <?php echo $form->numberFieldControlGroup($model, 'max_games', array('append' => Yii::t('app', 'Games'))); ?>
                <?php echo $form->numberFieldControlGroup($model, 'max_groups', array('append' => Yii::t('app', 'Groups'))); ?>
                <?php echo $form->numberFieldControlGroup($model, 'max_user_per_group', array('append' => Yii::t('app', 'User'))); ?>


                <div class="span12 noFM">
                    <button type="submit" class="btn sharp btn-primary"><?php echo Yii::t('app', 'Save') ?></button>
                    <button type="reset" class="btn sharp"><?php echo Yii::t('app', 'Reset') ?></button>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
        <!-- form -->

    </div>
</section>
