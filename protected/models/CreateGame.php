<?php


class CreateGame extends CFormModel
{

    public $cd_gameset_id;
    public $group_count;
    public $max_games;
    public $user_per_group;
    public $gamename;
    public $game_key;

    /**
     * Declares the validation rules.
     * The rules state that email and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('cd_gameset_id, group_count, user_per_group, gamename, game_key', 'required'),
            array('game_key', 'unique', 'className' => 'Game'),
            array('group_count', 'validGroupcount'),
            array('max_games', 'validGameCount'),
            array('user_per_group, group_count','numerical','integerOnly'=>true,'min'=>1 ,'max'=>250),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'cd_gameset_id' => Yii::t('app', 'Game set'),
            'gamename' => Yii::t('app', 'Game name'),
            'game_key' => Yii::t('app', 'Game key'),
            'group_count' => Yii::t('app', 'Group count'),
            'user_per_group' => Yii::t('app', 'User per group'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */

    public function validGroupcount($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->group_count < 1) {
                $this->addError('group_count', Yii::t('app', 'Group count must be at least 1'));
            }
            $user = User::model()->findByPk(Yii::app()->user->id);
            if (!$user->is_admin) {
                if ($this->group_count > $user->max_groups) {
                    $this->addError('group_count', Yii::t('app', 'Allowed group count exceeded. Please contact your administrator!'));
                }
            }
        }
    }

    public function validGameCount($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::model()->findByPk(Yii::app()->user->id);
            $games_count = Game::model()->countByAttributes(array('admin_id' => Yii::app()->user->id));
            if (!$user->is_admin) {
                if ($user->max_games > $games_count) {
                    $this->addError('gamename', Yii::t('app', 'Allowed max games exceeded. Please contact your administrator!'));
                }
            }
        }
    }

    public function validUserpergroup($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::model()->findByPk(Yii::app()->user->id);
            if (!$user->is_admin) {
                if ($user->max_user_per_group > $this->user_per_group) {
                    $this->addError('user_per_group', Yii::t('app', 'Allowed max user per group exceeded. Please contact your administrator!'));
                }
            }
        }
    }

    public function create()
    {
        $game = new Game;
        $game->game_key = $this->game_key;
        $game->name = $this->gamename;
        $game->admin_id = Yii::app()->user->id;
        $game->cd_gameset_id = $this->cd_gameset_id;
        $game->save();

      // print_r($game->getErrors());

        for ($i = 1; $i <= $this->group_count; $i++) {
            $group = new Group;
            $group->groupname = Yii::t('app','Group {i}', array('{i}'=>$i));
            $group->game_id = $game->getPrimaryKey();
            $group->user_max = $this->user_per_group;
            $group->save();

            $sim_p_status= new SimPeriodStatus();
            $sim_p_status->game_id=$game->id;
            $sim_p_status->group_id=$group->id;
            $sim_p_status->period=0;
            $sim_p_status->orders_set=1;
            $sim_p_status->shift_schedulings_set=1;
            $sim_p_status->production_orders_set=1;
            $sim_p_status->simulated=1;
            $sim_p_status->save();

            $starting_parts = CdProduct::model()->findAllByAttributes(array('cd_gameset_id'=>$this->cd_gameset_id));

            foreach ($starting_parts as $starting_part) {
                $stock = new Stock();
                $stock->cd_product_id = $starting_part->id;
                $stock->group_id = $group->getPrimaryKey();
                $stock->period = 0;
                $stock->amount = $starting_part->start_amount;
                $stock->price = $starting_part->value;
                $stock->save();

                $stock_rotation = new StockRotation();
                $stock_rotation->cd_product_id = $starting_part->id;
                $stock_rotation->group_id = $group->getPrimaryKey();
                $stock_rotation->period = 0;
                $stock_rotation->sim_time = 0;
                $stock_rotation->amount = $starting_part->start_amount;
                $stock_rotation->save();
            }
        }

    }

}
