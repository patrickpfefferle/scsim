<?php

class ShiftSchedulingController extends Controller
{

    public function accessRules()
    {
        return array(

            array('allow',
                'actions' => array('new'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionHome()
    {
        $this->render('home');
    }

    public function actionInputdata()
    {
        $shifts=ShiftScheduling::model()->findAllByAttributes(array('group_id' => Yii::app()->user->getChoosedGroup(), 'period'=>Yii::app()->user->getChoosedPeriod()),array('order'=>'id asc'));
        $this->render('inputdata',array('shifts'=>$shifts));
    }

    public function actionNew()
    {
        $this->needChoosedGame();

        $machines = CdMachine::model()->findAllByAttributes(array('cd_gameset_id' => Yii::app()->user->GameSet), array('order' => 'ident + 0 ASC'));

        $ps = $period_status = SimPeriodStatus::getCurrentPeriodSet();

        if(SimPeriodStatus::isReadytoSimulate())
        {
            $this->redirect(array('simulation/simulate'));
        }

        if ($ps->orders_set == false) {
            $this->redirect(array('order/new'));
        } else if ($ps->production_orders_set== false) {
            $this->redirect(array('productionOrder/new'));
        } else if ($ps->shift_schedulings_set == true) {
            $this->redirect(array('site/index'));
        }

        /*
                $Period = Yii::app()->db
                        ->createCommand("SELECT MAX(period) FROM shift_schedulings")
                        ->where('group_id=:group_id', array(':group_id' => Yii::app()->user->getChoosedGroup()))
                        ->queryScalar() + 1;

        */
        $shiftSchedulings = array();

        if (!empty($_POST['ShiftScheduling'])) {

            for ($i = 0; $i <= count($_POST['ShiftScheduling']) - 1; $i++) {


                $shiftScheduling = new ShiftScheduling();
                $shiftScheduling->attributes = $_POST['ShiftScheduling'][$i];
                $shiftSchedulings[] = $shiftScheduling;
            }

            $errors = Yii::app()->shiftScheduling->newShiftSchedulingInput($shiftSchedulings);

            if (empty($errors)) {
                $this->redirect(array('simulation/ajaxsimulate'));
            }
            else
            {
                foreach ($errors as $error) {
                    foreach ($error as $e) {

                        Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', $e));
                    }

                }
            }

        } else {
            // Check if there are entities in db
            $existingEntities = ShiftScheduling::model()->findAllByAttributes(array('period' => $ps->period, 'group_id' => Yii::app()->user->getChoosedGroup()));
            foreach($existingEntities as $existingEntity) {
                /** @var ShiftScheduling $existingEntity */
                $shiftSchedulings[] = $existingEntity;
            }
        }

        $this->render('new', array('machines' => $machines, 'shiftSchedulings' => $shiftSchedulings));
    }

}