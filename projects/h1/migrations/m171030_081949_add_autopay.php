<?php

use yii\db\Migration;

class m171030_081949_add_autopay extends Migration
{
    public function safeUp()
    {
        $result=false;

        $this->createTable('autopay', 
	       [
    	       'id' => $this->primaryKey(),
    	       'date' => $this->datetime(),
    	       'firstname' => $this->string(250),
    	       'lastname' => $this->string(250),
    	       'phone' => $this->string(250),
    	       'email' => $this->string(250),
    	       'course' => $this->string(250),
    	       'details' => $this->text(),
    	       'user_id' => $this->integer()->notNull()
    	   ]
        );

        $this->createTable('autopay_details', 
	       [
    	       'id' => $this->primaryKey(),
    	       'autopay_id' => $this->integer(),
    	       'pay_date' => $this->date()->notNull(),
    	       'pay_sum' => $this->integer()->notNull(),
    	       'order_id' => $this->integer()
    	   ]
        );

        $this->createIndex('order_id','autopay_details','order_id');
        $this->createIndex('autopay_id','autopay_details','autopay_id');
        $this->addForeignKey('autopay_id_fk','autopay_details','autopay_id','autopay','id','CASCADE','CASCADE');
        $this->addForeignKey('order_id_fk','autopay_details','order_id','orders','id','CASCADE','CASCADE');

        $result = true;
        
        return $result;

    }

    public function safeDown()
    {
        $result=false;
        
        $this->dropForeignKey('autopay_id_fk','autopay_details');
        $this->dropForeignKey('order_id_fk','autopay_details');
        $this->dropTable('autopay_details');
        $this->dropTable('autopay');
        $result = true;
        return $result;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171030_081949_add_autopay cannot be reverted.\n";

        return false;
    }
    */
}
