<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $id
 * @property integer $cd_product_id
 * @property integer $amount
 * @property string $order_type
 * @property double $calculated_delivery_time
 * @property integer $delivered
 * @property double $delivery_costs
 * @property double $unit_price
 * @property double $total_price
 * @property double $end_price
 * @property double $order_period
 * @property double $delivery_period
 * @property integer $group_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Groups $group
 * @property CdProducts $cdProduct
 */
class Order extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'orders';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cd_product_id', 'validateProduct'),
            array('group_id', 'validateGroup'),
            array('cd_product_id, group_id', 'required'),
            array('amount, delivered, group_id', 'numerical', 'integerOnly' => true),
            array('calculated_delivery_time, delivery_costs, unit_price, total_price, end_price, order_period, delivery_period', 'numerical'),
            array('order_type', 'length', 'max' => 10),
            array('created', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cd_product_id, amount, order_type, calculated_delivery_time, delivered, delivery_costs, unit_price, total_price, end_price, order_period, delivery_period, group_id, created', 'safe', 'on' => 'search'),
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
            'group' => array(self::BELONGS_TO, 'Groups', 'group_id'),
            'cdProduct' => array(self::BELONGS_TO, 'CdProduct', 'cd_product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'cd_product_id' => 'Cd Product',
            'amount' => 'Amount',
            'order_type' => 'Order Type',
            'calculated_delivery_time' => 'Calculated Delivery Time',
            'delivered' => 'Delivered',
            'delivery_costs' => 'Delivery Costs',
            'unit_price' => 'Unit Price',
            'total_price' => 'Total Price',
            'end_price' => 'End Price',
            'order_period' => 'Order Period',
            'delivery_period' => 'Delivery Period',
            'group_id' => 'Group',
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
        $criteria->compare('cd_product_id', $this->cd_product_id);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('order_type', $this->order_type, true);
        $criteria->compare('calculated_delivery_time', $this->calculated_delivery_time);
        $criteria->compare('delivered', $this->delivered);
        $criteria->compare('delivery_costs', $this->delivery_costs);
        $criteria->compare('unit_price', $this->unit_price);
        $criteria->compare('total_price', $this->total_price);
        $criteria->compare('end_price', $this->end_price);
        $criteria->compare('order_period', $this->order_period);
        $criteria->compare('delivery_period', $this->delivery_period);
        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Order the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function validateProduct($attribute, $params)
    {
        $product = cdProduct::model()->findByPk($this->cd_product_id);

        if (empty($product))
            $this->addError($attribute, Yii::t('app', 'The Product  "{product}" is invalid!', array('{product}' => $this->cd_product_id)));
    }

    public function validateGroup($attribute, $params)
    {
        $group = Group::model()->findByPk($this->group_id);

        if (empty($group))
            $this->addError($attribute, Yii::t('app', 'The group is invalid!'));
    }
}
