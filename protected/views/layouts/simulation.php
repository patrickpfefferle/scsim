<!DOCTYPE html>
<html lang='en'>
<meta charset='utf-8'>
<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css'/>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/style.css'/>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/style-landing.css'/>
    <link rel='stylesheet' type='text/css'
          href='<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css'/>
    <script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.7.2.min.js"></script>
    <script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
</head>
<body id="landingBody">

<header class='navbar blue blue2 navbar-fixed-top'>
    <div class='navbar-inner'>
        <?php $this->widget('application.components.amai.AmaiNavBar', array(
            'settings' => array('pagetitle' => 'SCSim Phönix'
            ),
            'items' => array()
        )); ?>
    </div>
</header>
<section class='container-fluid pad40'>
    <br>
    <?php echo $content; ?>
</section>

</body>
</html>