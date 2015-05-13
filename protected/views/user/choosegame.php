<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Choose Game');

 $this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Choose'),
    'subtitle' => Yii::t('app', 'current game')
));

foreach ($games as $game) {
    ?>
        <div class="wellDark borBox" style="margin: 0px; margin-bottom: 10px; padding: 20px">
            <b>           <?php
            echo CHtml::image(Yii::app()->request->baseUrl . '/images/game.png', '').'  ';
            if(!empty($game->group))
            {
                echo $game->game->name.' ['.Yii::t('app','Group:').' '.$game->group->groupname.']';
            }else
                echo $game->game->name.' ['.Yii::t('app','Group:').' '.Yii::t('app','no member of a group').']';

            ?>
            </b>
            <div class="btn-group sharp pull-right">
                <?php
                    echo CHtml::link(
                        '<button class="btn btn-info" type="button">' . Yii::t('app', 'use this') . ' <i class="icon-white icon-arrow-right"></i></button>', array('user/usegame', 'id' => $game->game_id));
                ?>
            </div>
        </div>
<?php
}
?>
