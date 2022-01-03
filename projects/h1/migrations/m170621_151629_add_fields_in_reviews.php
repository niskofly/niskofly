<?php

use yii\db\Schema;
use yii\db\Migration;

class m170621_151629_add_fields_in_reviews extends Migration
{
/*
    public function up()
    {
		$this->addColumn('reviews', 'language_id', $this->integer());
		$this->addColumn('reviews', 'page_id', $this->integer());
		

    }

    public function down()
    {
		$this->dropColumn('reviews', 'language_id');
		$this->dropColumn('reviews', 'page_id');
        return true;
    }
*/

        // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
		$this->addColumn('reviews', 'language_id', $this->integer()->notNull()->defaultValue(2));
		$this->addColumn('reviews', 'page_id', $this->integer());
	    
    }

    public function safeDown()
    {
		$this->dropColumn('reviews', 'language_id');
		$this->dropColumn('reviews', 'page_id');
    }
   
}
