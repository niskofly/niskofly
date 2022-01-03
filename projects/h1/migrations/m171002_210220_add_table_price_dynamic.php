<?php

use yii\db\Migration;

class m171002_210220_add_table_price_dynamic extends Migration
{
/*
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m171002_210220_add_table_price_dynamic cannot be reverted.\n";

        return false;
    }
*/

        // Use up()/down() to run migration code without a transaction.
    public function up()
    {
	    	$result=false;

	        $this->createTable('dynamicPrice', 
	        [
                'id' => $this->primaryKey(),
                'daysBefore' => $this->integer()->notNull(),
                'discount' => $this->integer()->notNull(),
                'active' =>$this->integer()->notNull(),
            ]);
        
            $this->addColumn('sched', 'dynamicPrice',$this->integer()->notNull()); 
            $result = true;
            return $result;
    }

    public function down()
    {
            $this->dropColumn('sched', 'dynamicPrice');
            $this->dropTable('dynamicPrice');
            return true;
    }
   
}
