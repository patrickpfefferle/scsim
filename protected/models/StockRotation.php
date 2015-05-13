<?php

/**
 * This is the model class for table "stock_rotations".
 *
 * The followings are the available columns in table 'stock_rotations':
 * @property integer $id
 * @property integer $cd_product_id
 * @property integer $group_id
 * @property double $period
 * @property integer $sim_time
 * @property integer $amount
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Groups $group
 * @property CdProducts $cdProduct
 */
class StockRotation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stock_rotations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cd_product_id, group_id, period, sim_time', 'required'),
			array('cd_product_id, group_id, sim_time, amount', 'numerical', 'integerOnly'=>true),
			array('period', 'numerical'),
			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cd_product_id, group_id, period, sim_time, amount, created', 'safe', 'on'=>'search'),
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
			'cdProduct' => array(self::BELONGS_TO, 'CdProducts', 'cd_product_id'),
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
			'sim_time' => 'Sim Time',
			'amount' => 'Amount',
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
		$criteria->compare('sim_time',$this->sim_time);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StockRotation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
