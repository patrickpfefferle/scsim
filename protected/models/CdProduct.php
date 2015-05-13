<?php

/**
 * This is the model class for table "cd_products".
 *
 * The followings are the available columns in table 'cd_products':
 * @property integer $id
 * @property string $kind
 * @property string $number
 * @property string $description
 * @property double $value
 * @property integer $discount_amount
 * @property double $delivery_costs
 * @property double $delivery_time
 * @property double $delivery_deviation
 * @property integer $admin_id
 * @property string $created
 * @property integer cd_gameset_id
 * @property integer start_amount
 *
 * The followings are the available model relations:
 * @property CdInputpart[] $cdInputparts
 * @property User $admin
 * @property CdWorkflow $cdWorkflows
 * @property Order[] $orders
 * @property ProductionOrder[] $productionOrders
 * @property StockRotation[] $stockRotations
 * @property CdGameset $CdGameset
 */
class CdProduct extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cd_products';
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
            array('description, admin_id', 'required'),
            array('discount_amount, admin_id, cd_gameset_id', 'numerical', 'integerOnly' => true),
            array('value, delivery_costs, delivery_time, delivery_deviation', 'numerical'),
            array('kind', 'length', 'max' => 1),
            array('number', 'length', 'max' => 45),
            array('description', 'length', 'max' => 100),
            array('created', 'safe'),
            // The following rule is used by search().
            array('id, kind, number, description, value, discount_amount, delivery_costs, delivery_time, delivery_deviation, admin_id, created', 'safe', 'on' => 'search'),
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
            'cdGameset' => array(self::BELONGS_TO, 'CdGameset', 'cd_gameset_id'),

            'cdInputparts' => array(self::HAS_MANY, 'CdInputpart', 'cd_product_id'),
            'orders' => array(self::HAS_MANY, 'Order', 'cd_product_id'),
            'productionOrders' => array(self::HAS_MANY, 'ProductionOrder', 'cd_product_id'),
            'stockRotations' => array(self::HAS_MANY, 'StockRotation', 'cd_product_id'),

            'cdWorkflow' => array(self::HAS_ONE, 'CdWorkflow', 'output_product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'kind' => Yii::t('app', 'Kind'),
            'number' => Yii::t('app', 'Number'),
            'description' => Yii::t('app', 'Description'),
            'value' => Yii::t('app', 'Value'),
            'discount_amount' => Yii::t('app', 'Discount Amount'),
            'delivery_costs' => Yii::t('app', 'Delivery Costs'),
            'delivery_time' => Yii::t('app', 'Delivery Time'),
            'delivery_deviation' => Yii::t('app', 'Delivery Deviation'),
            'start_amount' => Yii::t('app', 'Start Amount'),
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
        $criteria->compare('kind', $this->kind, true);
        $criteria->compare('number', $this->number, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('value', $this->value);
        $criteria->compare('discount_amount', $this->discount_amount);
        $criteria->compare('delivery_costs', $this->delivery_costs);
        $criteria->compare('delivery_time', $this->delivery_time);
        $criteria->compare('delivery_deviation', $this->delivery_deviation);
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
     * @return CdProduct the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Finds a single CdProduct by name and the current users' gameset
     * @param $name e.g. "E 10"
     * @return array|CActiveRecord|mixed|null
     */
    public function findByName($name) {
        return $this->findByAttributes(array('number' => $name, 'cd_gameset_id' => Yii::app()->user->GameSet));
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
