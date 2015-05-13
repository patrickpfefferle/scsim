<?php Yii::app()->bootstrap->register(); ?>
<!DOCTYPE html>
<html lang='en'>
<meta charset='utf-8'>
<head>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css'/>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/style.css'/>
    <!-- <script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.7.2.min.js"></script> -->

    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css"/>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>

    <script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
    <script type='text/javascript' src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>

    <link rel='stylesheet' type='text/css'
          href='<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-responsive.css'/>
    <link rel='stylesheet' type='text/css' href='<?php echo Yii::app()->request->baseUrl; ?>/css/main.css'/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php
// Hier prüfen ob und wieviele neue Mails vorhanden sind
$newMessageCount = Yii::app()->user->unreadMessages();
$insimmode = false;
if (Yii::app()->user->isGroupchoosed()) {
    if (SimPeriodStatus::getIsInSimulation(Yii::app()->user->getChoosedGroup())) {
        $insimmode = true;
    }
}

// Aktuellen Schritt finden für die Simulation
$simulationEntryPoint = 'order/new';
$period_status = SimPeriodStatus::getCurrentPeriodSet();
/*if(SimPeriodStatus::isReadytoSimulate())
{
    $simulationEntryPoint = 'simulation/simulate';
}*/
if ($period_status->production_orders_set == true) {
    $simulationEntryPoint = 'shiftScheduling/new';
} else if ($period_status->orders_set == true) {
    $simulationEntryPoint = 'productionOrder/new';
}

?>

<header class='navbar blue blue2 navbar-fixed-top'>
    <div class='navbar-inner'>
        <?php $this->widget('application.components.amai.AmaiNavBar', array(
            'settings' => array('pagetitle' => 'SCSim Phönix'
            ),
            'items' => array(
                array('label' => Yii::t('app', 'Administration'), 'image' => 'cube_green.png', 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->isAdmin,
                    'items' => array(
                        array('label' => Yii::t('app', 'Manage Games'), 'url' => array('admin/showgames')),
                        array('label' => Yii::t('app', 'Manage User'), 'url' => array('admin/userindex')),
                    )
                ),
                array('label' => Yii::t('app', 'Simulate now'), 'image' => 'media_play_green.png', 'visible' => !$insimmode && !Yii::app()->user->isGuest && Yii::app()->user->isAllowedtoPlay(Yii::app()->user->getChoosedGroup()), 'url' => array($simulationEntryPoint)),
                array('label' => Yii::t('app', 'Games'), 'image' => 'cube_green.png', 'visible' => !Yii::app()->user->isGuest,
                    'items' => array(
                        array('label' => Yii::t('app', 'Choose Game'), 'url' => array('user/chooseGame')),
                        array('label' => Yii::t('app', 'Join Game'), 'url' => array('user/JoinGame')),
                    )
                ),
                array('label' => Yii::t('app', 'Marketplace'), 'image' => 'handshake.png', 'visible' => !$insimmode && !Yii::app()->user->isGuest && Yii::app()->user->isAllowedtoPlay(Yii::app()->user->getChoosedGroup())),
                array('label' => '', 'url' => array('message/inbox'), 'icon' => 'icon-white icon-envelope', 'badge' => $newMessageCount, 'orientation' => 'right', 'visible' => !Yii::app()->user->isGuest),
                array('label' => '', 'icon' => 'icon-white icon-user', 'orientation' => 'right', 'visible' => !Yii::app()->user->isGuest,
                    'items' => array(
                        array('label' => Yii::t('app', 'Profile'), 'url' => array('user/editProfile')),
                        array('label' => Yii::t('app', 'Change Password'), 'url' => array('user/changePassword')),
                    )
                ),
                array('label' => Yii::t('app', 'Login'), 'icon' => 'icon-white icon-lock', 'url' => array('site/login'), 'orientation' => 'right', 'visible' => Yii::app()->user->isGuest),
                array('label' => Yii::t('app', 'Register'), 'icon' => 'icon-white icon-star-empty', 'url' => array('user/register'), 'orientation' => 'right', 'visible' => Yii::app()->user->isGuest),
                array('label' => '', 'icon' => 'icon-white icon-question-sign', 'url' => array('site/help'), 'orientation' => 'right'),
                array('label' => '', 'icon' => 'icon-white icon-off', 'url' => array('site/logout'), 'tooltip' => 'abmelden', 'orientation' => 'right', 'visible' => !Yii::app()->user->isGuest),
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
                        array('label' => 'greek', 'flag' => 'el'),
                    )
                ),
            )
        )); ?>
    </div>
</header>
<?php
$gamechoosed = Yii::app()->user->isGamechoosed();

if (!$gamechoosed) {
    $lightbox = "";
} else {
    $groupname = CHtml::link(Yii::t('app', 'Choose Group'), array('group/list'));
    if (Yii::app()->user->isGroupchoosed()) {
        $groupname = Yii::app()->user->GroupName;
    }

    $lightbox = CHtml::image(Yii::app()->request->baseUrl . '/img/cube_green.png', 'IMAGE') . "  " . CHtml::link("<b>" . Yii::t('app', 'Game:') . " </b>" . Yii::app()->user->GameName . "</br>", array('user/chooseGame'));

    if (Yii::app()->user->isAdminOrModOfGame()) {
        $lightbox .= CHtml::image(Yii::app()->request->baseUrl . '/img/users3.png', 'IMAGE') . "  " . CHtml::link("<b>" . Yii::t('app', 'Group:') . " </b>" . Yii::app()->user->GroupName . "</br>", array('group/viewgroups'));
    } else {
        if (Yii::app()->user->isGroupchoosed()) {
            $lightbox .= CHtml::image(Yii::app()->request->baseUrl . '/img/users3.png', 'IMAGE') . "  " . "<b>" . Yii::t('app', 'Group:') . " </b>" . Yii::app()->user->GroupName . "</br>";
        } else {
            $lightbox .= CHtml::image(Yii::app()->request->baseUrl . '/img/users3.png', 'IMAGE') . "  " . CHtml::link("<b>" . Yii::t('app', 'Group:') . " </b>" . Yii::t('app', 'Choose Group') . "</br>", array('group/list'));
        }

    }
    if (Yii::app()->user->isPeriodchoosed()) {
        $lightbox .= CHtml::image(Yii::app()->request->baseUrl . '/img/component_blue.png', 'IMAGE') . "  " . CHtml::link("<b>" . Yii::t('app', 'Period:') . " </b>" . Yii::app()->user->getChoosedPeriod() . "</br>", array('user/listPeriods'));
    } else if (Yii::app()->user->isGroupchoosed()) {
        $lightbox .= CHtml::image(Yii::app()->request->baseUrl . '/img/component_blue.png', 'IMAGE') . "  " . CHtml::link("<b>" . Yii::t('app', 'Period:') . " </b>" . Yii::t('app', 'Choose Period') . "</br>", array('user/listPeriods'));
    } else {
        // $lightbox .= CHtml::image(Yii::app()->request->baseUrl . '/img/component_blue.png', 'IMAGE') . "  " . Yii::t('app', 'Period:') . "</br>";
    }

    if ($insimmode) {

        $lightbox .= '<br>';
        $lightbox .= CHtml::link(Yii::t('app', 'Simulation in progress...'),array('simulation/simstatus','layout'=>true));
        $lightbox .= '<br>';
        $lightbox .= '<div class="progress progress-success" style="height: 5px" >';
        $lightbox .= '<div id="simbar" class="bar" style = "width:0%" >';
        $lightbox .= '</div >';
        $lightbox .= '</div >';
        $insimmode = true;

    }
}
?>

<section class='container-fluid pad40'>
    <section class='row-fluid'>
        <?php $this->widget('application.components.amai.AmaiSideBar', array(
            'visible' => !Yii::app()->user->isGuest && $gamechoosed,
            'lightbox' => $lightbox,
            'items' => array(
                array('label' => 'Dashboard', 'image' => 'blackboard_empty.png', 'url' => array('game/home'),'visible'=> !$insimmode),
                array('divider' => 'divider', 'visible'=>!$insimmode),
                array('label' => 'Input data', 'image' => 'notebook_edit.png', 'visible' => !$insimmode && Yii::app()->user->isGroupChoosed(), 'items' =>
                    array(
                        array('label' => Yii::t('app','Orders'), 'image' => 'print_layout_single.png', 'url' => array('order/inputdata')),
                        array('label' => Yii::t('app','Production orders'), 'image' => 'print_layout_single.png', 'url' => array('productionorder/inputdata')),
                        array('label' => Yii::t('app','Shift schedulings'), 'image' => 'print_layout_single.png', 'url' => array('shiftscheduling/inputdata')),
                    )
                ),
                array('divider' => 'divider', 'visible'=>!$insimmode),
                array('label' => 'Produktion', 'image' => 'blueprint.png', 'visible' => !$insimmode && Yii::app()->user->isGroupChoosed(), 'items' =>
                    array(
                        array('label' => Yii::t('app', 'Gantt'), 'image' => 'branch_element.png', 'url' => array('production/ganttMain')),
                        array('label' => 'Leerzeitenkosten', 'image' => 'document_stop.png', 'url' => array('machine/idletime')),
                        array('label' => 'Warteliste Arbeitsplatz', 'image' => 'document_warning.png'),
                        array('label' => 'Warteliste Material', 'image' => 'document_warning.png', 'url' => array('productionorder/waitmaterial')),
                        array('label' => 'Aufträge in Bearbeitung', 'image' => 'table2_run.png', 'url' => array('productionorder/notready')),
                        array('label' => 'Beendete Aufträge', 'image' => 'table2_check.png', 'url' => array('productionorder/ready')),
                    )
                ),
                array('label' => 'Lager', 'image' => 'shelf_empty.png', 'visible' =>!$insimmode && Yii::app()->user->isGroupChoosed(), 'items' =>
                    array(
                        array('label' => Yii::t('app', 'Inventory'), 'image' => 'shelf.png', 'url' => array('stock/inventory')),
                        array('label' => 'Zugang', 'image' => 'document_ok.png', 'url' => array('stock/arrival')),
                        array('label' => 'Ausstehend', 'image' => 'delivery_note.png', 'url' => array('stock/missing')),
                    )
                ),
                array('label' => Yii::t('app', 'Benchmark'), 'image' => 'chart_pie2.png', 'visible' =>!$insimmode && Yii::app()->user->isGroupChoosed(), 'items' =>
                    array(

                        array('label' => Yii::t('app', 'Result'), 'image' => 'chart_pie2.png', 'url' => array('benchmark/result')),
                        array('label' => Yii::t('app', 'Overall result'), 'image' => 'chart_pie2.png', 'url' => array('benchmark/overallresult')),
                        array('label' => Yii::t('app', 'Profit/Unit'), 'image' => 'chart_pie2.png', 'url' => array('benchmark/profitunit')),
                        array('label' => Yii::t('app', 'Sale'), 'image' => 'chart_pie2.png', 'url' => array('benchmark/sale')),
                        array('label' => Yii::t('app', 'Sell wish'), 'image' => 'chart_pie2.png', 'url' => array('benchmark/sellwish')),
                        array('label' => Yii::t('app', 'Delivery reliability'), 'image' => 'chart_pie2.png', 'url' => array('benchmark/deliveryreliability')),
                        array('label' => Yii::t('app', 'Productivity'), 'image' => 'chart_pie2.png', 'url' => array('benchmark/productivity')),
                        array('label' => Yii::t('app', 'Capacity ratio'), 'image' => 'chart_pie2.png', 'url' => array('benchmark/capacityratio')),
                        array('label' => Yii::t('app', 'Workload'), 'image' => 'chart_pie2.png', 'url' => array('benchmark/workload')),
                        array('label' => Yii::t('app', 'Idle time'), 'image' => 'chart_pie2.png', 'url' => array('benchmark/idletime')),
                        array('label' => Yii::t('app', 'Idle time costs'), 'image' => 'chart_pie2.png', 'url' => array('benchmark/idletimecosts')),
                        array('label' => Yii::t('app', 'Stock value'), 'image' => 'chart_pie2.png', 'url' => array('benchmark/stockvalue')),
                        array('label' => Yii::t('app', 'Storage costs'), 'image' => 'chart_pie2.png', 'url' => array('benchmark/stockcosts')),
                    )
                ),
                array('label' => 'Kennzahlen', 'image' => 'calculator.png', 'visible' => !$insimmode && Yii::app()->user->isGroupChoosed(), 'url' => array('game/result')),
                array('divider' => 'divider', 'visible' =>  !$insimmode && Yii::app()->user->isGroupChoosed()),
                array('label' => Yii::t('app', 'Filetransfer'), 'image' => 'server_client_exchange.png', 'visible' =>!$insimmode && Yii::app()->user->isGroupChoosed(), 'items' =>
                    array(
                        array('label' => Yii::t('app', 'Upload'), 'image' => 'code_edit.png', 'url' => array('simulation/upload')),
                        array('label' => Yii::t('app', 'Download'), 'image' => 'code.png', 'url' => array('simulation/download')),
                    )
                ),
            )
        )); ?>
        <section id="contentbox" class='span10 content borBox'>
            <?php
            foreach (Yii::app()->user->getFlashes() as $key => $message) {
                ?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="wellLight borBox">
                            <div class="row-fluid">
                                <?php
                                if ($key == TbHtml::ALERT_COLOR_SUCCESS) {
                                    echo '<div style="font-weight:bold; text-align:center; color: green;">' . CHtml::image(Yii::app()->request->baseUrl . '/img/pin_green.png', 'IMAGE', array('align' => 'left')) . $message . '</div>';
                                }
                                if ($key == TbHtml::ALERT_COLOR_INFO) {
                                    echo '<div style="font-weight:bold; text-align:center; color: blue;">' . CHtml::image(Yii::app()->request->baseUrl . '/img/pin_blue.png', 'IMAGE', array('align' => 'left')) . $message . '</div>';
                                }
                                if ($key == TbHtml::ALERT_COLOR_WARNING) {
                                    echo '<div style="font-weight:bold; text-align:center; color: orange;">' . CHtml::image(Yii::app()->request->baseUrl . '/img/pin_yellow.png', 'IMAGE', array('align' => 'left')) . $message . '</div>';
                                }
                                if ($key == TbHtml::ALERT_COLOR_ERROR) {
                                    echo '<div style="font-weight:bold; text-align:center; color: red;">' . CHtml::image(Yii::app()->request->baseUrl . '/img/pin_red.png', 'IMAGE', array('align' => 'left')) . $message . '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                // echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
            }
            ?>
            <?php echo $content; ?>
        </section>
    </section>
</section>

<script type="text/javascript"
        src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.qtip-1.0.0-rc3.min.js"></script>

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


<?php
if ($insimmode) {
    ?>
    <script type="text/javascript">
        function updateProgressbar() {
            $.ajax({
                type: "GET",
                cache: false,
                url: <?php echo "'".Yii::app()->createAbsoluteUrl('simulation/simprogress', array('group_id'=>Yii::app()->user->getChoosedGroup()))."'" ?>,
                dataType: "text",
                success: function (data) {
                    $("#simbar").attr("style", data);
                    if(data=='width:100%')
                    {
                        window.location.reload();
                    }
                }
            });
            updateSimStatus();
        }

        function updateSimStatus()
        {
            if(window.location.pathname=='/scsim/index.php/simulation/simstatus')
            {
                $.ajax({
                    type: "GET",
                    cache: false,
                    url: <?php echo "'".Yii::app()->createAbsoluteUrl('simulation/simstatus')."'" ?>,
                    dataType: "text",
                    success: function (data) {
                        $("#contentbox").html(data);
                    }
                });
            }
        }

        updateProgressbar();
        setInterval(updateProgressbar, 2000);

    </script>
<?php
}
?>

</body>
</html>
