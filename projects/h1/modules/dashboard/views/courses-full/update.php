<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelCourses app\models\Courses */
/* @var $modelCoursesGroup_1 app\models\CoursesGroup */
/* @var $modelCoursesGroup_2 app\models\CoursesGroup */
/* @var $modelCoursesGroup_3 app\models\CoursesGroup */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Courses',
]) . $modelCourses->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelCourses->name, 'url' => ['view', 'id' => $modelCourses->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="courses-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelCourses' => $modelCourses,
        'modelCoursesGroup_1' => $modelCoursesGroup_1,
        'modelCoursesGroup_2' => $modelCoursesGroup_2,
        'modelCoursesGroup_3' => $modelCoursesGroup_3,
        'modelsSched_1' =>  $modelsSched_1,
        'modelsSched_2' =>  $modelsSched_2,
        'modelsSched_3' =>  $modelsSched_3,
    ]) ?>

</div>
