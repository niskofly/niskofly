<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'] = $path;

$error = Yii::$app->session->getFlash('error');

?>


<div class="container">
    <div class="row">
        <div class="tests-question">
            <div class="col-md-12">
                <div class="border-page-header">
                    <h1><?= $test['name']?></h1>
                    <div>
                        <?= Yii::t('app', 'Вопрос') ?>
                        <span class="tests-question_current"><?= $number ?></span>
                        <?= Yii::t('app', 'из') ?>
                        <?= $test->getQuestionCount() ?>
                    </div>
                    <br>
<?php if($error): ?>
                    <div class="alert alert-danger">
                        <?= $error ?>
                    </div>
<?php endif ?>
                    <div class="row">
                        <div class="col-md-6">
                            <h4><?= $question->name ?></h4>
<?php $form = ActiveForm::begin();?>
                            <input type="hidden" name="question_number" value="<?= $number ?>">
                            <ul class="list-unstyled tests-question_content">
<?php foreach($question->getAnswers() as $answer): ?>
                                <li>
                                    <label>
                                        <input type="radio" name="answer" value="<?= $answer['id'] ?>">
                                        <span class="tests-question_content_variant"> <?= $answer['name'] ?></span>
                                    </label>
                                </li>
<?php endforeach ?>
                            </ul>
<?php if($number < $test->getQuestionCount()): ?>
                            <button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Далее')?></button>
<?php else: ?>
                            <button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Завершить')?></button>
<?php endif ?>
<?php ActiveForm::end(); ?>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
