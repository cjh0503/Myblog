<?php

namespace backend\models;

use Yii;
use backend\models\AuthItem;
use yii\rbac\Item;

class PermissionForm extends AuthItem
{
    public function init() {
        parent::init();
        $this->type = Item::TYPE_PERMISSION;
    }
}