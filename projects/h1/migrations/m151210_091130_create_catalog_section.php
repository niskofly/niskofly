<?php

use yii\db\Schema;
use yii\db\Migration;

class m151210_091130_create_catalog_section extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%catalog_section}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'title_ru' => Schema::TYPE_STRING . ' NULL',
            'title_en' => Schema::TYPE_STRING . ' NULL',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m151210_091130_create_catalog_section cannot be reverted.\n";

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
