<?php

namespace backend\models;

use Yii;
use backend\models\AuthItem;
use yii\rbac\Item;

class RoleForm extends AuthItem
{
    public function init() {
        parent::init();
        $this->type = Item::TYPE_ROLE;
    }
}
