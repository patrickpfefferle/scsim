<?php
foreach ($groups as $group) {

    ?>

    <div class="panel-group" id="accordion">
        <div class="panel panel-default wellLight" id="panel"
        . <?php $group->id ?>>
        <div class="panel-heading">
            <h3 class="panel-title">
                <a data-toggle="collapse" data-target=  <?php echo '#collapse' . $group->id ?>
                href=  <?php echo '#collapse' . $group->id ?> class="collapsed">
                    <?php echo $group->groupname ?>  <?php echo Yii::t('app', ' (' . $group->user_count . ' of ' . $group->user_max . ' users)') ?>

                </a>

                <div class="progress progress-success" style="width: 100%; height: 10px">
                    <div class="bar" style="width:<?php echo $group->user_count / $group->user_max * 100 ?>%">
                    </div>
                </div>

            </h3>

        </div>
        <div id=  <?php echo 'collapse' . $group->id ?> class="panel-collapse collapse
        ">
        <div class="panel-body">
            <div align="right">
                <?php
                $period = SimPeriodStatus::getLastPlayedPeriod($group->id);
                if ($period > 0) {
                    echo '<b>' . Yii::t('app', 'Current played period: {p}', array('{p}' => $period)) . ' </b>';
                    echo CHtml::link(
                        '<button class="btn btn-warning sharp" style="margin-bottom:5px;" type="button"><i class="icon-white icon-minus"></i> ' . Yii::t('app', 'Reset to Period {p}', array('{p}' => $period - 1)) . '</button>', array('admin/resetperiod', 'groupId' => $group->id, 'nextview' => 'admin/showgame'));
                } else {
                    echo '<b>' . Yii::t('app', 'Currently no period played') . ' </b>';
                }
                ?>
            </div>
            <table class="table table-bordered">


                <thead>
                <tr>
                    <th><?php echo Yii::t('app', 'Prename'); ?> </th>
                    <th><?php echo Yii::t('app', 'Lastname'); ?></th>
                    <th><?php echo Yii::t('app', 'E-Mail'); ?></th>
                    <th><?php echo Yii::t('app', 'Ident'); ?></th>
                    <th><?php echo Yii::t('app', 'Organisation'); ?></th>
                    <th><?php echo Yii::t('app', 'Options'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $user2games = User2game::model()->findAllByAttributes(array('group_id' => $group->id, 'game_id' => $group->game_id));

                foreach ($user2games as $user2game) {
                    $user = User::model()->findByPk($user2game->user_id);
                    ?>
                    <tr>
                        <td><?php echo $user->prename ?></td>
                        <td><?php echo $user->lastname ?></td>
                        <td><?php echo $user->email ?></td>
                        <td><?php echo $user->ident ?></td>
                        <td><?php echo $user->organisation ?></td>
                        <td style="text-align: center">
                            <div class="btn-group sharp" data-toggle="radio" style="">
                                <?php

                                echo CHtml::link('<button class="btn btn-mini btn-danger"><i class="icon-white icon-remove-sign"></i></button>', array('admin/removegroupuser', 'userid' => $user['id'], 'groupid' => $group['id']), array('confirm' => Yii::t('app', 'Do you want to really want to remove {user} from {group}?', array('{user}' => $user['prename'] . ' ' . $user['lastname'], '{group}' => $group->groupname))));

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
    </div>
    </div>
    <br>
<?php
}
?>