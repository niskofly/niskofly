<?php

use yii\db\Schema;
use yii\db\Migration;

class m170322_210819_add_new_field_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'phone', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m170322_210819_add_new_field_to_user cannot be reverted.\n";

        $this->dropColumn('{{%user}}', 'phone');

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
