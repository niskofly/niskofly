<?php

use yii\db\Schema;
use yii\db\Migration;

class m151123_133217_news_add_languages extends Migration
{
    public function up()
    {
        $this->addColumn('news', 'name_ru', 'string');
        $this->addColumn('news', 'name_en', 'string');
        $this->addColumn('news', 'announce_ru', 'string');
        $this->addColumn('news', 'announce_en', 'string');
        $this->addColumn('news', 'text_ru', 'string');
        $this->addColumn('news', 'text_en', 'string');
    }

    public function down()
    {
        echo "m151123_133217_news_add_languages cannot be reverted.\n";

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
