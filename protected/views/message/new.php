<?php
/* @var $model NewMessage */
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'New message');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'New'),
    'subtitle' => Yii::t('app', 'message')
));

?>
<?php echo CHtml::beginForm(); ?>

<div class="wellLight borBox">
    <h4><?php echo Yii::t('app', 'Receivers') ?></h4>

    <div class="panel-group" id="accordion">
        <?php $jsForValues = '' ?>
        <?php foreach ($groups as $idx => $group) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <?php echo CHtml::checkBox('NewMessage[toGroups][]', $model->containsGroup($group), array(
                            'value' => $group->id,
                            'id' => 'NewMessage_toGroup_' . $group->id,
                            'onChange' => 'javascript:onGroupSelectionChanged(this,'.$idx.')'
                            ));
                        ?>

                        <a class="<?php echo ($model->containsGroup($group) ? 'disabled' : ''); ?>" id="<?php echo 'NewMessage_toGroup_link_' . $group->id; ?>" data-toggle="<?php echo ($model->containsGroup($group) ? '' : 'collapse"'); ?>" data-parent="#accordion"
                           href="#collapse_<?php echo $group->id; ?>">
                            <?php echo $group->groupname ?>
                        </a>
                    </h4>
                </div>
                <?php
                $members = User::model()->findAll('id in (SELECT user_id FROM user2games where game_id=:game_id and group_id=:group_id)', array('game_id' => Yii::app()->user->ChoosedGame, 'group_id' => $group->id));
                $membersIDName = array();
                foreach ($members as $member) {
                    /* @var $member User */
                    $membersIDName[] = array("id" => $member->id, "text" => $member->prename . ' ' . $member->lastname);
                }
                ?>
                <div id="collapse_<?php echo $group->id; ?>" class="panel-collapse collapse">
                    <div class="panel-body">
                        <?php
                        $this->widget('yiiwheels.widgets.select2.WhSelect2', array(
                            'asDropDownList' => false,

                            'name' => 'NewMessage[toUser][' . $idx . ']',
                            'pluginOptions' => array(
                                // 'id' => 'NewMessage_toUserInGroup_'.$group->id,
                                'tags' => $membersIDName, // array(["id"=>"7", "text"=>"Andreas"], ["id"=>"9", "text"=>"Marius"]),
                                'placeholder' => 'Gruppenmitglied auswählen',
                                'width' => '40%',
                                'tokenSeparators' => array(',', ' ')
                            )));

                        $jsForValues .= "jQuery('#NewMessage_toUser_" . $idx . "').select2('data',[";
                        $selectedUsersAtStartCount = 0;
                        foreach ($model->toUser as $userId) {
                            // check if member is in this group
                            $inGroup = false;
                            foreach ($members as $member) {
                                if ($member->id == $userId) {
                                    $inGroup = true;
                                    break;
                                }
                            }
                            if ($inGroup) {
                                $jsForValues .= $model->getJSUserString($userId);
                                $selectedUsersAtStartCount++;
                            }
                        }
                        $jsForValues .= "]);";
                        // show collapsed if user is already selected
                        if ($selectedUsersAtStartCount > 0) {
                            $jsForValues .= "\n";
                            $jsForValues .= "jQuery('#collapse_".$group->id."').collapse('show');";
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<br>
<br>
<?php echo TbHtml::textField('NewMessage[subject]', $model->subject, array('placeholder' => Yii::t('app', 'Subject'), 'span' => 12)); ?>
<?php $this->widget('yiiwheels.widgets.redactor.WhRedactor', array(
    'name' => 'NewMessage[message]',
    'value' => $model->message,
));?>
<?php echo CHtml::submitButton(); ?>
<?php echo CHtml::endForm(); ?>

<script type="application/javascript">
    function onGroupSelectionChanged(checkbox,idx) {
        var groupID = checkbox.value;
        // alert('val: '+checkbox.checked+' '+groupID+' idx '+idx);
        if (checkbox.checked) {
            jQuery('#NewMessage_toUser_'+idx).select2('val','');
            jQuery('#NewMessage_toUser_'+idx).select2('disable');
            //jQuery('#NewMessage_toGroup_link_'+groupID).attr('data-toggle', '');
            jQuery('#NewMessage_toGroup_link_'+groupID).addClass('disabled');
            // jQuery('#collapse_'+groupID).collapse('hide');
            jQuery('#NewMessage_toGroup_link_'+groupID).attr('href', 'javascript:return false;');
            jQuery('#collapse_'+groupID).hide();
        } else {
            jQuery('#collapse_'+groupID).show();
            jQuery('#NewMessage_toUser_'+idx).select2("enable");
            jQuery('#collapse_'+groupID).collapse('show');
            //jQuery('#NewMessage_toGroup_link_'+groupID).attr('data-toggle', 'collapse');
            jQuery('#NewMessage_toGroup_link_'+groupID).removeClass('disabled');
            jQuery('#NewMessage_toGroup_link_'+groupID).attr('href', '#collapse_'+groupID);
        }

    }
    $(document).ready(function () {
        <?php echo $jsForValues."\n"; ?>

        <?php /* .select2("enable", false); */ /*$("#e8_2").select2("val", "");*/?>

    });

</script>
