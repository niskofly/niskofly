<?php

use yii\db\Schema;
use yii\db\Migration;

class m151123_141308_news_field_types extends Migration
{
    public function up()
    {
        $this->alterColumn("news", "announce_ru", "text null");
        $this->alterColumn("news", "announce_en", "text null");
        $this->alterColumn("news", "text_ru", "text null");
        $this->alterColumn("news", "text_en", "text null");
    }

    public function down()
    {
        echo "m151123_141308_news_field_types cannot be reverted.\n";

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
