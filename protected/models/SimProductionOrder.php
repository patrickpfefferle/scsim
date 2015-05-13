<?php

/**
 * This is the model class for table "sim_production_orders".
 *
 * The followings are the available columns in table 'sim_production_orders':
 * @property integer $id
 * @property integer $period
 * @property integer $cd_machine_id
 * @property integer $group_id
 * @property integer $amount
 * @property integer $production_order_id
 * @property integer $finished
 * @property integer $cycle_time
 * @property integer $elapsed_cycle_time
 * @property double $costs
 * @property double $set_up_time
 * @property double $clearing_time
 * @property integer $cd_workflow_id
 * @property integer $cd_step_id
 * @property integer $production_number
 * @property integer $sequence
 * @property string $color_gantt
 * @property string $status
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Groups $group
 * @property ProductionOrders $productionOrder
 */
class SimProductionOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sim_production_orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('period, cd_machine_id, group_id, amount, production_order_id, finished, cycle_time, elapsed_cycle_time, cd_workflow_id, cd_step_id, production_number, sequence', 'numerical', 'integerOnly'=>true),
			array('costs, set_up_time, clearing_time', 'numerical'),
			array('color_gantt, status', 'length', 'max'=>45),
			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, period, cd_machine_id, group_id, amount, production_order_id, finished, cycle_time, elapsed_cycle_time, costs, set_up_time, clearing_time, cd_workflow_id, cd_step_id, production_number, sequence, color_gantt, status, created', 'safe', 'on'=>'search'),
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
			'productionOrder' => array(self::BELONGS_TO, 'ProductionOrders', 'production_order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'period' => 'Period',
			'cd_machine_id' => 'Cd Machine',
			'group_id' => 'Group',
			'amount' => 'Amount',
			'production_order_id' => 'Production Order',
			'finished' => 'Finished',
			'cycle_time' => 'Cycle Time',
			'elapsed_cycle_time' => 'Elapsed Cycle Time',
			'costs' => 'Costs',
			'set_up_time' => 'Set Up Time',
			'clearing_time' => 'Clearing Time',
			'cd_workflow_id' => 'Cd Workflow',
			'cd_step_id' => 'Cd Step',
			'production_number' => 'Production Number',
			'sequence' => 'Sequence',
			'color_gantt' => 'Color Gantt',
			'status' => 'Status',
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
		$criteria->compare('period',$this->period);
		$criteria->compare('cd_machine_id',$this->cd_machine_id);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('production_order_id',$this->production_order_id);
		$criteria->compare('finished',$this->finished);
		$criteria->compare('cycle_time',$this->cycle_time);
		$criteria->compare('elapsed_cycle_time',$this->elapsed_cycle_time);
		$criteria->compare('costs',$this->costs);
		$criteria->compare('set_up_time',$this->set_up_time);
		$criteria->compare('clearing_time',$this->clearing_time);
		$criteria->compare('cd_workflow_id',$this->cd_workflow_id);
		$criteria->compare('cd_step_id',$this->cd_step_id);
		$criteria->compare('production_number',$this->production_number);
		$criteria->compare('sequence',$this->sequence);
		$criteria->compare('color_gantt',$this->color_gantt,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SimProductionOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
