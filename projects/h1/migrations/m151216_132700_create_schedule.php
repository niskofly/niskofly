<?php

use yii\db\Schema;
use yii\db\Migration;

class m151216_132700_create_schedule extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%schedule}}', [
            'id' => Schema::TYPE_PK,
            'section_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'service_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'start_date_from' => Schema::TYPE_DATE . ' NOT NULL',
            'start_date_to' => Schema::TYPE_DATE . ' NOT NULL',
            'schedule_ru' => Schema::TYPE_TEXT,
            'schedule_en' => Schema::TYPE_TEXT,
            'price' => Schema::TYPE_FLOAT . ' NOT NULL',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m151216_132700_create_schedule cannot be reverted.\n";

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
