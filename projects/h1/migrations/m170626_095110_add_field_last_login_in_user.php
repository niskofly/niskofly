<?php

use yii\db\Migration;

class m170626_095110_add_field_last_login_in_user extends Migration
{
/*
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170626_095110_add_field_last_login_in_user cannot be reverted.\n";

        return false;
    }
*/

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
	    $result=false;
	    $this->addColumn('user', 'last_login_at', $this->integer());
		$result=true;
        return $result;

    }

    public function down()
    {
	    $result=false;
		$this->dropColumn('user', 'last_login_at');
		$result=true;
        return $result;
    }
}
