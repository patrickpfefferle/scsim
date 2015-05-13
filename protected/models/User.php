<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $prename
 * @property string $lastname
 * @property string $email
 * @property string $ident
 * @property string $organisation
 * @property string $password_md5
 * @property integer $blocked
 * @property string $created
 * @property boolean $is_admin
 * @property boolean $is_mod
 * @property string $cookieauthkey
 *
 * The followings are the available model relations:
 * @property Message[] $messages
 * @property Message[] $messages1
 * @property User2game[] $user2games
 * @property CdMachine[] $cdMachines
 * @property CdGameset[] $cdGamesets
 * @property CdInputpart[] $cdInputparts
 * @property CdStep[] $cdSteps
 * @property CdWorkflow[] $cdWorkflows
 * @property Rights[] $rights
 */
class User extends CActiveRecord
{

    public $oldpassword;
    public $password;
    public $password_wdh;
    public $gamekey;
    public $text = "Beispiel";

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            $this->email = strtolower($this->email);
            if ($this->scenario == 'register' || $this->scenario == 'resetPassword' || $this->scenario == 'changePassword') {
                $this->password_md5 = md5($this->password);
            }

            return true;
        } else return false;

    }


    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('prename, lastname, email', 'required'),
            array('valid_until', 'type', 'type' => 'date', 'dateFormat' => 'yyyy-mm-dd'),

            array('blocked, is_admin, is_mod, max_groups, max_games, max_user_per_group', 'numerical', 'integerOnly' => true),
            array('prename, lastname, email', 'length', 'max' => 100),
            array('ident, organisation', 'length', 'max' => 50),
            array('password_md5', 'length', 'max' => 40),
            array('email', 'email'),
            array('email', 'unique'),
            array('password, password_wdh', 'required', 'on' => array('changePassword')),
            array('password, password_wdh, gamekey', 'required', 'on' => array('register')),
            array('gamekey', 'gameKeyValid', 'on' => array('register')),
            array('password_wdh', 'compare', 'compareAttribute' => 'password', 'on' => 'register, changePassword'),
            // The following rule is used by search().
            array('id, prename, lastname, email, ident, organisation, password_md5, blocked, created', 'safe', 'on' => 'search'),
        );
    }


    public static function getRandomPassword()
    {
        $length = 8;
        $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        shuffle($chars);
        return implode(array_slice($chars, 0, $length));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'sentmessages' => array(self::HAS_MANY, 'Message', 'from_id'),
            'receivedmessages' => array(self::HAS_MANY, 'Message', 'to_id'),
            'user2games' => array(self::HAS_MANY, 'User2game', 'user_id'),
            'cdMachines' => array(self::HAS_MANY, 'CdMachine', 'admin_id'),
            'cdGamesets' => array(self::HAS_MANY, 'CdGameset', 'admin_id'),
            'cdInputparts' => array(self::HAS_MANY, 'CdInputpart', 'admin_id'),
            'cdProducts' => array(self::HAS_MANY, 'CdProduct', 'admin_id'),
            'cdSteps' => array(self::HAS_MANY, 'CdStep', 'admin_id'),
            'cdWorkflows' => array(self::HAS_MANY, 'CdWorkflow', 'admin_id'),
            'rights' => array(self::HAS_MANY, 'Right', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'prename' => Yii::t('app', 'Prename'),
            'lastname' => Yii::t('app', 'Lastname'),
            'email' => Yii::t('app', 'Email'),
            'ident' => Yii::t('app', 'Ident'),
            'organisation' => Yii::t('app', 'Organisation'),
            'password_md5' => Yii::t('app', 'Password Crypted'),
            'created' => Yii::t('app', 'Created'),
            'blocked' => Yii::t('app', 'Blocked'),
            'password' => Yii::t('app', 'Password'),
            'gamekey' => Yii::t('app', 'Gamekey'),
            'password_wdh' => Yii::t('app', 'Password repeat'),
            'oldpassword' => Yii::t('app', 'Old password'),
            'is_admin' => Yii::t('app', 'Is a administrator'),
            'is_mod' => Yii::t('app', 'Is a moderator'),
            'valid_until' => Yii::t('app', 'Valid until'),
            'max_groups' => Yii::t('app', 'Maximal Groups'),
            'max_games' => Yii::t('app', 'Maximal Games'),
            'max_user_per_group' => Yii::t('app', 'Maximal User/Group'),
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
        $criteria->compare('prename', $this->prename, true);
        $criteria->compare('lastname', $this->lastname, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('ident', $this->ident, true);
        $criteria->compare('organisation', $this->organisation, true);
        $criteria->compare('password_md5', $this->password_md5, true);
        $criteria->compare('blocked', $this->blocked);
        $criteria->compare('created', $this->created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function gameKeyValid($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $game = Game::model()->find('game_key=:gamekey', array('gamekey' => $this->gamekey));
            if ($game === null) {
                $this->addError('gamekey', Yii::t('app', 'Gamekey not valid!'));
            }
        }
    }

    public static function isMemberOfGroup($groupId)
    {
        return (User2game::model()->count('user_id=:user_id and group_id=:group_id', array(':user_id' => Yii::app()->user->id, ':group_id' => $groupId)) >= 1) ? (true) : (false);
    }

    public function validatePassword($password)
    {
        return $password == $this->password_md5;
    }


}
