<?php

/* @var $this yii\web\View */
use app\models\Language;

$homeUrl = "/";
$lang = Language::getCurrent();
if(isset($lang->alias)){
    $homeUrl .= $lang->alias;
}
Yii::$app->homeUrl = $homeUrl;


$this->title = Yii::t('app', 'Заказ №')." ".$model->id;

?>
<div class="container">
    <h1><?= $this->title ?></h1>
    <br>
    <table class="table">
        <tr>
            <td><?= Yii::t('app', 'Уровень') ?></td>
            <td><?= $model->level ?></td>
        </tr>
        <tr>
            <td><?= Yii::t('app', 'Дата начала') ?></td>
            <td><?= $model->start_date ?></td>
        </tr>
        <tr>
            <td><?= Yii::t('app', 'Расписание') ?></td>
            <td><?= $model->schedule ?></td>
        </tr>
        <tr>
            <td><?= Yii::t('app', 'Стоимость') ?></td>
            <td><?= $model->price ?></td>
        </tr>
        <tfoot>
<?php if($model->paid): ?>
        <tr>
            <td colspan="2" class="success">
                <?= Yii::t('app', 'Заказ оплачен') ?>
            </td>
        </tr>
<?php else: ?>
        <tr>
            <td colspan="2" class="text-right">
                <a href="" class="btn btn-primary"><?= Yii::t('app', 'Перейти к оплате') ?></a>
            </td>
        </tr>
<?php endif ?>
        </tfoot>
    </table>
</div>
