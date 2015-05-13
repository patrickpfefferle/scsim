<?php

/**
 * This is the model class for table "rights".
 *
 * The followings are the available columns in table 'rights':
 * @property integer $id
 * @property string $ident
 * @property string $set_to
 * @property integer $user_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Right extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rights';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('user_id', 'validateUser'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('ident', 'length', 'max'=>20),
			array('set_to', 'length', 'max'=>200),
			// The following rule is used by search().
			array('id, ident, set_to, user_id, created', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'ident' => Yii::t('app', 'Ident'),
			'set_to' => Yii::t('app', 'Set To'),
			'user_id' =>Yii::t('app',  'User'),
			'created' => Yii::t('app', 'Created'),
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
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('ident',$this->ident,true);
		$criteria->compare('set_to',$this->set_to,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Right the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public function validateUser($attribute, $params)
    {
        $user = User::model()->findByPk($this->$attribute);

        if (!isset($user))
            $this->addError($attribute, Yii::t('app', 'Invalid User!'));
    }
}
