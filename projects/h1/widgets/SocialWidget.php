<?php
/**
 * SocialWidget.php - new.headin.pro
 * Initial version by: BeforyDeath
 * Initial version created on: 03.09.15 10:54
 */

namespace app\widgets;

use yii\base\Widget;

class SocialWidget extends Widget
{
    public function run()
    {
        return $this->render('social');
    }
}