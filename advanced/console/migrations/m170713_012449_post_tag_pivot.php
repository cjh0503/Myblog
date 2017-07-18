<?php

use yii\db\Migration;

class m170713_012449_post_tag_pivot extends Migration
{
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170713_012449_post_tag_pivot cannot be reverted.\n";

        return false;
    }

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%post_tag_pivot}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m170713_012449_post_tag_pivot cannot be reverted.\n";

        return false;
    }
    
}
