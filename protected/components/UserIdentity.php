<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    public $_id;

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        $record = User::model()->find('email=:email', array('email' => strtolower($this->username)));
        if ($record === null) {
            $this->_id = -1;
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if ($record->password_md5 !== md5($this->password)) // here I compare db password with password field
        {
            $this->_id = -1;
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else if ($record->blocked) //  here I check status as Active in db
        {
            $err = Yii::t('app', 'You have been set inactive by an admin.');
            $this->errorCode = $err;
        } else {
            $this->_id = $record->id;
            $this->errorCode = self::ERROR_NONE;
            //Cookie setzen für JavaScript Planer resp. API
            $record->cookieauthkey = md5(User::getRandomPassword());
            $record->save();
            $cookie = new CHttpCookie('passcode', $record->cookieauthkey);
            $cookie->expire = time() + 604800; // 7 Tage gültig
            Yii::app()->request->cookies['scsimJSPlaner'] = $cookie;
            //Yii::app()->user->load($record->id, $record->is_admin, $record );

            $this->setState('UserID', $record->id);
            $this->setState('IsAdmin', $record->is_admin);
            $this->setState('IsMod', $record->is_mod);
            $this->setState('Name', $record->prename . ' ' . $record->lastname);

            if (empty(Yii::app()->request->cookies['language'])) {

                $cookie = new CHttpCookie('language', 'en');
                $cookie->expire = time() + 60 * 60 * 24 * 180;
                Yii::app()->request->cookies['language'] = $cookie;
                $_SESSION['lang'] = 'en';
            }
            if(empty( $_SESSION['lang']))
            {
                $_SESSION['lang'] = Yii::app()->request->cookies['language'];
            }
        }
        return !$this->errorCode;
    }

    public function getId() //  override Id
    {
        return $this->_id;
    }


}