<?php

class NewMessage extends CFormModel
{
    public $message;
    public $subject;
    public $toGroups = array();
    public $toUser = array();


    public function rules()
    {
        return array(
            array('message, subject', 'required'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'message' => Yii::t('app', 'Text'),
            'subject' => Yii::t('app', 'Subject'),
        );
    }

    public function sendMessage()
    {
        $ok = false;
        if ($this->toGroups == null && $this->toUser == null) {
            throw new ExceptionClass('To send a message you need a groupID or userID');
        }

        if ($this->toGroups != null) {

            foreach ($this->toGroups as $group) {
                $groupUser = User2game::model()->findAllByAttributes(array('group_id' => $group, 'game_id' => Yii::app()->user->ChoosedGame));
                //$groupUser = User2game::model()->findAll('group_id=:group_id and game_id=:game_id',array(':group_id' => $group, ':game_id' => Yii::app()->user->currentGame));

                foreach ($groupUser as $user) {

                    $ok = $this->saveMessage($this->subject, $this->message, $user->user_id);

                }
            }
        }
        if ($this->toUser != null) {

            foreach ($this->toUser as $user) {

                $ok = $this->saveMessage($this->subject, $this->message, $user);

            }
        }
        return $ok;
    }


    private function saveMessage($subject, $message, $user_id)
    {
        $dbmessage = new Message();
        $dbmessage->to_id = $user_id;
        $dbmessage->from_id = Yii::app()->user->id;
        $dbmessage->message = $message;
        $dbmessage->header = $subject;
        return $dbmessage->save();
    }

    public function containsGroup($group)
    {
        foreach ($this->toGroups as $id) {
            if ($id == $group->id) {
                return true;
            }
        }
        return false;
    }

    public function getJSUserString($id)
    {
        $user = User::model()->findByPk($id);
        /* @var $user User */
        // TODO: use json_encode(array('id' => $id, 'text' => $user->prename));
        return json_encode(array('id' => $id, 'text' => $user->prename . ' ' . $user->lastname));
        // return ' {id: "'.$id.'", text: "'.$user->prename.'"},';
    }

}
