<?php

use yii\db\Schema;
use yii\db\Migration;

class m151229_142610_create_test_results extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%test_results}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'result' => Schema::TYPE_STRING . ' NOT NULL',
            'date' => Schema::TYPE_DATE . ' NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m151229_142610_create_test_results cannot be reverted.\n";

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
