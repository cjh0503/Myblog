<?php

namespace common\components\behavior;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class PermissionBehavior extends Behavior
{
    public $ations = [];
    
    public function events() {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }
    /**
    * 
    * @param \yii\base\ActionEvent $event
    * @throws ForbiddenHttpException
    * @return boolean
    */
    public function beforeAction($event)
    {
        $controller = $event->action->controller->id;//获取控制器
        $action = $event->action->id;//获取到action
        
        //验证权限
        $access = $controller."::".$action;  //权限name
        
        /* @var yii\rbac\DbManager $auth */
    }
}