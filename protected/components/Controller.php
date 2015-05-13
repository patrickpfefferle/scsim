<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    function init()
    {
        if (!isset(Yii::app()->request->cookies['language'])) {
            Yii::app()->language = 'en';
            // die('using defautl language');
        } else {
            Yii::app()->language = explode('_', Yii::app()->request->cookies['language']->value)[0];
            // die ('--'. Yii::app()->language.'--');
        }

        //Sessionstate für Admin in jedem Fall setzen.
        $a = Yii::app()->user->getState('IsAdmin');
        if (empty($a)) {
            Yii::app()->user->setState('IsAdmin', false);
        }

    }

    function needChoosedGame()
    {
        if (!Yii::app()->user->isGamechoosed()) {
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_WARNING, Yii::t('app', 'To use this function please choose a game!'));
            $this->redirect(array('user/ChooseGame'));
        }
        if(!Yii::app()->user->isGroupchoosed())
        {
            Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_WARNING, Yii::t('app', 'To use this function please choose a group!'));
            $this->redirect(array('group/list'));
        }
    }

    



}