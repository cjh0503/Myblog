<?php

namespace frontend\controllers;

use common\models\Posts;
use common\models\User;

class KjController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new User();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
