<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Edit Profile');

?>

<?php $this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Edit'),
    'subtitle' => Yii::t('app', 'your profile')
)); ?>


<div class="form">


    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'id' => 'editprofile-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>

    <div class="form sharp">


        <?php echo $form->textFieldControlGroup($model, 'prename'); ?>
        <?php echo $form->textFieldControlGroup($model, 'lastname'); ?>
        <?php echo $form->emailFieldControlGroup($model, 'email'); ?>
        <?php echo $form->textFieldControlGroup($model, 'organisation'); ?>

        <div class="span12 noFM">
            <button type="submit" class="btn sharp btn-primary"><?php echo Yii::t('app', 'Save') ?></button>
            <button type="reset" class="btn sharp"><?php echo Yii::t('app', 'Reset') ?></button>
        </div>
    </div>


    <?php $this->endWidget(); ?>
</div><!-- form -->
