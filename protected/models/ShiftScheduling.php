<?php

/**
 * This is the model class for table "shift_scheduling".
 *
 * The followings are the available columns in table 'shift_scheduling':
 * @property integer $id
 * @property integer $cd_machine_id
 * @property integer $shift_amount
 * @property integer $overtime
 * @property integer $group_id
 * @property integer $period
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Group $group
 * @property CdMachine $cdMachine
 */
class ShiftScheduling extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'shift_schedulings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cd_machine_id, group_id, period', 'numerical', 'integerOnly' => true),
            array('group_id', 'validateGroup'),
            array('shift_amount', 'numerical', 'integerOnly' => true, 'min' => '1', 'max' => '3'),
            array('overtime', 'numerical', 'integerOnly' => true, 'max' => '1440'),
            array('cd_machine_id', 'validateMachine'),
            array('cd_machine_id, shift_amount, period, group_id', 'required'),
            array('created', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cd_machine_id, shift_amount, overtime, group_id, period, created', 'safe', 'on' => 'search'),
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
            'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
            'machine' => array(self::BELONGS_TO, 'CdMachine', 'cd_machine_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'cd_machine_id' => Yii::t('app', 'Machine'),
            'shift_amount' => Yii::t('app', 'Shift Amount'),
            'overtime' => Yii::t('app', 'Overtime'),
            'group_id' => Yii::t('app', 'Group'),
            'period' => Yii::t('app', 'Period'),
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('cd_machine_id', $this->cd_machine_id);
        $criteria->compare('shift_amount', $this->shift_amount);
        $criteria->compare('overtime', $this->overtime);
        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('period', $this->period);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ShiftScheduling the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function validateMachine($attribute, $params)
    {
        $machine = cdMachine::model()->findByPk($this->cd_machine_id);

        if (empty($machine))
            $this->addError($attribute, Yii::t('app', 'The Machine  "{machine}" is invalid!', array('{machine}' => $this->cd_machine_id)));

    }

    public function validateGroup($attribute, $params)
    {
        $group = Group::model()->findByPk($this->group_id);

        if (empty($group))
            $this->addError($attribute, Yii::t('app', 'The group is invalid!'));
    }


}
