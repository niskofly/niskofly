<?php

use yii\db\Migration;

/**
 * Class m210713_101548_change_user_table
 */
class m210713_101548_change_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'username', $this->string(255)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('user', 'username', $this->string(25)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210713_101548_change_user_table cannot be reverted.\n";

        return false;
    }
    */
}
