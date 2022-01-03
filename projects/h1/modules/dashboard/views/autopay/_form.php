<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\MaskedInput;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Autopay */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin([
        'layout'=>'horizontal',
        'id' => 'autopay-form',
        'validateOnChange' => true,
        'validateOnType' => true,
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl'=>Url::to(['autopay/valid']),
        'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
                'label' => 'col-sm-4',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
        ],    
        ],
        ]
    ); ?>

<div class="col-sm-4">
<div class="panel panel-info">
  <div class="panel-heading">
    <h3> Client information </h3>
  </div>

<div class="autopay-form panel-body">


    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true,'placeholder' => 'firstname']) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true,'placeholder' => 'lastname']) ?>

   <?= $form->field($model, 'phone')->widget(MaskedInput::className(),[
        'mask'=>'+\971-99-9999999','options'=>['placeholder'=>'+971-xx-xxxxxxx']
//        'mask' => '8(999)999-99-99',
    ]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true,'placeholder' => 'email']) ?>

    <?= $form->field($model, 'course')->textInput(['maxlength' => true,'placeholder' => 'course']) ?>

    <?= $form->field($model, 'details')->textarea(['rows' => 2, 'cols' => 5,'placeholder' => 'Details']) ?>

    <?php if($model->isNewRecord) : ?>
    <?= $form->field($model, 'summaAutopay')->textInput(['maxlength' => true,'placeholder' => 'Enter sum ']) ?>
    
    <?= $form->field($model, 'countDetails')->textInput(['maxlength' => true,'placeholder' => 'Enter number of month ']) ?>
    <?= $form->field($model, 'startDate')->widget(yii\jui\DatePicker::classname(), ['dateFormat' => 'dd.MM.yyyy']) ?>
    <?php endif; ?>

    <?
    $data = User::find()
        ->select(['email as value', 'email as label', 'id as id'])
        ->asArray()
        ->all();
    ?>

    <div>Account Email (Required)</div>
    <?= AutoComplete::widget([
        'name' => 'Company',
        'id' => 'ddd',
        'clientOptions' => [
            'source' => $data,
            'autoFill' => true,
            'minLength' => '1',
            'select' => new JsExpression("function( event, ui ) {
    $('#autopay-user_id').val(ui.item.id);
    }")],
        'options' => [
            'class' => 'form-control'
        ]
    ]);
    ?>
    <?= Html::activeHiddenInput($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success col-sm-4' : 'btn btn-primary col-sm-4']) ?>
        <?= Html::a('Cancel',Url::to(['autopay/index']),['class' => 'btn btn-primary col-sm-4']) ?>
        

        <?php if ($model->isNewRecord) :?>
            <?= Html::a('Generate','',['class'=>'btn btn-info generate-row col-sm-4']) ?>
        <?php endif; ?>
    </div>


</div>
</div>
</div>
<div class="col-sm-8">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3> Client detail information </h3>
        </div>
        <div class="panel-body">
              <table class="table">
                <tr>
                    <th>Pay Date</th>
                    <th>Pay Sum</th>
                </tr>
                
                <tr class="js-clone-row" data-type="AutopayDetails">
                    <td><?= $form->field($clientDetailModel, "[0]pay_date",['template'=>'{input}{error}']
                        )->label(false) ?> </td>
                    <td><?= $form->field($clientDetailModel, "[0]pay_sum",['template'=>'{input}{error}'])->label(false) ?> </td>
                </tr>
              </table>            
        </div>
    
    </div>
</div>
<?php ActiveForm::end(); ?>
