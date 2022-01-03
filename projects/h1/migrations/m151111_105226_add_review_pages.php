<?php

use yii\db\Migration;
use yii\db\Expression;

class m151111_105226_add_review_pages extends Migration
{
    public function up()
    {
        $this->insert('page', [
            'language_id' => 1,
            'name' => 'Отзывы',
            'alias' => 'reviews',
            'meta_title' => 'Отзывы',
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()'),
            'active' => 1
        ]);
        $this->insert('page', [
            'language_id' => 2,
            'name' => 'Reviews',
            'alias' => 'reviews',
            'meta_title' => 'Reviews',
            'created_at' => new Expression('NOW()'),
            'updated_at' => new Expression('NOW()'),
            'active' => 1
        ]);
    }

    public function down()
    {
        echo "m151111_105226_add_review_pages cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
