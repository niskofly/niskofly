<?php

use yii\db\Schema;
use yii\db\Migration;

class m151222_112832_order_add_details_fields extends Migration
{
    public function up()
    {
        $this->addColumn('orders', 'level', 'string');
        $this->addColumn('orders', 'start_date', 'string');
        $this->addColumn('orders', 'schedule', 'string');
    }

    public function down()
    {
        echo "m151222_112832_order_add_details_fields cannot be reverted.\n";

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
