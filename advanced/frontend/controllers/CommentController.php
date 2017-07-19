<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Comment;

class CommentController extends Controller
{
    public function actionAdd($id)
    {
        if(Yii::$app->user->isGuest){
            $comment = new Comment();
            $comment->user_id = Yii::$app->user->identity->id;
            $comment->post_id = $id;
            $comment->comment = Yii::$app->request->post('comment');
            if($comment->save()){
                return $this->redirect(Yii::$app->request->referrer);
            }
            echo "string";
        }
    }
}

