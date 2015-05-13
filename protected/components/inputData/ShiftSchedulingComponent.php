<?php

/**
 * Class to generate normally derivated random numbers
 *
 * @author   Andreas Vratny <andreas@vratny.de>
 * @author   Marius Heinemann-Grüder <marius.hg@live.de>
 * @version  0.1
 * @access   public
 */
class ShiftSchedulingComponent extends CComponent
{
    /**
     * Init this component
     */
    public function init()
    {


    }

    public function newShiftSchedulingInput($shiftSchedulings)
    {
        $errors = "";
        $valid = true;

        $ps = SimPeriodStatus::getCurrentPeriodSet();

        for ($i = 0; $i <= count($shiftSchedulings) - 1; $i++) {

            $shiftSchedulings[$i]->group_id = Yii::app()->user->getChoosedGroup();

            $shiftSchedulings[$i]->period = $ps->period;

            if ($i == 0) {
                $valid =  $shiftSchedulings[$i]->validate();
                var_dump($valid);
            } else {
                $valid_new =  $shiftSchedulings[$i]->validate();
                $valid = $valid && $valid_new;
            }


            if (!$valid) {

                $errors = $shiftSchedulings[$i]->getErrors();
                break;

            }
        }

        if ($valid) {
            $groupId = Yii::app()->user->getChoosedGroup();
            $period = SimPeriodStatus::getCurrentPeriod($groupId);
            // Alle Schichtplanungen dieser Periode löschen
            ShiftScheduling::model()->deleteAllByAttributes(array('group_id' => $groupId, 'period' => $period));

            foreach ($shiftSchedulings as $shiftScheduling) {
                $shiftScheduling->save();
            }
            $ps->shift_schedulings_set = 1;
            $ps->save();

        }

        return $errors;
    }

}