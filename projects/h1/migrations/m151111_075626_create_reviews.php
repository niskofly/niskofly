<?php

use yii\db\Schema;
use yii\db\Migration;

class m151111_075626_create_reviews extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%reviews}}', [
            'id' => Schema::TYPE_PK,
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'rating' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 5',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m151111_075626_create_reviews cannot be reverted.\n";

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
