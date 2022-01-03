<?php

use yii\db\Migration;

/**
 * Class m200601_053727_update_pages
 */
class m200601_053727_update_pages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('page', 'sort',$this->integer()->defaultValue(100)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('page', 'sort');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200601_053727_update_pages cannot be reverted.\n";

        return false;
    }
    */
}
