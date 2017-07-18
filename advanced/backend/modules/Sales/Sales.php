<?php

namespace backend\modules\sales;

/**
 * sales module definition class
 */
class Sales extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\sales\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->modules = [
            'Product' => [
                'class' => 'backend\modules\sales\modules\Product\Product',
            ],
            'ProductCategory' => [
                'class' => 'backend\modules\sales\modules\ProductCategory\ProductCategory',
            ],
        ];
    }
}
