<?php

/**
 * This is the model class for table "messages".
 *
 * The followings are the available columns in table 'messages':
 * @property integer $id
 * @property integer $from_id
 * @property integer $to_id
 * @property string $header
 * @property string $message
 * @property string $unique_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $from
 * @property User $to
 */
class Message extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'messages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('from_id', 'required'),
            array('from_id, to_id', 'numerical', 'integerOnly' => true),
            array('header', 'length', 'max' => 200),
            array('unique_id', 'length', 'max' => 30),
            array('message', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, from_id, to_id, header, message, unique_id, created', 'safe', 'on' => 'search'),
        );
    }

    public function from()
    {
        $user = User::model()->findByPk($this->from_id);
        if (!empty($user)) {
            return $user->prename . " " . $user->lastname;
        } else return Yii::t('app', 'System');
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'from' => array(self::BELONGS_TO, 'User', 'from_id'),
            'to' => array(self::BELONGS_TO, 'User', 'to_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'from_id' => Yii::t('app', 'From'),
            'to_id' => Yii::t('app', 'To'),
            'header' => Yii::t('app', 'Header'),
            'message' => Yii::t('app', 'Message'),
            'unique_id' => Yii::t('app', 'Unique'),
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('from_id', $this->from_id);
        $criteria->compare('to_id', $this->to_id);
        $criteria->compare('header', $this->header, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('unique_id', $this->unique_id, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Message the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function ownsMessage($id)
    {
        $message = Message::model()->findByPk($id);
        return $message->to_id != Yii::app()->user->id;
    }

    public static function canDeleteMessage($id)
    {
        $message = Message::model()->findByPk($id);
        return Message::ownsMessage($id);
    }
}
