<?php

use yii\db\Schema;
use yii\db\Migration;

class m151123_140448_news_null extends Migration
{
    public function up()
    {
        $this->alterColumn("news", "name", "varchar(255) null");
        $this->alterColumn("news", "announce", "text null");
        $this->alterColumn("news", "text", "text null");
    }

    public function down()
    {
        echo "m151123_140448_news_null cannot be reverted.\n";

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
