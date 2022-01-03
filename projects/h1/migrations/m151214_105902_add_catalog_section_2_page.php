<?php

use yii\db\Schema;
use yii\db\Migration;

class m151214_105902_add_catalog_section_2_page extends Migration
{
    public function up()
    {
        $this->addColumn('page', 'catalog_section_id', 'integer');
        $this->addColumn('page', 'after_content', 'text');
    }

    public function down()
    {
        echo "m151214_105902_add_catalog_section_2_page cannot be reverted.\n";

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
