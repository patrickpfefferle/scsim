<?php

/**
 * This is the model class for table "user2games".
 *
 * The followings are the available columns in table 'user2games':
 * @property integer $id
 * @property integer $user_id
 * @property integer $game_id
 * @property integer $group_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Game $game
 * @property Group $group
 * @property User $user
 */
class User2game extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user2games';
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
            array('group_id', 'validateGroup'),
            array('user_id', 'validateUser'),
            array('user_id, game_id', 'required'),
            array('user_id, game_id, group_id', 'numerical', 'integerOnly' => true),
            array('user_id, game_id, group_id', 'ext.emptyNullValidator'),
            // Alternativ zum externen Validator
            // array('user_id, game_id, group_id', 'default', 'setOnEmpty' => true, 'value' => null
            // The following rule is used by search().
            array('id, user_id, game_id, group_id, created', 'safe', 'on' => 'search'),
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
            'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
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
            'user_id' => Yii::t('app', 'User'),
            'game_id' => Yii::t('app', 'Game'),
            'group_id' => Yii::t('app', 'Group'),
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
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('game_id', $this->game_id);
        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User2game the static model class
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

    public function validateGroup($attribute, $params)
    {
        if (!is_null($this->$attribute)) {
            $group = Group::model()->findByPk($this->$attribute);

            if (!isset($group))
                $this->addError($attribute, Yii::t('app', 'The group is invalid!'));
        }
    }

    public function validateUser($attribute, $params)
    {
        $user = User::model()->findByPk($this->$attribute);

        if (!isset($user))
            $this->addError($attribute, Yii::t('app', 'Invalid User!'));
    }

}
