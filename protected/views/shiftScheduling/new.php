<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm */
/* @var $shiftSchedulings array */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Shift Scheduling');

$this->widget('application.components.amai.AmaiPageHeader', array(
    'header' => Yii::t('app', 'Shift Scheduling')
));
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
        'id' => 'shiftscheduling-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>



    <div class="form sharp">

        <table border="0">
            <tr>
                <th style="text-align: left">#Ident</th>
                <th style="width: 5px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="text-align: left">Beschreibung</th>
                <th style="text-align: center">Schichten</th>
                <th style="text-align: left">Überstunden</th>
            </tr>

            <?php


            for ($i = 0; $i <= count($machines) - 1; $i++) {
                // Existierenden Eintrag finden in $shiftSchedulings
                /** @var $matchedExistingScheduling ShiftScheduling */
                $matchedExistingScheduling = null;
                foreach($shiftSchedulings as $existingEntity) {
                    if ($existingEntity->cd_machine_id == $machines[$i]->id) {
                        $matchedExistingScheduling = $existingEntity;
                        break;
                    }
                }

                $amount = 1;
                $overtime = "";

                if ($matchedExistingScheduling != null) {
                    $overtime = $matchedExistingScheduling->overtime;
                    $amount = $matchedExistingScheduling->shift_amount;
                }

                $shift_amount_field_name = "ShiftScheduling[" . $i . "][shift_amount]";
                $shift_amount_field_id = "ShiftScheduling_" . $i . "_shift_amount";
                $overtime_field_name = "ShiftScheduling[" . $i . "][overtime]";
                $overtime_field_id = "ShiftScheduling_" . $i . "_overtime";
                $cd_machine_id_field_name = "ShiftScheduling[" . $i . "][cd_machine_id]";
                $cd_machine_id_field_id = "ShiftScheduling_" . $i . "_cd_machine_id";
                ?>
                <tr>
                    <td style="text-align: center">
                        <input type="hidden" name=  <?php echo $cd_machine_id_field_name ?> id
                        =  <?php echo $cd_machine_id_field_id ?> value= <?php echo $machines[$i]->id ?>>
                        <?php echo $machines[$i]->ident ?>
                    </td>
                    <td style="width: 5px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>

                    <td style="text-align: left">
                        <?php echo $machines[$i]->description ?>
                    </td>
                    <td style="text-align: center">
                        <input type="text" value="<?php echo $amount; ?>" name=<?php echo $shift_amount_field_name ?>  id
                        = <?php echo $shift_amount_field_id ?> class="span6 sharp" placeholder="Anzahl"/>
                    </td>
                    <td style="text-align: left">
                        <input type="text" value="<?php echo $overtime; ?>" name=<?php echo $overtime_field_name ?>  id
                        = <?php echo $overtime_field_id ?> class="span6 sharp" placeholder="In Minuten"/>
                    </td>
                </tr>
            <?php

            }

            ?>

        </table>

    </div>

    <br>
    <br>

    <div class="span12 noFM" align="center">
        <a class="btn sharp btn-secondary" href="<?php echo $this->createUrl('productionOrder/new');?>"><?php echo Yii::t('app', 'Back to production orders') ?></a>
        <button type="submit" class="btn sharp btn-primary"><?php echo Yii::t('app', 'Save and simulate') ?></button>
        <button type="reset" class="btn sharp"><?php echo Yii::t('app', 'Reset') ?></button>
    </div>


    <?php $this->endWidget(); ?>
</div><!-- form -->