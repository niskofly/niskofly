<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CoursesGroup */

$this->title = Yii::t('app', 'Create Courses Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courses-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
