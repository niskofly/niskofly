<?php

use yii\helpers\Url;
use app\models\Language;
use app\widgets\SimpleCallbackFormWidget;
use app\widgets\SimpleOrderFormWidget;

//css
$this->registerCssFile('/css/page/normalize.css');
$this->registerCssFile('/css/page/webflow.css');
$this->registerCssFile('/css/page/headway-toefl-ielts.webflow.css');

//Js
$this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js',
    ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/page/webflow.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/page/modernizr.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/page/page.js', ['position' => \yii\web\View::POS_END]);
//$this->registerJsFile('/js/page/changePrice.js', ['position' => \yii\web\View::POS_END]);


/** @var $page \yii\db\ActiveRecord */
$this->title = $page->meta_title;
$this->registerMetaTag(['name' => 'description', 'content' => $page->meta_description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page->meta_keywords]);

$this->params['breadcrumbs'] = $page->getPath();

$lang = Language::getCurrent();

?>

<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
<script type="text/javascript">
    WebFont.load({
        google: {
            families: ["Roboto:100,300,regular,500,700,900:latin,cyrillic-ext"]
        }
    });
</script>
<div class="body">
    <div class="close_form2" data-ix="close-form-join-body"></div>
    <div class="slide_down_div w-hidden-small w-hidden-tiny">
        <img class="slidedown" data-ix="arrowdown" src="/images/page/arrow.svg" width="24">
    </div>

    <?= SimpleCallbackFormWidget::widget() ?>

    <?= SimpleOrderFormWidget::widget(['selectedCourse' => 'English Language / TOEFL / IELTS']) ?>


    <div class="navibar">
        <div class="navibar_row w-row">
            <div class="_1 navibar_column w-col w-col-4 w-col-small-4"><img src="/images/page/logo_bar.png" width="121">
                <a class="callback_button w-button w-hidden-main w-hidden-medium w-hidden-small"
                   data-ix="show-modal-callback" href="#"></a>
            </div>
            <div class="_2 navibar_column w-col w-col-4 w-col-small-4">
                <a class="blue button navib w-button" href="#Fees"><?= Yii::t('app', 'Регистрируйся на IELTS'); ?></a>
                <a class="button navib w-button" href="#Fees"><?= Yii::t('app', 'Регистрируйся на TOEFL'); ?></a>
            </div>
            <div class="_3 navibar_column w-col w-col-4 w-col-small-4">
                <div class="tel_number hidden-sm"><?= Yii::t('app', 'позвоните нам'); ?> &nbsp;+ 971 <strong>4 362 53
                        13</strong>
                </div>
                <a class="callback_button w-button" data-ix="show-modal-callback" href="#"></a>
            </div>
        </div>
    </div>

    <div class="main_wrapper">

        <div class="hero_sec" data-ix="show-bar">
            <div class="hero_cont w-container">
                <?= $page->before_content; ?>
            </div>
        </div>
        <div class="benefits_sec">
            <div class="benefits_cont w-container">
                <div class="w-row">
                    <?= $this->render("toefl_ielts/service", ['lang' => $lang]); ?>
                </div>
            </div>
            <p style="clear: both;">&nbsp;</p>
            <a class="benefits button gray_outline red w-button" href="#Fees"><span class="icon_cta"></span>
                <?= Yii::t('app', 'Цены на курсы') ?></a>
        </div>

        <div class="accredit_sec">
            <div class="accredit_head"><?= $page->content; ?></div>
            <div class="accredit_ribbon">

                <img data-ix="british-council" sizes="(max-width: 479px) 100vw, 253px"
                     src="/images/page/brit_coun.png"
                     srcset="/images/page/brit_coun-p-500x546.png 500w, /images/page/brit_coun.png 506w"
                     width="253">
            </div>
        </div>
        <div class="ielts_sec">
            <div class="ielts_cont w-container">
                <div class="head_span w-clearfix" style="white-space: nowrap;">
                    <div class="h1"><?= Yii::t('app', 'Что такое'); ?>
                        <img class="ielts" src="/images/page/ielts.png" width="118"> ?</div>
                </div>
                <div class="ielts lead"><?= $page->aside; ?></div>

                <?= $this->render("toefl_ielts/ielts_circles", ['lang' => $lang]); ?>
            </div>
        </div>
        <div class="toefl_sec">
            <?= $this->render("toefl_ielts/toefl_sec", ['lang' => $lang]); ?>
        </div>
        <div class="speaker_sec">
            <div class="speaker_cont w-container">
                <?= $page->after_content; ?>
            </div>
        </div>
        <section class="fees_sec" id="Fees">
            <div class="fees_cont w-container">
                <?= $this->render("toefl_ielts/course", ['lang' => $lang]); ?>
            </div>
        </section>
        <section class="reviews_sec" id="reviews">
            <div class="reviews_cont w-container">
                <div class="lead_reviews">
                    <?php if ($lang->alias == 'en'): ?>
                        Our exam preparation programmes are lead by experienced teachers who will equip
                        you with the necessary skills and strategies to succeed
                    <?php endif; ?>
                    <?php if ($lang->alias == 'ru'): ?>
                        Профессиональные преподаватели Headway Institute подготовят
                        Вас к успешному прохождению квалификационных тестов.
                    <?php endif; ?>
                </div>
                <div class="w-row">
                    <?= $this->render("toefl_ielts/reviews", ['lang' => $lang]); ?>
                </div>
            </div>
        </section>
        <p style="clear: both;">&nbsp;</p>
    <?php $scheds=$page->getSched(); //print_r($scheds);  ?>

    
    <section class="schedule_sec" id="schedule">
      <div class="schedule_cont w-container">
        <h2 class="fees h1"><?= Yii::t('app', 'Расписание'); ?></h2>
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
          <div class="discount fee item"><?=number_format($sched['price_discount'],0,'','') ?>AED
            <br><span class="old-price"><?=number_format($sched['price_all'],0,'','') ?> AED</span>
          </div>       
          <a class="blue button buy discount gray_outline item w-button" data-ix="show-modal-join" href="#" onclick="$('#priceJoin').val(<?=number_format($sched['price_discount'],0,'','') ?>);$('#idSchedule').val(<?= $sched['id'] ?>);$('#needPay').val(1);return true;"><?=Yii::t('app', '<span class="discount_sec-headline-arrow discount_sec-regline">$</span>') ?></a>
          <?php else : ?>
          <div class="fee item"><?=number_format($sched['price_all'],0,'','') ?> AED</div>
          <a class="blue button buy gray_outline item w-button" data-ix="show-modal-join" data-price="<?=number_format($sched['price_all'],0,'','') ?>" href="#" onclick="$('#priceJoin').val(<?=number_format($sched['price_all'],0,'','') ?>);$('#idSchedule').val(<?= $sched['id'] ?>);$('#needPay').val(1);return true;"><?=Yii::t('app', '<span class="discount_sec-headline-arrow discount_sec-regline">$</span>') ?></a>
          <?php endif; ?>

        </div>


		<?php endforeach;?>
<!--
        <div class="schedule_item" data-ix="appear">
          <div class="course_title item">English IELTS
            <br><span class="text-span">30% discount</span>
          </div>
          <div class="duration item">6 weeks, 24 a/h*</div>
          <div class="item schedule">Mon, Wed
            <br>20:00-21:30</div>
          <div class="item starting_date">9th of January</div>
          <div class="discount fee item">860 AED
            <br><span class="old-price">1320 AED</span>
          </div><a class="blue button buy discount gray_outline item w-button" data-ix="show-modal-join" href="#">JOIN</a>
        </div>
-->
        
        <div class="schedule_note">
         <?php if ($lang->alias == 'en'): ?>
                        NOTE:
                        <ul>
                            <li>we require a minimum 4 delegates to run a group course,</li>
                            <li>full prepayment is required in advance,</li>
                            <li>you can settle your payment in cash, by cheque or credit card,</li>
                            <li>1 academic hour (a/h) is 45 minutes.</li>
                        </ul>
                    <?php endif; ?>

                    <?php if ($lang->alias == 'ru'): ?>
                        ПРИМЕЧАНИЕ:
                        <ul>
                            <li>минимальное количество человек в группе - 4,</li>
                            <li>регистрация на курс считается состоявшейся только по факту оплаты полной стоимости
                                курса,
                            </li>
                            <li>оплата может быть произведена наличными, чеком или банковской картой,</li>
                            <li>1 академический час = 45 мин.</li>
                        </ul>
                    <?php endif; ?>

          
          
          </div>
      </div>
    </section>
    </div>
</div>
<!-- [if lte IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script>
<![endif] -->

