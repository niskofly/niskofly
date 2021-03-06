<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Schedule */

$this->title = 'Create Schedule Item';
$this->params['breadcrumbs'][] = ['label' => 'Schedule', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
