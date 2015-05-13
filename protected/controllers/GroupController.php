<?php

class GroupController extends Controller
{
    public function actionList()
    {
        $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->ChoosedGame));
        if (!empty($groups)) {
            $this->render('list', array('model' => $groups));
        } else {
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'There are no groups in the current game!'));
            $this->render('list', array('model' => $groups));
        }
    }

    public function actionJoin($id)
    {
        $user = User::model()->find('id=:id', array('id' => Yii::app()->user->id));
        $group = Group::model()->findByPk($id);

        if (empty($user) || empty($group)) {
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Internal error!'));
            $this->redirect(array('group/list'));
        }

        $user2game = User2game::model()->findByAttributes(array('user_id' => Yii::app()->user->id, 'game_id' => $group->game_id));
        if (!(empty($user2game->group_id))) {
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'You are already member of another group!'));
        } else if ($group->user_count >= $group->user_max) {
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Group is full!'));
        } else {

            $group->user_count = $group->user_count + 1;
            $group->save();

            $user2game->group_id = $group->id;

            if ($user2game->save()) {
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS, Yii::t('app', 'You have joined the chosen group!'));
                Yii::app()->user->setChoosedGroup($group->id);
                $this->redirect(array('game/home'));
            } else {
                Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('app', 'Internal error!'));
            }
        }
        $this->redirect(array('group/list'));
    }

    public function actionSwitch($id)
    {
        //Kein Spiel gewählt
        if (!Yii::app()->user->isGamechoosed()) {
            $this->redirect(array('user/ChooseGame'));
        }
        //Wenn der User kein Admin ist, geht gar nix
        if (!Yii::app()->user->isAdmin && !Yii::app()->user->isMod) {
            return;
        }
        Yii::app()->user->setChoosedGroup($id);
        $this->redirect(array('site/index'));

    }

    public function actionViewgroups()
    {
        if (!Yii::app()->user->isAdmin && !Yii::app()->user->isMod) {
            $this->redirect(array('site/index'));
        }
        //Kein Spiel gewählt

        if (!Yii::app()->user->isGamechoosed()) {
            $this->redirect(array('user/ChooseGame'));
        }
        $game = Game::model()->findByPk(Yii::app()->user->getChoosedGame());
        if ($game->admin_id == Yii::app()->user->id) {
            $groups = Group::model()->findAllByAttributes(array('game_id' => Yii::app()->user->getChoosedGame()));
            $this->render('viewgroups', array('groups' => $groups));
        } else {
            $this->redirect(array('site/index'));
        }
    }


}