<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Language;
use app\widgets\SimpleCallbackFormWidget;
use app\widgets\SimpleOrderFormWidget;
use app\widgets\SimpleCouponFormWidget;
//css
$this->registerCssFile('/russian/css/normalize.css');
$this->registerCssFile('/russian/css/webflow.css');
$this->registerCssFile('/russian/css/headway-school.webflow.css');

//Js


/** @var $page \yii\db\ActiveRecord */
$this->title = $page->meta_title;
$this->registerMetaTag(['name' => 'description', 'content' => $page->meta_description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page->meta_keywords]);

$this->params['breadcrumbs'] = $page->getPath();

$lang = Language::getCurrent();

?>



<meta content="width=device-width, initial-scale=1" name="viewport">
<meta content="Webflow" name="generator">


<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
<script type="text/javascript">WebFont.load({  google: {    families: ["Roboto:100,300,regular,500,700,900:latin,cyrillic-ext"]  }});</script>
<!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
<script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
<link href="/russian/images/favicon.ico" rel="shortcut icon" type="image/x-icon">
<link href="/russian/images/webclip.png" rel="apple-touch-icon">
<style>
    @media screen and (min-width: 1200px) {
        .w-container {
            max-width: 1170px; }
    }
    input, textarea {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none; border-radius: 0; }
    body{
        -webkit-font-smoothing: antialiased;
        text-rendering: optimizeLegibility;
    }
</style>
<link rel="stylesheet" href="/owl/owl.carousel.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<style>
    .owl-theme .owl-nav {
        margin-top: 10px!important;
        right: 60px!important;
        bottom: 514px!important;
        text-align: right!important;
        -webkit-tap-highlight-color: transparent;
        position: relative!important;
        font-family: 'Essential icons', sans-serif;
        font-size: 18px;
        color: #fff;
        opacity: 0.68;
        -webkit-transition: all 200ms ease;
        transition: all 200ms ease;
    }
    .owl-theme .owl-nav:hover {
        opacity: 1;
    }
    .owl-carousel .owl-stage-outer {
        position: relative;
        overflow: visible;
    }
    .owl-theme .owl-nav {
        margin-top: 10px;
        text-align: center;
        -webkit-tap-highlight-color: transparent; }
    .owl-theme .owl-nav [class*='owl-'] {
        color: #FFF;
        font-size: 35px;
        margin: 5px;
        padding: 4px 0px;
        /*background-color: #D6D6D6;*/
        display: inline-block;
        cursor: pointer;
        border-radius: 3px; }
    .owl-theme .owl-nav [class*='owl-']:hover {
        /*background: #869791;*/
        color: #FFF;
        text-decoration: none; }
    .owl-theme .owl-nav .disabled {
        opacity: 0.5;
        cursor: default; }
    .owl-theme .owl-nav.disabled + .owl-dots {
        margin-top: 10px; }
    .owl-theme .owl-dots {
        text-align: center;
        -webkit-tap-highlight-color: transparent; }
    .owl-theme .owl-dots .owl-dot {
        display: inline-block;
        position: relative !important;
        top: -10px !important;
        left: 7% !important;
        zoom: 0.6;
        *display: inline; }
    .owl-theme .owl-dots .owl-dot span {
        width: 10px;
        height: 10px;
        bottom: 10px;
        margin: 8px 13px;
        background: #C4C4C4;
        display: block;
        -webkit-backface-visibility: visible;
        transition: opacity 200ms ease;
        border-radius: 30px; }
    .owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span {
        background: #E21B06; }
    .owl-theme .owl-nav.disabled + .owl-dots {
        margin-top: 30px!important;
    }
    @media only screen and (max-width: 600px) {
        .owl-theme .owl-dots .owl-dot {
            left: 0% !important;  }
    }
</style>




<div class="body">

    <div data-ix="close-form-join-body" class="close_form2"></div>
    <div class="slide_down_div w-hidden-small w-hidden-tiny"><img src="/russian/images/arrow.svg" width="24" data-ix="arrowdown" alt="" class="slidedown"></div>

    <?= SimpleOrderFormWidget::widget(['selectedCourse' => $page->name.' Free Class']) ?>

    <?= SimpleCouponFormWidget::widget(['type'=>'2','course'=>$page->name]) ?>

    <?= SimpleCallbackFormWidget::widget() ?>

    <?= SimpleOrderFormWidget::widget(['selectedCourse' => $page->name.' Choose Course']) ?>



    <div class="main_wrapper">
        <div data-ix="show-bar" class="russian-sec">
            <div class="russian-container w-container" data-ix="appear">
                <h1 class="russian-h1"><?=Yii::t('app','Russian language course for kids') ?>
                <p class="russian-paragraph"><?=Yii::t('app','The program is a perfect choice for native or bilingual Russian speaking children. It covers the essentials of kindergarten schooling and includes Language and Literature, Drawing, Arts and Crafts.')?></p>
                <div class="russian-link" data-ix="link-hero">
                    <div class="russian-link__line"></div><a href="#r-benefits" class="link" data-ix="link-hero"><?=Yii::t('app','Learn more')?></a></div>
            </div>
        </div>
        <section data-ix="show-bar" id="r-benefits" class="russian-sec2">
            <div class="russian-container2 w-container">
                <div class="russian-container2__cont2">
                    <div class="russian-container2__wrap">
                        <div class="russian-benefits__2screen" data-ix="black-benefits"><?=Yii::t('app','Native') ?></div>
                        <div class="russian-benefits__2screen__red" data-ix="red-benefits"><?=Yii::t('app','Speakers') ?></div>
                    </div>
                    <div class="russian-container2__wrap">
                        <div class="russian-benefits__2screen _2" data-ix="black-benefits"><?=Yii::t('app','Authentic')?></div>
                        <div class="russian-benefits__2screen__red" data-ix="red-benefits"><?=Yii::t('app','Materials')?></div>
                    </div>
                    <div class="russian-container2__wrap">
                        <div class="russian-benefits__2screen" data-ix="black-benefits"><?=Yii::t('app','Free introductory')?></div>
                        <div class="russian-benefits__2screen__red" data-ix="red-benefits"><?=Yii::t('app','Class')?></div>
                    </div>
                </div>
            </div>
        </section>
        <div data-ix="show-bar" class="russian-sec3">
            <div class="russian-container3 w-container">
                <div class="russian-container3__wrap">
                    <p class="paragraph" data-ix="appear"><?=Yii::t('app','Primary and secondary school children can cover the basics of the Russian school program with Russian Language and Literature classes, celebrate national holidays and gain other insights into the traditional Russian culture')?></p>
                </div><img src="/russian/images/3-1.jpg" width="443" srcset="/russian/images/3-1-p-500.jpeg 500w, /russian/images/3-1-p-800.jpeg 800w, /russian/images/3-1.jpg 886w" sizes="(max-width: 479px) 190px, (max-width: 767px) 47vw, (max-width: 991px) 291.1875px, 443px" alt="" class="_3-1"></div>
            <div class="russian-container3__wrap2">
                <div class="sec3-benef__wrap">
                    <div class="div-block-3"></div>
                    <div class="container-russian w-container">
                        <p class="paragraph white" data-ix="appear"><?=Yii::t('app','Our course is run in specialized groups which depend upon skills, level and age of your child. Our dedicated native teachers offer all the necessary support in learning Russian, such as:')?></p>
                        <div class="paragraph-list-container">





                            <? if ($lang->alias == 'en'){ ?>
                                <div class="paragraph-list_item">
                                    <div class="paragraph-list_item-number">01</div>
                                    <div class="paragraph-list_item-text">Pre-schooling</div>
                                </div>
                                <div class="paragraph-list_item">
                                    <div class="paragraph-list_item-number">02</div>
                                    <div class="paragraph-list_item-text">School catch up sessions</div>
                                </div>
                                <div class="paragraph-list_item">
                                    <div class="paragraph-list_item-number">03</div>
                                    <div class="paragraph-list_item-text">Russion GSE / IB preparation</div>
                                </div>
                            <?}?>

                            <? if ($lang->alias == 'ru'){ ?>
                                <div class="paragraph-list_item">
                                    <div class="paragraph-list_item-number">01</div>
                                    <div class="paragraph-list_item-text">Дошкольная подготовка</div>
                                </div>
                                <div class="paragraph-list_item">
                                    <div class="paragraph-list_item-number">02</div>
                                    <div class="paragraph-list_item-text">Общеобразовательная программа обучения</div>
                                </div>
                                <div class="paragraph-list_item">
                                    <div class="paragraph-list_item-number">03</div>
                                    <div class="paragraph-list_item-text">Подготовка к IGCSE / IB экзаменам</div>
                                </div>

                            <?}?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div data-ix="show-bar" class="russian-sec4">
            <div class="russian-container4 w-container">
                <div class="russian-container4__cont4">
                    <div class="div-block-2">
                        <p class="paragraph sec4"><?=Yii::t('app','Our key feature to help our students to advance is to create the appropriate conditions for acquisition. A child benefits from')?><br></p>
                    </div>
                    <div class="sec4-benef__wrap">

                        <? if ($lang->alias == 'en'){ ?>
                            <p class="sec4-benefits" data-ix="appear">Visual aids</p>
                            <p class="sec4-benefits" data-ix="appear">Physical and creative activity</p>
                            <p class="sec4-benefits" data-ix="appear">Accessible material</p>
                            <p class="sec4-benefits" data-ix="appear">Nurturing environment</p>
                        <?}?>

                        <? if ($lang->alias == 'ru'){ ?>
                            <p class="sec4-benefits" data-ix="appear">Наглядные пособия</p>
                            <p class="sec4-benefits" data-ix="appear">Физическая активность</p>
                            <p class="sec4-benefits" data-ix="appear">Творческие занятия</p>
                            <p class="sec4-benefits" data-ix="appear">Учебные материалы</p>
                            <p class="sec4-benefits" data-ix="appear">Дружеская атмосфера</p>
                        <?}?>

                    </div>
                </div>
            </div>
        </div>
        <div data-ix="show-bar" class="russian-sec5">
            <div class="russian-container5 w-container"><img src="/russian/images/5-1.jpg" width="1137" srcset="/russian/images/5-1-p-500.jpeg 500w, /russian/images/5-1-p-800.jpeg 800w, /russian/images/5-1-p-1080.jpeg 1080w, /russian/images/5-1-p-2000.jpeg 2000w, /russian/images/5-1.jpg 2274w" sizes="(max-width: 479px) 100vw, (max-width: 767px) 87vw, (max-width: 991px) 688px, 940px" alt="" class="image">
                <div class="russian-container5__wrap2">
                    <div class="div-block-2 sec5">
                        <p class="paragraph sec5"><?=Yii::t('app','At Headway Institute we pride ourselves on our proven and tested methodology when working with young learners.')?><br></p>
                    </div>
                    <div class="sec5-benef__wrap">
                        <p class="paragraph sec5_2" data-ix="appear"><?=Yii::t('app','Our approach to teaching is based on a multi-sensory strategy in which our curriculum utilises early childhood themes. In the group class each child will learn how to speak, read and think in the language. Folk stories, fairy tales, and literature will enhance their development in a fully immersive setting. For our older students, your teacher will focus on broader concepts, and place emphasis on your ability to write, and develop good grammar.')?><br></p>
                    </div>
                </div>
            </div>
        </div>
        <div data-ix="show-bar" class="russian-sec7">
            <div class="russian-container7__wrapper">
                <div class="owl-carousel owl-theme">
                    <div class="owl-slider-item _1"><img src="/russian/images/6-1.jpg" width="558" srcset="/russian/images/6-1-p-500.jpeg 500w, /russian/images/6-1-p-1080.jpeg 1080w, /russian/images/6-1.jpg 1116w" sizes="(max-width: 479px) 84vw, (max-width: 767px) 82vw, 558px" alt="" class="image-13"></div>
                    <div class="owl-slider-item"><img src="/russian/images/6-2.jpg" width="558" srcset="/russian/images/6-2-p-500.jpeg 500w, /russian/images/6-2-p-1080.jpeg 1080w, /russian/images/6-2.jpg 1116w" sizes="(max-width: 479px) 84vw, (max-width: 767px) 82vw, 558px" alt="" class="image-13"></div>
                    <div class="owl-slider-item"><img src="/russian/images/6-3.jpg" width="557.5" srcset="/russian/images/6-3-p-500.jpeg 500w, /russian/images/6-3-p-1080.jpeg 1080w, /russian/images/6-3.jpg 1116w" sizes="(max-width: 479px) 84vw, (max-width: 767px) 82vw, 557.5px" alt="" class="image-13"></div>
                    <div class="owl-slider-item"><img src="/russian/images/6-4.jpg" width="557.5" srcset="/russian/images/6-4.jpg 500w, /russian/images/6-4.jpg 1080w, /russian/images/6-4.jpg 1116w" sizes="(max-width: 479px) 84vw, (max-width: 767px) 82vw, 557.5px" alt="" class="image-13"></div>
                    <div class="owl-slider-item"><img src="/russian/images/6-5.jpg" width="557.5" srcset="/russian/images/6-5.jpg 500w, /russian/images/6-5.jpg 1080w, /russian/images/6-5.jpg 1116w" sizes="(max-width: 479px) 84vw, (max-width: 767px) 82vw, 557.5px" alt="" class="image-13"></div>
                    <div class="owl-slider-item"><img src="/russian/images/6-6.jpg" width="557.5" srcset="/russian/images/6-6.jpg 500w, /russian/images/6-6.jpg 1080w, /russian/images/6-6.jpg 1116w" sizes="(max-width: 479px) 84vw, (max-width: 767px) 82vw, 557.5px" alt="" class="image-13"></div>
                    <div class="owl-slider-item"><img src="/russian/images/6-7.jpg" width="557.5" srcset="/russian/images/6-7.jpg 500w, /russian/images/6-7.jpg 1080w, /russian/images/6-7.jpg 1116w" sizes="(max-width: 479px) 84vw, (max-width: 767px) 82vw, 557.5px" alt="" class="image-13"></div>
                    <div class="owl-slider-item"><img src="/russian/images/6-8.jpg" width="557.5" srcset="/russian/images/6-8.jpg 500w, /russian/images/6-8.jpg 1080w, /russian/images/6-8.jpg 1116w" sizes="(max-width: 479px) 84vw, (max-width: 767px) 82vw, 557.5px" alt="" class="image-13"></div>
                    <div class="owl-slider-item"><img src="/russian/images/6-9.jpg" width="557.5" srcset="/russian/images/6-9.jpg 500w, /russian/images/6-9.jpg 1080w, /russian/images/6-9.jpg 1116w" sizes="(max-width: 479px) 84vw, (max-width: 767px) 82vw, 557.5px" alt="" class="image-13"></div>
                </div>
            </div>
        </div>
        <div data-ix="show-bar" class="russian-sec6">
            <div class="russian-container6 w-container">
                <h1 class="russian-h2"><?=Yii::t('app','We offer group courses and individual classes')?></h1>
                <div class="russian-container6__wrapper">
                    <div class="russian-container6__wrapper__div" data-ix="appear">
                        <div class="russian-h3"><?=Yii::t('app','Group courses')?></div>
                    </div>
                    <div class="russian-container6__wrapper__div div2" data-ix="appear">
                        <div class="russian-h3"><?=Yii::t('app','Individual classes')?></div>
                    </div>
                </div>
            </div>
        </div>
        <div data-ix="show-bar" class="russian-sec5">
            <div class="russian-container6_2 w-container">
                <div class="russian-container5__wrap2">
                    <div class="div-block-2 sec6_2">
                        <p class="paragraph sec6_2"><?=Yii::t('app','Advantages of studying at Headway Institute')?><br></p>
                    </div>
                    <div class="sec5-benef__wrap sec6_2">
                        <p class="paragraph smalltext" data-ix="appear"><?=Yii::t('app','Our curriculum is based on the classical teaching methods complying with the Russian Federation Standards of Education. In class we use authentic school books and classical literature for children (preschoolers). Our teaching processes are carried out by certified primary school professionals from Russia. Classes involve entertaining activities and cultivate love and understanding of the culture. We organize children&#x27;s matinees, contests and theatrical performances. Children will also learn about traditional handicraft.')?><br></p>
                    </div>
                </div>
            </div>
        </div>
        <div data-ix="show-bar" class="russian-sec8">
            <div class="russian-container8 w-container">
                <h1 class="russian-h3-2" data-ix="appear"><?=Yii::t('app','Select suitable type of Russian course')?></h1>
                <div class="r-select-wrapper" data-ix="appear">
                    <div tabindex="2" class="container8__item _1">
                        <div class="container8__item-text"><?=Yii::t('app','for Native speakers')?></div>
                    </div>
                    <div tabindex="3" class="container8__item _2">
                        <div class="container8__item-text _3"><?=Yii::t('app','for Billinguals')?></div>
                    </div>
                    <div tabindex="1" class="container8__item _3">
                        <div class="container8__item-text"><?=Yii::t('app','as a foreign language')?></div>
                    </div>
                </div>
                <h1 class="russian-h3-2" data-ix="appear"><?=Yii::t('app','I am...')?></h1>
                <div class="r-select-wrapper" data-ix="appear">
                    <div tabindex="1" class="container8__item block2">
                        <div class="container8__item-text"><?=Yii::t('app','Starting from zero')?></div>
                    </div>
                    <div tabindex="2" class="container8__item block2 last">
                        <div class="container8__item-text _2"><?=Yii::t('app','Studied language before')?></div>
                    </div>
                </div>
            </div>
        </div>


        <div data-ix="show-bar" class="russian-sec9">
            <div class="russian-container9 w-container">
                <h1 class="russian-h3-2" data-ix="appear"><?=Yii::t('app','Choose the best option')?></h1>
                <div class="r-price-green-wrapper" data-ix="appear">
                    <div class="r-price-heading_container">
                        <h1 class="r-price-heading_h3"><?=Yii::t('app','Group course')?></h1>
                        <div class="r-price-green-heading_number">4-10 <?=Yii::t('app','kids')?></div><a href="#" class="r-price-heading_bttn w-button" data-ix="show-modal-join"><?=Yii::t('app','Choose course')?></a></div>
                    <div class="r-price-heading_container-raw">
                        <div class="r-price-heading_container-col">
                            <div class="r-price-heading_container-item">
                                <div class="text-block-22"><?=Yii::t('app','Pay monthly online with a credit card (subscription)')?></div>
                            </div>
                            <div class="r-price-heading_container-item numbers price_group">
                                <div class="r-price-heading_container-item-col">
                                    <div class="r-price-number">420</div>
                                    <div class="r-price-descr"><?=Yii::t('app','for')?> 60 <?=Yii::t('app','min')?></div>
                                </div>
                                <div class="r-price-heading_container-item-col">
                                    <div class="r-price-number">550</div>
                                    <div class="r-price-descr"><?=Yii::t('app','for')?> 90 <?=Yii::t('app','min')?></div>
                                </div>
                                <div class="r-price-heading_container-item-col last">
                                    <div class="r-price-number">600</div>
                                    <div class="r-price-descr"><?=Yii::t('app','for')?> 120 <?=Yii::t('app','min')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="r-price-heading_container-col">
                            <div class="r-price-heading_container-item">
                                <div class="text-block-22"><?=Yii::t('app','Pay monthly to a personal manager')?></div>
                            </div>
                            <div class="r-price-heading_container-item numbers price_group">
                                <div class="r-price-heading_container-item-col">
                                    <div class="r-price-number">460</div>
                                    <div class="r-price-descr"><?=Yii::t('app','for')?> 60 <?=Yii::t('app','min')?></div>
                                </div>
                                <div class="r-price-heading_container-item-col">
                                    <div class="r-price-number">605</div>
                                    <div class="r-price-descr"><?=Yii::t('app','for')?> 90 <?=Yii::t('app','min')?></div>
                                </div>
                                <div class="r-price-heading_container-item-col last">
                                    <div class="r-price-number">660</div>
                                    <div class="r-price-descr"><?=Yii::t('app','for')?> 120 <?=Yii::t('app','min')?></div>
                                </div>
                            </div>
                        </div>
                        <div class="r-price-heading_container-col">
                            <div class="r-price-heading_container-item">
                                <div class="text-block-22"><?=Yii::t('app','Pay per lesson to a personal manager')?></div>
                            </div>
                            <div class="r-price-heading_container-item numbers last price_group">
                                <div class="r-price-heading_container-item-col">
                                    <div class="r-price-number">150</div>
                                    <div class="r-price-descr"><?=Yii::t('app','for')?> 60 <?=Yii::t('app','min')?></div>
                                </div>
                                <div class="r-price-heading_container-item-col">
                                    <div class="r-price-number">165</div>
                                    <div class="r-price-descr"><?=Yii::t('app','for')?> 90 <?=Yii::t('app','min')?></div>
                                </div>
                                <div class="r-price-heading_container-item-col last">
                                    <div class="r-price-number">180</div>
                                    <div class="r-price-descr"><?=Yii::t('app','for')?> 120 <?=Yii::t('app','min')?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="r-price-row">
                    <div class="r-price-col">
                        <div class="r-price-wrapper orange" data-ix="appear">
                            <div class="r-price-heading_container orange">
                                <h1 class="r-price-heading_h3" style=""><?=Yii::t('app','Semi-private')?></h1>
                                <div class="r-price-green-heading_number">2-3 <?=Yii::t('app','kids')?></div><a href="#" class="r-price-heading_bttn orange w-button" data-ix="show-modal-join"><?=Yii::t('app','Choose course')?></a></div>
                            <div class="r-price-heading_container-raw">
                                <div class="r-price-heading_container-col _2nd">
                                    <div class="r-price-heading_container-item numbers last">
                                        <div class="r-price-heading_container-item-col">
                                            <div class="r-price-number">158</div>
                                            <div class="r-price-descr"><?=Yii::t('app','for')?> 60 <?=Yii::t('app','min')?></div>
                                        </div>
                                        <div class="r-price-heading_container-item-col">
                                            <div class="r-price-number">231</div>
                                            <div class="r-price-descr"><?=Yii::t('app','for')?> 90 <?=Yii::t('app','min')?></div>
                                        </div>
                                        <div class="r-price-heading_container-item-col">
                                            <div class="r-price-number">1580</div>
                                            <div class="r-price-descr _2line">10 <?=Yii::t('app','lessons')?>, 60 <?=Yii::t('app','minutes each')?></div>
                                        </div>
                                        <div class="r-price-heading_container-item-col last">
                                            <div class="r-price-number">2310</div>
                                            <div class="r-price-descr _2line">10 <?=Yii::t('app','lessons')?>, 90 <?=Yii::t('app','minutes each')?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="r-price-col last">
                        <div class="r-price-wrapper purple" data-ix="appear">
                            <div class="r-price-heading_container purple">
                                <h1 class="r-price-heading_h3"><?=Yii::t('app','Private')?></h1>
                                <div class="r-price-green-heading_number"><?=Yii::t('app','One on one')?></div><a href="#" class="r-price-heading_bttn purple w-button" data-ix="show-modal-join"><?=Yii::t('app','Choose course')?></a></div>
                            <div class="r-price-heading_container-raw">
                                <div class="r-price-heading_container-col _2nd">
                                    <div class="r-price-heading_container-item numbers last">
                                        <div class="r-price-heading_container-item-col">
                                            <div class="r-price-number">210</div>
                                            <div class="r-price-descr"><?=Yii::t('app','for')?> 60 <?=Yii::t('app','min')?></div>
                                        </div>
                                        <div class="r-price-heading_container-item-col">
                                            <div class="r-price-number">315</div>
                                            <div class="r-price-descr"><?=Yii::t('app','for')?> 90 <?=Yii::t('app','min')?></div>
                                        </div>
                                        <div class="r-price-heading_container-item-col">
                                            <div class="r-price-number">2100</div>
                                            <div class="r-price-descr _2line">10 <?=Yii::t('app','lessons')?>, 60 <?=Yii::t('app','minutes each')?></div>
                                        </div>
                                        <div class="r-price-heading_container-item-col last">
                                            <div class="r-price-number">3150</div>
                                            <div class="r-price-descr _2line">10 <?=Yii::t('app','lessons')?>, 90 <?=Yii::t('app','minutes each')?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <?php $scheds=$page->getSched(); //print_r($scheds);  ?>

        <section id="schedule" class="schedule_sec">
            <div class="schedule_cont w-container">
                <h1 class="h1 fees"><?= Yii::t('app', 'Расписание'); ?></h1>
                <div class="schedule_title_div">
                    <div class="course_title"><?= Yii::t('app', 'название курса'); ?></div>
                    <div class="duration"><?= Yii::t('app', 'длительность'); ?></div>
                    <div class="schedule"><?= Yii::t('app', 'график'); ?></div>
                    <div class="starting_date"><?= Yii::t('app', 'дата начала'); ?></div>
                    <div class="fee"><?= Yii::t('app', 'цена'); ?></div>
                    <div class="buy"><?= Yii::t('app', 'регистрация'); ?></div>
                </div>


                <?php foreach($scheds as $sched) :?>

                    <div class="schedule_item" data-ix="appear">
                        <?php if ($sched['price_discount']>0) :?>
                            <div class="course_title item"><?=$sched['course_name'] ?> <br><?=$sched['group_name'] ?>
                                <br><span class="text-span"><?=number_format(100-($sched['price_discount']/$sched['price_all']*100),0,'','')?>% <?=Yii::t('app','скидка')?></span>
                            </div>
                        <?php else :?>
                            <div class="course_title item"><?=$sched['course_name'] ?> <br><?=$sched['group_name'] ?></div>
                        <?php endif; ?>
                        <div class="duration item"><?=$sched['week'].' '.Yii::t('app','недель').', <br>'.$sched['academic_hour'].' '.Yii::t('app','а/ч*') ?></div>
                        <div class="item schedule"><?=$sched['schedule'] ?></div>
                        <div class="item starting_date"><?=$sched['start_date'] ?></div>
                        <?php if ($sched['price_discount']>0) : ?>
                            <div class="fee item discount">
                                <?=number_format($sched['price_discount'],0,'','') ?>AED
                                <br>
                                <span class="old-price"><?=number_format($sched['price_all'],0,'','') ?> AED</span>
                            </div>
                            <a class="blue button buy discount gray_outline item w-button" data-ix="show-modal-join" href="#" onclick="$('#priceJoin').val(<?=number_format($sched['price_discount'],0,'','') ?>);$('#idSchedule').val(<?= $sched['id'] ?>);$('#needPay').val(1);return true;"><?=Yii::t('app', '<span class="discount_sec-headline-arrow discount_sec-regline">$</span>') ?></a>
                        <?php else : ?>
                            <div class="fee item"><?=number_format($sched['price_all'],0,'','') ?> AED</div>
                            <a class="blue button buy gray_outline item w-button" data-ix="show-modal-join" href="#" onclick="$('#priceJoin').val(<?=number_format($sched['price_all'],0,'','') ?>);$('#idSchedule').val(<?= $sched['id'] ?>);$('#needPay').val(1);return true;"><?=Yii::t('app', '<span class="discount_sec-headline-arrow discount_sec-regline">$</span>') ?></a>
                        <?php endif; ?>

                    </div>


                <?php endforeach;?>



                <? if ($lang->alias == 'en'){ ?>
                <div class="text-block-26">NOTE:<br>
                    <strong>•</strong>  we require a minimum of 4 delegates to run a group course,<br>
                    <strong>•</strong>  full prepayment is required in advance,<br>
                    <strong>•</strong>  you can settle your payment in cash, by cheque or credit card,<br>
                    <strong>•</strong>  full terms and conditions can be found
                    <a href="https://headin.pro/en/about/terms_and_conditions" target="_blank" class="link-3">here</a><br>
                </div>
                <?}?>



                <? if ($lang->alias == 'ru'){ ?>
                    <div class="text-block-26">ПРИМЕЧАНИЕ:<br>
                        <strong>•</strong>  минимальное количество человек в группе - 4,<br>
                        <strong>•</strong>  регистрация на курс считается состоявшейся только по факту оплаты полной стоимости курса,<br>
                        <strong>•</strong>  оплата может быть произведена наличными, чеком или банковской картой,<br>
                        <strong>•</strong>  1 академический час = 45 мин.
                        <!--<a href="https://headin.pro/en/about/terms_and_conditions" target="_blank" class="link-3">here</a><br>-->
                    </div>
                <?}?>



                <h1 class="h1 schedule2"><?=Yii::t('app', 'Russian language for kids. Schedule for 2020 academic year')?></h1>
                <div class="r-scheduleterms-wr">
                    <div class="r-scheduleterms-col" data-ix="appear">
                        <div class="r-scheduleterms-caption"><?=Yii::t('app', 'THE First term')?></div>
                        <div class="r-scheduleterms-item"><?=Yii::t('app', 'Saturday`s school will start on 7th September 2019')?></div>
                        <div class="r-scheduleterms-item"><?=Yii::t('app', 'The duration of the first term 7th September — 21th December 2019')?></div>
                        <div class="r-scheduleterms-item last"><?=Yii::t('app', 'New Year Party 13th December 2019')?></div>
                    </div>
                    <div class="r-scheduleterms-col" data-ix="appear">
                        <div class="r-scheduleterms-caption"><?=Yii::t('app', 'THE SECOND TERM')?></div>
                        <div class="r-scheduleterms-item"><?=Yii::t('app', 'The second term will start on 11th January 2020')?></div>
                        <div class="r-scheduleterms-item"><?=Yii::t('app', 'The duration of the second term 11th January — 27th June 2020')?></div>
                        <div class="r-scheduleterms-item last"><?=Yii::t('app', 'End of the school year Party TBA')?></div>
                    </div>
                    <div class="r-scheduleterms-col last" data-ix="appear">
                        <div class="r-scheduleterms-caption"><?=Yii::t('app', 'THE LAST CLASS')?></div>
                        <div class="r-scheduleterms-item last"><?=Yii::t('app', 'The last class 27th June 2020')?></div>
                    </div>
                </div>
            </div>
        </section>
        <section id="reviews" class="also_sec">
            <div class="logos_cont w-container">
                <div class="russian-container5__wrap2 logos">
                    <div class="div-block-2 sec6_2">
                        <p class="paragraph sec6_2"><?=Yii::t('app', 'We are running classes in several international schools in Dubai')?><br></p>
                    </div>
                    <div class="sec5-benef__wrap sec6_2">
                        <p class="paragraph smalltext logos" data-ix="appear"><?=Yii::t('app', 'Headway Institute also offers an excellent opportunity to provide language classes to schools. Our course can be integrated into the school curriculum, or as an extracurricular activity. Our course for the schoolchildren will be set at your school, and taught by experienced native-speaking Russian tutors qualified to Master’s and PhD level in linguistics and language teaching. We are running classes in several international schools in Dubai. Please contact us if you would like us to arrange a course in your school.')?><br></p>
                    </div>
                </div>
                <div class="owl-carousel owl-theme logos">


                    <?
                    $landingSliders = (new \app\models\LandingSlider())->find()->orderBy('sort')->all();
                     foreach ($landingSliders as $landingSlider){
                         ?>
                         <div class="owl-slider-item _1 logos">
                             <a href="<?=$landingSlider->href ?>">
                                 <div class="sunmarkle-cont"><img src="/slider/<?=$landingSlider->img ?>" width="218" alt="" class="r-logo"></div>
                             </a>
                              </div>

                         <?
                     }

                    ?>



                </div>
            </div>
        </section>
        <section id="reviews" class="reviews_sec">
            <div class="reviews_cont w-container">
                <div class="children-lead_reviews"><?=$page->after_content ?></div>
                <div class="columns w-row">

                    <?php
                    //$reviews=$page->getPageReview($lang->id);
                    $reviews = $page->items;

                    foreach($reviews as $review) {
                        if ($review->language_id == $lang->id){
                    ?>
                    <div class="review_row w-col w-col-4">
                        <div class="reviews_div" data-ix="appear"><img src="/russian/images/quote_1.svg" alt="" class="quote">
                            <div class="text-block-23"><?=$review->text ?></div>
                            <div class="author"><?=$review->name.', '.$review->date ?></div>
                            <img src="/russian/images/stars.svg" alt="" class="stars">
                        </div>
                    </div>

                    <?} }?>


                </div>
            </div>



        </section>
        <section id="reviews" class="allcourses-sec">
            <div class="allcourses__right"></div>
            <div class="container-2 w-container">
                <div class="allcourses__left">
                    <div class="children-allcourses-head"><?=Yii::t('app', 'All Russian Courses')?><br></div>
                    <?=$page->hrefs ?>
                </div>
            </div>
        </section>
    </div>
    <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.4.1.min.220afd743d.js" type="text/javascript" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="/russian/js/webflow.js" type="text/javascript"></script>
    <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



</div>

<?
/*$this->registerJsFile('/owl/jquery.min.js', ['position' => \yii\web\View::POS_END]);*/
$this->registerJsFile('/owl/owl.carousel.min.js', ['position' => \yii\web\View::POS_END, 'defer' => true]);
?>

<script>
    $(document).ready(function() {
        $('.callback_button').click(function() {
            $('body').css('overflow', 'hidden');
        });
        $('.close_form, .close_form2').click(function() {
            $('body').css('overflow', 'auto');
            $('.close_form2').css('display', 'none');
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.fees_row').click(function() {
            $('body').css('overflow', 'hidden');
        });
        $('.close_form, .close_form2').click(function() {
            $('body').css('overflow', 'auto');
            $('.close_form2').css('display', 'none');
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(window).on('load', (function () {
            $('.owl-carousel').owlCarousel({
                margin: 0,
                /*loop:true,*/
                autoWidth: true,
                navText: ["l", "r"],
                items: 3,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    990: {
                        nav: true,
                    }
                }
            })
        }));
    })
</script>
