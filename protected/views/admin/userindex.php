<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Users');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Users'),
    'subtitle' => Yii::t('app', 'Administration of Users')
));

?>
<br>
<div class="row-fluid">
    <div class="span12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th><?php echo Yii::t('app', 'Prename'); ?> </th>
                <th><?php echo Yii::t('app', 'Lastname'); ?></th>
                <th><?php echo Yii::t('app', 'E-Mail'); ?></th>
                <th><?php echo Yii::t('app', 'Ident'); ?></th>
                <th><?php echo Yii::t('app', 'Organisation'); ?></th>
                <th><?php echo Yii::t('app', 'Status'); ?></th>
                <th><?php echo Yii::t('app', 'Valid until'); ?></th>
                <th><?php echo Yii::t('app', 'Options'); ?></th>
            </tr>
            </thead>
            <tbody>
            <form name="filter" action="" method="get">
                <tr>
                    <td><input name="prename" class="span12 sharp" placeholder="<?php echo Yii::t('app', 'Prename'); ?>"
                               type="text" onkeydown="submitform(event);" value="<?php echo @$_GET['prename'] ?>"></td>
                    <td><input name="lastname" class="span12 sharp"
                               placeholder="<?php echo Yii::t('app', 'Lastname'); ?>"
                               type="text" onkeydown="submitform(event);" value="<?php echo @$_GET['lastname'] ?>"></td>
                    <td><input name="email" class="span12 sharp" placeholder="<?php echo Yii::t('app', 'E-Mail'); ?>"
                               type="text" onkeydown="submitform(event);" value="<?php echo @$_GET['email'] ?>"></td>
                    <td><input name="ident" class="span12 sharp" placeholder="<?php echo Yii::t('app', 'Ident'); ?>"
                               type="text" onkeydown="submitform(event);" value="<?php echo @$_GET['ident'] ?>"></td>
                    <td><input name="organisation" class="span12 sharp"
                               placeholder="<?php echo Yii::t('app', 'Organisation'); ?>" type="text"
                               onkeydown="submitform(event);" value="<?php echo @$_GET['organisation'] ?>">
                    </td>

                    <td>
                        <select name="status" onchange="submitform_simple();" class="span12 sharp" name="mydropdown">
                            <option <?php if (@$_GET['status'] == '') {
                                echo 'selected';
                            } ?> value=""><?php echo Yii::t('app', 'No Filter'); ?></option>
                            <option <?php if (@$_GET['status'] == 'Administrator') {
                                echo 'selected';
                            } ?> value="Administrator"><?php echo Yii::t('app', 'Administrator'); ?></option>
                            <option <?php if (@$_GET['status'] == 'Moderator') {
                                echo 'selected';
                            } ?> value="Moderator"><?php echo Yii::t('app', 'Moderator'); ?></option>
                            <option <?php if (@$_GET['status'] == 'User') {
                                echo 'selected';
                            } ?> value="User"><?php echo Yii::t('app', 'User'); ?></option>
                        </select>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </form>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user['prename'] ?></td>
                    <td><?php echo $user['lastname'] ?></td>
                    <td><?php echo $user['email'] ?></td>
                    <td><?php echo $user['ident'] ?></td>
                    <td><?php echo $user['organisation'] ?></td>
                    <td><?php
                        if($user['blocked']==1){
                            echo ' <code>('.Yii::t('app','blocked').')</code> ';
                        }
                        if ($user['is_admin'] == 1 and $user['is_mod'] == 1) {
                            echo Yii::t('app', 'Administrator');
                        }
                        if ($user['is_admin'] == 1 and $user['is_mod'] == 0) {
                            echo Yii::t('app', 'Administrator');
                        }
                        if ($user['is_admin'] == 0 and $user['is_mod'] == 1) {
                            echo Yii::t('app', 'Moderator');
                        }
                        if ($user['is_admin'] == 0 and $user['is_mod'] == 0) {
                            echo Yii::t('app', 'User');
                        }

                        ?></td>
                    <td>
                    <?php
                        if(empty($user['valid_until']))
                        {
                            echo Yii::t('app','unlimited');
                        }else
                        {
                        echo Yii::app()->dateFormatter->format(Yii::app()->locale->dateFormat, $user['valid_until']) ;
                        }
                    ?></td>
                    <td style="text-align: center">
                        <div class="btn-group sharp" data-toggle="radio" style="">
                            <?php
                            echo CHtml::link('<button class="btn btn-mini btn-success"><i class="icon-white icon-pencil"></i></button>', array('admin/manageuser', 'id' => $user['id']));
                            echo CHtml::link('<button class="btn btn-mini btn-warning"><i class="icon-white icon-ban-circle"></i></button>', array('admin/userblock', 'id' => $user['id']),array('confirm' => $user['blocked']==0 ? Yii::t('app','Do you want to block {user}?',array('{user}'=>$user['prename'].' '.$user['lastname'])):Yii::t('app','Do you want to unblock {user}?',array('{user}'=>$user['prename'].' '.$user['lastname']))));
                            echo CHtml::link('<button class="btn btn-mini btn-danger"><i class="icon-white icon-remove-sign"></i></button>', array('admin/userdelete', 'id' => $user['id']),array('confirm' => Yii::t('app','Do you want to delete {user}?',array('{user}'=>$user['prename'].' '.$user['lastname']))));

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