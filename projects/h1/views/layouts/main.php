<?php
/**
 * main.php - new.headin.pro
 * Initial version by: BeforyDeath
 * Initial version created on: 14.08.15 11:40
 */

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\models\Language;
use app\widgets\LanguageWidget;
use app\widgets\MenuTopWidget;
use app\widgets\SocialWidget;
use app\widgets\SubscriptionWidget;
use app\widgets\SearchFormWidget;
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\bootstrap\Modal;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use kartik\nav\NavX;
use app\models\Page;
use yii\widgets\Menu;
use app\widgets\ReCaptchaInvisible;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>

<?php  $lang = Language::getCurrent(); ?>
<?php
$lang_alt_id = null;
if ($lang->id == 1){
    $lang_alt_id = 2;
}else{
    $lang_alt_id = 1;
}
$lang_alt = Language::find()->where(['id' =>$lang_alt_id ])->one();

$view_url ='';
$current_urls = Yii::$app->request->url;
$current_urls = explode("/", $current_urls);
foreach ($current_urls as $current_url){
    if ($lang->alias == $current_url || $current_url == ''){
        continue;
    }else{
        $view_url = $view_url . $current_url . '/';
    }
}
$view_url = substr( $view_url, 0,-1);
?>


<html data-wf-page="589399e3034ea3301e1f03aa" data-wf-site="589399e3034ea3301e1f03a9" lang="<?= $lang->alias ?>">
<head>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TQ52KT4');</script>
  <!-- End Google Tag Manager -->

    <?if(Yii::$app->request->pathInfo === ''){  ?>
        <link rel="stylesheet" href="https://forms.amocrm.ru/forms/assets/css/v3/iframe.css" type="text/css">
        <link rel="stylesheet" href="https://forms.amocrm.ru/forms/assets/css/v3/iframe_extended.css" type="text/css">
    <?}?>

  <meta name="uri-translation" content="on" />
  <link rel="alternate" hreflang="<?= $lang_alt->alias ?>" href="https://headin.pro/<?= $lang_alt->alias ?>/<?= $view_url ?>"  />
  <meta charset="<?= Yii::$app->charset ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="mailru-verification" content="b06098c8445f9fcb" />
  <meta name="google-site-verification" content="HhgnajOfr7RrKqby3GHEhyoiaFsMvMXp1g7JOC2Stbo" />
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"><?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title><?php $this->head() ?>


  <!--open graph-->
  <meta property="og:site_name" content="Headway Institute"/>
  <meta property="og:url" content="<?= Html::encode(yii\helpers\Url::current([], true)) ?>">
  <meta property="og:image" content="<?= Url::home(true);?>images/logo.png">
  <meta property="og:image:type" content="image/png">

  <meta name="twitter:card" content="summary_large_image"/>
  <meta name="twitter:site" content="Headway Institute"/>
  <meta name="twitter:creator" content="Headway Institute"/>
  <meta name="twitter:image:src" content="https://headin.pro/images/logo.png"/>
  <meta name="twitter:domain" content="https://headin.pro"/>
  <!--/open graph-->


</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TQ52KT4"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->




<?php $this->beginBody() ?>
<section class="conf">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-xs-12">
          <?= LanguageWidget::widget(); ?>
        <ul class="signjoin text-right">
            <?php if (Yii::$app->user->isGuest): ?>
              <li class="signin">
                <a href="<?= Url::toRoute('/user/registration/register') ?>"><?= Yii::t('app', 'Регистрация') ?></a>
              </li>
              <li class="join">
                <a href="<?= Url::toRoute('/user/security/login') ?>"><?= Yii::t('app', 'Вход') ?></a>
              </li>


            <?php else: ?>
                <?php if (Yii::$app->user->identity->isAdmin): ?>
                <li class="signin">
                  <a href="<?= Url::toRoute('/dashboard') ?>"><?= Yii::t('app', 'Панель управления') ?></a>
                </li>
                <?php endif ?>
              <li class="signin">
                <a href="<?= Url::toRoute('/user/settings/profile') ?>"><?= Yii::$app->user->identity->username ?></a>
              </li>
              <li class="join">
                <a data-method="post" href="<?= Url::toRoute('/user/security/logout') ?>"><?= Yii::t('app', 'Выход') ?></a>
              </li>
            <?php endif ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<header>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-xs-12">
        <a href="<?= Yii::$app->homeUrl ?>"><img src="/images/logo.png" alt="" class="logo"></a>
      </div>
      <div class="col-md-8 col-xs-12">
        <div class="row">

          <div class="col-xs-12 col-sm-6 col-md-4 col-md-push-4">
              <?= SocialWidget::widget() ?>
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4 col-md-pull-4">
              <?= SearchFormWidget::widget() ?>
          </div>

          <div class="col-sm-12 visible-xs-block visible-sm-block"></div>

          <div class="col-xs-12 col-sm-5 col-sm-push-7 col-md-4 col-md-push-0">
            <p class="top-phone">
              <a href="tel:+97143625313">
                <span class="lptracker_phone">+ 971 <b>4 362 53 13</b></span>
              </a>
            </p>
          </div>

          <div class="work-time col-xs-12 col-sm-7 col-sm-pull-5 col-md-pull-0 col-md-offset-4 col-md-5">
              <?= Yii::t('app', '<span>сб-чт</span> с 9.00 до 20.00, <span>пт</span> выходной') ?>
          </div>

          <!-- <div class="col-xs-12 col-md-3">
                        <button class="btn btn-default callback" id="feedback_button" data-url="<?/*= Yii::$app->homeUrl */?>/feedback_popup">
                            <?/*= Yii::t('app', 'обратный звонок') */?>
                        </button>
                    </div>-->

          <div class="col-xs-12 col-md-3">
              <?php
              $this->title = Yii::t('app', 'Отправить заявку');
              Modal::begin([
                      'header' => '<h2 class="h1">'. $this->title.'</h2>',
                      'toggleButton' => [
                              'label' => Yii::t('app', 'обратный звонок'),
                              'tag' => 'button',
                              'class' => 'btn btn-default callback',
                      ],
              ]);

              $modelFeedback = new \app\models\Feedback();
              $actionUrl = '/';
              $lang = Language::getCurrent();
              if (isset($lang)) {
                  $actionUrl .= $lang->alias . '/';
              }
              $actionUrl .= 'feedback';
              $form = ActiveForm::begin([
                      'action' => $actionUrl,
              ]);
              ?>
              <?= $form->field($modelFeedback, 'name'); ?>
              <?= $form->field($modelFeedback, 'phone'); ?>
              <?= $form->field($modelFeedback, 'promocode'); ?>
              <?= $form->field($modelFeedback, 'message')->TextArea(['rows' => 8]); ?>


              <?= $form->field($modelFeedback, 'reCaptcha')->widget(
                      ReCaptchaInvisible::className(), [
                              'siteKey' => Yii::$app->params['reCaptcha']['siteKey'],
                              'size' => ReCaptcha::SIZE_INVISIBLE,
                      ]
              )->label(false) ?>

              <?= $form->field($modelFeedback, 'course')->hiddenInput([
                              'value'=>  Yii::t('app', 'обратный звонок'),
                              'id' => 'course',
                      ]
              )->label(false); ?>

            <div class="form-group text-right">
                <?= Html::submitButton(Yii::t('app', 'Отправить'), [
                        'class' => 'btn btn-default',
                    //'onclick' => 'ga(\'send\', \'event\', \'form\', \'call_back\', \''.$lang->alias.'_call_back_sent\');'
                ]) ?>
            </div>
              <?php ActiveForm::end(); ?>
              <?php Modal::end(); ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</header>

<nav class="navbar navbar-inverse navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-menu">
        <span class="sr-only">Открыть навигацию</span> <span class="icon-bar"></span>
        <span class="icon-bar"></span> <span class="icon-bar"></span>
      </button>
      <a href="<?= Yii::$app->homeUrl ?>" class="navbar-brand" style="font-size: 24px; color: #fefefe;"><img src="/images/home.png" alt=""></a>
    </div>
    <div class="collapse navbar-collapse" id="top-menu">
        <?php
        $page = Page::find()->select(['id', 'parent_id', 'name', 'alias', 'active','sort'])
                ->where(
                        'alias <> "/" AND language_id=:language_id AND active=1',
                        [':language_id'=> Language::getCurrent()->id]
                )
                ->orderBy(['sort' => SORT_DESC])
                ->asArray()->all();
        /*
                    print_r($page);
                    die();
        */
        //$menu = Page::TreeMenu($page, Language::getCurrent()->alias);


        /* $menuCourses = $menu[1]['items'];

         $newMenu = [];
         foreach ($menuCourses as $key => $menuItems){
             $newMenuItems = [];
             array_push($newMenu, $menuCourses[$key]) ;
             $newMenu[count($newMenu)-1]['items'] = [];
             $menuCourses[$key]['items'] = [];
             foreach ($menuItems['items'] as $newMenuItem){
                 //die(var_dump($keyname));
                 array_push($newMenu, $newMenuItem);
                 $i = 0;
                 foreach ($newMenu[count($newMenu)-1]['items'] as $lastMenuItem){
                     $i++;
                     array_push($newMenu, $lastMenuItem);
                 }
                 $newMenu[count($newMenu)-1 - $i]['items'] = [];
             }
         }
             if (Yii::$app->devicedetect->isMobile())
             {
             $menu[1]['items'] = $newMenu;
                 */?><!--
                <style>
                    .dropdown-menu > li > a{
                        white-space: unset;
                    }
                </style>

            --><?/*}*/
        if (Yii::$app->devicedetect->isMobile())
        {

            $menu = Page::TreeMenu($page, Language::getCurrent()->alias, 0, '', 0 , 3);
            /*todo Russian Language classes for children in Regent International School непонятно что было тут
            зачемто убирали из списка
           */

            // $menu[1]['items'][2]['items'][1]['items'] = [];
            $oldMenu = $menu;

            $menuCourses = $menu[1]['items'];
            unset($menu[1]);
            $newMenu = [];
            foreach ($menuCourses as $key => $menuItems){
                $newMenuItems = [];
                array_unshift($menu, $menuCourses[$key]) ;

            }



            $newMenu = array_reverse($menu);
            $menu = $oldMenu;

            echo NavX::widget([
                    'options'=>['class'=>'nav-justified-new'],
                    'items' => $newMenu,
                    'activateParents' => false,
                    'encodeLabels' => false
            ]);


            echo NavX::widget([
                    'options'=>['class'=>'nav-justified-old'],
                    'items' => $menu,
                    'activateParents' => false,
                    'encodeLabels' => false
            ]);
            ?>
          <!-- <style>
               .dropdown-menu > li > a{
                   white-space: unset;
               }
           </style>-->
        <?}else{
            $menu = Page::TreeMenu($page, Language::getCurrent()->alias);
            /*todo Russian Language classes for children in Regent International School непонятно что было тут
             зачемто убирали из списка
            */
            //$menu[1]['items'][2]['items'][1]['items'] = [];


            echo NavX::widget([
                    'options'=>['class'=>'nav-justified'],
                    'items' => $menu,
                    'activateParents' => false,
                    'encodeLabels' => false
            ]);

            if (!Yii::$app->devicedetect->isMobile())
            {
                $this->registerJs('$(".navbar [data-toggle=dropdown]").click(function(){window.location=$(this).attr("href")})');
            }

        }

        /*
                use yii\bootstrap\NavBar;
            NavBar::begin();
            echo NavX::widget([
            'options' => ['class' => 'nav-justified'],
            'items' => $menu,
            'activateParents' => true,
            'encodeLabels' => true
            ]);
            NavBar::end();
        */


        //    echo MenuTopWidget::widget();




        ?>
    </div>
  </div>
</nav>

<?php if(isset($this->params['breadcrumbs'])): ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
          <?= Breadcrumbs::widget([
                  'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
          ]) ?>
      </div>
    </div>
  </div>
<?php endif ?>
<?= $content ?>

<!-- <section class="subscr">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?//= SubscriptionWidget::widget() ?>
            </div>
        </div>
    </div>
</section>
-->

<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <p>
            BO-1-GF, Boutique Villa 1, Ground Floor,<br>
            next to Dubai Knowledge Park, Dubai,<br>
            United Arab Emirates<br>
            P.O.Box 502993, Dubai, UAE
        </p>

        <p><b>Telephone:</b> <span class="lptracker_phone">+971 4 362 53 13/17/19</span><br> <b>e-mail:</b>
          <a href="mailto:info@headin.pro">info@headin.pro</a></p>
      </div>
        <?php $language = Language::getCurrent()->alias; ?>
      <div class="col-md-7">
        <div class="row">
          <div class="col-md-7">
            <ul class="footer-list list-unstyled">
              <li><a href="/<?= $language ?>/about"><?= Yii::t('app', 'О нас') ?></a></li>
              <li><a href="/<?= $language ?>/tutoring"><?= Yii::t('app', 'Репетитор') ?></a></li>
              <li>
                <a href="/<?= $language ?>/business-training"><?= Yii::t('app', 'Бизнес тренинги') ?></a>
              </li>
              <li><a href="/<?= $language ?>/schedule"><?= Yii::t('app', 'График занятий') ?></a></li>
              <li><a href="/<?= $language ?>/contact"><?= Yii::t('app', 'Контакты') ?></a></li>
              <li><a href="/<?= $language ?>/courses"><?= Yii::t('app', 'Курсы') ?></a>
                <ul>
                  <li>
                    <a href="/<?= $language ?>/courses/arabic-language"><?= Yii::t('app', 'Арабский') ?></a>
                  </li>
                  <li>
                    <a href="/<?= $language ?>/courses/english-language"><?= Yii::t('app', 'Английский') ?></a>
                  </li>
                  <li>
                    <a href="/<?= $language ?>/courses/russian-language"><?= Yii::t('app', 'Русский') ?></a>
                  </li>
                </ul>
              </li>
              <li><a href="/<?= $language ?>/feedback"><?= Yii::t('app', 'Записаться на курс') ?></a></li>
                <?php if(false): // надо вернуть, когда карта сайта заработает ?>
                  <li><a href="/<?= $language ?>/sitemap"><?= Yii::t('app', 'Карта сайта') ?></a></li>
                <?php endif ?>
            </ul>
          </div>
          <div class="col-md-5">
            <div class="row">
              <div class="footer_right">
                  <?= SocialWidget::widget() ?>
              </div>
            </div>
            <div class="row">
              <div class="text-right payment">
                <div class="footer_right">
                  <img src="/images/visa.png" alt="visa"> <img src="/images/mastercard.png" alt="mastercard">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="footer_right">
                <div class="copyright">2011-<?= date('Y')?> Headway Institue FZ-LLC &copy;</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer><?php $this->endBody() ?>
<!-- BEGIN CALLGEAR INTEGRATION WITH ROISTAT -->
<script>
    (function(w, d, s, h, id) {
        w.roistatProjectId = id; w.roistatHost = h;
        var p = d.location.protocol == "https:" ? "https://" : "http://";
        var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init?referrer="+encodeURIComponent(d.location.href);
        var js = d.createElement(s); js.charset="UTF-8"; js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);
    })(window, document, 'script', 'cloud.roistat.com', '965d827ed6ace1a4e4b59f8ca431fe75');
</script>
<script>
    (function(){
        var onReady = function(){
            var interval = setInterval(function(){
                if (typeof Comagic !== "undefined" && typeof Comagic.setProperty !== "undefined" && typeof Comagic.hasProperty !== "undefined") {
                    Comagic.setProperty("roistat_visit", window.roistat.visit);
                    Comagic.hasProperty("roistat_visit", function(resp){
                        if (resp === true) {
                            clearInterval(interval);
                        }
                    });
                }
            }, 1000);
        };
        var onRoistatReady = function(){
            window.roistat.registerOnVisitProcessedCallback(function(){
                onReady();
            });
        };
        if (typeof window.roistat !== "undefined") {
            onReady();
        } else {
            if (typeof window.onRoistatModuleLoaded === "undefined") {
                window.onRoistatModuleLoaded = onRoistatReady;
            } else {
                var previousOnRoistatReady = window.onRoistatModuleLoaded;
                window.onRoistatModuleLoaded = function(){
                    previousOnRoistatReady();
                    onRoistatReady();
                };
            }
        }
    })();
</script>
<!-- END CALLGEAR INTEGRATION WITH ROISTAT -->

<!-- callback -->

<script type="text/javascript" src="//cdn.callbackhunter.com/cbh.js?hunter_code=1ee5ba3089b8836fb22c9e3ecbd1bc32" charset="UTF-8"></script>

<!--  end callback-->

<script>
    var __cs = __cs || [],
        attempts = 10,
        currentAttempt = 0,
        intervalId;

    intervalId = setInterval(function () {
        currentAttempt ++;
        console.log(1);
        if (window.roistat) {
            __cs.push(['setProperty', ['roistat_id', roistat.getVisit()]]);
            clearInterval(intervalId);
        } else if (currentAttempt > attempts) {
            clearInterval(intervalId);
        }
    }, 2000);
</script>
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
    document,'script','//connect.facebook.net/en_US/fbevents.js');

  fbq('init', '871964992895015');
  fbq('track', "PageView");</script>
<noscript><img alt="Facebook Pixel" height="1" width="1" style="display:none"
               src="https://www.facebook.com/tr?id=871964992895015&ev=PageView&noscript=1"
  /></noscript>
<!-- End Facebook Pixel Code -->

<!--[if lt IE 9]>-->
<!--<script src="js/html5shiv.js"></script>--><!--<script src="js/respond.min.js"></script>--><!--<![endif]-->
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,"script","//www.google-analytics.com/analytics.js","ga");ga("create", "UA-24998211-1", {"cookieDomain":"auto"});ga("require", "displayfeatures");ga("send", "pageview");
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
  (function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
      try {
        w.yaCounter33682639 = new Ya.Metrika({
          id:33682639,
          clickmap:true,
          trackLinks:true,
          accurateTrackBounce:true,
          webvisor:true
        });
      } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
      s = d.createElement("script"),
      f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = "https://mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
      d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
  })(document, window, "yandex_metrika_callbacks");
</script>
<!-- /Yandex.Metrika counter -->
<noindex><script async src="data:text/javascript;charset=utf-8;base64,ZnVuY3Rpb24gbG9hZHNjcmlwdChlLHQpe3ZhciBuPWRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoInNjcmlwdCIpO24uc3JjPSIvL2xwdHJhY2tlci5ydS9hcGkvIitlO24ub25yZWFkeXN0YXRlY2hhbmdlPXQ7bi5vbmxvYWQ9dDtkb2N1bWVudC5oZWFkLmFwcGVuZENoaWxkKG4pO3JldHVybiAxfXZhciBpbml0X2xzdGF0cz1mdW5jdGlvbigpe2xzdGF0cy5zaXRlX2lkPTEzNTIyO2xzdGF0cy5yZWZlcmVyKCl9O3ZhciBqcXVlcnlfbHN0YXRzPWZ1bmN0aW9uKCl7alFzdGF0Lm5vQ29uZmxpY3QoKTtsb2Fkc2NyaXB0KCJzdGF0c19hdXRvLmpzIixpbml0X2xzdGF0cyl9O2xvYWRzY3JpcHQoImpxdWVyeS0xLjEwLjIubWluLmpzIixqcXVlcnlfbHN0YXRzKQ=="></script></noindex>

<noscript><div><img src="https://mc.yandex.ru/watch/33682639" style="position:absolute; left:-9999px;" alt="" /></div></noscript>

<script type="application/ld+json">
  {
    "@context" : "http://schema.org",
    "@type" : "EducationalOrganization",
    "name" : "Headway Institute",
    "logo":"https://headin.pro/images/logo.png",
    "description": "Headway Institute FZ-LLC is an education centre offering a range of academic and non-academic courses in Dubai",
    "url": "https://headin.pro/",
    "image" : "https://headin.pro/images/logo.png",
    "telephone" : [ "+971 4 362 53 13", "+971 4 362 53 17", "+971 4 362 53 19" ],
    "email" : "info@headin.pro",
      "address" : {
          "@type" : "PostalAddress",
          "streetAddress" : "BO-1-GF, Boutique Villa 1, Ground Floor",
          "addressLocality" : "Dubai",
          "addressRegion" : "Dubai Knowledge Village",
          "addressCountry" : "United Arab Emirates",
          "postalCode" : "502993"
      },
    "aggregateRating" : {
      "@type" : "AggregateRating",
      "ratingValue" : "4.7",
      "ratingCount" : "9654"
    },
    "sameAs" : [
      "https://www.facebook.com/headin.pro",
      "http://twitter.com/Headin_Pro",
      "https://www.linkedin.com/company/headway-institute",
      "http://instagram.com/headin.pro/",
      "http://vk.com/headin_pro"
    ]
  }
</script>

<!-- HTML-код модального окна -->
<!--<div id="myModalBox" class="modal fade ">
    <div class="modal-dialog" >
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" onclick="document.cookie = 'modal_closed=true';" data-dismiss="modal" aria-hidden="true">×</button>

            </div>

            <div class="modal-body">
                <a target="_blank" href="https://headin.pro/en/courses/ramadan-promo"><img style=" width: 100%;height: auto;" src="/images/ramadan_2019.jpg"></a>
            </div>

        </div>
    </div>
</div>-->

<!-- Скрипт, вызывающий модальное окно после загрузки страницы -->
<!--<script>
    $(document).ready(function() {
        function getCookie(name) {
            var matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }
        $DATE = (+new Date());

        if (getCookie('modal') == undefined){
            document.cookie = "modal=" +  $DATE;
            document.cookie = "modal_closed=false";
            $("#myModalBox").modal('show');
        }else{

            if (getCookie('modal_closed') == 'true' && getCookie('modal') < $DATE - (3600 * 1000 * 24 * 7)){
                document.cookie = "modal_closed=false";
                $("#myModalBox").modal('show');
            }

            if (getCookie('modal_closed') == 'false'){
                document.cookie = "modal="+ $DATE;
                $("#myModalBox").modal('show');
            }
        }

    });
</script>-->

<script type="text/javascript">
    var __cs = __cs || [];
    __cs.push(["setCsAccount", "bqn5tfQq3biWQp05GqAtB0d4gd4MwOGv"]);
</script>
<script type="text/javascript" async src="https://app.callgear.com/static/cs.min.js"></script>
<script type="text/javascript" async src="https://custom.callgear.com/static/65834/script.js"></script>

<!-- calltouch -->
<script type="text/javascript">
    (function(w,d,n,c){w.CalltouchDataObject=n;w[n]=function(){w[n]["callbacks"].push(arguments)};if(!w[n]["callbacks"]){w[n]["callbacks"]=[]}w[n]["loaded"]=false;if(typeof c!=="object"){c=[c]}w[n]["counters"]=c;for(var i=0;i<c.length;i+=1){p(c[i])}function p(cId){var a=d.getElementsByTagName("script")[0],s=d.createElement("script"),i=function(){a.parentNode.insertBefore(s,a)};s.type="text/javascript";s.async=true;s.src="https://mod.calltouch.ru/init.js?id="+cId;if(w.opera=="[object Opera]"){d.addEventListener("DOMContentLoaded",i,false)}else{i()}}})(window,document,"ct","gzc8llkp");
</script>
<!-- calltouch -->

</body>
</html>
<?php $this->endPage() ?>
