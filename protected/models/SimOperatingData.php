<?php

/**
 * This is the model class for table "sim_operating_datas".
 *
 * The followings are the available columns in table 'sim_operating_datas':
 * @property integer $id
 * @property integer $cd_machine_id
 * @property integer $group_id
 * @property integer $period
 * @property integer $simtime_start
 * @property integer $simtime_end
 * @property integer $day
 * @property integer $day_start
 * @property integer $day_end
 * @property string $shift
 * @property integer $production_order_id
 * @property integer $sim_production_order_id
 * @property double $shift_costs
 * @property double $machine_costs
 * @property double $costs
 * @property string $created
 */
class SimOperatingData extends CActiveRecord
{

    public $sum;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sim_operating_datas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cd_machine_id, group_id, period, simtime_start, simtime_end, day, day_start, day_end, production_order_id, sim_production_order_id', 'numerical', 'integerOnly'=>true),
			array('shift_costs, machine_costs, costs', 'numerical'),
			array('shift', 'length', 'max'=>45),
			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cd_machine_id, group_id, period, simtime_start, simtime_end, day, day_start, day_end, shift, production_order_id, sim_production_order_id, shift_costs, machine_costs, costs, created', 'safe', 'on'=>'search'),
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
			'cd_machine_id' => 'Cd Machine',
			'group_id' => 'Group',
			'period' => 'Period',
			'simtime_start' => 'Simtime Start',
			'simtime_end' => 'Simtime End',
			'day' => 'Day',
			'day_start' => 'Day Start',
			'day_end' => 'Day End',
			'shift' => 'Shift',
			'production_order_id' => 'Production Order',
			'sim_production_order_id' => 'Sim Production Order',
			'shift_costs' => 'Shift Costs',
			'machine_costs' => 'Machine Costs',
			'costs' => 'Costs',
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
		$criteria->compare('cd_machine_id',$this->cd_machine_id);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('period',$this->period);
		$criteria->compare('simtime_start',$this->simtime_start);
		$criteria->compare('simtime_end',$this->simtime_end);
		$criteria->compare('day',$this->day);
		$criteria->compare('day_start',$this->day_start);
		$criteria->compare('day_end',$this->day_end);
		$criteria->compare('shift',$this->shift,true);
		$criteria->compare('production_order_id',$this->production_order_id);
		$criteria->compare('sim_production_order_id',$this->sim_production_order_id);
		$criteria->compare('shift_costs',$this->shift_costs);
		$criteria->compare('machine_costs',$this->machine_costs);
		$criteria->compare('costs',$this->costs);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SimOperatingData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
