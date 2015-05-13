<?php

/**
 * This is the model class for table "groups".
 *
 * The followings are the available columns in table 'groups':
 * @property integer $id
 * @property string $groupname
 * @property integer $game_id
 * @property string $created
 * @property integer $user_count
 * @property integer $user_max
 *
 * The followings are the available model relations:
 * @property Game $game
 * @property Message[] $messages
 * @property User2game[] $user2games
 * @property ShiftScheduling[]  $ShiftSchedulings
 * @property Order[]  $Orders
 * @property ProductionOrder[]  $ProductionOrders
 * @property StockRotation[]  $StockRotations
 */
class Group extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'groups';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('game_id', 'validateGame'),
            array('game_id, user_count, user_max', 'numerical', 'integerOnly' => true),
            array('groupname', 'length', 'max' => 100),
            // The following rule is used by search().
            array('id, groupname, game_id, created, user_count, user_max', 'safe', 'on' => 'search'),
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
            'game' => array(self::BELONGS_TO, 'Game', 'game_id'),

            'messages' => array(self::HAS_MANY, 'Message', 'to_group_id'),
            'user2games' => array(self::HAS_MANY, 'User2game', 'group_id'),
            'ShiftSchedulings' => array(self::HAS_MANY, 'ShiftScheduling', 'group_id'),
            'orders' => array(self::HAS_MANY, 'Order', 'group_id'),
            'productionOrders' => array(self::HAS_MANY, 'ProductionOrder', 'group_id'),
            'stockRotations' => array(self::HAS_MANY, 'StockRotation', 'group_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'groupname' => Yii::t('app', 'Groupname'),
            'game_id' => Yii::t('app', 'Game'),
            'created' => Yii::t('app', 'Created'),
            'user_count' => Yii::t('app', 'User Count'),
            'user_max' => Yii::t('app', 'User Max'),
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
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('groupname', $this->groupname, true);
        $criteria->compare('game_id', $this->game_id);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('user_count', $this->user_count);
        $criteria->compare('user_max', $this->user_max);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Group the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function validateGame($attribute, $params)
    {
        $game = Game::model()->findByPk($this->$attribute);

        if (!isset($game))
            $this->addError($attribute, Yii::t('app', 'The Game is invalid!'));
    }
}
