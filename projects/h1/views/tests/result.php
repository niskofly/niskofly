<?php

use yii\helpers\Url;

$this->params['breadcrumbs'] = $path;

?>


<div class="container">
    <div class="test-result">
    <div class="row">
        <div class="col-md-12">
            <div class="border-page-header">
                <h1><?= $test['name']?></h1>
                <article>
                    <h4><?= Yii::t('app', 'Ваш результат') ?></h4>
                    <div>
                        <p><?= $result ?></p>
                    </div>
                </article>
            </div>
        </div>
    </div>
    </div>
</div>
