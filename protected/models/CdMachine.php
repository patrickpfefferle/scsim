<?php

/**
 * This is the model class for table "cd_machines".
 *
 * The followings are the available columns in table 'cd_machines':
 * @property integer $id
 * @property string $description
 * @property string $ident
 * @property integer $admin_id
 * @property double $running_costs
 * @property double $fixed_costs
 * @property double $cost_price
 * @property double $replacement_time
 * @property double $replacement_deviation
 * @property integer cd_gameset_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $admin
 * @property CdStep[] $cdSteps
 * @property ShiftScheduling[] $shiftSchedulings
 * @property CdGameset $CdGameset
 */
class CdMachine extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cd_machines';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('admin_id', 'validateAdmin'),
            array('cd_gameset_id', 'validateGameSet'),
            array('description', 'required'),
            array('admin_id, cd_gameset_id', 'numerical', 'integerOnly' => true),
            array('running_costs, fixed_costs, cost_price, replacement_time, replacement_deviation', 'numerical'),
            array('description', 'length', 'max' => 100),
            array('ident', 'length', 'max' => 45),
            array('created', 'safe'),
            // The following rule is used by search().
            array('id, description, ident, admin_id, running_costs, fixed_costs, cost_price, replacement_time, replacement_deviation, created, cd_gameset_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cdSteps' => array(self::HAS_MANY, 'CdStep', 'cd_machine_id'),
            'shiftSchedulings' => array(self::HAS_MANY, 'ShiftScheduling', 'cd_maschine_id'),
            'admin' => array(self::BELONGS_TO, 'User', 'admin_id'),
            'cdGameset' => array(self::BELONGS_TO, 'CdGameset', 'cd_gameset_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Description'),
            'ident' => Yii::t('app', 'Ident'),
            'admin_id' => Yii::t('app', 'Admin'),
            'running_costs' => Yii::t('app', 'Running Costs'),
            'fixed_costs' => Yii::t('app', 'Fixed Costs'),
            'cost_price' => Yii::t('app', 'Cost Price'),
            'replacement_time' => Yii::t('app', 'Replacement Time'),
            'replacement_deviation' => Yii::t('app', 'Replacement Deviation'),
            'cd_gameset_id' => Yii::t('app', 'Gameset'),
            'wage_shift_one'=>Yii::t('app','Wage Shift 1'),
            'wage_shift_two'=>Yii::t('app','Wage Shift 2'),
            'wage_shift_three'=>Yii::t('app','Wage Shift 3'),
            'wage_overtime'=>Yii::t('app','Wage Overtime'),
            'created' => Yii::t('app', 'Created'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('ident', $this->ident, true);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('running_costs', $this->running_costs);
        $criteria->compare('fixed_costs', $this->fixed_costs);
        $criteria->compare('cost_price', $this->cost_price);
        $criteria->compare('replacement_time', $this->replacement_time);
        $criteria->compare('replacement_deviation', $this->replacement_deviation);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('cd_gameset_id', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CdMachine the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function validateGameSet($attribute, $params)
    {
        $gameSet = CdGameset::model()->findByPk($this->$attribute);

        if (!isset($gameSet))
            $this->addError($attribute, Yii::t('app', 'The GameSet is invalid!'));
    }

    public function validateAdmin($attribute, $params)
    {
        $user = User::model()->findByPk($this->$attribute);

        if (!isset($user) || !($user->is_admin))
            $this->addError($attribute, Yii::t('app', 'You are no admin!'));
    }
}
