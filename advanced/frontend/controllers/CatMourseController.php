<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\base\Event;
use vendor\animals\Cat;
use vendor\animals\Mourse;

Class CatMourseController extends Controller
{
    public function actionIndex()
    {
        $cat = new Cat();
        $mourse = new Mourse();
        //事件触发处理器
        Event::on(Cat::className(), 'miaos', [$mourse, 'run']);
        $cat->shout();
    }
}