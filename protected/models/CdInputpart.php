<?php

/**
 * This is the model class for table "cd_partcombinations".
 *
 * The followings are the available columns in table 'cd_partcombinations':
 * @property integer $id
 * @property integer $cd_step_id
 * @property integer $cd_product_id
 * @property integer $amount
 * @property integer $admin_id
 * @property integer cd_gameset_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property CdProduct $cdProduct
 * @property CdStep $cdStep
 * @property User $admin
 * @property CdGameset $CdGameset
 */
class CdInputpart extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cd_inputparts';
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
            array('cd_step_id', 'validateStep'),
            array('cd_product_id', 'validateProduct'),
            array('cd_step_id, cd_product_id, admin_id, cd_gameset_id', 'required'),
            array('cd_step_id, cd_gameset_id ,cd_product_id, amount, admin_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            array('id, cd_step_id, cd_product_id, cd_gameset_id,amount, admin_id, created', 'safe', 'on' => 'search'),
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
            'cdProduct' => array(self::BELONGS_TO, 'CdProduct', 'cd_product_id'),
            'cdStep' => array(self::BELONGS_TO, 'CdStep', 'cd_step_id'),
            'cdGameset' => array(self::BELONGS_TO, 'CdGameset', 'cd_gameset_id'),
            'admin' => array(self::BELONGS_TO, 'User', 'admin_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'cd_step_id' => Yii::t('app', 'Step'),
            'cd_product_id' => Yii::t('app', 'Product'),
            'amount' => Yii::t('app', 'Amount'),
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
        $criteria->compare('cd_step_id', $this->cd_step_id);
        $criteria->compare('cd_product_id', $this->cd_product_id);
        $criteria->compare('amount', $this->amount);
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
     * @return CdInputpart the static model class
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

    public function validateStep($attribute, $params)
    {
        $step = cdStep::model()->findByPk($this->$attribute);

        if (!isset($step))
            $this->addError($attribute, Yii::t('app', 'The Step is invalid!'));
    }


}
