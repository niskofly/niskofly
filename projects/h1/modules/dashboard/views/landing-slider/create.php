<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LandingSlider */

$this->title = 'Create Landing Slider item';
$this->params['breadcrumbs'][] = ['label' => 'Landing Sliders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="landing-slider-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
