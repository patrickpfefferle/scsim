<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08.08.14
 * Time: 23:37
 */
?>

<div id="refresh" style="text-align:center;">
    <section class='container-fluid'>
        <div class='row-fluid'>
            <div class='span3'><br/></div>
            <div class='span6'>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td style="text-align: center"> <?php echo Yii::t('app', 'Status'); ?> </td>
                        <td> <?php echo Yii::t('app', 'Description'); ?> </td>
                    </tr>
                    </thead>
                    <tr>
                        <td style="text-align: center">
                            <img src="<?php echo Yii::app()->request->baseUrl . '/img/loading.gif'; ?>" alt=""
                                 width="32" height="32">
                        </td>
                        <td style="vertical-align: middle;">
                            <b> <?php echo Yii::t('app', 'Simulation processing'); ?> </b>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
</div>


<script type="application/javascript">

    /* function xmlhttp() {
     var xhr;

     if (window.XMLHttpRequest) {
     xhr = new XMLHttpRequest(); // IE 7+, alle anderen Browser
     } else if (window.ActiveXObject) {
     xhr = new ActiveXObject("Microsoft.XMLHTTP"); // IE 5-6
     }

     return xhr;
     }
     var xhr = xmlhttp();



     function Serveranfrage() {
     xhr.open('GET', <?php echo "'".Yii::app()->createAbsoluteUrl('simulation/simstatus')."'" ?>, true);
     xhr.onreadystatechange = isReady;
     xhr.send(null);

     }

     function StartSimulate()
     {
     xhr.open('GET', <?php echo "'".Yii::app()->createAbsoluteUrl('simulation/simulate')."'" ?>, true);
     xhr.send(null);
     }

     */

    aok = false;

    readysimulate = false;

    $(document).ready(function () {
        $.get(<?php echo "'".Yii::app()->createAbsoluteUrl('simulation/simstatus')."'" ?>, function (responseText) {
            var container = document.getElementById('refresh');
            container.innerHTML = responseText;
        });
        if (aok == false) {
            aok = true;
            $.get(<?php echo "'".Yii::app()->createAbsoluteUrl('simulation/simulate')."'" ?>, function (responseText) {

            });
        }
    });


    window.setInterval(function () {
        if (readysimulate == false) {
            $.get(<?php echo "'".Yii::app()->createAbsoluteUrl('simulation/simstatus')."'" ?>, function (responseText) {
                if (responseText == '1') {
                    window.document.location.replace("<?php echo Yii::app()->createAbsoluteUrl('game/result') ?>");
                } else {

                    var container = document.getElementById('refresh');
                    container.innerHTML = responseText;
                }
            });
        }
    }, 5000);


</script>