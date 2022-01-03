<?php

use yii\db\Schema;
use yii\db\Migration;

class m160107_141501_add_languages_to_test_logic extends Migration
{
    public function up()
    {
        $this->addColumn('test_logic', 'result_ru', 'text');
        $this->addColumn('test_logic', 'result_en', 'text');
    }

    public function down()
    {
        echo "m160107_141501_add_languages_to_test_result cannot be reverted.\n";

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
