<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Choose Group');

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links' => array(
        Yii::t('app', 'Choose Group'),
    ),
)); ?>

<?php

foreach ($model as $group) {
    ?>
    <div class="wellLight borBox" style="padding-top: 0px; padding-left: 0px ; padding-right: 0px; padding-bottom: 0px; margin-bottom: 10px">
        <div class="wellBlue borBox" style="margin: 0px; margin-bottom: 10px; padding: -1px">
            <?php echo CHtml::image(Yii::app()->request->baseUrl . '/img/users3.png', '').'  '. $group->groupname; ?>

            <div class="pull-right">
                <?php
                if ($group->user_count >= $group->user_max) {
                    echo TbHtml::labelTb(Yii::t('app','Group is full'), array('color' => TbHtml::LABEL_COLOR_IMPORTANT));;
                } else {
                    echo CHtml::link(
                        '<button class="btn btn-info sharp" style="margin-top:-5px;" type="button"><i class="icon-white icon-plus"></i> ' . Yii::t('app', 'Join now!') . '</button>', array('group/join', 'id' => $group->id));
                }
                ?>
            </div>
            <hr>
        </div>
        <div style="margin: 10px;">
            <?php echo Yii::t('app','{usercount} of {usermax} members are in the group',array('{usercount}'=>$group->user_count,'{usermax}'=>$group->user_max));?>
            <?php echo TbHtml::progressBar($group->user_count / $group->user_max * 100,array('color'=>'bar-success')); ?>
        </div>
    </div>
<?php
}
?>
