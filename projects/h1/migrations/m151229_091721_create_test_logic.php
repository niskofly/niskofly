<?php

use yii\db\Schema;
use yii\db\Migration;

class m151229_091721_create_test_logic extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%test_logic}}', [
            'id' => Schema::TYPE_PK,
            'test_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'ordering' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 10',
            'ordering' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 10',
            'points_min' => Schema::TYPE_INTEGER,
            'points_max' => Schema::TYPE_INTEGER,
            'result' => Schema::TYPE_TEXT
        ], $tableOptions);
    }

    public function down()
    {
        echo "m151229_091721_create_test_logic cannot be reverted.\n";

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
