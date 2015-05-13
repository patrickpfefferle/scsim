<?php

/**
 * This is the model class for table "cd_gameset".
 *
 * The followings are the available columns in table 'cd_gameset':
 * @property integer $id
 * @property string $description
 * @property integer $admin_id
 * @property string $created
 *
 *
 * The followings are the available model relations:
 * @property User $admin
 * @property CdMachine[] $cdMachines
 * @property CdInputpart[] $cdInputparts
 * @property CdProduct[] $cdProducts
 * @property CdStep[] $cdSteps
 * @property CdWorkflow[] $cdWorkflows
 * @property CdGame[] $cdGames
 */
class CdGameset extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cd_gamesets';
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
            array('id, admin_id', 'numerical', 'integerOnly' => true),
            array('description', 'length', 'max' => 100),
            array('created', 'safe'),
            // The following rule is used by search().
            array('id, description, admin_id, created', 'safe', 'on' => 'search'),
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
            'admin' => array(self::BELONGS_TO, 'User', 'admin_id'),

            'cdMachine' => array(self::HAS_MANY, 'CdMachine', 'cd_gameset_id'),
            'cdInputparts' => array(self::HAS_MANY, 'CdInputpart', 'cd_gameset_id'),
            'cdProducts' => array(self::HAS_MANY, 'CdProduct', 'cd_gameset_id'),
            'cdSteps' => array(self::HAS_MANY, 'CdStep', 'cd_gameset_id'),
            'cdWorkflow' => array(self::HAS_MANY, 'CdWorkflow', 'cd_gameset_id'),
            'cdGames' => array(self::HAS_MANY, 'CdGame', 'cd_gameset_id'),
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
            'admin_id' => Yii::t('app', 'Admin'),
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
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Gameset the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function validateAdmin($attribute, $params)
    {
        $user = User::model()->findByPk($this->$attribute);

        if (!isset($user) || !($user->is_admin))
            $this->addError($attribute, Yii::t('app', 'You are no admin!'));
    }
}
