<?php

/**
 * This is the model class for table "sim_waiting_products".
 *
 * The followings are the available columns in table 'sim_waiting_products':
 * @property integer $id
 * @property integer $missing_product_id
 * @property integer $output_product_id
 * @property integer $cd_machine_id
 * @property integer $production_order_id
 * @property integer $sim_production_order_id
 * @property integer $amount
 * @property integer $period
 * @property integer $group_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Groups $group
 */
class SimWaitingProduct extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sim_waiting_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, group_id', 'required'),
			array('id, missing_product_id, output_product_id, cd_machine_id, production_order_id, sim_production_order_id, amount, period, group_id', 'numerical', 'integerOnly'=>true),
			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, missing_product_id, output_product_id, cd_machine_id, production_order_id, sim_production_order_id, amount, period, group_id, created', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'missing_product_id' => 'Missing Product',
			'output_product_id' => 'Output Product',
			'cd_machine_id' => 'Cd Machine',
			'production_order_id' => 'Production Order',
			'sim_production_order_id' => 'Sim Production Order',
			'amount' => 'Amount',
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
		$criteria->compare('missing_product_id',$this->missing_product_id);
		$criteria->compare('output_product_id',$this->output_product_id);
		$criteria->compare('cd_machine_id',$this->cd_machine_id);
		$criteria->compare('production_order_id',$this->production_order_id);
		$criteria->compare('sim_production_order_id',$this->sim_production_order_id);
		$criteria->compare('amount',$this->amount);
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
	 * @return SimWaitingProduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function waitForProduct($missing_product_id,$output_product_id,$cd_machine_id,$production_order_id,$sim_production_order_id,$amount,$period,$group_id)
    {
        $simWaitProduct = SimWaitingProduct::model()->findByAttributes(array('missing_product_id'=>$missing_product_id,'sim_production_order_id'=>$sim_production_order_id,'period'=>$period));
        if(empty($simWaitProduct))
        {
            $simWaitProduct = new SimWaitingProduct();
            $simWaitProduct->missing_product_id=$missing_product_id;
            $simWaitProduct->output_product_id=$output_product_id;
            $simWaitProduct->cd_machine_id=$cd_machine_id;
            $simWaitProduct->production_order_id=$production_order_id;
            $simWaitProduct->sim_production_order_id=$sim_production_order_id;
            $simWaitProduct->amount=$amount;
            $simWaitProduct->period=$period;
            $simWaitProduct->group_id=$group_id;

        } else
        {
            $simWaitProduct->amount=$amount;
        }
        $simWaitProduct->save();
    }

    public static function unwaitForProduct($missing_product_id,$sim_production_order_id,$period)
    {
        $simWaitProduct = SimWaitingProduct::model()->findByAttributes(array('missing_product_id'=>$missing_product_id,'sim_production_order_id'=>$sim_production_order_id,'period'=>$period));
        if(!empty($simWaitProduct))
        {
            $simWaitProduct->delete();
        }
    }
}
