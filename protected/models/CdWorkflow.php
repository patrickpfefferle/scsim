<?php

/**
 * This is the model class for table "cd_workflow".
 *
 * The followings are the available columns in table 'cd_workflow':
 * @property integer $id
 * @property string $description
 * @property integer $output_product_id
 * @property integer $admin_id
 * @property string $created
 * @property integer cd_gameset_id
 *
 * The followings are the available model relations:
 * @property CdStep[] $cdSteps
 * @property User $admin
 * @property CdProduct $outputProduct
 * @property CdGameset $CdGameset
 */
class CdWorkflow extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cd_workflows';
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
            array('output_product_id', 'validateProduct'),
            array('output_product_id, admin_id, cd_gameset_id', 'numerical', 'integerOnly' => true),
            array('description', 'length', 'max' => 100),
            array('created', 'safe'),
            // The following rule is used by search().
            array('id, description, output_product_id, admin_id, created, cd_gameset_id', 'safe', 'on' => 'search'),
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
            'cdSteps' => array(self::HAS_MANY, 'CdStep', 'cd_workflow_id'),

            'admin' => array(self::BELONGS_TO, 'User', 'admin_id'),
            'outputProduct' => array(self::BELONGS_TO, 'CdProduct', 'output_product_id'),
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
            'output_product_id' => Yii::t('app', 'Output Product'),
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
        $criteria->compare('description', $this->description, true);
        $criteria->compare('output_product_id', $this->output_product_id);
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
     * @return CdWorkflow the static model class
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

    public function validateGameSet($attribute, $params)
    {
        $gameSet = CdGameset::model()->findByPk($this->$attribute);

        if (!isset($gameSet))
            $this->addError($attribute, Yii::t('app', 'The GameSet is invalid!'));
    }

    public function validateProduct($attribute, $params)
    {
        $product = cdProduct::model()->findByPk($this->$attribute);

        if (!isset($product))
            $this->addError($attribute, Yii::t('app', 'The Product is invalid!'));
    }
}
