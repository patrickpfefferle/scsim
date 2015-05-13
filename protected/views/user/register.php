<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Register');

?>
<section style="height: 892px;" class="span10 content borBox"><div class="row-fluid">

<?php $this->widget('application.components.amai.AmaiPageHeader', array(
   'header'=>Yii::t('app','Register'),
    'subtitle'=>Yii::t('app',' on SCSIM Phönix')
)); ?>

<div class="form">


    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'id' => 'register-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <div class="form sharp">
        <?php echo $form->textFieldControlGroup($model, 'prename'); ?>
        <?php echo $form->textFieldControlGroup($model, 'lastname'); ?>
        <?php echo $form->textFieldControlGroup($model, 'ident', array('help' => Yii::t('app', 'Please ask your trainer for this!'))); ?>
        <?php echo $form->emailFieldControlGroup($model, 'email'); ?>
        <?php echo $form->textFieldControlGroup($model, 'organisation'); ?>
        <?php echo $form->passwordFieldControlGroup($model, 'password'); ?>
        <?php echo $form->passwordFieldControlGroup($model, 'password_wdh'); ?>
        <?php echo $form->textFieldControlGroup($model, 'gamekey', array('help' => Yii::t('app', 'You will get your key from your trainer!'))); ?>

    <div class="span12 noFM">
        <button type="submit" class="btn sharp btn-primary"><?php echo Yii::t('app', 'Register')?></button>
        <button type="reset" class="btn sharp"><?php echo Yii::t('app', 'Reset')?></button>
    </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->

        </div>
    </section>
