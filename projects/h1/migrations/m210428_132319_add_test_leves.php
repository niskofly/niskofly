<?php

use yii\db\Migration;

/**
 * Class m210428_132319_add_test_leves
 */
class m210428_132319_add_test_leves extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('test_level_name', 'test_id',$this->integer()->notNull());
        $this->addColumn('test_level_name', 'name_tech',$this->string(255)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('test_level_name', 'test_id');
        $this->dropColumn('test_level_name', 'name_tech');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210428_132319_add_test_leves cannot be reverted.\n";

        return false;
    }
    */
}
