<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 02.03.14
 * Time: 13:23
 */
class MessageController extends Controller
{

    public function actionInbox()
    {
        $this->needChoosedGame();

        $messages = Message::model()->findAllByAttributes(array('to_id' => Yii::app()->user->id), array('order'=>'created DESC'));
        $this->render('inbox', array('messages' => $messages));
    }

    public function actionNew($id = null)
    {
        $this->needChoosedGame();

        $model = new NewMessage();

        if (!is_null($id)) {
            $message = Message::model()->findByPk($id);
            $model->toUser[] = $message->from_id;
            $model->subject = 'RE: ' . $message->header;
        }

        if (isset($_POST['NewMessage'])) {
            // var_dump($_POST['NewMessage']);
            $model->attributes = $_POST['NewMessage'];
            // get all group ids
            if (isset($_POST['NewMessage']['toGroups'])) {
                $model->toGroups = $_POST['NewMessage']['toGroups'];
                // var_dump($model->toGroups);
            }
            // merge all to users into one array
            if (isset($_POST['NewMessage']['toUser'])) {

                $allGroupUsers = $_POST['NewMessage']['toUser'];

                foreach ($allGroupUsers as $str) {
                    if ($str != "") {
                        $arr = explode(',', $str);
                        $model->toUser = array_merge($model->toUser, $arr);
                    }
                }
            }
            if ($model->sendMessage()) {
                // TODO: Message wird noch nicht angezeigt
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, Yii::t('app', 'Your message has been send successfully!'));
                $this->redirect('inbox');

            }
        }


        if (Yii::app()->user->isGamechoosed()) {
            $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->ChoosedGame));
        } else {
            throw new CHttpException(403, Yii::t('app', 'Sie müssen zuerst ein Spiel auswählen!'));
        }


        $this->render('new', array('model' => $model, 'groups' => $groups));
    }

    public function actionDelete($id)
    {
        $this->needChoosedGame();

        if (Message::canDeleteMessage($id)) {
            throw new CHttpException(403, Yii::t('app', 'Action not possible!'));
        }
        $message = Message::model()->findByPk($id);
        if (empty($message)) {
            throw new CHttpException(404, Yii::t('app', 'No message found!'));
        }
        $message->delete();
        $this->redirect(array('Message/inbox'));
    }

    public function actionView($id)
    {
        $this->needChoosedGame();

        $message = Message::model()->findByPk($id);
        if (empty($message)) {
            throw new CHttpException(404, Yii::t('app', 'No message found!'));
        }
        if (Message::ownsMessage($id)) {
            throw new CHttpException(403, Yii::t('app', 'This message is not yours!'));
        }
        $message->read = 1;
        $message->save();
        $this->render('view', array('message' => $message));
    }
}