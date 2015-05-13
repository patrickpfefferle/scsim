<?php

/**
 * This is the model class for table "sim_debug_logs".
 *
 * The followings are the available columns in table 'sim_debug_logs':
 * @property integer $id
 * @property integer $group_id
 * @property integer $period
 * @property integer $simtime
 * @property integer $order_id
 * @property integer $production_order_id
 * @property integer $sim_production_order_id
 * @property integer $sim_operating_data_id
 * @property integer $sim_machine_id
 * @property integer $cd_product_id
 * @property integer $cd_workflow_id
 * @property integer $sequence
 * @property integer $cd_step_id
 * @property string $text
 * @property string $created
 */
class SimDebugLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sim_debug_logs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, period, simtime, order_id, production_order_id, sim_production_order_id, sim_operating_data_id, sim_machine_id, cd_product_id, cd_workflow_id, sequence, cd_step_id', 'numerical', 'integerOnly'=>true),
			array('text, created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, group_id, period, simtime, order_id, production_order_id, sim_production_order_id, sim_operating_data_id, sim_machine_id, cd_product_id, cd_workflow_id, sequence, cd_step_id, text, created', 'safe', 'on'=>'search'),
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
			'group_id' => 'Group',
			'period' => 'Period',
			'simtime' => 'Simtime',
			'order_id' => 'Order',
			'production_order_id' => 'Production Order',
			'sim_production_order_id' => 'Sim Production Order',
			'sim_operating_data_id' => 'Sim Operating Data',
			'sim_machine_id' => 'Sim Machine',
			'cd_product_id' => 'Cd Product',
			'cd_workflow_id' => 'Cd Workflow',
			'sequence' => 'Sequence',
			'cd_step_id' => 'Cd Step',
			'text' => 'Text',
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
		$criteria->compare('period',$this->period);
		$criteria->compare('simtime',$this->simtime);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('production_order_id',$this->production_order_id);
		$criteria->compare('sim_production_order_id',$this->sim_production_order_id);
		$criteria->compare('sim_operating_data_id',$this->sim_operating_data_id);
		$criteria->compare('sim_machine_id',$this->sim_machine_id);
		$criteria->compare('cd_product_id',$this->cd_product_id);
		$criteria->compare('cd_workflow_id',$this->cd_workflow_id);
		$criteria->compare('sequence',$this->sequence);
		$criteria->compare('cd_step_id',$this->cd_step_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SimDebugLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function Log($array)
    {
        $log= new SimDebugLog();
        $log->attributes=$array;
        $log->save();
    }
}
