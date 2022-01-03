<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\Test;
use app\models\TestQuestion;

/* @var $this yii\web\View */
/* @var $model app\models\Test */

$this->title = 'Test:';
$this->params['breadcrumbs'][] = ['label' => 'Test', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'label' => Yii::t('app', 'Описание'),
                'value' => $model->getDescription(),
                'format' => 'html'
            ],
            'active',
            'ordering'
        ],
    ]) ?>

<?php
$questions = $model->getQuestions();
if($questions):
?>
    <h3><?= Yii::t('app', 'Вопросы теста:') ?></h3>
    <table class="table">
        <tbody>
<?php foreach($questions as $question): ?>
            <tr>
                <td>
                    <a href="<?= Url::toRoute(['/dashboard/testsquestions/view', 'id' => $question['id']]) ?>"><?= $question['name'] ?></a>
                </td>
            </tr>
<?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>

</div>
