<?php

use yii\db\Schema;
use yii\db\Migration;

class m151228_170052_add_test_description extends Migration
{
    public function up()
    {
        $this->addColumn('tests', 'description', 'text');
    }

    public function down()
    {
        echo "m151228_170052_add_test_description cannot be reverted.\n";

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
