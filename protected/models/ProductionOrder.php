<?php

/**
 * This is the model class for table "production_orders".
 *
 * The followings are the available columns in table 'production_orders':
 * @property integer $id
 * @property integer $group_id
 * @property integer $cd_product_id
 * @property integer $amount
 * @property double $order_period
 * @property string $color_gantt
 * @property integer $order_number
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Groups $group
 * @property CdProducts $cdProduct
 * @property SimProductionOrders[] $simProductionOrders
 */
class ProductionOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'production_orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, cd_product_id, amount, order_number', 'numerical', 'integerOnly'=>true),
			array('order_period', 'numerical'),
			array('color_gantt', 'length', 'max'=>45),
            array('cd_product_id', 'validateGroup'),
            array('group_id', 'validateProduct'),
			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, group_id, cd_product_id, amount, order_period, color_gantt, order_number, created', 'safe', 'on'=>'search'),
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
			'simProductionOrders' => array(self::HAS_MANY, 'SimProductionOrders', 'production_order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'group_id' => 'Group',
			'cd_product_id' => 'Cd Product',
			'amount' => 'Amount',
			'order_period' => 'Order Period',
			'color_gantt' => 'Color Gantt',
			'order_number' => 'Order Number',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('cd_product_id',$this->cd_product_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('order_period',$this->order_period);
		$criteria->compare('color_gantt',$this->color_gantt,true);
		$criteria->compare('order_number',$this->order_number);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductionOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function validateProduct($attribute, $params)
    {
        $product = cdProduct::model()->findByPk($this->cd_product_id);

        if (empty($product))
            $this->addError($attribute,  Yii::t('app', 'The Product  "{product}" is invalid!', array('{product}'=>$this->cd_product_id)));
    }

    public function validateGroup($attribute, $params)
    {
        $group = Group::model()->findByPk($this->group_id);

        if (empty($group))
            $this->addError($attribute, Yii::t('app', 'The group is invalid!'));
    }
}
