<?php

use yii\db\Migration;

/**
 * Class m200601_072011_pages_reviews
 */
class m200601_072011_pages_reviews extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page_reviews}}', [
            'review_id' => $this->integer(),
            'page_id' => $this->integer(),
            'PRIMARY KEY(review_id, page_id)',
        ]);

        // creates index for column `review_id`
        $this->createIndex(
            '{{%idx-page_reviews-review_id}}',
            '{{%page_reviews}}',
            'review_id'
        );

        // add foreign key for table `{{%reviews}}`
        $this->addForeignKey(
            '{{%fk-page_reviews-review_id}}',
            '{{%page_reviews}}',
            'review_id',
            '{{%reviews}}',
            'id',
            'CASCADE'
        );

        // creates index for column `page_id`
        $this->createIndex(
            '{{%idx-page_reviews-page_id}}',
            '{{%page_reviews}}',
            'page_id'
        );

        // add foreign key for table `{{%page}}`
        $this->addForeignKey(
            '{{%fk-page_reviews-page_id}}',
            '{{%page_reviews}}',
            'page_id',
            '{{%page}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%reviews}}`
        $this->dropForeignKey(
            '{{%fk-page_reviews-review_id}}',
            '{{%page_reviews}}'
        );

        // drops foreign key for table `{{%page}}`
        $this->dropForeignKey(
            '{{%fk-page_reviews-page_id}}',
            '{{%page_reviews}}'
        );

        // drops index for column `page_id`
        $this->dropIndex(
            '{{%idx-page_reviews-page_id}}',
            '{{%page_reviews}}'
        );

        // drops index for column `review_id`
        $this->dropIndex(
            '{{%idx-page_reviews-review_id}}',
            '{{%page_reviews}}'
        );

        $this->dropTable('{{%page_reviews}}');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200601_072011_pages_reviews cannot be reverted.\n";

        return false;
    }
    */
}
