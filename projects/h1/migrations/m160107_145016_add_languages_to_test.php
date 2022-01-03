<?php

use yii\db\Schema;
use yii\db\Migration;

class m160107_145016_add_languages_to_test extends Migration
{
    public function up()
    {
        $this->addColumn('tests', 'description_ru', 'text');
        $this->addColumn('tests', 'description_en', 'text');
    }

    public function down()
    {
        echo "m160107_145016_add_languages_to_test cannot be reverted.\n";

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
