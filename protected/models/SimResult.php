<?php

/**
 * This is the model class for table "sim_results".
 *
 * The followings are the available columns in table 'sim_results':
 * @property integer $id
 * @property integer $normal_capacity
 * @property integer $possible_capacity
 * @property double $capacity_ratio
 * @property integer $productive_time
 * @property double $efficiency
 * @property integer $sales
 * @property integer $sales_quantity
 * @property double $delivery_reliability
 * @property integer $idle_time
 * @property double $idle_time_costs
 * @property double $stock_value
 * @property double $storage_costs
 * @property double $normal_sale_price
 * @property double $normal_sale_profit
 * @property double $normal_sale_profit_unit
 * @property double $summary
 * @property integer $period
 * @property integer $group_id
 * @property string $created
 */
class SimResult extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sim_results';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('normal_capacity, possible_capacity, productive_time, sales, sales_quantity, idle_time, period, group_id', 'numerical', 'integerOnly'=>true),
			array('capacity_ratio, efficiency, delivery_reliability, idle_time_costs, stock_value, storage_costs, normal_sale_price, normal_sale_profit, normal_sale_profit_unit, summary', 'numerical'),
			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, normal_capacity, possible_capacity, capacity_ratio, productive_time, efficiency, sales, sales_quantity, delivery_reliability, idle_time, idle_time_costs, stock_value, storage_costs, normal_sale_price, normal_sale_profit, normal_sale_profit_unit, summary, period, group_id, created', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'normal_capacity' => 'Normal Capacity',
			'possible_capacity' => 'Possible Capacity',
			'capacity_ratio' => 'Capacity Ratio',
			'productive_time' => 'Productive Time',
			'efficiency' => 'Efficiency',
			'sales' => 'Sales',
			'sales_quantity' => 'Sales Quantity',
			'delivery_reliability' => 'Delivery Reliability',
			'idle_time' => 'Idle Time',
			'idle_time_costs' => 'Idle Time Costs',
			'stock_value' => 'Stock Value',
			'storage_costs' => 'Storage Costs',
			'normal_sale_price' => 'Normal Sale Price',
			'normal_sale_profit' => 'Normal Sale Profit',
			'normal_sale_profit_unit' => 'Normal Sale Profit Unit',
			'summary' => 'Summary',
			'period' => 'Period',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('normal_capacity',$this->normal_capacity);
		$criteria->compare('possible_capacity',$this->possible_capacity);
		$criteria->compare('capacity_ratio',$this->capacity_ratio);
		$criteria->compare('productive_time',$this->productive_time);
		$criteria->compare('efficiency',$this->efficiency);
		$criteria->compare('sales',$this->sales);
		$criteria->compare('sales_quantity',$this->sales_quantity);
		$criteria->compare('delivery_reliability',$this->delivery_reliability);
		$criteria->compare('idle_time',$this->idle_time);
		$criteria->compare('idle_time_costs',$this->idle_time_costs);
		$criteria->compare('stock_value',$this->stock_value);
		$criteria->compare('storage_costs',$this->storage_costs);
		$criteria->compare('normal_sale_price',$this->normal_sale_price);
		$criteria->compare('normal_sale_profit',$this->normal_sale_profit);
		$criteria->compare('normal_sale_profit_unit',$this->normal_sale_profit_unit);
		$criteria->compare('summary',$this->summary);
		$criteria->compare('period',$this->period);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SimResult the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
