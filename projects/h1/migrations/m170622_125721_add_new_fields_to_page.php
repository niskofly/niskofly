<?php

use yii\db\Schema;
use yii\db\Migration;

class m170622_125721_add_new_fields_to_page extends Migration
{
/*
    public function up()
    {
		


    }

    public function down()
    {
        echo "m170622_125721_add_new_fields_to_page cannot be reverted.\n";

        return false;
    }
*/

    public function safeUp()
    {
		$this->addColumn('page', 'block2_1_head', $this->string(250));
		$this->addColumn('page', 'block2_1_desc', $this->text());
		$this->addColumn('page', 'block2_2_head', $this->string(250));
		$this->addColumn('page', 'block2_2_desc', $this->text());
		$this->addColumn('page', 'block2_3_head', $this->string(250));
		$this->addColumn('page', 'block2_3_desc', $this->text());
		$this->addColumn('page', 'block3_head', $this->string(250));
		$this->addColumn('page', 'block4_1_head', $this->string(250));
		$this->addColumn('page', 'block4_1_desc', $this->text());
		$this->addColumn('page', 'block4_2_head', $this->string(250));
		$this->addColumn('page', 'block4_2_desc', $this->text());
		$this->addColumn('page', 'hrefs', $this->text());
	    
    }

    public function safeDown()
    {
		$this->dropColumn('page', 'block2_1_head');
		$this->dropColumn('page', 'block2_1_desc');
		$this->dropColumn('page', 'block2_2_head');
		$this->dropColumn('page', 'block2_2_desc');
		$this->dropColumn('page', 'block2_3_head');
		$this->dropColumn('page', 'block2_3_desc');
		$this->dropColumn('page', 'block3_head');
		$this->dropColumn('page', 'block4_1_head');
		$this->dropColumn('page', 'block4_1_desc');
		$this->dropColumn('page', 'block4_2_head');
		$this->dropColumn('page', 'block4_2_desc');
		$this->dropColumn('page', 'hrefs');
		
    }
    
}
