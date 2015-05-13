<?php

/**
 * This is the model class for table "sim_period_status".
 *
 * The followings are the available columns in table 'sim_period_status':
 * @property integer $id
 * @property integer $game_id
 * @property integer $group_id
 * @property integer $period
 * @property integer $orders_set
 * @property integer $shift_schedulings_set
 * @property integer $production_orders_set
 * @property integer $simulation_started
 * @property integer $simulated
 * @property string $created
 */
class SimPeriodStatus extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sim_period_status';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('game_id, group_id, period, orders_set, shift_schedulings_set, production_orders_set, simulated', 'numerical', 'integerOnly' => true),
            array('created', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, game_id, group_id, period, orders_set, shift_schedulings_set, production_orders_set, simulated, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'game_id' => 'Game',
            'group_id' => 'Group',
            'period' => 'Period',
            'orders_set' => 'Orders Set',
            'shift_scheduling_set' => 'Shift Scheduling Set',
            'production_orders_set' => 'Production Orders Set',
            'simulated' => 'simulated',
            'created' => 'Created',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('game_id', $this->game_id);
        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('period', $this->period);
        $criteria->compare('InputOrders', $this->orders_set);
        $criteria->compare('InputShiftScheduling', $this->shift_schedulings_set);
        $criteria->compare('InputProductionOrders', $this->production_orders_set);
        $criteria->compare('simulated', $this->simulated);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SimPeriodStatus the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getCurrentPeriod($groupId = null)
    {
        /* $period = Yii::app()->db
             ->createCommand("SELECT MAX(period) FROM sim_period_status")
             ->where('group_id=:group_id', array(':group_id' => $groupId));
         echo $period->getText();
         print_r($period->params);
         die();*/
        $period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_period_status')->where('group_id=:group_id', array(':group_id' => $groupId))->queryScalar();
        return $period;
    }

    public static function getLastPlayedPeriod($groupId = null)
    {
        /* $period = Yii::app()->db
             ->createCommand("SELECT MAX(period) FROM sim_period_status")
             ->where('group_id=:group_id', array(':group_id' => $groupId));
         echo $period->getText();
         print_r($period->params);
         die();*/
        $period = Yii::app()->db->createCommand()->select('max(period)')->from('sim_period_status')->where('group_id=:group_id and simulated=1', array(':group_id' => $groupId))->queryScalar();
        return $period;
    }

    public static function getIsInSimulation($groupId=null)
    {
        $ps=SimPeriodStatus::model()->findByAttributes(array('group_id'=>$groupId,'period'=>SimPeriodStatus::getCurrentPeriod($groupId)));
        if(empty($ps))
        {
            return false;
        }
        if($ps->simulation_started && $ps->simulated!=1)
        {
            return true;
        } else return false;
    }

    /**
     * Returns a SimPeriodStatus
     * @param $groupId
     */
    public static function getCurrentPeriodSet($groupId = null)
    {
        if ($groupId == null) {
            $groupId = Yii::app()->user->getChoosedGroup();
        }

        $period = SimPeriodStatus::getCurrentPeriod($groupId);

        $ps = SimPeriodStatus::model()->findByAttributes(array('group_id' => $groupId, 'period' => $period));
        /*
                if (empty($ps)) {
                    $ps = new SimPeriodStatus();
                    $ps->group_id = $groupId;
                    $ps->game_id = 0;
                    $ps->save();
                    return $ps;
                } */
        //Prüfe ob alle Bedinungen erfüllt sind

        $allReady = true;

        // var_dump($ps);
        //  die();

        if (!empty($ps)) {
            ($ps->orders_set != 1) ? ($allReady = false) : (null);
            ($ps->shift_schedulings_set != 1) ? ($allReady = false) : (null);
            ($ps->production_orders_set != 1) ? ($allReady = false) : (null);
            ($ps->simulated != 1) ? ($allReady = false) : (null);
        }

        if ($allReady == true || empty($ps)) {
            $ps = new SimPeriodStatus();
            $ps->period = $period + 1;
            $ps->group_id = $groupId;
            $ps->game_id = Yii::app()->user->getChoosedGame();
            $ps->save();
            return $ps;
        } else {
            return $ps;
        }
    }

    /**
     * @param null $groupId
     * @return bool
     */
    public static function isReadytoSimulate($groupId = null)
    {
        if ($groupId == null) {
            $groupId = Yii::app()->user->getChoosedGroup();
        }

        $ps = SimPeriodStatus::getCurrentPeriodSet($groupId);

        $allReady = true;

        ($ps->orders_set != 1) ? ($allReady = false) : (null);
        ($ps->shift_schedulings_set != 1) ? ($allReady = false) : (null);
        ($ps->production_orders_set != 1) ? ($allReady = false) : (null);

        return $allReady;
    }
}
