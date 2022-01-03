<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var $this  yii\web\View
 * @var $form  yii\widgets\ActiveForm
 * @var $model dektrium\user\models\SettingsForm
 */

$this->title = Yii::t('app', 'Мои регулярные платежи');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>

    <!--<div>
        <a class="subscription_no" href="<?/*= Url::toRoute(['/order/test-subscription'], true) */?>">Тест подписок</a>
    </div>-->
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <div class="subscription-container">

                    <?
                    $subscription_pay = (new \yii\db\Query())
                        ->select('id_order')
                        ->from('payfort_token')
                        ->createCommand()->queryAll( PDO::FETCH_COLUMN);
                    ?>

                    <? if (empty($courses)) {
                        ?>

                        <div>
                            <?= Yii::t('app', 'У вас нет регулярных платежей.'); ?>
                        </div>

                        <?
                    }else { ?>
                        <div style="padding: 10px; font-size: 15px">
                            <?/*= Yii::t('app', 'Terms and Conditions'); */?><!--
                             </div>-->



                            <input type="checkbox" id="i_hereby" onclick="checkFluency()">
                            <label for="i_hereby">

                                <?= Yii::t('app', 'I hereby confirm that I have read and accept the Institute´s terms and conditions.') ?>

                            </label>


                        </div>

                        <? foreach ($courses as $key => $course_group) { ?>


                            <div style="padding: 10px; font-size: 15px"><?= $key ?></div>

                            <?
                            $subscription_pay_isset = false;
                            $url_pay = null;
                            foreach ($course_group as $course) {
                                if ($course['paid'] == 0 && $url_pay == null) {
                                    $url_pay = $course['url'];
                                    break;
                                }
                            } ?>

                            <?

                            foreach ($course_group as $course) {
                                if (array_search($course['id_order'], $subscription_pay) !== false) {
                                    $subscription_pay_isset = $course['id_order'];
                                    break;
                                }
                            } ?>


                            <? if ($url_pay !== null) { ?>
                                <? if ($subscription_pay_isset !== false) { ?>
                                    <div class="subscription-item">
                                        <button name="i_hereby_send"  class="subscription_no disabled"
                                                data-href="<?= Url::toRoute(['/order/delete-subscription', 'id' => $subscription_pay_isset], true) ?>">
                                            <?= Yii::t('app', 'Отписаться'); ?>
                                        </button>
                                    </div>
                                <?
                                } else { ?>
                                    <div class="subscription-item">
                                        <button name="i_hereby_send"  class="subscription_ok disabled"
                                           data-href="<?= Url::toRoute(['/order/recurse-pay', 'url' => $url_pay], true) ?>">
                                            <?= Yii::t('app', 'Подписаться'); ?>
                                        </button>
                                    </div>
                                <? }
                            } ?>




                            <? foreach ($course_group as $course) { ?>
                                <div class="subscription-row">
                                    <div class="subscription-item">
                                        <?= $course['price'] ?> AED
                                    </div>
                                    <div class="subscription-item">
                                        <?= $course['date'] ?>
                                    </div>


                                    <div class="subscription-item">
                                        <?= $course['sale'] ?>
                                        <? if ($course['paid'] == 1) { ?>
                                            <a class="subscription_ok"><?= Yii::t('app', 'Подписка оплаченна'); ?></a>
                                        <? } else { ?>
                                            <a class="subscription_no"><?= Yii::t('app', 'Подписка не оплаченна'); ?></a>
                                        <? } ?>
                                    </div>
                                </div>
                            <? } ?>
                        <? }
                    }?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    document.getElementById('i_hereby').disabled = true;
    window.onload = function () {
        document.getElementById('i_hereby').disabled = false;
        if (document.getElementById('i_hereby').checked === true) {
            checkFluency();
        }
    };


    function checkFluency(){
        var x = document.getElementsByName('i_hereby_send');
        
        for (var i = 0; i < x.length; i++){
            x[i].classList.toggle('disabled');
        }



    }


    document.addEventListener('click', function(event) {

        if (event.target.dataset.href != undefined) {
            if (!event.target.classList.contains('disabled')){
                location.href = event.target.dataset.href;
            }else {
                document.getElementById('i_hereby').focus();
            }
        }

    });

</script>

<style>
    .disabled{
        opacity: 0.5;
        cursor: no-drop;
    }
    .subscription_ok, .subscription_no {

        padding: 5px 10px;
        border-radius: 10px;
        color: #ffffff;
    }

    .subscription_ok {
        background: #398439;
        color: #ffffff;
    }

    .subscription_ok:hover {
        text-decoration: none;
        background: #00a0e3;
        color: #ffffff !important;
        border-color: #00a0e3
    }

    .subscription_no {
        background: #ff3f41;
    }

    .subscription_no:hover {
        color: #ffffff;
    !important;
        text-decoration: none;
        background: #ff4e14;
    }

    .subscription-container {
        display: flex;
        flex-direction: column;
    }

    .subscription-row {
        display: flex;
        justify-content: space-evenly;
    }

    .subscription-item {
        padding: 5px 10px;
        flex: 1;
    }
</style>