<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Join Game');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Join'),
    'subtitle' => Yii::t('app', 'to a additional game')
));
?>

<div class="form">


    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'id' => 'joingame-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>

    <div class="form sharp">
        <?php echo $form->textFieldControlGroup($model, 'gamekey', array('help' => Yii::t('app', 'You will get your key from your trainer!'))); ?>
        <div class="span12 noFM">
            <button type="submit" class="btn sharp btn-primary"><?php echo Yii::t('app', 'Join now!') ?></button>
        </div>
    </div>



    <?php $this->endWidget(); ?>
</div><!-- form -->
