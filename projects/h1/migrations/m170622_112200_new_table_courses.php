<?php

use yii\db\Schema;
use yii\db\Migration;

class m170622_112200_new_table_courses extends Migration
{
/*
    public function up()
    {

    }

    public function down()
    {
        echo "m170622_112200_new_table_courses cannot be reverted.\n";

        return false;
    }
*/

        // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
	    	$result=false;

	        $this->createTable('courses', [
            'id' => $this->primaryKey(),
            'name' => $this->string(254)->notNull(),
            'id_page' => $this->integer(),
            'week'=>$this->integer(),
            'academic_hour'=>$this->integer(),
            'language_id'=>$this->integer()->notNull(),
            'data'=>$this->timestamp(),
            'user_id'=>$this->integer()->notNull(),
        ]);

	        $this->addForeignKey('language_fk','courses','language_id','language','id');
	        $this->addForeignKey('page_fk','courses','id_page','page','id');

	        $this->createTable('courses_group', [
            'id' => $this->primaryKey(),
            'name' => $this->string(254)->notNull(),
            'desc_name' => $this->string(254),
            'id_courses' => $this->integer(),
            'price_hour'=>$this->money(12,2),
            'desc_price_hour' => $this->string(254),
            'price_all'=>$this->money(12,2),
            'desc_price_all' => $this->string(254),
            'data'=>$this->timestamp(),
            'user_id'=>$this->integer()->notNull(),
        ]);
	        $this->addForeignKey('courses_fk','courses_group','id_courses','courses','id');
	    		
		$this->createTable('sched', [
            'id' => $this->primaryKey(),
            'schedule' => $this->string(254)->notNull(),
            'id_courses_group' => $this->integer()->notNull(),
            'start_date'=>$this->date(),
            'archive'=>$this->integer()->notNull()->defaultValue(7),
            'price_discount'=>$this->money(12,2)->notNull()->defaultValue(0),
            'public'=>$this->integer()->notNull()->defaultValue(0),
            'data'=>$this->timestamp(),
            'user_id'=>$this->integer()->notNull(),
        ]);
	        $this->addForeignKey('courses_group_fk','sched','id_courses_group','courses_group','id');
	        $result=true;
	        return $result;
	    		
    }

    public function safeDown()
    {
	      $this->dropTable('courses');
	      $this->dropTable('courses_group');
	      $this->dropTable('sched');
    }
   
}
