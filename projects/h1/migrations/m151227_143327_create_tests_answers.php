<?php

use yii\db\Schema;
use yii\db\Migration;

class m151227_143327_create_tests_answers extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%tests_answers}}', [
            'id' => Schema::TYPE_PK,
            'testquestion_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'points' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'active' => Schema::TYPE_BOOLEAN . ' DEFAULT 1',
            'ordering' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 10',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m151227_143327_create_tests_answers cannot be reverted.\n";

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
