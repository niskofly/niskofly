<?php
/**
 * Created by PhpStorm.
 * User: scriptosaur
 * Date: 12.11.15
 * Time: 13:40
 */

namespace app\widgets;

use yii\base\Widget;
use app\models\News;


class IndexNewsWidget extends Widget
{
    public function run()
    {
        $news = News::find()->orderBy('date DESC')->limit(2)->all();
        return $this->render(
            'index_news',
            [
                'news' => $news
            ]
        );
    }
}
