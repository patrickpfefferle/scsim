<?php

/**
 * This is the model class for table "cd_shift_costs".
 *
 * The followings are the available columns in table 'cd_shift_costs':
 * @property integer $id
 * @property integer $cd_gameset_id
 * @property double $wage_shift_one
 * @property double $wage_shift_two
 * @property double $wage_shift_three
 * @property double $wage_overtime
 * @property double $running_costs
 * @property double $fixed_costs
 * @property string $created
 *
 * The followings are the available model relations:
 * @property CdGamesets $cdGameset
 */
class CdShiftCost extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cd_shift_costs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cd_gameset_id', 'numerical', 'integerOnly'=>true),
			array('wage_shift_one, wage_shift_two, wage_shift_three, wage_overtime, running_costs, fixed_costs', 'numerical'),
			array('created', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cd_gameset_id, wage_shift_one, wage_shift_two, wage_shift_three, wage_overtime, running_costs, fixed_costs, created', 'safe', 'on'=>'search'),
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
			'cdGameset' => array(self::BELONGS_TO, 'CdGamesets', 'cd_gameset_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cd_gameset_id' => 'Cd Gameset',
			'wage_shift_one' => 'Wage Shift One',
			'wage_shift_two' => 'Wage Shift Two',
			'wage_shift_three' => 'Wage Shift Three',
			'wage_overtime' => 'Wage Overtime',
			'running_costs' => 'Running Costs',
			'fixed_costs' => 'Fixed Costs',
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
		$criteria->compare('cd_gameset_id',$this->cd_gameset_id);
		$criteria->compare('wage_shift_one',$this->wage_shift_one);
		$criteria->compare('wage_shift_two',$this->wage_shift_two);
		$criteria->compare('wage_shift_three',$this->wage_shift_three);
		$criteria->compare('wage_overtime',$this->wage_overtime);
		$criteria->compare('running_costs',$this->running_costs);
		$criteria->compare('fixed_costs',$this->fixed_costs);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CdShiftCost the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
