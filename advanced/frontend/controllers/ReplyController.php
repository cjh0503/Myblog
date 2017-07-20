<?php

namespace frontend\controllers;

use Yii;
use common\models\Reply;

Class ReplyController extends \yii\web\Controller
{
    public function actionAdd(){
        if(!Yii::$app->user->isGuest){
            $reply = new Reply();
            $reply->user_id = Yii::$app->user->identity->id;
            $reply->comment_id = Yii::$app->request->post('comment_id');
            $reply->reply = Yii::$app->request->post('reply');
            if($reply->save()){
                return $this->redirect(Yii::$app->request->referrer);
            }
            echo "string";
        } else {
            echo "请先登录";
        }
    }
}
