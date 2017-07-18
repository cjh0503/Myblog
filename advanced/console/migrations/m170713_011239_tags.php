<?php

use yii\db\Migration;

class m170713_011239_tags extends Migration
{
//    public function safeUp()
//    {
//
//    }
//
//    public function safeDown()
//    {
//        echo "m170713_011239_tags cannot be reverted.\n";
//
//        return false;
//    }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%tags}}', [
            'id' => $this->primaryKey(),
            'tag' => $this->string()->notNull(),
            'tag_img' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m170713_011239_tags cannot be reverted.\n";

        return false;
    }
}
