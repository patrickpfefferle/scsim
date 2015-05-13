<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'New Game');

?>
<section style="height: 892px;" class="span10 content borBox">
    <div class="row-fluid">

        <?php $this->widget('application.components.amai.AmaiPageHeader', array(
            'header' => Yii::t('app', 'New Game'),
            'subtitle' => Yii::t('app', ' Create a new game')
        )); ?>

        <div class="form">


            <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
                'id' => 'create-game-form',
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
            ));
            ?>
            <div class="form sharp">
                <div class="control-group">
                    <?php
                    echo $form->label($model, 'cd_gameset_id', array('class'=>'control-label'));
                    $gamesetOptions = CHtml::listData(CdGameset::model()->findAll(), 'id', 'description');
                    echo $form->dropDownList($model, 'cd_gameset_id', $gamesetOptions, array('prompt' => Yii::t('app', 'Select your GameSet'), 'style'=>'margin-left: 10px'));
                    echo $form->error($model,'cd_gameset_id');
                    ?>
                </div>

            <?php echo $form->numberFieldControlGroup($model, 'group_count'); ?>
            <?php echo $form->numberFieldControlGroup($model, 'user_per_group'); ?>
            <?php echo $form->textFieldControlGroup($model, 'gamename'); ?>
            <?php echo $form->textFieldControlGroup($model, 'game_key'); ?>


            <div class="span12 noFM">
                <button type="submit" class="btn sharp btn-primary"><?php echo Yii::t('app', 'Create') ?></button>
                <button type="reset" class="btn sharp"><?php echo Yii::t('app', 'Reset') ?></button>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <!-- form -->

    </div>
</section>
