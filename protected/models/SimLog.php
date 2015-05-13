<?php

/**
 * This is the model class for table "sim_logs".
 *
 * The followings are the available columns in table 'sim_logs':
 * @property integer $id
 * @property integer $status
 * @property string $description
 * @property integer $group_id
 * @property integer $period
 * @property string $log_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Groups $group
 */
class SimLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sim_logs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, group_id, period', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>200),
			array('log_id', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, status, description, group_id, period, log_id, created', 'safe', 'on'=>'search'),
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
			'status' => 'Status',
			'description' => 'Description',
			'group_id' => 'Group',
			'period' => 'Period',
			'log_id' => 'Log',
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
		$criteria->compare('status',$this->status);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('period',$this->period);
		$criteria->compare('log_id',$this->log_id,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SimLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function createLog($period,$groupID,$log_id,$status=0,$description='')
    {
        //Finden der log_id
        $simlog=SimLog::model()->findByAttributes(array('group_id'=>$groupID,'log_id'=>$log_id,'period'=>$period));
        if(empty($simlog))
        {
           $simlog=new SimLog();
            $simlog->description=$description;
            $simlog->group_id=$groupID;
            $simlog->status=$status;
            $simlog->log_id=$log_id;
            $simlog->period=$period;
        } else
        {
            if($description!='')
            {
                $simlog->description=$description;
            }
            $simlog->group_id=$groupID;
            $simlog->status=$status;
            $simlog->log_id=$log_id;
            $simlog->period=$period;
        }
        $simlog->save(false);
    }
}
