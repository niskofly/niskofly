<?php

use yii\db\Schema;
use yii\db\Migration;

class m151224_220611_change_order_date_type extends Migration
{
    public function up()
    {
        $this->alterColumn("orders", "date", Schema::TYPE_DATETIME);
    }

    public function down()
    {
        echo "m151224_220611_change_order_date_type cannot be reverted.\n";

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
