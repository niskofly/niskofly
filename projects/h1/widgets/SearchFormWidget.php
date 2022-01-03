<?php

namespace app\widgets;

use yii\base\Widget;

class SearchFormWidget extends Widget
{
    public function run()
    {
        $q = "";
        if(isset($_GET["q"])) {
            $q = $_GET["q"];
        }
        return $this->render('search', ['q' => $q]);
    }
}
