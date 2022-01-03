<?php

use yii\helpers\Url;

$this->title = Yii::t('app', 'Список тестов');
//$this->registerMetaTag(['name' => 'description', 'content' => $page->meta_description]);
//$this->registerMetaTag(['name' => 'keywords', 'content' => $page->meta_keywords]);
?>


<div class="container">
    <div class="tests-index">
        <div class="row">
            <div class="col-md-12">
                <div class="border-page-header">
                    <h1><?= Yii::t('app', 'Список тестов') ?></h1>
                    <ul class="list-unstyled">
                        <?php foreach ($tests as $test): ?>
                            <li>
                                <a href="<?= Url::toRoute([
                                    'tests/view',
                                    'id' => $test->id
                                ]) ?>"><?= $test['name'] ?></a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
