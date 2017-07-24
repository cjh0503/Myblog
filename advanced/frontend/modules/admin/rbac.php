<?php

namespace frontend\modules\admin;

/**
 * Rbac module definition class
 */
use yii\rbac\DbManager;

class rbac extends DbManager
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\Rbac\controllers';
    
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }

    public function createItem($item){
        if(empty($item->name) || $this->getOneItem($item->name) !== null){
            return false;
        }
        return $this->addItem($item) ? true : false;
    }
    
    public function getOneItem($name){
        return $this->getItem($name);
    }
    
    public function updateOneItem($name, $item){
        return $this->updateItem($name, $item);
    }
    
    public function deleteOneItem($name){
        if($item = $this->getOneItem($name)){
            return $this->removeItem($item);
        }else{
            return false;
        }
    }
}
