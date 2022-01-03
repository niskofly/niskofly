<?php

use yii\db\Migration;

/**
 * Class m200513_111816_landing_slider
 */
class m200513_111816_landing_slider extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%landing_slider}}', [
            'id' => $this->primaryKey(),
            'img' => $this->string(255)->notNull(),
            'href' => $this->string(255)->notNull(),
            'sort' => $this->integer()->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%landing_slider}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200513_111816_landing_slider cannot be reverted.\n";

        return false;
    }
    */
}
