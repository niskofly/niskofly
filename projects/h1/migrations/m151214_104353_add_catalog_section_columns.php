<?php

use yii\db\Schema;
use yii\db\Migration;

class m151214_104353_add_catalog_section_columns extends Migration
{
    public function up()
    {
        $this->addColumn('catalog_section', 'title_price_ru', 'string');
        $this->addColumn('catalog_section', 'title_price_en', 'string');
    }

    public function down()
    {
        echo "m151214_104353_add_catalog_section_columns cannot be reverted.\n";

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
