<?php

use yii\db\Schema;
use yii\db\Migration;

class m151002_051735_add_column_sff extends Migration
{
    public function up()
    {
        $this->addColumn('page', 'show_feedback_form', 'boolean');
    }

    public function down()
    {
        echo "m151002_051735_add_column_sff cannot be reverted.\n";

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
