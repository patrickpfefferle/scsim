<?php

/**
 * Userclass of a scsim user
 *
 * @author   Andreas Vratny <andreas@vratny.de>
 * @author   Marius Heinemann-Grüder <marius.hg@live.de>
 * @version  0.2
 * @access   public
 */
class ScsimUser extends CWebUser
{

    /**
     * Which group is selected.
     * If no group is selected the value is null
     */
    public function getChoosedGroup()
    {
        return $this->getState('choosedGroup');
    }

    /**
     * Select a group
     */
    public function setChoosedGroup($value = null)
    {
        $this->setState('choosedGroup', $value);
        if ($value != null) {
            $group = Group::model()->findByPk($value);
            if (!empty($group)) {
                $this->setGroupName($group->groupname);
                $this->setChoosedPeriod(SimPeriodStatus::getCurrentPeriod($group->id));

            } else {
                //Die Gruppe gibt es gar nicht Oo
                $this->setChoosedGroup();
                $this->setChoosedPeriod();
            }
        }
    }

    /**
     * Get the users current gameset
     */
    public function getGameSet()
    {
        return $this->getState('gameSet');
    }

    /**
     * Select the gameset to the users current game
     */
    public function setGameSet($value = null)
    {
        $this->setState('gameSet', $value);
    }

    /**
     * Which game is selected.
     * If no game is selected the value is null
     */
    public function getChoosedGame()
    {
        return $this->getState('choosedGame');
    }

    /**
     * Select a game
     */
    public function setChoosedGame($value = null)
    {
        $this->setState('choosedGame', $value);
        //Sollte sich das Spiel ändern, muss auch nach der bestehenden Gruppe gesucht werden!
        if ($value != null) {
            $game = Game::model()->findByPk($value);
            if (!empty($game)) {
                // Gameset setzen
                $this->setGameSet($game->cd_gameset_id);
                // Das angegebene Spiel wurde gefunden
                //Spielname setzen
                $this->setGameName($game->name);
                //Versuche direkt auch die Gruppe zu selektieren
                $User2Game = User2game::model()->findByAttributes(array('game_id' => $value, 'user_id' => $this->getUserID()));
                if (!empty($User2Game->group_id)) {
                    //Eine Zuordnung zu einer Gruppe besteht bereits
                    $this->setChoosedGroup($User2Game->group_id);
                } else {
                    $this->setChoosedGroup();
                    $this->setChoosedPeriod();
                }

            } else {
                //Es wurde kein Spiel mit dieser ID gefunden, somit muss Periode und Gruppe zurückgesetzt werden
                $this->setChoosedGame();
                $this->setChoosedGroup();
                $this->setChoosedPeriod();
            }
        }
    }

    /**
     * Which period is selected.
     * If no period is selected the value is null
     */
    public function getChoosedPeriod()
    {
        $maxPeriod = Yii::app()->db->createCommand()->select('max(period)')->from('sim_period_status')->where('group_id=:group_id ', array(':group_id' => Yii::app()->user->getChoosedGroup()))->queryScalar();
        if($maxPeriod<$this->getState('choosedPeriod'))
        {
            Yii::app()->user->setChoosedPeriod($maxPeriod);
            return $maxPeriod;
        } else
        return $this->getState('choosedPeriod');
    }

    /**
     * Select a period
     */
    public function setChoosedPeriod($value = null)
    {
        $this->setState('choosedPeriod', $value);
    }

    /**
     * Which gamename is the current
     * If no gamename is selected the value is empty
     */
    public function getGameName()
    {
        return $this->getState('GameName');
    }

    /**
     * Select a GameName
     */
    public function setGameName($value = '')
    {
        $this->setState('GameName', $value);
    }

    /**
     * Which groupname is the current
     * If no groupname is selected the value is empty
     */
    public function getGroupName()
    {
        return $this->getState('GroupName');
    }

    /**
     * Select a GameName
     */
    public function setGroupName($value = '')
    {
        $this->setState('GroupName', $value);
    }

    /**
     * The current logged in user id of database
     */
    public function getUserID()
    {
        return $this->getState('UserID');
    }

    /**
     * Is the current User a admin?
     */
    public function getIsAdmin()
    {
        return $this->getState('IsAdmin');
    }


    /**
     * Is the current User a Moderator?
     */
    public function getIsMod()
    {
        return $this->getState('IsMod');
    }


    /**
     * Current name of the logged in user
     */
    public function getName()
    {
        return $this->getState('Name');
    }


/// Functions

    /**
     * Was a game choosed by the user?
     * @return bool
     */
    public function isGamechoosed()
    {
        return $this->getChoosedGame() != null;
    }

    /**
     * Was a group choosed by the user?
     * @return bool
     */
    public function isGroupchoosed()
    {
        return $this->getChoosedGroup() != null;
    }

    /**
     * Was a period choosed by the user?
     * @return bool
     */
    public function isPeriodchoosed()
    {
        return $this->getChoosedPeriod() != null;
    }

    /**
     * How many messages are unread?
     * @return int
     */
    public function unreadMessages()
    {
        return Message::model()->count('t.read=:read and (to_id=:to_id)', array(':to_id' => $this->getUserID(), ':read' => '0'));
    }

    /**
     * Is current User Admin or Mod of the Game?
     */
    public function isAdminOrModOfGame()
    {
        $game_id = $this->getChoosedGame();
        if (empty($game_id)) {
            return false;
        } else {
            $game = Game::model()->findByPk($game_id);
            if (empty($game)) {
                $this->setChoosedGame();
                $this->setChoosedGroup();
                $this->setChoosedPeriod();
                return false;
            }


            if ($game->admin_id == $this->getUserID()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function isAllowedtoPlay($groupId = null)
    {
        if ($groupId == null) {
            return false;
        }
        $model = User2game::model()->findByAttributes(array('group_id' => $groupId, 'user_id' => Yii::app()->user->getUserID()));
        if (empty($model)) {
            return false;
        } else {
            return true;
        }
    }

}