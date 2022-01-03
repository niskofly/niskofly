<?php

use yii\helpers\Url;

$this->title = $test->name;
$this->params['breadcrumbs'] = $path;

?>

<div class="container">
    <div class="tests-index-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="border-page-header">
                    <h1><?= $test->name?></h1>
                    <article>
                        <?= $test->getDescription() ?>
                    </article>
                    <br>
                    <a href="<?= Url::toRoute(['tests/question', 'id' => $test->id, 'number' => 1]) ?>" class="btn btn-default"><?= Yii::t('app', 'Начать')?></a>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
