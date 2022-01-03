<?php

use yii\db\Migration;

class m170628_081947_add_filed_in_feedback extends Migration
{
/*
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170628_081947_add_filed_in_feedback cannot be reverted.\n";

        return false;
    }
*/

    public function safeUp()
    {
		$this->addColumn('feedback', 'roistat', $this->string(250));
		$this->addColumn('feedback', 'google', $this->string(250));
	    
    }

    public function safeDown()
    {
		$this->dropColumn('feedback', 'roistat');
		$this->dropColumn('feedback', 'google');
		
    }
}
