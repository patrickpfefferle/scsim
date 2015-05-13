<?php

class UserController extends Controller
{

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('register', 'resetPassword'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('chooseGame', 'joinGame', 'useGame', 'changePassword', 'editProfile', 'listPeriods', 'choosePeriod'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionResetPassword()
    {
        $model = new User();

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'resetPassword-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['User'])) {

            $user = User::model()->findByAttributes(array('email' => $_POST['User']['email']));

            $user->scenario = 'resetPassword';
            if (!empty($user)) {

                $user->password = User::getRandomPassword();
                $user->save();
                $message = new YiiMailMessage;
                $message->view = 'resetPassword';
                //userModel is passed to the view
                $message->setBody(array('password' => $user->password), 'text/html');
                $message->setSubject('New password request');
                $message->addTo($user->email);
                $message->from = Yii::app()->params['adminEmail'];
                Yii::app()->mail->send($message);
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, Yii::t('app', 'Password successfully resetted!'));
                $this->redirect(array('site/login'));

            } else {
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'No user found with this e-mail address!'));
            }
        }
        $this->render('resetPassword', array('model' => $model));
    }

    public function actionChangePassword()
    {
        $model = User::model()->findByPk(Yii::app()->user->id);

        $model->scenario = 'changePassword';


        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'changePassword-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->validate()) {
                if ($model->save()) {
                    //TODO: Message wird nicht ausgegeben
                    Yii::app()->user->logout();
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, Yii::t('app', 'Password successfully changed!'));
                    $this->redirect(array('site/login'));
                } else {
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Problem while saving!'));
                }
            } else {
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Please check the errors below!'));
            }
        }
        $this->render('changePassword', array('model' => $model));
    }

    public function actionEditProfile()
    {
        $model = User::model()->findByPk(Yii::app()->user->id);

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'editProfile-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->validate()) {
                if ($model->save()) {
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, Yii::t('app', 'Data successfully changed!'));
                } else {
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Problem while saving!'));
                }
            } else {
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Please check the errors below!'));
            }
        }
        $this->render('editProfile', array('model' => $model));
    }

    public function actionRegister()
    {
        $model = new User();
        $model->scenario = 'register';
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate()) {
                if ($model->save()) {
                    $user2game = new User2game();
                    $user2game->user_id = $model->id;
                    $user2game->game_id = Game::model()->find('game_key=:gamekey', array('gamekey' => $model->gamekey))->id;
                    $user2game->save();
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, Yii::t('app', 'Registration successfull! Please check your mails for further instructions!'));
                    $this->redirect(array('site/login'));
                } else {
                    Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Problem while saving!'));
                }
            } else
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Please check the errors below!'));

        }
        // display the login form
        $this->render('register', array('model' => $model));
    }

    /*
     *
     */
    public function actionChooseGame()
    {
        $games = User2game::model()->with('game', 'group')->findAll('user_id=:user_id', array('user_id' => Yii::app()->user->id));
        $this->render('choosegame', array('games' => $games));
    }

    public function actionUseGame($id)
    {
        $user2game = User2game::model()->findByAttributes(array('user_id' => Yii::app()->user->id, 'game_id' => $id));
        if (!empty($user2game)) {
            //Yii::app()->user->setState('currentGame', $user2game->game_id);
            Yii::app()->user->setChoosedGame($user2game->game_id);
            if (empty($user2game->group_id)) {
                $this->redirect(array('group/list'));
            } else {
                $this->redirect(array('game/home'));
            }

        } else {
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'No permissions to use this game!'));
            $this->redirect(array('user/choosegame'));
        }
    }

    public function actionJoinGame()
    {
        $joinGameForm = new JoinGameForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'joingame-form') {
            echo CActiveForm::validate($joinGameForm);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['JoinGameForm'])) {
            $joinGameForm->attributes = $_POST['JoinGameForm'];
            // validate user input and redirect to the previous page if valid
            if ($joinGameForm->validate()) {
                $user2game = new User2game();
                $user2game->user_id = Yii::app()->user->id;
                $user2game->game_id = Game::model()->find('game_key=:gamekey', array('gamekey' => $joinGameForm->gamekey))->id;
                $user2game->save();

                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, Yii::t('app', 'Successfully joined the game!'));
                $this->redirect(array('user/choosegame'));
            } else
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Please check the errors below!'));

        }
        $this->render('joingame', array('model' => $joinGameForm));
    }

    public function actionListPeriods()
    {
        $periods = SimPeriodStatus::model()->findAllByAttributes(array('group_id' => Yii::app()->user->getChoosedGroup(), 'simulated' => 1));

        $this->render('listPeriods', array('model' => $periods));
    }

    public function actionchoosePeriod($period)
    {
        Yii::app()->user->setChoosedPeriod($period);
        $this->redirect(array('site/index'));
    }
}