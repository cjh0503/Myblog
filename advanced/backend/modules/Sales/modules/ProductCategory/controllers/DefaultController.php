<?php

namespace backend\modules\sales\modules\ProductCategory\controllers;

use yii\web\Controller;

/**
 * Default controller for the `ProductCategory` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
