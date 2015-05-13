<?php

/**
 * This is the model class for table "cd_steps".
 *
 * The followings are the available columns in table 'cd_steps':
 * @property integer $id
 * @property integer $cd_machine_id
 * @property integer $cycle_time
 * @property integer $set_up_time
 * @property integer $clearing_time
 * @property integer $cd_workflow_id
 * @property integer $sequence
 * @property integer $admin_id
 * @property string $created
 * @property integer cd_gameset_id
 *
 * The followings are the available model relations:
 * @property CdInputpart[] $CdInputparts
 * @property CdMachine $cdMachine
 * @property CdWorkflow $cdWorkflow
 * @property User $admin
 * @property CdGameset $CdGameset
 */
class CdStep extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cd_steps';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('admin_id', 'validateAdmin'),
            array('cd_gameset_id', 'validateGameSet'),
            array('cd_workflow_id', 'validateWorkflow'),
            array('cd_machine_id', 'validateMachine'),
            array('cd_machine_id, admin_id, cd_gameset_id, cd_workflow_id', 'numerical', 'integerOnly' => true),
            array(', cycle_time, set_up_time, clearing_time, sequence', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            array('id, cd_machine_id, cycle_time, set_up_time, clearing_time, cd_workflow_id, admin_id, gameset_id, sequence, created', 'safe', 'on' => 'search'),
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
            'cdInputparts' => array(self::HAS_MANY, 'cdInputparts', 'cd_step_id'),

            'cdMachine' => array(self::BELONGS_TO, 'CdMachine', 'cd_machine_id'),
            'cdWorkflow' => array(self::BELONGS_TO, 'CdWorkflow', 'cd_workflow_id'),
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
            'cd_machine_id' => Yii::t('app', 'Machine'),
            'cycle_time' => Yii::t('app', 'Cycle Time'),
            'set_up_time' => Yii::t('app', 'Set Up Time'),
            'clearing_time' => Yii::t('app', 'Clearing Time'),
            'cd_workflow_id' => Yii::t('app', 'Workflow'),
            'sequence' => Yii::t('app', 'Sequence'),
            'admin_id' => Yii::t('app', 'Admin'),
            'gameset_id' => Yii::t('app', 'Gameset'),
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
        $criteria->compare('cd_machine_id', $this->cd_machine_id);
        $criteria->compare('cycle_time', $this->cycle_time);
        $criteria->compare('set_up_time', $this->set_up_time);
        $criteria->compare('clearing_time', $this->clearing_time);
        $criteria->compare('cd_workflow_id', $this->cd_workflow_id);
        $criteria->compare('sequence', $this->sequence);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('cd_gameset_id', $this->created, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CdStep the static model class
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

    public function validateMachine($attribute, $params)
    {
        $machine = cdMachine::model()->findByPk($this->$attribute);

        if (!isset($machine))
            $this->addError($attribute, Yii::t('app', 'The Machine is invalid!'));
    }

    public function validateWorkflow($attribute, $params)
    {
        $workflow = cdWorkflow::model()->findByPk($this->$attribute);

        if (!isset($workflow))
            $this->addError($attribute, Yii::t('app', 'The Workflow is invalid!'));
    }

}
