<?php

namespace app\controllers;

use app\models\Language;
use app\models\News;
use app\models\Page;
use app\models\Review;
use Yii;
use yii\web\Controller;

class SitemapController extends Controller
{
    private $array;
    private $array_idx_lvl; //Индекс по level
    private $groups;         //доменные группы
    private $language;


	public function actionIndex()
	{
	    $urls = array();
        $this->language = array();
        $language_objects = Language::find()->all();
        foreach ($language_objects as $item){
            $this->language[$item->id] = $item->alias;
        }
            $reviews = Review::find()->all();
            foreach ($reviews as $review){
                $urls[] = array(
                    '/en/reviews/' .$review->id
                , 'weekly'
                );
                $urls[] = array(
                    '/ru/reviews/' .$review->id
                , 'weekly'
                );
            }


        $news = News::find()->all();
        foreach ($news as $new) {
            $urls[] = array(
                '/' . $this->language[1] . '/news/' . $new->id
            , 'weekly',
                $urls[] = array(
                    '/' . $this->language[2] . '/news/' . $new->id
                , 'weekly'
                )
            );
        }
        //$pages = Page::find()->where(['active' => 1])->asArray()->all();
        $pages = Page::find()->asArray()->all();
        $this->array = array();  //выходной массив
        $this->array_idx_lvl = array();  //индекс по полю level


        $this->recursive($pages); //Запускаем

        foreach ($this->array as $item){
            if ('/'.$item['language'].$item['path'] === '/en//'){
                $urls[] = array('/'.$item['language']
                , 'weekly'                                                           // вероятная частота изменения категории
                );
               continue;
            }
            if ('/'.$item['language'].$item['path'] === '/ru//'){
                $urls[] = array('/'.$item['language']
                , 'weekly'                                                           // вероятная частота изменения категории
                );
                continue;
            }
            $urls[] = array('/'.$item['language'].$item['path']
            , 'weekly'                                                           // вероятная частота изменения категории
            );
        }

        $urls[] = array(
            '/ru/reviews', 'weekly'
        );
        $urls[] = array(
            '/ru/user/register', 'weekly'
        );
        $urls[] = array(
            '/en/user/register', 'weekly'
        );

            $xml_sitemap = $this->renderPartial('index', array( // записываем view на переменную для последующего кэширования
                'host' => Yii::$app->request->hostInfo,         // текущий домен сайта
                'urls' => $urls,                                // с генерированные ссылки для sitemap
            ));

            //Yii::$app->cache->set('sitemap', $xml_sitemap, 3600*12); // кэшируем результат, чтобы не нагружать сервер и не выполнять код при каждом запросе карты сайта.


        header('Content-Type: application/xml'); // тоже самое, формат отдачи контента
        echo $xml_sitemap;
    }


    private function recursive($data, $pid = 0, $level = 0, $path = "", $access_parent = "inherit"){
        //перебираем строки
        foreach ($data as $row) {
            //Начинаем со строк, pid которых передан в функцию, у нас это 0, т.е. корень сайта
            if ($row['parent_id'] == $pid) {
                //Собираем строку в ассоциативный массив
                $_row['uid']    = $row['id'];
                $_row['language'] = $this->language[$row['language_id']];
                $_row['pid']    = $row['parent_id'];
                $_row['name']   = $_row['name'] = str_pad('', $level*3, '.').$row['name']; //Функцией str_pad добавляем точки
                $_row['level']  = $level;       //Добавляем уровень
                $_row['path']   = $path."/".$row['alias'];   //Добавляем имя к пути

                //Разруливаем доступы
                if($row['access'] == 'inherit') {
                    $_row['access'] = $access_parent; //Если стоит наследование, делаем как у родителя
                } else {
                    $_row['access'] = (in_array($row['access'], $this->groups)) ? 'allow' : 'deny';
                }
                $this->array[$row['id']] = $_row; //Результирующий массив индексируемый по uid

                //Для быстрой выборки по level, формируем индекс
                $this->array_idx_lvl[$level][$row['id']]  = $row['id'];

                //Строка обработана, теперь запустим эту же функцию для текущего uid, то есть
                //пойдёт обратотка дочерней строки (у которой этот uid является pid-ом)

                //var_dump($_row);
                $this->recursive($data, $row['id'], $level + 1, $_row['path'], $_row['access']);
            }
        }
    }
}