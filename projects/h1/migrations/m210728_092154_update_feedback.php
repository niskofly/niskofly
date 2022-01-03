<?php

use yii\db\Migration;

/**
 * Class m210728_092154_update_feedback
 */
class m210728_092154_update_feedback extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('feedback', 'promocode',$this->string('255')->null()->defaultValue('---'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('feedback', 'promocode');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210728_092154_update_feedback cannot be reverted.\n";

        return false;
    }
    */
}
