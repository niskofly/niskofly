<?php
/**
 * view.php - new.headin.pro
 * Initial version by: BeforyDeath
 * Initial version created on: 25.08.15 17:16
 */

use app\models\Language;
use app\models\Page;
use yii\helpers\Url;
use app\widgets\FeedbackWidget;
use app\widgets\IndexNewsWidget;
use app\widgets\IndexReviewsWidget;

/** @var $page \yii\db\ActiveRecord */
$this->title = $page->meta_title;

$this->registerMetaTag(['name' => 'description', 'content' => $page->meta_description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page->meta_keywords]);

//open graph
$this->registerMetaTag(['name' => 'og:title', 'content' => $page->meta_title]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $page->meta_description]);

$this->registerMetaTag(['name' => 'twitter:title', 'content' => $page->meta_title]);
$this->registerMetaTag(['name' => 'twitter:description', 'content' => $page->meta_description]);
//open graph




if (Yii::$app->request->pathInfo == '') {
    $isMainPage = true;
} else {
    $isMainPage = false;
    $this->params['breadcrumbs'] = $page->getPath();
}

$imageUrl = $page->getImageUrl();
$catalog_section = $page->getCatalogSection();
$schedule = $page->getSchedule();

?>

<?php if($isMainPage): ?>
    <div class="page-banner">
        <div class="page-banner-container" style='background-image: url("<?= $imageUrl?>")'>

            <div class="page-banner-left">



                <?
                $lang = Language::getCurrent();
                if ($lang->alias == 'en'){ ?>
                    <div class="page-banner-header">
                        Your language center<br>
                        in Dubai Knowledge Village

                    </div>
                    <div class="page-banner-text">
                        providing face to face, online
                        classes for adult, kids,
                        corporate clients and schools
                    </div>
                <?}?>

                <? if ($lang->alias == 'ru'){ ?>
                    <div class="page-banner-header">
                        Ваш языковой центр<br>
                        в Dubai Knowledge Village

                    </div>

                    <div class="page-banner-text">
                        обучение лицом к лицу, онлайн-классы для взрослых, детей, корпоративных клиентов и школ
                    </div>
                <?}?>




           </div>
           <div class="page-banner-right">
               <div class="page-banner-form">

                   <script>var amo_forms_params = {"id":631162,"hash":"e03cc6601918deac53585192943e6282","locale":"en"};</script>
                   <!--<script id="amoforms_script" defer="defer" charset="utf-8" src="https://forms.amocrm.ru/forms/assets/js/amoforms.js"></script>
-->


                       <link href="//fonts.googleapis.com/css?family=PT+Sans+Narrow&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css">
                       <link href="//fonts.googleapis.com/css?family=PT+Sans:400,700&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css">
                       <link href="https://fonts.googleapis.com/css?family=Roboto:400,500&amp;subset=cyrillic" rel="stylesheet" type="text/css">

                   <meta name="viewport"
                         content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
                   <style>
                       #amofroms_main_wrapper {
                           font-family: Roboto;
                           color: #2e3640;
                           box-sizing: border-box;
                           border: 1px solid #D8D9DB;
                           background: #FFFFFF;
                       }

                       #button_submit,
                       #button_messenger_submit,
                       .amoforms-sended-message_wrapper {
                           font-family: Roboto !important;
                       }

                       #button_messenger_submit svg {
                           width: 32px;
                           height: 32px;
                           margin-right: 8px;
                       }

                       .pika-single * {
                           font-family: Roboto !important;
                       }


                       .amoforms-input-select,
                       .amoforms-input-multiselect {
                           font-family: Roboto !important;
                           color: #2e3640 !important;
                       }

                       .amoforms__field_terms-link {
                           color: #2e3640;
                           font-family: Roboto;
                       }

                       .amoforms__field_terms-link label {
                           border-bottom: 1px solid #2e3640 !important;
                       }

                       .checkboxes_dropdown_icon:after {
                           border-color: rgba(152, 169, 181, 1);
                       }

                       .text-input::-webkit-input-placeholder,
                       .text-input::-moz-placeholder,
                       .text-input:-ms-input-placeholder,
                       .text-input:-moz-placeholder {
                           color: rgba(152, 169, 181, 1);
                       }

                       ::-webkit-input-placeholder { /* Chrome */
                           color: rgba(152, 169, 181, 1);
                       }

                       :-ms-input-placeholder { /* IE 10+ */
                           color: rgba(152, 169, 181, 1);
                       }

                       ::-moz-placeholder { /* Firefox 19+ */
                           color: rgba(152, 169, 181, 1);
                           opacity: 1;
                       }

                       :-moz-placeholder { /* Firefox 4 - 18 */
                           color: rgba(152, 169, 181, 1);
                           opacity: 1;
                       }

                       .checkboxes_dropdown__title_wrapper {
                           color: rgba(152, 169, 181, 1);
                       }

                       .svg-card-calendar-dims {
                           fill: rgba(152, 169, 181, 1);
                       }

                       .js-amoforms-field-height {
                           height: 53px !important;
                           min-height: 53px !important;
                       }

                       .js-amoforms-border-radius {
                           /**/

                           background-color: #F9F9F9;

                           border-color: #D8D9DB;


                           border-radius: 0px;
                       }


                       .amoforms__fields__container .amoforms__field__control_smart_address label {
                           border-color: #D8D9DB;
                       }


                       .amoforms__fields__editor-sidebar {
                           /**/


                           /**/
                       }
                   </style>
                   <link rel="stylesheet" type="text/css"
                         href="https://forms.amocrm.ru/forms/css/form_631162_e03cc6601918deac53585192943e6282.css">

                   <div  id="amofroms_main_wrapper" class="amoforms__fields__editor-withborders  sidebar_none"
                        style="max-width: 509px;">

                       <form id="amoforms_form"  onsubmit="return false" class="amoforms-form amoforms-view-form"
                             enctype="multipart/form-data" style="">

                           <div class="amoforms__fields__container amoforms__fields__container_text amoforms__fields__container_inside">
                               <div class="amoforms__fields__container__inner amoforms__fields__container__inner_text  amoforms__fields__container__inner_inside ">
                                   <div class="amoforms__field__name amoforms__field__name_text"
                                        title="Enter your name">
                                       <label class="amoforms__field__name-label">
                                           <div><?= Yii::t('app', 'Введите имя') ?></div>
                                       </label>
                                       <span class="amoforms__field__required">*</span>
                                   </div>

                                   <div class="amoforms__field__control amoforms__field__control_text js-amoforms-border-radius js-amoforms-field-height">

                                       <input type="text" name="fields[name_1]" required placeholder="<?= Yii::t('app', 'Введите имя') ?>"
                                              class="amoforms_placeholder js-form-changes-skip text-input js-amoforms-font js-amoforms-color  amoforms-validate_required">
                                   </div>
                                   <div class="amoforms__field__required-inside">*</div>
                               </div>
                           </div>

                           <div class="amoforms__fields__container amoforms__fields__container_multitext amoforms__fields__container_inside">
                               <div class="amoforms__fields__container__inner amoforms__fields__container__inner_multitext  amoforms__fields__container__inner_inside ">
                                   <div class="amoforms__field__name amoforms__field__name_multitext" title="<?= Yii::t('app', 'Телефон') ?>">
                                       <label class="amoforms__field__name-label">
                                           <div><?= Yii::t('app', 'Телефон') ?></div>
                                       </label>
                                       <span class="amoforms__field__required">*</span>
                                   </div>

                                   <div class="amoforms__field__control amoforms__field__control_multitext js-amoforms-border-radius js-amoforms-field-height">


                                       <input type="tel"
                                              id="register-form-phone-main"
                                              class="amoforms_placeholder js-form-changes-skip text-input js-amoforms-font js-amoforms-color  amoforms-validate_required amoforms-validate_phone"
                                              name="fields[79667_1][167797]" required placeholder="<?= Yii::t('app', 'Телефон') ?>">
                                   </div>
                                   <div class="amoforms__field__required-inside">*</div>
                               </div>
                           </div>

                           <div class="amoforms__fields__container amoforms__fields__container_multitext amoforms__fields__container_inside">
                               <div class="amoforms__fields__container__inner amoforms__fields__container__inner_multitext  amoforms__fields__container__inner_inside ">
                                   <div class="amoforms__field__name amoforms__field__name_multitext" title="Email">
                                       <label class="amoforms__field__name-label">
                                           <div>Email</div>
                                       </label>
                                       <span class="amoforms__field__required">*</span>
                                   </div>

                                   <div class="amoforms__field__control amoforms__field__control_multitext js-amoforms-border-radius js-amoforms-field-height">


                                       <input type="email"
                                              class="amoforms_placeholder js-form-changes-skip text-input js-amoforms-font js-amoforms-color  amoforms-validate_required amoforms-validate_email"
                                              name="fields[79669_1][167809]" required placeholder="Email">
                                   </div>
                                   <div class="amoforms__field__required-inside">*</div>
                               </div>
                           </div>

                           <div class="amoforms__fields__container amoforms__fields__container_text amoforms__fields__container_inside">
                               <div class="amoforms__fields__container__inner amoforms__fields__container__inner_text  amoforms__fields__container__inner_inside ">
                                   <div class="amoforms__field__name amoforms__field__name_text" title="Promocode">
                                       <label class="amoforms__field__name-label">
                                           <div><?= Yii::t('app', 'Промокод') ?></div>
                                       </label>
                                       <span class="amoforms__field__required" style="display: none">*</span>
                                   </div>

                                   <div class="amoforms__field__control amoforms__field__control_text js-amoforms-border-radius js-amoforms-field-height">
                                       <input type="text" name="fields[639575_2]" placeholder="<?= Yii::t('app', 'Промокод') ?>" class="amoforms_placeholder js-form-changes-skip text-input js-amoforms-font js-amoforms-color ">
                                   </div>
                               </div>
                           </div>


                           <?  if ($lang->alias == 'en'){ ?>
                           <div class="amoforms__fields__container amoforms__fields__container_header amoforms__fields__container_inside">
                               <div class="amoforms__fields__container__inner amoforms__fields__container__inner_header ">
                                   <div class="amoforms__field__control amoforms__field__control_header js-amoforms-border-radius ">
                                       <label class="amoforms__field__name-header text-input js-form-changes-skip js-amoforms-font js-amoforms-color"
                                              style="
          font-size: 28px;  text-align: left;">Sign up for free trial class</label>

                                   </div>
                               </div>
                           </div>

                           <?} else {?>

                           <div class="amoforms__fields__container amoforms__fields__container_header amoforms__fields__container_inside">
                               <div class="amoforms__fields__container__inner amoforms__fields__container__inner_header ">
                                   <div class="amoforms__field__control amoforms__field__control_header js-amoforms-border-radius ">
                                       <label class="amoforms__field__name-header text-input js-form-changes-skip js-amoforms-font js-amoforms-color"
                                              style="
          font-size: 24px;  text-align: left;">Запишитесь на бесплатное</label>

                                   </div>
                               </div>
                           </div>

                               <div class="amoforms__fields__container amoforms__fields__container_header amoforms__fields__container_inside">
                               <div class="amoforms__fields__container__inner amoforms__fields__container__inner_header ">
                                   <div class="amoforms__field__control amoforms__field__control_header js-amoforms-border-radius ">
                                       <label class="amoforms__field__name-header text-input js-form-changes-skip js-amoforms-font js-amoforms-color"
                                              style="
          font-size: 24px;  text-align: left;">пробное занятие</label>

                                   </div>
                               </div>
                           </div>

                           <?}?>


                           <input type="hidden" name="form_id" id="form_id" value="631162">
                           <input type="hidden" name="hash" value="e03cc6601918deac53585192943e6282">
                           <!--<input type="hidden" name="user_origin" id="user_origin"
                                  value="{&quot;datetime&quot;:&quot;Tue Mar 16 2021 15:41:45 GMT+0300 (Москва, стандартное время)&quot;,&quot;referer&quot;:&quot;&quot;}">

                           <input type="hidden" name="fields[490059_2]" id="ga"
                                  value="{&quot;ga&quot;:{&quot;trackingId&quot;:&quot;UA-24998211-1&quot;,&quot;clientId&quot;:&quot;804898028.1597041859&quot;},&quot;utm&quot;:{&quot;source&quot;:&quot;&quot;,&quot;medium&quot;:&quot;&quot;,&quot;content&quot;:&quot;&quot;,&quot;campaign&quot;:&quot;&quot;,&quot;term&quot;:&quot;&quot;},&quot;data_source&quot;:&quot;form&quot;}">
                         -->  <input type="hidden" name="fields[490061_2]" id="utm_source" value="">
                           <input type="hidden" name="fields[490063_2]" id="utm_medium" value="">
                           <input type="hidden" name="fields[490065_2]" id="utm_campaign" value="">
                           <input type="hidden" name="fields[490067_2]" id="utm_term" value="">
                           <input type="hidden" name="fields[490135_2]" id="utm_term" value="">
                           <input type="hidden" name="fields[490137_2]" id="utm_campaign" value="">
                           <input type="hidden" name="fields[490139_2]" id="utm_medium" value="">
                           <input type="hidden" name="fields[490141_2]" id="utm_source" value="">
                           <input type="hidden" name="fields[475703_2]" id="roistat_visit" value="<?=array_key_exists('roistat_visit', $_COOKIE) ? $_COOKIE['roistat_visit'] : 'no_cookie'?>">


                           <div class="amoforms__fields__submit">
                               <div class="amoforms__submit-button__flex amoforms__submit-button__flex_center">

                                   <button class="amoforms__submit-button amoforms__submit-button_rounded  text-input js-form-changes-skip js-amoforms-font js-amoforms-field-height"
                                           type="submit" id="button_submit" style="color: #FFFFFF;
                background-color: #611f88;
                border-radius: 53px;
                                                ">
                                       <span class="amoforms__spinner-icon"></span>
                                       <span class="amoforms__submit-button-text"><?= Yii::t('app', 'Отправить запрос') ?></span>
                                   </button>
                               </div>

                                 </div>
                           <div id="amoforms__fields__error-required"></div>
                           <div id="amoforms__fields__error-typo"></div>
                           <input type="hidden" id="amoform_iframe_lang" value="en">
                           <input type="hidden" id="amoform_modal_button_color" value="#FFFFFF">
                           <input type="hidden" id="amoform_modal_button_bg_color" value="#FF597C">
                           <input type="hidden" id="amoform_modal_button_text" value="Заполнить форму">
                           <input type="hidden" id="amoform_display" value="Y">
                           <input id="visitor_uid" type="hidden" name="visitor_uid"
                                  value="bbbab82b-3bfe-499d-94e4-80f88b4afd81"></form> <!-- /amoform-form -->
                   </div>


               </div>
           </div>
        </div>
        <script>
            function ready() {
                $(function () {
                    $('#amoforms_form').submit(function (e) {

                        $("#button_submit").prop('disabled', true)
                        var request = $.ajax({
                            type: 'POST',
                            url: '/order/ajax-lead',
                            data: $(this).serialize(),
                            success: function(data){
                                if (data['error'] !== null){
                                    var s = 0;
                                    document.getElementById("button_submit").insertAdjacentHTML('afterend','<div id="message" class="amoforms-sended-message" style=" inset: -1px; z-index: 25;"><div class="amoforms-sended-message_wrapper"><div class="amoforms-sended-message_inner error-message"><div class="amoforms-sended-message_icon"></div><div class="amoforms-sended-message_error"></div><div class="amoforms-sended-message_text">' +
                                        '<?= Yii::t('app', 'Произошла ошибка') ?>' +
                                        '</div></div></div></div>')
                                    var n = document.getElementById("message");
                                    setTimeout(function () {s = 1, (n.style.opacity = s)}, 10)
                                    setTimeout(function () {s = 0, (n.style.opacity = s)}, 6000)


                                }else{
                                    var s = 0;
                                    document.getElementById("button_submit").insertAdjacentHTML('afterend','<div id="message" class="amoforms-sended-message" style=" inset: -1px; z-index: 25;"><div class="amoforms-sended-message_wrapper"><div class="amoforms-sended-message_inner"><div class="amoforms-sended-message_icon"></div><div class="amoforms-sended-message_error"></div><div class="amoforms-sended-message_text">' +
                                        '<?= Yii::t('app', 'Спасибо за ваш запрос, ваш личный академический координатор свяжется с вами в течение 24 часов.') ?>' +
                                        '</div></div></div></div>')
                                    var n = document.getElementById("message");
                                    setTimeout(function () {s = 1, (n.style.opacity = s)}, 10)
                                    setTimeout(function () {s = 0, (n.style.opacity = s)}, 6000)
                                }

                            },
                            error: function (jqXHR) {
                                var s = 0;
                                document.getElementById("button_submit").insertAdjacentHTML('afterend','<div id="message" class="amoforms-sended-message" style=" inset: -1px; z-index: 25;"><div class="amoforms-sended-message_wrapper"><div class="amoforms-sended-message_inner error-message"><div class="amoforms-sended-message_icon"></div><div class="amoforms-sended-message_error"></div><div class="amoforms-sended-message_text">' +
                                    '<?= Yii::t('app', 'Произошла ошибка') ?>' +
                                    '</div></div></div></div>')
                                var n = document.getElementById("message");
                                setTimeout(function () {s = 1, (n.style.opacity = s)}, 10)
                                setTimeout(function () {s = 0, (n.style.opacity = s)}, 2000)
                            }
                        });
                    });
                })
            };
            document.addEventListener("DOMContentLoaded", ready);
        </script>


        <style>
            .page-banner-container {
                background-size: cover;
                display: flex;
                justify-content: center;
                padding: 100px 0;
            }

            .page-banner-left {
                width: 40%;
                display: flex;
                flex-direction: column;
            }

            .page-banner-right {
                height: 511px;
                min-width: 420px;
            }

            .page-banner-header {
                font-size: 40px;
                color: #fff;
                font-weight: bold;
            }

            .page-banner-text {
                font-size: 40px;
                color: #fff;
                max-width: 680px;
            }

            @media (max-width: 1460px) {
                .page-banner-header {
                    font-size: 35px;

                }

                .page-banner-text {
                    font-size: 35px;

                    max-width: 480px;
                }
            }

            @media (max-width: 768px) {
                .page-banner-container {
                    flex-direction: column;
                }

                .page-banner-left {
                    width: 100%;
                    padding: 0 20px 0 20px;
                }

                .page-banner-right {
                    display: flex;
                    min-width: auto;
                    justify-content: center;

                }
            }

        </style>

        <!--<img src="<?/*= $imageUrl*/?>" class="page-banner__image" alt="Language Courses"/>-->
    </div>
<?php endif ?>
<?php if($page->before_content): ?>
    <div class="page-before-content">
        <div class="container">
            <?= $page->before_content?>
        </div>
    </div>
<?php endif ?>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
<?php if (Yii::$app->request->pathInfo != ''): ?>
                <h1><?= $page->name ?></h1>
<?php endif ?>

<?php if($page->aside): ?>
                <div class="col-md-9">
                    <?= $page->content ?>
                </div>
                <div class="col-md-3">

                <?
                    $page1 = Page::find()->select(['id', 'parent_id', 'name', 'alias', 'active'])
                        ->where(
                            'alias <> "/" AND language_id=:language_id AND active=1',
                            [':language_id'=> Language::getCurrent()->id]
                        )
                        ->asArray()->all();
                    $menu = Page::TreeMenu($page1, Language::getCurrent()->alias);

                    $menuItems = $menu[1]['items'][2]['items'][1]['items'];


                    if ( substr($menu[1]['items'][2]['items'][1]['url'], 4) == 'courses/russian-language/russian-language-for-children'){
                        foreach ($menuItems as $item) {

                            echo('<a class="list-group-item" href="' . $item['url'] . '">' . $item['label'] . '</a>');
                        }
                    }?>

                <?= $page->aside ?>
                </div>

<?php else: ?>
                <?= $page->content ?>
<?php endif ?>

<?php if($catalog_section && false): ?>
                <div class="catalog-section">
                    <div class="container">
                        <table class="table table-striped table-bordered">
<?php if($catalog_section['title_service'] || $catalog_section['title_price']): ?>
                            <thead><tr>
                                <th><?= $catalog_section['title_service']?></th>
                                <th><?= $catalog_section['title_price']?></th>
                                <th></th>
                            </tr></thead>
<?php endif ?>
                            <tbody>
<?php foreach($catalog_section['services'] as $service): ?>
                                <tr>
                                    <td><?= $service['name'] ?></td>
                                    <td><?= $service['price'] ?> AED</td>
                                    <td><button class="btn btn-primary"><?= Yii::t('app', 'Заказать') ?></button></td>
                                </tr>
<?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
<?php endif ?>

<?php if($schedule): ?>
                <div class="catalog-section">
                    <div class="container">
                        <table class="table table-striped table-bordered">
                            <thead><tr>
                                <th><?= Yii::t('app', 'Уровень')?></th>
                                <th><?= Yii::t('app', 'Дата начала')?></th>
                                <th><?= Yii::t('app', 'Расписание')?></th>
                                <th><?= Yii::t('app', 'Цена')?></th>
                                <th></th>
                            </tr></thead>
                            <tbody>
<?php foreach($schedule as $record): ?>
                                <tr>
                                    <td><?= $record['level']?></td>
                                    <td><?= $record['start_dates']?></td>
                                    <td><?= $record['schedule']?></td>
                                    <td><?= $record['price']?> AED</td>
                                    <td>
                                        <a href="<?= Url::toRoute(
                                            ['order/create', 'class'=>$record['id']]
                                        ) ?>" class="btn btn-primary"><?= Yii::t('app', 'Заказать')?></a>
                                    </td>
                                </tr>
<?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
<?php endif ?>

<?php if($page->after_content): ?>
                <div class="page-after-content">
                    <div class="container">
                        <?= $page->after_content?>
                    </div>
                </div>
<?php endif ?>

<?php if($isMainPage): ?>
                <div class="narrow_row">
                    <div class="index_news">
                        <?= IndexNewsWidget::widget() ?>
                    </div>
                    <div class="index_reviews">
                        <?= IndexReviewsWidget::widget() ?>
                    </div>
                </div>
<?php endif ?>

<?php if($page->show_feedback_form == 1): ?>
                <div class="col-md-9">
                    <?= FeedbackWidget::widget() ?>
                </div>
<?php endif ?>

            </div>
        </div>
    </div>
</section>
