<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Login');
?>

<section class='container-fluid'>
    <div class='row-fluid landing'>
        <div class='span4'><br/></div>
        <div class='span4 borBox'>
            <div class='navbar blue'>
                <div class='navbar-inner'>
                    <div class='container-fluid'>
                        <p class='wtext'>Login</p>
                    </div>
                </div>
            </div>
            <div class='row-fluid well borBox whiter'>
                <div class='form-horizontal tCenter'>
                    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                        'id' => 'register-form',
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                        ),
                    )); ?>

                    <fieldset>
                        <?php echo $form->textFieldControlGroup($model, 'email', array('class'=>'span12 sharp')); ?>
                        <?php echo $form->passwordFieldControlGroup($model,'password',array('class'=>'span12 sharp',
                            'help'=> CHtml::link('<p class="text-info">'. Yii::t('app', 'I forgot my password').'</p>', array('user/resetPassword')),)); ?>
                        <?php echo $form->checkBoxControlGroup($model, 'rememberMe'); ?>
                    </fieldset>

                    <div class="span12 noFM">
                        <button type="submit" class="btn sharp btn-primary"><?php echo Yii::t('app', 'Login')?></button>
                        <button type="reset" class="btn sharp"><?php echo Yii::t('app', 'Reset')?></button>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>

    </div>
</section>


