<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Reset Password');

?>

<?php $this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Reset'),
    'subtitle' => Yii::t('app', ' password for SCSIM')
)); ?>

<div class="form">


    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'id' => 'resetpassword-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <div class="form sharp">
        <?php echo $form->emailFieldControlGroup($model, 'email'); ?>


        <div class="span12 noFM">
            <button type="submit" class="btn sharp btn-primary"><?php echo Yii::t('app', 'Reset Password') ?></button>
            <button type="reset" class="btn sharp"><?php echo Yii::t('app', 'Reset') ?></button>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
