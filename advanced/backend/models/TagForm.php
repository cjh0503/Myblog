<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\Url;

class TagForm extends Model
{
    public $tag_img;
    
    public function rules() {
        return [
            [['tag_img'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload() {
        if ($this->validate()) {
            $uploadPath = 'uploads/' . md5(microtime()) . '.' . $this->tag_img->extension;
            $this->tag_img->saveAs($uploadPath);
            return Url::to('Myblog/advanced/backend/web/' . $uploadPath, true);
        } else {
            return false;
        }
    }
}
