<!DOCTYPE html>
<html lang='en'>
<meta charset='utf-8'>
<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css'/>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/style.css'/>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/style-landing.css'/>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css'/>
    <script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.7.2.min.js"></script>
    <script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
    <script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/main-landing.js"></script>
</head>
<body id="landingBody">

<header class='navbar blue blue2 navbar-fixed-top'>
    <div class='navbar-inner'>
        <?php $this->widget('application.components.amai.AmaiNavBar', array(
            'settings' => array('pagetitle' => 'SCSim Phönix'
            ),
            'items' => array(
                array('label' => Yii::t('app','Login'),'icon' => 'icon-white icon-lock', 'url' => array('site/login'), 'orientation' => 'right','visible'=>Yii::app()->user->isGuest),
                array('label' => Yii::t('app','Regsiter'), 'icon' => 'icon-white icon-star-empty', 'url' => array('user/register'), 'orientation' => 'right','visible'=>Yii::app()->user->isGuest),
                array('label' => '', 'icon' => 'icon-white icon-question-sign', 'url' => array('site/help'), 'orientation' => 'right'),
                array('label' => '', 'icon' => 'icon-white icon-off', 'url' => array('site/logout'), 'tooltip' => 'abmelden', 'orientation' => 'right', 'visible'=>!Yii::app()->user->isGuest),
                array('label' => '', 'flag' => Yii::app()->language, 'orientation' => 'right', 'items' =>
                    array(
                        array('label' => 'English', 'flag' => 'en'),
                        array('label' => 'Deutsch', 'flag' => 'de'),
                        array('label' => 'español', 'flag' => 'es'),
                        array('label' => 'français', 'flag' => 'fr'),
                        array('label' => 'italiano', 'flag' => 'it'),
                        array('label' => '日本語 (にほんご)', 'flag' => 'ja'),
                        array('label' => 'język polski', 'flag' => 'pl'),
                        array('label' => 'русский язык', 'flag' => 'ru'),
                    )
                ),
            )
        )); ?>
    </div>
</header>

<?php echo $content; ?>

<script type="application/javascript">
    function changeLang(lang) {
        $.ajax({
            url: "<?php echo $this->createUrl('site/ChangeLanguage');?>",
            type: "POST",
            data: {lang: lang},
            success: function (data, textStatus, jqXHR) {
                window.location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR);
            }
        });
    }
</script>
</body>
</html>