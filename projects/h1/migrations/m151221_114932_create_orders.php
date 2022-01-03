<?php

use yii\db\Schema;
use yii\db\Migration;

class m151221_114932_create_orders extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%orders}}', [
            'id' => Schema::TYPE_PK,
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'details' => Schema::TYPE_TEXT,
            'price' => Schema::TYPE_INTEGER . ' NOT NULL',
            'paid' => Schema::TYPE_BOOLEAN,
        ], $tableOptions);
    }

    public function down()
    {
        echo "m151221_114932_create_orders cannot be reverted.\n";

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
