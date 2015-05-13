<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Change Password');

 ?>

<?php $this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Change'),
    'subtitle' => Yii::t('app', 'password for SCSIM')
)); ?>

<div class="form">


    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'id' => 'changepassword-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>

    <div class="form sharp">

        <?php echo $form->passwordFieldControlGroup($model, 'password'); ?>
        <?php echo $form->passwordFieldControlGroup($model, 'password_wdh'); ?>


        <div class="span12 noFM">
            <button type="submit" class="btn sharp btn-primary"><?php echo Yii::t('app', 'Change Password') ?></button>
            <button type="reset" class="btn sharp"><?php echo Yii::t('app', 'Reset') ?></button>
        </div>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
