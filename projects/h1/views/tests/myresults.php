<?php

use yii\helpers\Url;

?>


<div class="container">
    <div class="test-results">
        <div class="row">
            <div class="col-md-12">
<?php if($results): ?>
                <h2><?=Yii::t('app', 'Результаты пройденных тестов') ?></h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th><?= Yii::t('app', 'Дата') ?></th>
                            <th><?= Yii::t('app', 'Тест') ?></th>
                            <th><?= Yii::t('app', 'Уровень') ?></th>
                            <th><?= Yii::t('app', 'Результат') ?></th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach($results as $result): ?>
                        <tr>
                            <td><?= $result->date ?></td>
                            <td><?= $result->name ?></td>
                            <td><?= $result->level->name ?></td>
                            <td><?= $result->result ?></td>
                        </tr>
<?php endforeach ?>
                    </tbody>
                </table>
<?php endif ?>
            </div>
        </div>
    </div>
</div>
