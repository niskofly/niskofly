<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelCourses app\models\Courses */
/* @var $modelCoursesGroup_1 app\models\CoursesGroup */
/* @var $modelCoursesGroup_2 app\models\CoursesGroup */
/* @var $modelCoursesGroup_3 app\models\CoursesGroup */

$this->title = Yii::t('app', 'Create Courses');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_create', [
        'modelCourses' => $modelCourses,
    ]) ?>

</div>
