<?php

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Gantt for machines');


$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Gantt'),
    'subtitle' => Yii::t('app', 'for machines')
));


?>
<select id="dayselect" onchange="Serveranfrage()">
    <option value="1"> <?php echo Yii::t('app', 'Day 1') ?></option>
    <option value="2"> <?php echo Yii::t('app', 'Day 2') ?></option>
    <option value="3"> <?php echo Yii::t('app', 'Day 3') ?></option>
    <option value="4"> <?php echo Yii::t('app', 'Day 4') ?></option>
    <option value="5"> <?php echo Yii::t('app', 'Day 5') ?></option>
</select>


<div id="gantt_area">

</div>



<script type="application/javascript">
    var firstload = true;

    function xmlhttp() {
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
        var e = document.getElementById("dayselect");
        var strUser = e.options[e.selectedIndex].value;
        xhr.open('GET', '<?php echo Yii::app()->createAbsoluteUrl('production/gantt')."?day=" ?>' + strUser, true);
        xhr.onreadystatechange = isReady;
        xhr.send(null);

    }

    function isReady() {
        var container = document.getElementById('gantt_area');
        container.innerHTML = xhr.responseText;

        $('.po_time').each(function(){
            $(this).qtip({
                content: {
                    url: '<?php echo Yii::app()->createAbsoluteUrl('production/HoverId')."" ?>',
                    data: { id: $(this).attr('tooltip') },
                    method: 'get'
                },
                position:
                {
                    corner:{
                        tooltip: 'bottomMiddle',
                        target: 'topMiddle'
                    }
                },
                style:
                {
                    width: 300
                },
                show:
                {
                    delay:10
                }

            });
        });
    }

    $(document).ready(function () {
        if (firstload) {
            firstload = false;
            Serveranfrage();
        }
    });


</script>

<script  type="application/javascript">
    $(document).ready(function(){

    });
</script>