<?php

use yii\db\Migration;

class m170717_012645_auth extends Migration
{
//    public function safeUp()
//    {
//
//    }
//
//    public function safeDown()
//    {
//        echo "m170717_012645_auth cannot be reverted.\n";
//
//        return false;
//    }

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('auth', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);
        $this->addForeignKey('fk-auth-user_id-user-id', 'auth', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('auth');
    }
    
}
