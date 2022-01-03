<?php

use yii\db\Schema;
use yii\db\Migration;

class m151210_110607_create_catalog_service extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%catalog_service}}', [
            'id' => Schema::TYPE_PK,
            'name_ru' => Schema::TYPE_STRING . ' NOT NULL',
            'name_en' => Schema::TYPE_STRING . ' NOT NULL',
            'price' => Schema::TYPE_FLOAT . ' NOT NULL',
            'section' => Schema::TYPE_INTEGER . ' NULL',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m151210_110607_create_catalog_service cannot be reverted.\n";

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
