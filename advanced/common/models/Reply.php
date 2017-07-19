<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "reply".
 *
 * @property integer $id
 * @property integer $comment_id
 * @property integer $user_id
 * @property string $reply
 * @property integer $status
 * @property integer $create_at
 * @property integer $update_at
 */
class Reply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reply';
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
            [['comment_id', 'user_id', 'create_at', 'update_at'], 'required'],
            [['comment_id', 'user_id', 'status', 'create_at', 'update_at'], 'integer'],
            [['reply'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment_id' => 'Comment ID',
            'user_id' => 'User ID',
            'reply' => 'Reply',
            'status' => 'Status',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
    
    public static function findreply (){
        
    }
}
