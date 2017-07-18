<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $tag
 * @property string $tag_img
 * @property integer $created_at
 * @property integer $updated_at
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['tag', 'tag_img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag' => 'Tag',
            'tag_img' => 'Tag Img',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function getAllTag() {
        $tags = self::find()->all();
        return $tags;
    }
    
    public function getPosts() {
        return $this->hasMany(Posts::className(), ['id' => 'post_id'])
                ->viaTable('post_tag_pivot', ['tag_id' => 'id']);
    }
    
    public function getPostsNum() {
        $tags = $this->getAllTag();
        $num = [];
        foreach ($tags as $key => $value) {
            $id = $value['id'];
            $total = count(self::findOne($id)->getPosts()->all());
            $num[$id] = $total;
        }
        return $num;
    }
    
}
