<?php

use yii\db\Migration;

class m170825_073152_add_fields_to_order extends Migration
{
/*
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170825_073152_add_fields_to_order cannot be reverted.\n";

        return false;
    }
*/

        // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        		$this->addColumn('orders', 'phone', $this->string(250));
        		$this->addColumn('orders', 'email', $this->string(250));
        		$this->addColumn('orders', 'course', $this->string(250));
        		$this->addColumn('orders', 'firstname', $this->string(250));
        		$this->addColumn('orders', 'lastname', $this->string(250));
        		$this->addColumn('orders', 'url', $this->string(20)->notNull());
        		$this->addColumn('orders', 'id_schedule', $this->integer());
        		$this->addColumn('orders', 'status', $this->string(100));
                $this->addColumn('orders', 'date_status',$this->timestamp());
                $this->addColumn('orders', 'user_id',$this->integer()->notNull());  
                $this->createIndex('orderUrl','orders','url',true);      		
                return true;
    
    }

    public function down()
    {
        $this->dropIndex('orderUrl','orders');      		
		$this->dropColumn('orders', 'phone');
		$this->dropColumn('orders', 'email');
		$this->dropColumn('orders', 'course');
		$this->dropColumn('orders', 'firstname');
		$this->dropColumn('orders', 'lastname');
		$this->dropColumn('orders', 'url');
		$this->dropColumn('orders', 'id_schedule');
		$this->dropColumn('orders', 'status');
		$this->dropColumn('orders', 'date_status');
		$this->dropColumn('orders', 'user_id');
        return true;
    }
   
}
