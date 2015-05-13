<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Inbox');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Inbox'),
    'subtitle' => Yii::t('app', '')
));

?>
<div align="right">
<?php
echo CHtml::link(
'<button class="btn btn-info sharp" style="margin-top:-5px;" type="button"><i class="icon-white icon-plus"></i> ' . Yii::t('app', 'New Message') . '</button>', array('message/new'));
?>
</div>
<br>
<div class="row-fluid">
    <div class="span12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    <center> <?php echo Yii::t('app', 'State'); ?></center>
                </th>
                <th><?php echo Yii::t('app', 'From'); ?> </th>
                <th><?php echo Yii::t('app', 'Subject'); ?></th>
                <th><?php echo Yii::t('app', 'Date'); ?></th>
                <th><?php echo Yii::t('app', 'Options'); ?></th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($messages as $message) { ?>
                <tr>
                    <?php ($message->read) ? ($icon = CHtml::image(Yii::app()->request->baseUrl . '/img/mail_open.png', 'IMAGE')) : ($icon = CHtml::image(Yii::app()->request->baseUrl . '/img/mail_yellow.png', 'IMAGE')) ?>
                    <td>
                        <center> <?php echo $icon ?></center>
                    </td>
                    <td><?php echo $message->from() ?> </td>
                    <td><?php echo CHtml::link($message->header, array('message/view', 'id' => $message->id)) ?> </td>
                    <td><?php echo Yii::app()->dateFormatter->format('dd.MM.yyyy HH:mm:ss', $message->created) ?></td>
                    <td>
                        <div class="btn-group sharp" data-toggle="radio">
                            <?php
                            echo CHtml::link('<button class="btn btn-mini btn-success"><i class="icon-white icon-eye-open"></i></button>', array('message/view', 'id' => $message->id));
                            echo CHtml::link('<button class="btn btn-mini btn-success"><i class="icon-white icon-share"></i></button>', array('message/new', 'id' => $message->id));
                            echo CHtml::link('<button class="btn btn-mini btn-danger"><i class="icon-white icon-remove"></i></button>', array('message/delete', 'id' => $message->id));
                            ?>
                        </div>
                    </td>
                </tr>
            <?php } ?>


            </tbody>
        </table>
    </div>
</div>