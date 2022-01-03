<?php

use yii\db\Schema;
use yii\db\Migration;

class m170131_070016_TestValue extends Migration
{
    public function up()
    {

        //Очистка тестов
        $this->execute('TRUNCATE `tests`;');

        //Очистка списка вопросов
        $this->execute('TRUNCATE `tests_questions`;');

        //Очистка списка ответов
        $this->execute('TRUNCATE `tests_answers`;');

        //Очистка логики ответов
        $this->execute('TRUNCATE `test_logic`;');

        //Очистка результатов теста
        $this->execute('TRUNCATE `test_results`;');


        //Список тестов
        $this->execute('
          INSERT INTO `tests` VALUES (\'1\', \'2\', \'Knowledge of English language\', \'1\', \'1\', \'\');
        ');

        //Список вопросов
        $this->execute('
          INSERT INTO `tests_questions` VALUES (\'1\', \'1\', \'My mother … a doctor.\', \'1\', \'1\'), (\'2\', \'1\', \'Angela is … Mexico. She speaks Spanish.\', \'1\', \'2\'), (\'3\', \'1\', \'Where … your wife from?\', \'1\', \'3\'), (\'4\', \'1\', \'There are … people outside.\', \'1\', \'4\'), (\'5\', \'1\', \'My brother … in a bank.\', \'1\', \'5\'), (\'6\', \'1\', \'I usually … at seven o’clock.\', \'1\', \'6\'), (\'7\', \'1\', \'They … to the teacher at the moment.\', \'1\', \'7\'), (\'8\', \'1\', \'Sarah … blonde hair but now she is quite dark.\', \'1\', \'8\'), (\'9\', \'1\', \'These cars … in Germany.\', \'1\', \'9\'), (\'10\', \'1\', \'What …when you opened the door?\', \'1\', \'10\'), (\'11\', \'1\', \'We stayed at my … place last summer.\', \'1\', \'11\'), (\'12\', \'1\', \'I don’t mind … tonight if you do the dishes.\', \'1\', \'12\'), (\'13\', \'1\', \'I … Miguel for years. He’s my neighbor.\', \'1\', \'13\'), (\'14\', \'1\', \'Sandra is going to the cinema tonight if she … her homework.\', \'1\', \'14\'), (\'15\', \'1\', \'Andy … his bike before he went on a cycling holiday.\', \'1\', \'15\'), (\'16\', \'1\', \'It’s easy to install … you follow the instructions carefully.\', \'1\', \'16\'), (\'17\', \'1\', \'People … next to the airport are fed up with the noise.\', \'1\', \'17\'), (\'18\', \'1\', \'I look forward to … from you soon.\', \'1\', \'18\'), (\'19\', \'1\', \'If you had come to the party, you … a great time.\', \'1\', \'19\'), (\'20\', \'1\', \'… mean he never bought anyone a present.\', \'1\', \'20\'), (\'21\', \'1\', \'I don’t know why she always arrives … .\', \'1\', \'21\'), (\'22\', \'1\', \'I’ve been … dedicated to my training programme.\', \'1\', \'22\'), (\'23\', \'1\', \'When they told me I had passed the test, I was over the\', \'1\', \'23\'), (\'24\', \'1\', \'… that this was her first attempt, I think that was a pretty decent performance.\', \'1\', \'24\'), (\'25\', \'1\', \'He appears … the truth.\', \'1\', \'25\');
        ');

        //Список ответов
        $this->execute('
          INSERT INTO `tests_answers` VALUES (\'1\', \'1\', \'Is\', \'1\', \'1\', \'1\'), (\'2\', \'1\', \'Am\', \'0\', \'1\', \'2\'), (\'3\', \'1\', \'Work\', \'0\', \'1\', \'3\'), (\'4\', \'1\', \'Works\', \'0\', \'1\', \'4\'), (\'5\', \'2\', \'In\', \'0\', \'1\', \'1\'), (\'6\', \'2\', \'From\', \'1\', \'1\', \'2\'), (\'7\', \'2\', \'Likes\', \'0\', \'1\', \'3\'), (\'8\', \'2\', \'Live\', \'0\', \'1\', \'4\'), (\'9\', \'3\', \'Is\', \'1\', \'1\', \'1\'), (\'10\', \'3\', \'Are\', \'0\', \'1\', \'2\'), (\'11\', \'3\', \'Does\', \'0\', \'1\', \'3\'), (\'12\', \'3\', \'Do\', \'0\', \'1\', \'4\'), (\'13\', \'4\', \'Much\', \'0\', \'1\', \'1\'), (\'14\', \'4\', \'Any\', \'0\', \'1\', \'2\'), (\'15\', \'4\', \'Some\', \'1\', \'1\', \'3\'), (\'16\', \'4\', \'A\', \'0\', \'1\', \'4\'), (\'17\', \'5\', \'Work\', \'0\', \'1\', \'1\'), (\'18\', \'5\', \'Is working\', \'0\', \'1\', \'2\'), (\'19\', \'5\', \'Manager\', \'0\', \'1\', \'3\'), (\'20\', \'5\', \'Works\', \'1\', \'1\', \'5\'), (\'21\', \'6\', \'Am getting up\', \'0\', \'1\', \'1\'), (\'22\', \'6\', \'Get up\', \'1\', \'1\', \'2\'), (\'23\', \'6\', \'Gets up\', \'0\', \'1\', \'3\'), (\'24\', \'6\', \'Getting up\', \'0\', \'1\', \'5\'), (\'25\', \'7\', \'Are listen\', \'0\', \'1\', \'1\'), (\'26\', \'7\', \'Are listening\', \'1\', \'1\', \'2\'), (\'27\', \'7\', \'Listening\', \'0\', \'1\', \'3\'), (\'28\', \'7\', \'Listen\', \'0\', \'1\', \'5\'), (\'29\', \'8\', \'Has\', \'0\', \'1\', \'1\'), (\'30\', \'8\', \'Use to have\', \'0\', \'1\', \'2\'), (\'31\', \'8\', \'Was having\', \'0\', \'1\', \'3\'), (\'32\', \'8\', \'Used to have\', \'1\', \'1\', \'4\'), (\'33\', \'9\', \'Are made\', \'1\', \'1\', \'1\'), (\'34\', \'9\', \'Made\', \'0\', \'1\', \'2\'), (\'35\', \'9\', \'Was made\', \'0\', \'1\', \'3\'), (\'36\', \'9\', \'Make\', \'0\', \'1\', \'4\'), (\'37\', \'10\', \'Was he do\', \'0\', \'1\', \'1\'), (\'38\', \'10\', \'Does he do\', \'0\', \'1\', \'2\'), (\'39\', \'10\', \'He did\', \'0\', \'1\', \'3\'), (\'40\', \'10\', \'Was he doing\', \'1\', \'1\', \'4\'), (\'41\', \'11\', \'Aunt\', \'0\', \'1\', \'1\'), (\'42\', \'11\', \'Aunt’s\', \'1\', \'1\', \'2\'), (\'43\', \'11\', \'Aunts\', \'0\', \'1\', \'3\'), (\'44\', \'11\', \'Aunts’\', \'0\', \'1\', \'4\'), (\'45\', \'12\', \'Cooking\', \'1\', \'1\', \'1\'), (\'46\', \'12\', \'To cook\', \'0\', \'1\', \'2\'), (\'47\', \'12\', \'Cook\', \'0\', \'1\', \'3\'), (\'48\', \'12\', \'I cook\', \'0\', \'1\', \'4\'), (\'49\', \'13\', \'Have known\', \'1\', \'1\', \'1\'), (\'50\', \'13\', \'Have been knowing\', \'0\', \'1\', \'2\'), (\'51\', \'13\', \'Knew\', \'0\', \'1\', \'3\'), (\'52\', \'13\', \'Know\', \'0\', \'1\', \'4\'), (\'53\', \'14\', \'Is finishing\', \'0\', \'1\', \'1\'), (\'54\', \'14\', \'Will finish\', \'0\', \'1\', \'2\'), (\'55\', \'14\', \'Finishes\', \'1\', \'1\', \'3\'), (\'56\', \'14\', \'Finish\', \'0\', \'1\', \'4\'), (\'57\', \'15\', \'Has checked\', \'0\', \'1\', \'1\'), (\'58\', \'15\', \'Had checked\', \'1\', \'1\', \'2\'), (\'59\', \'15\', \'Checked\', \'0\', \'1\', \'3\'), (\'60\', \'15\', \'Has been checked\', \'0\', \'1\', \'4\'), (\'61\', \'16\', \'So that\', \'0\', \'1\', \'1\'), (\'62\', \'16\', \'Unless\', \'0\', \'1\', \'2\'), (\'63\', \'16\', \'As long as\', \'1\', \'1\', \'3\'), (\'64\', \'16\', \'As if\', \'0\', \'1\', \'4\'), (\'65\', \'17\', \'Which live\', \'0\', \'1\', \'1\'), (\'66\', \'17\', \'Living\', \'1\', \'1\', \'2\'), (\'67\', \'17\', \'Who lives\', \'0\', \'1\', \'3\'), (\'68\', \'17\', \'Are living\', \'0\', \'1\', \'4\'), (\'69\', \'18\', \'Hearing\', \'1\', \'1\', \'1\'), (\'70\', \'18\', \'Hear\', \'0\', \'1\', \'2\'), (\'71\', \'18\', \'Be heard\', \'0\', \'1\', \'2\'), (\'72\', \'18\', \'Have heard\', \'0\', \'1\', \'4\'), (\'73\', \'19\', \'Would have\', \'0\', \'1\', \'1\'), (\'74\', \'19\', \'Will have\', \'0\', \'1\', \'2\'), (\'75\', \'19\', \'Will have had\', \'0\', \'1\', \'3\'), (\'76\', \'19\', \'Would have had\', \'1\', \'1\', \'4\'), (\'77\', \'20\', \'To be\', \'0\', \'1\', \'1\'), (\'78\', \'20\', \'He is\', \'0\', \'1\', \'2\'), (\'79\', \'20\', \'Being\', \'1\', \'1\', \'3\'), (\'80\', \'20\', \'Not to be\', \'0\', \'1\', \'4\'), (\'81\', \'21\', \'Late\', \'1\', \'1\', \'1\'), (\'82\', \'21\', \'Lately\', \'0\', \'1\', \'2\'), (\'83\', \'21\', \'Recently\', \'0\', \'1\', \'3\'), (\'84\', \'21\', \'Later\', \'0\', \'1\', \'4\'), (\'85\', \'22\', \'Thoroughly\', \'0\', \'1\', \'1\'), (\'86\', \'22\', \'Sincerely\', \'0\', \'1\', \'2\'), (\'87\', \'22\', \'Absolutely\', \'0\', \'1\', \'3\'), (\'88\', \'22\', \'Strongly\', \'1\', \'1\', \'4\'), (\'89\', \'23\', \'Chair\', \'0\', \'1\', \'1\'), (\'90\', \'23\', \'Moon\', \'1\', \'1\', \'3\'), (\'91\', \'23\', \'Feet\', \'0\', \'1\', \'3\'), (\'92\', \'23\', \'Back\', \'0\', \'1\', \'4\'), (\'93\', \'24\', \'Giving\', \'1\', \'1\', \'1\'), (\'94\', \'24\', \'Have given\', \'0\', \'1\', \'2\'), (\'95\', \'24\', \'Given\', \'0\', \'1\', \'3\'), (\'96\', \'24\', \'Have been giving\', \'0\', \'1\', \'4\'), (\'97\', \'25\', \'To discover\', \'1\', \'1\', \'1\'), (\'98\', \'25\', \'Discovering\', \'0\', \'1\', \'2\'), (\'99\', \'25\', \'Being discovere\', \'0\', \'1\', \'3\'), (\'100\', \'25\', \'To have discovered\', \'0\', \'1\', \'4\');
          ');

        //Логика теста
        $this->execute("
            INSERT INTO `test_logic` VALUES ('1', '1', '1', '5', '25', '<p>Dear <strong>%Name%</strong>,</p><p><br>Congratulations! You have successfully completed Headway Institute\'s Online Placement Test for English.<br>According to the result, your English level is <strong>%Level%</strong>.<br>What\'s the next step?<br>Visit our website to find out more about our courses and schedule.<br>If you need more information about our language programs, registration process and fees, please contact us by replying to this email or call 04 3625313.<br>We look forward to assisting you in your language learning journey.<br><br>All the best,<br>Headway Institute</p>');
        ");

        //Настройка уровней прохождения теста
        $this->execute('
            INSERT INTO `test_level` VALUES (\'6\', \'1\', \'1\', \'1\', \'5\'), (\'7\', \'1\', \'2\', \'5\', \'7\'), (\'8\', \'1\', \'3\', \'8\', \'10\'), (\'9\', \'1\', \'4\', \'16\', \'20\'), (\'10\', \'1\', \'5\', \'21\', \'25\');
        ');
    }

    public function down()
    {
        echo "m170131_070016_TestValue cannot be reverted.\n";

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
