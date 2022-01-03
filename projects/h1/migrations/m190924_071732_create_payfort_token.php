<?php

use yii\db\Migration;

/**
 * Class m190924_071732_create_payfort_token
 */
class m190924_071732_create_payfort_token extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%payfort_token}}', [
            'user_id' => $this->integer()->notNull(),
            'code' => $this->string(32)->notNull(),
            'id_order' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull()
        ]);

        $this->createIndex('{{%payfort_token_unique}}', '{{%payfort_token}}', ['user_id', 'code'], true);
        $this->addForeignKey('{{%fk_user_payfort_token}}', '{{%payfort_token}}', 'user_id', '{{%user}}', 'id',  'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk_id_order}}', '{{%payfort_token}}', 'id_order', '{{%orders}}', 'id');
    }

    public function down()
    {
        $this->dropTable('{{%payfort_token}}');
    }

}
