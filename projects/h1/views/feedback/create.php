<?php

/* @var $this yii\web\View */


$this->title = 'Feedback';

?>


<div class="container">
<div class="feedback-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
