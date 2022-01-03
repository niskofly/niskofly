<?php

use yii\db\Schema;
use yii\db\Migration;

class m170130_150520_alterTableTest extends Migration
{
    public function up()
    {
        //Удаляем не нужное поле
        $this->execute('ALTER TABLE `tests` DROP COLUMN `description_ru`, DROP COLUMN `description_en`;');

        $this->execute('ALTER TABLE `test_logic` DROP COLUMN `result_ru`, DROP COLUMN `result_en`;');


        $this->execute('
            CREATE TABLE `test_level_name` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `language_id` int(11) DEFAULT NULL,
              `name` varchar(256) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
        ');


        $this->execute('
            INSERT INTO `test_level_name` VALUES
            (\'1\', \'2\', \'Elementary\'),
            (\'2\', \'2\', \'Pre-intermediate\'),
            (\'3\', \'2\', \'Intermediate\'),
            (\'4\', \'2\', \'Upper-intermediate\'),
            (\'5\', \'2\', \'Advanced\'),
            (\'6\', \'1\', \'Элементарный\'),
            (\'7\', \'1\', \'Ниже среднего\'),
            (\'8\', \'1\', \'Промежуточный\'),
            (\'9\', \'1\', \'Выше среднего\'),
            (\'10\', \'1\', \'Продвинутый\');
        ');

        $this->execute('
             CREATE TABLE `test_level` (
               `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
               `test_id` int(11) DEFAULT NULL,
               `level_name_id` int(5) DEFAULT NULL,
               `points_minimum` int(5) DEFAULT NULL,
               `points_maximum` int(5) DEFAULT NULL,
               PRIMARY KEY (`id`)
             ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
        ');

        $this->execute('
          ALTER TABLE `test_results`
          ADD COLUMN `test_id` int(11) AFTER `result`,
          ADD COLUMN `level_name_id` int(11) AFTER `test_id`,
          ADD COLUMN `points` int(5) AFTER `level_name_id`;
        ');


    }

    public function down()
    {
        echo "m170130_150520_alterTableTest cannot be reverted.\n";

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
