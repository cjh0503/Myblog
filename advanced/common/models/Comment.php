<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $user_id
 * @property string $comment
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    public function rules()
    {
        return [
            [['post_id', 'user_id'], 'required'],
            [['post_id', 'user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'comment' => 'Comment',
            'status' => 'Status',
            'created_at' => 'Create At',
            'updated_at' => 'Update At',
        ];
    }
    
    public static function findcomment($id){
        return self::find()
                ->where(['post_id' => $id, 'status' => 1])
                ->orderBy(['created_at' => SORT_DESC])
                ->all();
    }
}
