<?php

use yii\db\Schema;
use yii\db\Migration;
use yii\db\Expression;

class m151106_095300_create_news extends Migration
{
//    public function up()
//    {
//    }
//
//    public function down()
//    {
//        echo "m151106_095300_create_news cannot be reverted.\n";
//
//        return false;
//    }


    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%news}}', [
            'id' => Schema::TYPE_PK,
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'filename' => Schema::TYPE_STRING,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'announce' => Schema::TYPE_TEXT,
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
        ], $tableOptions);
        $this->insert('page', [
            'language_id' => 1,
            'name' => 'Новости',
            'alias' => 'news',
            'meta_title' => 'Новости',
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()'),
            'active' => 1
        ]);
        $this->insert('page', [
            'language_id' => 2,
            'name' => 'News',
            'alias' => 'news',
            'meta_title' => 'News',
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()'),
            'active' => 1
        ]);
    }

    public function safeDown()
    {
    }

}
