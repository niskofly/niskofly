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
  <div class="slide_down_div w-hidden-small w-hidden-tiny"><img class="slidedown" data-ix="arrowdown" src="/images/page/arrow.svg" width="24">
  </div>
  
   <?= SimpleOrderFormWidget::widget(['selectedCourse' => $page->name.' Free Class']) ?>  

   <?= SimpleCouponFormWidget::widget(['type'=>'2','course'=>$page->name]) ?>

   <?= SimpleCallbackFormWidget::widget() ?>
  
   <?= SimpleOrderFormWidget::widget(['selectedCourse' => $page->name.' Choose Course']) ?>
  

  
  
  <div class="navibar">
    <div class="navibar_row w-row">
      <div class="_1 navibar_column w-col w-col-4 w-col-small-4">
        <a class="w-inline-block" href="https://headin.pro/en"><img src="/images/page/logo_bar.png" width="121">
        </a>
        <a class="callback_button w-button w-hidden-main w-hidden-medium w-hidden-small" data-ix="show-modal-callback" href="#"></a>
      </div>
      <div class="_2 navibar_column w-col w-col-4 w-col-small-4"><a class="button button_register navib purple w-button" data-ix="show-modal-register"><?=Yii::t('app','Зарегистрироваться на пробный урок') ?></a><a class="button navib voucher_button w-button" data-ix="show-modal-voucher"><?=Yii::t('app','Получить купон на 50 AED') ?></a>
      </div>
      <div class="_3 navibar_column w-col w-col-4 w-col-small-4">
        <div class="tel_number"><?=Yii::t('app','Позвоните нам') ?> &nbsp;+ 971 <strong>4 362 53 13</strong>
        </div>
        <a class="callback_button w-button" data-ix="show-modal-callback" href="#"></a>
      </div>
    </div>
  </div>
  <div class="main_wrapper">
    <div class="hero_sec regularitalian" data-ix="show-bar">
      <div class="hero_cont regulararabic w-container">
        <h1 class="h1 hero"><?=$page->h1 ?></h1>
      <!-- <p class="hero_descr regulararabic">        -->
	    <?php 
	      //  $before = str_replace('<p>','',$page->before_content);
	       // $before = str_replace('</p>','',$before);
	        	        echo Html::tag('div', Html::decode($page->before_content), ['class' => 'hero_descr regulararabic']);

	        
        ?>      <!--  </p>  -->
        <a class="button hero regulararabic w-button" href="#Benefits"><?=Yii::t('app','Подробнее') ?> &nbsp;<span class="arrow">5</span></a>
      </div>
    </div>
    <div class="discount_sec_mob w-hidden-main w-hidden-medium" data-ix="show-modal-voucher"><img sizes="100vw" src="/images/page/voucher_mob.png" srcset="/images/page/voucher_mob-p-500.png 500w, /images/page/voucher_mob-p-800.png 800w, /images/page/voucher_mob-p-1080.png 1080w, /images/page/voucher_mob.png 1134w">
    </div>
    <div class="discount_sec w-hidden-small w-hidden-tiny" data-ix="discount-action">
      <div class="discount_sec-cont w-container"><img class="discount_sec-icon" src="/images/page/voucher.png" width="79">
        <h3 class="discount_sec-headline"><?=Yii::t('app','Получить свой купон на 50 AED') ?></h3><span class="discount_sec-headline-arrow discount_sec-headline">$</span>
        
        <?= SimpleCouponFormWidget::widget(['type'=>'1','course'=>$page->name]) ?>

        
        
        
      </div>
    </div>
    <div class="benefits_sec regulararabic" id="Benefits">
      <div class="benefits_cont w-container">
        <div class="w-row">
          <div class="benefits_row w-col w-col-4" data-ix="appear">
            <div class="div_icon"><img src="/images/page/native_speak.svg">
            </div>
            <h3 class="benefits_head"><?=$page->block2_1_head ?></h3>
            <div><?=$page->block2_1_desc ?></div>
          </div>
          <div class="benefits_row w-col w-col-4" data-ix="appear">
              <div class="div_icon"><img style="height: 64px;  filter: invert(0.5) sepia(1) saturate(999) hue-rotate(555deg)" src="/images/page/communication_icon.svg">
            </div>
            <h3 class="benefits_head"><?=$page->block2_2_head ?></h3>
            <div><?=$page->block2_2_desc ?></div>
          </div>
          <div class="_3 benefits_row w-col w-col-4" data-ix="appear">
            <div class="div_icon"><img src="/images/page/supp_env.svg">
            </div>
            <h3 class="benefits_head"><?=$page->block2_3_head ?></h3>
            <div><?=$page->block2_3_desc ?></div>
          </div>
        </div>
      </div>
        <div style="
            display: flex;
            justify-content: center;
            width: 100%;">
            <a class="button button_register purple w-button" data-ix="show-modal-register"><?=Yii::t('app','Зарегистрироваться на пробный урок') ?></a>
        </div>
           </div>
    <div class="programme_sec" id="Programme">
      <div class="programme-cont w-container">
        <div class="lead programme"><?=$page->block3_head ?></div><img class="image" data-ix="appear" sizes="(max-width: 767px) 92vw, (max-width: 991px) 728px, 891px" src="/images/page/Arab_Programme.png" srcset="/images/page/Arab_Programme-p-500x.png 500w, /images/page/Arab_Programme-p-800x.png 800w, /images/page/Arab_Programme-p-1080x.png 1080w, /images/page/Arab_Programme-p-1600x.png 1600w, /images/page/Arab_Programme.png 1782w" width="891"><a class="button purple_outline w-button" href="#Fees"><span class="icon_cta"></span><?=Yii::t('app','Стоимость курсов') ?></a>
      </div>
    </div>
    <div class="cc_sec">
      <div class="cc_cont w-container">
        <div class="w-row" data-ix="appear">
          <div class="column w-col w-col-6">
            <div class="cc_wrapper w-clearfix">
              <div class="cc_left"><img src="/images/page/Group_2.svg">
              </div>
              <div class="cc_right">
                <h3 class="heading"><?=$page->block4_1_head ?></h3>
                <?=$page->block4_1_desc ?>
                <!--
                <p class="paragraph">Every group course fits within above-mentioned framework and lasts from 4 to 6 weeks, depending on the class frequency. Advantages of learning in a group:</p>
                <ul class="cc_list">
                  <li class="cc_list_el">More entertaining and dynamic classes</li>
                  <li class="cc_list_el">Better motivation and commitment</li>
                  <li class="cc_list_el">Leaning form classmates</li>
                  <li class="cc_list_el">More conversational practice</li>
                </ul>
                -->
              </div>
            </div>
          </div>
          <div class="column-2 w-col w-col-6">
            <div class="cc_wrapper right w-clearfix">
              <div class="cc_left"><img src="/images/page/individ.svg">
              </div>
              <div class="cc_right">
                <h3 class="heading"><?=$page->block4_2_head ?></h3>
				<?=$page->block4_2_desc ?>
<!--
                <p class="paragraph">Private and semi-private classes are tailored as per the student requirements and run at flexible timings. Advantages of learning Arabic in a private mode:</p>
                <ul class="cc_list">
                  <li class="cc_list_el">Adjusted to specific learning goals and needs</li>
                  <li class="cc_list_el">Flexible schedule</li>
                  <li class="cc_list_el">Ideal for people who travel frequently</li>
                  <li class="cc_list_el">Learn Arabic with friends, family or colleagues</li>
                </ul>
-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <section class="fees_sec" id="Fees">
      <div class="fees_cont w-container">
        <h2 class="fees h1 regulararabic"><?=Yii::t('app','Стоимость курсов') ?></h2>
        <div class="price toefl_slider_wr w-hidden-main w-hidden-medium w-hidden-small w-slider" data-animation="slide" data-duration="500" data-hide-arrows="1" data-infinite="1">
          <div class="w-slider-mask">
            <div class="price toefl_slide w-slide">
              <div class="price_div price_div_left slider" data-ix="price-left">
                <div class="price_div_head"><img src="/images/page/group_icon.svg">
	                 <?php  $data=$page->getGroup();?>
	                 
                  <div class="price_type"><?=isset($data[0]) ? $data[0]->name : '' ?></div>
                  <div class="price_type_descr"><?=isset($data[0]) ? $data[0]->desc_name : '' ?></div>
                </div>
                <div class="price_cost_div">
                  <div class="price_cost_hour"><?=isset($data[0]) ? number_format($data[0]->price_hour,0,'','') : '' ?></div>
                  <div class="aed">AED</div>
                </div>
                <div class="price_cost_descr"><?=isset($data[0]) ? $data[0]->desc_price_hour : ''?></div>
                <div class="price_delimeter"></div>
                <div class="level price_cost_div">
                  <div class="lever price_cost_hour"><?=isset($data[0]) ? number_format($data[0]->price_all,0,'','') : '' ?></div>
                  <div class="aed level">AED</div>
                </div>
                <div class="price_cost_descr"><?=isset($data[0]) ? $data[0]->desc_price_all : '' ?></div>
                <a class="button course w-button" data-ix="show-modal-join" href="#"><?=Yii::t('app','Выберите курс')?></a>
              </div>
            </div>
            <div class="price toefl_slide w-slide">
              <div class="price_div price_middle_div">
                <div class="price_div_head purple slider"><img class="semi_icon" src="/images/page/semi_icon.svg">
                  <div class="price_type"><?=isset($data[1]) ? $data[1]->name : '' ?></div>
                  <div class="price_type_descr"><?isset($data[1]) ? $data[1]->desc_name : '' ?></div>
                </div>
                <div class="price_cost_div">
                  <div class="price_cost_hour"><?=isset($data[1]) ? number_format($data[1]->price_hour,0,'','') : '' ?></div>
                  <div class="_3 aed">AED</div>
                </div>
                <div class="price_cost_descr"><?=isset($data[1]) ? $data[1]->desc_price_hour : '' ?></div>
                <div class="price_delimeter"></div>
                <div class="level price_cost_div">
                  <div class="lever price_cost_hour"><?=isset($data[1]) ? number_format($data[1]->price_all,0,'','') : '' ?></div>
                  <div class="aed level">AED</div>
                </div>
                <div class="price_cost_descr"><?=isset($data[1]) ? $data[1]->desc_price_all : ''?></div><a class="button course purple w-button" data-ix="show-modal-join" href="#"><?=Yii::t('app','Выберите курс')?></a>
              </div>
            </div>
            <div class="price toefl_slide w-slide">
              <div class="price_div price_div_right slider" data-ix="price-right">
                <div class="green price_div_head"><img src="/images/page/private_icon.svg">
                  <div class="price_type"><?=isset($data[2]) ? $data[2]->name : '' ?></div>
                  <div class="price_type_descr"><?=isset($data[2]) ? $data[2]->desc_name : '' ?></div>
                </div>
                <div class="price_cost_div">
                  <div class="price_cost_hour"><?=isset($data[2]) ? number_format($data[2]->price_hour,0,'','') : '' ?></div>
                  <div class="_3 aed">AED</div>
                </div>
                <div class="price_cost_descr"><?=isset($data[2]) ? $data[2]->desc_price_hour : '' ?></div>
                <div class="price_delimeter"></div>
                <div class="level price_cost_div">
                  <div class="lever price_cost_hour"><?=isset($data[2]) ? number_format($data[2]->price_all,0,'','') : '' ?></div>
                  <div class="aed level">AED</div>
                </div>
                <div class="price_cost_descr"><?=isset($data[2]) ? $data[2]->desc_price_all : '' ?></div><a class="button course green w-button" data-ix="show-modal-join" href="#"><?=Yii::t('app','Выберите курс')?></a>
              </div>
            </div>
          </div>
          <div class="toefl_slider_arrow w-slider-arrow-left">
            <div class="w-icon-slider-left"></div>
          </div>
          <div class="toefl_slider_arrow w-slider-arrow-right">
            <div class="w-icon-slider-right"></div>
          </div>
          <div class="toefl_slider_nav w-round w-slider-nav w-slider-nav-invert"></div>
        </div>
        <div class="fees_row_wr w-row">
          <div class="fees_row w-col w-col-4 w-col-medium-4 w-col-small-4" data-ix="show-modal-join">
            <div class="price_div price_div_left w-preserve-3d" data-ix="price-left">
              <div class="price_div_head"><img src="/images/page/group_icon.svg">
                <div class="price_type"><?=isset($data[0]) ? $data[0]->name : '' ?></div>
                <div class="price_type_descr"><?=isset($data[0]) ? $data[0]->desc_name : '' ?></div>
              </div>
              <div class="price_cost_div">
                <div class="price_cost_hour"><?=isset($data[0]) ? number_format($data[0]->price_hour,0,'','') : '' ?></div>
                <div class="aed">AED</div>
              </div>
              <div class="price_cost_descr"><?=isset($data[0]) ? $data[0]->desc_price_hour : ''?></div>
              <div class="price_delimeter"></div>
              <div class="level price_cost_div">
                <div class="lever price_cost_hour"><?=isset($data[0]) ? number_format($data[0]->price_all,0,'','') : '' ?></div>
                <div class="aed level">AED</div>
              </div>
              <div class="price_cost_descr"><?=isset($data[0]) ? $data[0]->desc_price_all : '' ?></div>
              <a class="button course w-button" href="#"><?=Yii::t('app','Выберите курс')?></a>
            </div>
          </div>
          <div class="fees_row w-col w-col-4 w-col-medium-4 w-col-small-4" data-ix="show-modal-join">
            <div class="price_div price_middle_div">
              <div class="price_div_head purple"><img class="semi_icon" src="/images/page/semi_icon.svg">
                <div class="price_type"><?=isset($data[1]) ? $data[1]->name : '' ?></div>
                <div class="price_type_descr"><?=isset($data[1]) ? $data[1]->desc_name : '' ?></div>
              </div>
              <div class="price_cost_div">
                <div class="price_cost_hour"><?=isset($data[1]) ? number_format($data[1]->price_hour,0,'','') : '' ?></div>
                <div class="_3 aed">AED</div>
              </div>
              <div class="price_cost_descr"><?=isset($data[1]) ? $data[1]->desc_price_hour : '' ?></div>
              <div class="price_delimeter"></div>
              <div class="level price_cost_div">
                <div class="lever price_cost_hour"><?=isset($data[1]) ? number_format($data[1]->price_all,0,'','') : '' ?></div>
                <div class="aed level">AED</div>
              </div>
              <div class="price_cost_descr"><?=isset($data[1]) ? $data[1]->desc_price_all : ''?></div><a class="button course purple w-button" href="#"><?=Yii::t('app','Выберите курс')?></a>
            </div>
          </div>
          <div class="fees_row w-col w-col-4 w-col-medium-4 w-col-small-4" data-ix="show-modal-join">
            <div class="price_div price_div_right w-preserve-3d" data-ix="price-right">
              <div class="green price_div_head"><img src="/images/page/private_icon.svg">
                <div class="price_type"><?=isset($data[2]) ? $data[2]->name : '' ?></div>
                <div class="price_type_descr"><?=isset($data[2]) ? $data[2]->desc_name : '' ?></div>
              </div>
              <div class="price_cost_div">
                <div class="price_cost_hour"><?=isset($data[2]) ? number_format($data[2]->price_hour,0,'','') : '' ?></div>
                <div class="_3 aed">AED</div>
              </div>
              <div class="price_cost_descr"><?=isset($data[2]) ? $data[2]->desc_price_hour : '' ?></div>
              <div class="price_delimeter"></div>
              <div class="level price_cost_div">
                <div class="lever price_cost_hour"><?=isset($data[2]) ? number_format($data[2]->price_all,0,'','') : '' ?></div>
                <div class="aed level">AED</div>
              </div>
              <div class="price_cost_descr"><?=isset($data[2]) ? $data[2]->desc_price_all : '' ?></div><a class="button course green w-button" href="#"><?=Yii::t('app','Выберите курс')?></a>
            </div>
          </div>
        </div><a class="button gray_outline red w-button" href="#schedule"><span class="icon_cta"></span><?=Yii::t('app','Посмотреть расписание')?></a>
      </div>
    </section>
    <section class="reviews_sec" id="reviews">
      <div class="reviews_cont w-container">
        <div class="lead_reviews"><?=$page->after_content ?></div>
        <div class="w-row">
              <?php
              $reviews = $page->items;

              foreach($reviews as $review) {
              if ($review->language_id == $lang->id){
              ?>
          <div class="review_row w-col w-col-4">
            <div class="reviews_div" data-ix="appear"><img class="quote" src="/images/page/quote.svg">
              <div>
				<?=$review->text ?>			  
               </div>
              <div class="author">
              		<?=$review->name.', '.$review->date ?>
              </div>
              <img class="stars" src="/images/page/stars.svg">
            </div>
          </div>
              <?} }?>


        </div>
      </div>
    </section>
    <?php $scheds=$page->getSched(); //print_r($scheds);  ?>
      <? if($scheds[0]["Id"] === NULL){?>
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
          <a class="blue button buy gray_outline item w-button" data-ix="show-modal-join" href="#" onclick="$('#priceJoin').val(<?=number_format($sched['price_all'],0,'','') ?>);$('#idSchedule').val(<?= $sched['id'] ?>);$('#needPay').val(1);return true;"><?=Yii::t('app', '<span class="discount_sec-headline-arrow discount_sec-regline">$</span>') ?></a>
          <?php endif; ?>

        </div>


		<?php endforeach;?>

          <?}else{?>
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
                  <?}?>

<!--
        <div class="schedule_item" data-ix="appear">
          <div class="course_title item">English IELTS</div>
          <div class="duration item">6 weeks, 24 a/h*</div>
          <div class="item schedule">Mon, Wed
            <br>20:00-21:30</div>
          <div class="item starting_date">9th of January</div>
          <div class="fee item">1320 AED</div><a class="blue button buy gray_outline item w-button" data-ix="show-modal-join" href="#">JOIN</a>
        </div>
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
    <div class="allcourses_sec w-clearfix" data-ix="appear">
      <div class="allcourses-leftdiv">
	      
	  		<?=$page->hrefs ?>


      </div>
      <div class="allcourses-rightdiv regularitalian"></div>
    </div>
  </div>
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

