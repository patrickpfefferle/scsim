<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Admin Choose Group');

$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links' => array(
        Yii::t('app', 'Admin Choose Group'),
    ),
)); ?>

<?php

foreach ($groups as $group) {
    ?>
    <div class="wellLight borBox"
         style="padding-top: 0px; padding-left: 0px ; padding-right: 0px; padding-bottom: 0px; margin-bottom: 10px">
        <div class="wellBlue borBox" style="margin: 0px; margin-bottom: 10px; padding: -1px">
            <?php echo CHtml::image(Yii::app()->request->baseUrl . '/img/users3.png', '') . '  ' . $group->groupname; ?>

            <div class="pull-right">

                <?php
                $period = SimPeriodStatus::getLastPlayedPeriod($group->id);

                if ($period > 0) {
                    echo '<b>' . Yii::t('app', 'Current played period: {p}', array('{p}' => $period)) . ' </b>';
                    echo CHtml::link(
                        '<button class="btn btn-warning sharp" style="margin-bottom:5px;" type="button"><i class="icon-white icon-minus"></i> ' . Yii::t('app', 'Reset to Period {p}', array('{p}' => $period - 1)) . '</button>', array('admin/resetperiod', 'groupId' => $group->id,'nextview'=>'group/viewgroups'));
                } else
                {
                    echo '<b>' . Yii::t('app', 'Currently no period played') . ' </b>';
                }
                $period = 0;
                ?>
                <?php

                echo CHtml::link(
                    '<button class="btn btn-info sharp" style="margin-top:-5px;" type="button"><i class="icon-white icon-refresh"></i> ' . Yii::t('app', 'Switch') . '</button>', array('group/switch', 'id' => $group->id));
                ?>
            </div>
            <hr>
        </div>
        <div style="margin: 10px;">
            <?php echo Yii::t('app', '{usercount} of {usermax} members are in the group', array('{usercount}' => $group->user_count, '{usermax}' => $group->user_max)); ?>
            <?php echo TbHtml::progressBar($group->user_count / $group->user_max * 100, array('color' => 'bar-success')); ?>
        </div>
    </div>
<?php
}
?>