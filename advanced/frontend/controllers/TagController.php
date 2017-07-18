<?php

namespace frontend\controllers;

use common\models\Tag;

class TagController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $tag = new Tag();
        $tags = $tag->getAllTag();
        $num = $tag->getPostsNum();
        return $this->render('index',[
            'tags' => $tags,
            'num' => $num,
        ]);
    }

}
