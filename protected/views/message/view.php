<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 02.03.14
 * Time: 14:55
 */

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Detail'),
    'subtitle' => Yii::t('app', 'view of Message')
));
?>
<div class="wellDark borBox">
    <?php echo Yii::t('app', 'From:') . " " . $message->from() ?>
    <br>
    <?php echo Yii::t('app', 'Date:') . " " . Yii::app()->dateFormatter->format('dd.MM.yyyy HH:mm:ss', $message->created)

    ?>
    <br>
    <b><?php echo Yii::t('app', 'Subject:') . " " . $message->header ?> </b>
    <br>

    <div class="row-fluid">
        <div class="btn-group sharp pull-right">
            <?php
            echo CHtml::link('<button class="btn btn-success"><i class="icon-white icon-share"></i> ' . Yii::t('app', 'reply') . '</button>', array('message/new', 'id' => $message->id));
            if (empty($message->to_group_id)) {
                echo CHtml::link('<button class="btn btn-danger"><i class="icon-white icon-remove"></i> ' . Yii::t('app', 'remove') . '</button>', array('message/delete', 'id' => $message->id));
            }
            ?>
        </div>
    </div>

</div>
</br>
<h3><?php echo CHtml::image(Yii::app()->request->baseUrl . '/img/mail_open.png', 'IMAGE') . " " . Yii::t('app', 'Message:') ?></h3>
<div class="wellLight borBox" style="min-height:250px;">
    <b><?php echo $message->message ?> </b>
</div>
<br>
<?php echo CHtml::link('<button class="btn btn-info"><i class="icon-white icon-arrow-left"></i> ' . Yii::t('app', 'Back to Inbox') . '</button>', array('message/inbox')); ?>

