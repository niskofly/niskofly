<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%holyhope}}`.
 */
class m211004_110221_create_holyhope_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page_holyhope}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer()->notNull(),
            'holyhope_id' => $this->integer()->notNull(),
            'holyhope_name' => $this->string()->null(),
        ]);

       /* // creates index for column `page_id`
        $this->createIndex(
            '{{%idx-page_holyhope-page_id}}',
            '{{%page_holyhope}}',
            'page_id'
        );*/

       /* // add foreign key for table `{{%page}}`
        $this->addForeignKey(
            '{{%fk-page_holyhope-page_id}}',
            '{{%page_holyhope}}',
            'page_id',
            '{{%page}}',
            'id',
            'CASCADE'
        );*/
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /*$this->dropForeignKey(
            '{{%fk-page_holyhope-page_id}}',
            '{{%page_holyhope}}'
        );
        $this->dropIndex(
            '{{%idx-page_holyhope-page_id}}',
            '{{%page_holyhope}}'
        );*/
        $this->dropTable('{{%page_holyhope}}');
    }
}
