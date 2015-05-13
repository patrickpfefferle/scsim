<?php

/**
 * This is the model class for table "games".
 *
 * The followings are the available columns in table 'games':
 * @property integer $id
 * @property string $name
 * @property string $game_key
 * @property integer $admin_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $admin
 * @property CdGameset $CdGameset
 * @property Group[] $groups
 * @property Rule[] $rules
 * @property User2game[] $user2games
 */
class Game extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'games';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('admin_id', 'validateAdmin'),
            array('cd_gameset_id', 'validateGameSet'),
            array('admin_id', 'numerical', 'integerOnly' => true),
            array('name, game_key', 'length', 'max' => 20),
            array('game_key', 'unique'),
            // The following rule is used by search().
            array('id, name, game_key, user_id, created', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'admin_id'),
            'cdGameset' => array(self::BELONGS_TO, 'CdGameset', 'cd_gameset_id'),

            'groups' => array(self::HAS_MANY, 'Group', 'game_id'),
            'rules' => array(self::HAS_MANY, 'Rule', 'game_id'),
            'user2games' => array(self::HAS_MANY, 'User2game', 'game_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'game_key' => Yii::t('app', 'Game Key'),
            'admin_id' => Yii::t('app', 'Admin'),
            'gameset_id' => Yii::t('app', 'Gameset'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('game_key', $this->game_key, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('cd_gameset_id', $this->created, true);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Game the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function validateAdmin($attribute, $params)
    {
        $user = User::model()->findByPk($this->$attribute);

        if (!isset($user) || !($user->is_admin))
            $this->addError($attribute, Yii::t('app', 'You are no admin!'));
    }

    public function validateGameSet($attribute, $params)
    {
        $gameSet = CdGameset::model()->findByPk($this->$attribute);

        if (!isset($gameSet))
            $this->addError($attribute, Yii::t('app', 'The GameSet is invalid!'));
    }

    /**
     * Get the current period by search database for played periods
     *
     * @author Andreas Vratny <andreas@vratny.de>
     * @return Period as Integer
     * @throws ExceptionClass No game is selected
     */
    public static function getCurrentPeriod()
    {
        if(empty(Yii::app()->user->currentGame))
        {
            throw new ExceptionClass('No currentGame is selected!');
        }
     //   $period =
    }
}
