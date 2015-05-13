<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Games');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Games'),
    'subtitle' => Yii::t('app', 'Administration of Games')
));

?>
<div align="right">
    <?php
    echo CHtml::link(
        '<button class="btn btn-info sharp" style="margin-top:-5px;" type="button"><i class="icon-white icon-plus"></i> ' . Yii::t('app', 'New Game') . '</button>', array('admin/newgame'));
    ?>
</div>
<br>
<div class="row-fluid">
    <div class="span12">
        <table class="table table-bordered">


            <thead>
            <tr>
                <th><?php echo Yii::t('app', 'Game name'); ?> </th>
                <th><?php echo Yii::t('app', 'Game Key'); ?></th>
                <th><?php echo Yii::t('app', 'Game Set'); ?></th>
                <th><?php echo Yii::t('app', 'Created'); ?></th>
                <th><?php echo Yii::t('app', 'Options'); ?></th>
            </tr>
            </thead>


            <tbody>
            <?php foreach ($model as $m) { ?>
                <tr>
                    <td><?php echo $m->name ?></td>
                    <td><?php echo $m->game_key ?></td>
                    <?php
                    $gameset = CdGameset::model()->findByPk($m->cd_gameset_id);
                    ?>
                    <td><?php if (!empty($gameset)) {
                            echo $gameset->description;
                        } else echo Yii::t('app', 'empty'); ?></td>
                    <td><?php echo Yii::app()->dateFormatter->format(Yii::app()->locale->dateFormat, $m->created) ?></td>

                    <td style="text-align: center">
                        <div class="btn-group sharp" data-toggle="radio" style="">
                            <?php
                            echo CHtml::link('<button class="btn btn-mini btn-success"><i class="icon-white icon-eye-open"></i></button>', array('admin/showgame', 'id' => $m->id));
                            echo CHtml::link('<button class="btn btn-mini btn-danger"><i class="icon-white icon-remove-sign"></i></button>', array('admin/gamedelete', 'id' => $m->id), array('confirm' => Yii::t('app', 'Do you want to delete {game}?', array('{game}' => $m->name))));

                            ?>
                        </div>
                    </td>
                </tr>
            <?php
            }
            ?>


            </tbody>

        </table>
    </div>
</div>

<script type="text/javascript">
    function submitform(event) {
        if (event.keyCode === 13)
            document.filter.submit();
    }
    function submitform_simple() {
        document.filter.submit();
    }
</script>