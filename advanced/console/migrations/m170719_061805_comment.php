<?php

use yii\db\Migration;

class m170719_061805_comment extends Migration
{
//    public function safeUp()
//    {
//
//    }
//
//    public function safeDown()
//    {
//        echo "m170719_061805_comment cannot be reverted.\n";
//
//        return false;
//    }

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'comment' => $this->string(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'create_at' => $this->integer()->notNull(),
            'update_at' => $this->integer()->notNull(),
        ],$tableOptions);
    }

    public function down()
    {
        echo "m170719_061805_comment cannot be reverted.\n";

        return false;
    }
    
}
