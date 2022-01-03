<?php

use yii\db\Schema;
use yii\db\Migration;

class m151118_120457_add_image_to_main_page extends Migration
{
    public function up()
    {
        $this->addColumn('page', 'image_url', 'string');

    }

    public function down()
    {
        echo "m151118_120457_add_image_to_main_page cannot be reverted.\n";

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
