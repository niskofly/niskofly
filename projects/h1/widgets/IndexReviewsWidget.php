<?php
/**
 * Created by PhpStorm.
 * User: scriptosaur
 * Date: 12.11.15
 * Time: 14:23
 */

namespace app\widgets;

use yii\base\Widget;
use app\models\Review;


class IndexReviewsWidget extends Widget
{
    public function run()
    {
        $reviews = Review::find()->orderBy('date DESC')->limit(2)->all();
        return $this->render(
            'index_reviews',
            [
                'reviews' => $reviews
            ]
        );
    }
}
