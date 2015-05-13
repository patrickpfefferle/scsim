<?php

/**
 * This is the model class for table "sim_sellings".
 *
 * The followings are the available columns in table 'sim_sellings':
 * @property integer $id
 * @property integer $cd_product_id
 * @property integer $group_id
 * @property integer $period
 * @property integer $amount
 * @property double $price
 * @property double $end_price
 * @property integer $ordered_amount
 * @property double $delivery_reliability
 * @property string $selling_type
 * @property integer $to_group_id
 * @property string $created
 */
class SimSelling extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sim_sellings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cd_product_id, group_id, period, amount, ordered_amount, to_group_id', 'numerical', 'integerOnly'=>true),
			array('price, end_price, delivery_reliability', 'numerical'),
			array('selling_type', 'length', 'max'=>45),
			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cd_product_id, group_id, period, amount, price, end_price, ordered_amount, delivery_reliability, selling_type, to_group_id, created', 'safe', 'on'=>'search'),
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
			'cd_product_id' => 'Cd Product',
			'group_id' => 'Group',
			'period' => 'Period',
			'amount' => 'Amount',
			'price' => 'Price',
			'end_price' => 'End Price',
			'ordered_amount' => 'Ordered Amount',
			'delivery_reliability' => 'Delivery Reliability',
			'selling_type' => 'Selling Type',
			'to_group_id' => 'To Group',
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
		$criteria->compare('cd_product_id',$this->cd_product_id);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('period',$this->period);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('price',$this->price);
		$criteria->compare('end_price',$this->end_price);
		$criteria->compare('ordered_amount',$this->ordered_amount);
		$criteria->compare('delivery_reliability',$this->delivery_reliability);
		$criteria->compare('selling_type',$this->selling_type,true);
		$criteria->compare('to_group_id',$this->to_group_id);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SimSelling the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function addComputerSelling($cd_product_id,$group_id,$period,$amount,$price,$ordered_amount,$selling_type='solid sale')
    {
        $simSelling= new SimSelling();
        $simSelling->cd_product_id=$cd_product_id;
        $simSelling->group_id=$group_id;
        $simSelling->period=$period;
        $simSelling->amount=$amount;
        $simSelling->price=$price;
        $simSelling->ordered_amount=$ordered_amount;

        //Berechnungen
        $simSelling->end_price=$simSelling->amount*$simSelling->price;
        $simSelling->delivery_reliability=$simSelling->amount/($simSelling->ordered_amount/100);

        //Type setzen
        $simSelling->selling_type=$selling_type;

        $simSelling->save(0);
    }
}
