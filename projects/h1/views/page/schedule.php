<?php

use app\models\PageHolyhope;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Language;
use app\widgets\SimpleCallbackFormWidget;
use app\widgets\SimpleOrderFormWidget;
use app\widgets\SimpleCouponFormWidget;
//css
$this->registerCssFile('/css/page/headway-regular-courses.normalize.css');
$this->registerCssFile('/css/page/headway-regular-courses.only.webflow.css');
$this->registerCssFile('/css/page/headway-regular-courses.webflow.css');

//Js
$this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js',
    ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/page/webflow-arab-english.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/page/modernizr.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('/js/page/page.js', ['position' => \yii\web\View::POS_END]);


/** @var $page \yii\db\ActiveRecord */
$this->title = $page->meta_title;
$this->registerMetaTag(['name' => 'description', 'content' => $page->meta_description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page->meta_keywords]);

$this->params['breadcrumbs'] = $page->getPath();

$lang = Language::getCurrent();

?>

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
  <style>
    .discount-form-field::-webkit-input-placeholder { /* WebKit browsers */
        color:    #7E640F;
  </style>
  

<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js"></script>
<script type="text/javascript">
    WebFont.load({
        google: {
            families: ["Roboto:100,300,regular,500,700,900:latin,cyrillic-ext"]
        }
    });
</script>
<div class="body">
          <section class="schedule_sec" id="schedule">
              <div class="schedule_cont w-container">
                  <h2 class="fees h1"><?= Yii::t('app', 'Расписание'); ?></h2>
                  <div class="schedule_title_div">
                      <div class="course_title"><?= Yii::t('app', 'название курса'); ?></div>
                      <div class="duration"><?= Yii::t('app', 'длительность'); ?></div>
                      <div class="schedule"><?= Yii::t('app', 'график'); ?></div>
                      <div class="starting_date"><?= Yii::t('app', 'дата начала'); ?></div>
                      <div class="fee"><?= Yii::t('app', 'цена'); ?></div>
                      <!-- <div class="buy"><?/*= Yii::t('app', 'регистрация'); */?></div>-->
                  </div>


                  <?php
                  $lang = Language::getCurrent();
                  $scheds = $page->getSchedAll(); //print_r($scheds);
                  foreach($scheds as $sched) :?>
                      <?php foreach( $sched['ScheduleItems'] as $schedule_item) :?>
                          <?
                          $end_date = date('Y-m-d',strtotime($schedule_item['EndDate']));
                          $begin_date = date('d-m-Y',strtotime($schedule_item['BeginDate']));

                          $date1 = new DateTime($schedule_item['EndDate']);
                          $date2 = new DateTime($schedule_item['BeginDate']);
                          $week = $date2->diff($date1);
                          $week = $week->format('%a%') / 7;
                          ?>


                          <?  $madel_holyhope = PageHolyhope::getHolyhopeByIds( $sched['Id'], $page->id)  ?>
                          <div class="schedule_item" data-ix="appear">
                              <?php if ($sched['price_discount']>0) :?>
                                  <div class="course_title item"><?=$sched['Name'] ?> <br><?=$sched['Type'] ?> <br><?=$sched['Level'] ?>
                                      <br><span class="text-span"><?=number_format(100-($madel_holyhope['price_discount']/$madel_holyhope['price_all']*100),0,'','')?>% <?=Yii::t('app','скидка')?></span>
                                  </div>
                              <?php else :?>
                                  <div class="course_title item"><?=$sched['Name'] ?> <br><?=$sched['Type'] ?> <br><?=$sched['Level'] ?></div>
                              <?php endif; ?>



                              <div class="duration item"><?=  $week.  ' '.Yii::t('app','недель').', 
                            <br>'.$sched['FiscalInfo']['Units'].' '.Yii::t('app','а/ч*') ?></div>
                              <div class="item schedule"><?=
                                  PageHolyhope::getDayString($schedule_item['Weekdays'], $lang->alias).
                                  '<br>'.$schedule_item['BeginTime'] .'-'. $schedule_item['EndTime'].
                                  '<br>'.$schedule_item['ClassroomName']
                                  ?>
                              </div>
                              <div class="item starting_date"><?=$begin_date?></div>
                              <?php if ($sched['price_discount']>0) : ?>
                                  <div class="discount fee item"><?=number_format($sched['price_discount'],0,'','') ?>AED
                                      <br><span class="old-price"><?=number_format($sched['price_all'],0,'','') ?> AED</span>
                                  </div>
                                  <a class="blue button buy discount gray_outline item w-button" data-ix="show-modal-join" href="#" onclick="$('#priceJoin').val(<?=number_format($sched['price_discount'],0,'','') ?>);$('#idSchedule').val(<?= $sched['id'] ?>);$('#needPay').val(1);return true;"><?=Yii::t('app', '<span class="discount_sec-headline-arrow discount_sec-regline">$</span>') ?></a>
                              <?php else :?>
                                  <div class="fee item"><?= (int)preg_replace('#[^0-9\.,]#','',$sched['FiscalInfo']['Value']) ?> AED</div>
                                  <!--<a class="blue button buy gray_outline item w-button"
                                 data-ix="show-modal-join" href="#" onclick="$('#priceJoin').val(<?/*=(int)preg_replace('#[^0-9\.,]#','',$sched['FiscalInfo']['Value']) */?>);$('#idSchedule').val(<?/*= $sched['id'] */?>);$('#needPay').val(1);return true;"><?/*=Yii::t('app', '<span class="discount_sec-headline-arrow discount_sec-regline">$</span>') */?></a>
                      -->    <?php endif; ?>

                          </div>
                      <?php endforeach;?>
                  <?php endforeach;?>

      </div>
    </section>
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function () {
        $('.callback_button').click(function () {
            $('body').css('overflow', 'hidden');
        });
        $('.close_form, .close_form2').click(function () {
            $('body').css('overflow', 'auto');
            $('.close_form2').css('display', 'none');
        });
    });
</script>
<script>
    jQuery(document).ready(function () {
        $('.fees_row').click(function () {
            $('body').css('overflow', 'hidden');
            $("[id = 'group']").val($(this).find('.price_type').html());
        });
        $('.close_form, .close_form2').click(function () {
            $('body').css('overflow', 'auto');
            $('.close_form2').css('display', 'none');
        });
    });
</script>
<script>
    jQuery(document).ready(function () {
        $('.button_register').click(function () {
            $('body').css('overflow', 'hidden');
        });
        $('.close_form, .close_form2').click(function () {
            $('body').css('overflow', 'auto');
            $('.close_form2').css('display', 'none');
        });
    });
</script>
<script>
    jQuery(document).ready(function () {
        $('.voucher_button').click(function () {
            $('body').css('overflow', 'hidden');
        });
        $('.close_form, .close_form2').click(function () {
            $('body').css('overflow', 'auto');
            $('.close_form2').css('display', 'none');
        });
    });
</script>
<!-- [if lte IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script>
<![endif] -->

