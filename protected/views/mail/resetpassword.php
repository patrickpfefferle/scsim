<?php echo Yii::t('app', 'Dear Sir or Madam!') ?> <br>
<br>
<br>
<br>
<?php echo Yii::t('app', 'here is your new random password:') ?><br>
<br>
<?php
echo Yii::t('app', 'This is your new Password: "{password}"',  array('{password}'=>$password));
?>
<br>
<br>
<?php echo Yii::t('app', 'Don´t forget to change your password after next login!') ?><br>
<br>
<?php echo Yii::t('app', 'Best Regards') ?> <br>
<br>
<?php echo Yii::t('app', 'Your SCSIM Team') ?> <br>