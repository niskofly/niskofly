<?php

use yii\db\Schema;
use yii\db\Migration;

class m151227_131621_create_tests_questions extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%tests_questions}}', [
            'id' => Schema::TYPE_PK,
            'test_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'active' => Schema::TYPE_BOOLEAN ,
            'ordering' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 10',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m151227_131621_create_tests_questions cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
