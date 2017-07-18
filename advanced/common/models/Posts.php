<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $author
 * @property string $content
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Posts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const STATUS_ACTIVE = 1;
    public static function tableName()
    {
        return 'posts';
    }
    public function behaviors() 
    {
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
            [['title', 'author'], 'required'],
            [['content'], 'string'],
            [['status'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['title', 'author'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => \Yii::t('app', '标题'),
            'author' => '作者',
            'content' => '内容',
            'status' => 'Status',
            'created_at' => '创建时间',
            'updated_at' => \Yii::t('app', 'Updated At'),
        ];
    }
    
    public function getTag(){
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
                ->viaTable('post_tag_pivot', ['post_id' => 'id']);
    }
    
    public function getCheckTag ($id,$atrr) {
        $checktag = [];
        $selftag = self::findOne($id)->getTag()->all();
        foreach ($selftag as $selftag) {
            $checktag[] = $selftag[$atrr];
        }
        return $checktag;
    }
}
