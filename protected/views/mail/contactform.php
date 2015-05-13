<?php echo Yii::t('app', 'Wow! You get a mail from a SCSIM player:') ?> <br>
<br>
<?php
    echo Yii::t('app', 'Name') .$name.'<br>';
    echo Yii::t('app', 'Mail') .$email.'<br>';
	echo Yii::t('app', 'Organisation').$organisation.'<br>';
    echo Yii::t('app', 'Subject').$subject.'<br>';
    echo "<br><br>";
    echo $text;
?>