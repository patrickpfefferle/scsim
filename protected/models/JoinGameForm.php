<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class JoinGameForm extends CFormModel
{
    public $gamekey;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // name, email, subject and body are required
            array('gamekey', 'required'),
            array('gamekey', 'gameUniqueAndExists'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'gamekey' => Yii::t('app', 'Gamekey'),
        );
    }

    public function gameUniqueAndExists($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $game = Game::model()->find('game_key=:gamekey', array('gamekey' => $this->gamekey));
            if ($game === null) {
                $this->addError('gamekey', Yii::t('app', 'Gamekey not valid!'));
            } else {
                $user2game = User2game::model()->findByAttributes(array('game_id' => $game->id, 'user_id' => Yii::app()->user->id));
                if (!empty($user2game)) {
                    $this->addError('gamekey', Yii::t('app', 'You are already in this game!'));
                }
            }
        }
    }
}