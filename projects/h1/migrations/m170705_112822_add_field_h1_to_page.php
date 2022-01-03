<?php

use yii\db\Migration;

class m170705_112822_add_field_h1_to_page extends Migration
{
/*
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170705_112822_add_field_h1_to_page cannot be reverted.\n";

        return false;
    }
*/

    public function safeUp()
    {
		$this->addColumn('page', 'h1', $this->text());
	    
    }

    public function safeDown()
    {
		$this->dropColumn('page', 'h1');
		
    }
}
