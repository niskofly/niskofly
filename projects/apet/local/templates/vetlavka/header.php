<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
  die();

global $ASSETS_VERSION;
$ASSETS_VERSION = "1.26";

/**
 * Файл для указания версии assets
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/version-value.php"))
  include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/version-value.php");

global $USER;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8"/>
  <title><? $APPLICATION->ShowTitle(); ?></title>
  <meta name="viewport" content="width=device-width"/>
  <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
  <meta name="apple-mobile-web-app-capable" content="yes"/>
  <meta name="format-detection" content="telephone=no"/>
  <meta name="yandex-verification" content="4671d55b949e95c7"/>
  <meta name="yandex-verification" content="7fe6ab9cc388d65a" />
  <meta name="google-site-verification" content="04jnOlsN-pbLKf5PMn5Y6XzzPP1q7mXAMCRoRLzbgC0" />
  <?
  /**
   * open graph
   */
  include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/open-graph.php");
  ?>
  <link type="image/x-icon" href="/img/favicon/favicon.ico" rel="shortcut icon"/>
  <link href="/img/favicon/apple-icon-114x114.png" rel="apple-touch-icon" sizes="114x114"/>
  <link href="/img/favicon/apple-icon-120x120.png" rel="apple-touch-icon" sizes="120x120"/>
  <link href="/img/favicon/apple-icon-144x144.png" rel="apple-touch-icon" sizes="144x144"/>
  <link href="/img/favicon/apple-icon-152x152.png" rel="apple-touch-icon" sizes="152x152"/>
  <link href="/img/favicon/apple-icon-180x180.png" rel="apple-touch-icon" sizes="180x180"/>
  <link type="image/png" href="/img/favicon/android-icon-192x192.png" rel="icon" sizes="192x192"/>
  <link type="image/png" href="/img/favicon/favicon-32x32.png" rel="icon" sizes="32x32"/>
  <link type="image/png" href="/img/favicon/favicon-96x96.png" rel="icon" sizes="96x96"/>
  <link type="image/png" href="/img/favicon/favicon-16x16.png" rel="icon" sizes="16x16"/>
  <link href="/img/favicon/manifest.json" rel="manifes"/>
  <script type="text/javascript">window.suggestmeyes_loaded = true;</script>
  <? $APPLICATION->ShowHead(); ?>
  <link href="<?= SITE_TEMPLATE_PATH ?>/css/app.min.css?ver=<?= $ASSETS_VERSION ?>" rel="stylesheet" media="all"/>
</head>

<body class="body js-body">

<div id="panel">
  <? $APPLICATION->ShowPanel(); ?>
</div>

<?
/**
 * SVG ICONS
 */
include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/svg-icons.php");
?>

<header>
  <div class="header-about">
    <div class="container header-about__container">
      <div class="header-about__city">
        <!-- info: Временно скрыто
        <div class="header-about__city-icon">
          <svg class="icon icon-map ">
            <use xlink:href="#map"></use>
          </svg>
        </div>
        <div class="header-about__city-name"><?= SiteInfo::getItem('vetLavka', 'address') ?></div>
        -->
        <div class="header-about__city-working-hours"><?= SiteInfo::getItem('vetLavka', 'workTime') ?></div>
      </div>
      <?
      $APPLICATION->IncludeComponent(
        "bitrix:menu",
        ".header",
        [
          "COMPONENT_TEMPLATE" => ".header",
          "MAX_LEVEL" => "1",
          "ROOT_MENU_TYPE" => "top",
          "MENU_CACHE_TYPE" => "N",
          "MENU_CACHE_TIME" => "3600",
          "MENU_CACHE_USE_GROUPS" => "Y",
          "MENU_CACHE_GET_VARS" => "",
          "USE_EXT" => "Y",
          "DELAY" => "N",
          "ALLOW_MULTI_SELECT" => "N",
          "CHILD_MENU_TYPE" => "left",
          "IS_MOBILE" => false
        ],
        false
      );
      ?>
      <div class="header-about__burger">
        <label class="menu-btn">
          <input type="checkbox" value="Y" class="menu-toggle js-toggle-menu"/>
          <span class="menu-btn__content"></span>
        </label>
      </div>
    </div>
  </div>

  <div class="header-actions">
    <div class="container header-actions__container">
      <div class="header-actions__links">
        <a href="/" class="header-actions__links-logo"
           style="<?= $APPLICATION->GetCurUri() == '/' ? 'pointer-events: none;' : '' ?>">
          <img src="/img/logo.png" alt="Логотип"/>
        </a>
        <div class="header-actions__links-call">
          <a href="tel: <?= SiteInfo::getItem('vetLavka', 'phone') ?>" class="header-actions__links-call_phone">
            <?= SiteInfo::getItem('vetLavka', 'phone') ?>
          </a>
          <div class="header-actions__links-call_link js-open-modal" data-modal="#callback-modal">Заказать звонок</div>
        </div>
      </div>

      <div class="header-actions__search">
        <div class="header-actions__search-icon">
          <svg class="icon icon-search ">
            <use xlink:href="#search"></use>
          </svg>
        </div>
        <?
        $APPLICATION->IncludeComponent(
          "bitrix:search.title",
          ".default",
          array(
            "SHOW_INPUT" => "Y",
            "INPUT_ID" => "title-search-input",
            "CONTAINER_ID" => "title-search",
            "PRICE_CODE" => array(
              0 => "ruble",
              1 => "RETAIL",
            ),
            "PRICE_VAT_INCLUDE" => "Y",
            "PREVIEW_TRUNCATE_LEN" => "150",
            "SHOW_PREVIEW" => "Y",
            "PREVIEW_WIDTH" => "175",
            "PREVIEW_HEIGHT" => "175",
            "CONVERT_CURRENCY" => "Y",
            "CURRENCY_ID" => "RUB",
            "PAGE" => "#SITE_DIR#search/index.php",
            "NUM_CATEGORIES" => "3",
            "TOP_COUNT" => "10",
            "ORDER" => "date",
            "USE_LANGUAGE_GUESS" => "Y",
            "CHECK_DATES" => "Y",
            "SHOW_OTHERS" => "Y",
            "CATEGORY_0_TITLE" => "Товары",
            "CATEGORY_0" => array(
              0 => "iblock_news",
            ),
            "CATEGORY_0_iblock_news" => array(
              0 => "all",
            ),
            "CATEGORY_1_TITLE" => "Форумы",
            "CATEGORY_1" => array(
              0 => "forum",
            ),
            "CATEGORY_1_forum" => array(
              0 => "all",
            ),
            "CATEGORY_2_TITLE" => "Каталоги",
            "CATEGORY_2" => array(),
            "CATEGORY_2_iblock_books" => array(
              0 => "all",
            ),
            "CATEGORY_OTHERS_TITLE" => "Товары",
            "COMPONENT_TEMPLATE" => ".default"
          ),
          false
        );
        ?>
      </div>
      <div class="header-actions__controls">
        <a href="/search" class="header-actions__controls-item header-actions__controls-item--mobile">
          <svg class="icon icon-search ">
            <use xlink:href="#search"></use>
          </svg>
        </a>
        <a href="/comparison" class="header-actions__controls-item">
          <svg class="icon icon-chart ">
            <use xlink:href="#chart"></use>
          </svg>
          <span class="header-actions__controls-count js-comparison-count"></span>
        </a>
        <a href="/favorites" class="header-actions__controls-item">
          <svg class="icon icon-heart ">
            <use xlink:href="#heart"></use>
          </svg>
          <span class="header-actions__controls-count js-favorites-count"></span>
        </a>
        <a href="<?= $USER->IsAuthorized() ? '/personal' : '/user/authorization/'; ?>"
           class="header-actions__controls-item">
          <svg class="icon icon-user ">
            <use xlink:href="#user"></use>
          </svg>
        </a>
        <a href="/personal/order/make" class="header-actions__controls-item">
          <svg class="icon icon-bag ">
            <use xlink:href="#bag"></use>
          </svg>
          <span class="header-actions__controls-count js-basket-count"></span>
        </a>
      </div>
    </div>
  </div>

  <div class="header-navigation">
    <?
    $APPLICATION->IncludeComponent(
      "bitrix:menu",
      ".categories",
      [
        "COMPONENT_TEMPLATE" => ".categories",
        "MAX_LEVEL" => "3",
        "ROOT_MENU_TYPE" => "categories",
        "MENU_CACHE_TYPE" => "N",
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_CACHE_GET_VARS" => "",
        "USE_EXT" => "Y",
        "DELAY" => "N",
        "ALLOW_MULTI_SELECT" => "N",
        "CHILD_MENU_TYPE" => "left",
        "IS_MOBILE" => false
      ],
      false
    );
    ?>
  </div>
  <div class="header-mobile js-header-mobile">
    <?
    $APPLICATION->IncludeComponent(
      "bitrix:menu",
      ".categories",
      [
        "COMPONENT_TEMPLATE" => ".categories",
        "MAX_LEVEL" => "3",
        "ROOT_MENU_TYPE" => "categories",
        "MENU_CACHE_TYPE" => "N",
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_CACHE_GET_VARS" => "",
        "USE_EXT" => "Y",
        "DELAY" => "N",
        "ALLOW_MULTI_SELECT" => "N",
        "CHILD_MENU_TYPE" => "left",
        "IS_MOBILE" => true
      ],
      false
    );
    ?>

    <?
    $APPLICATION->IncludeComponent(
      "bitrix:menu",
      ".header",
      [
        "COMPONENT_TEMPLATE" => ".header",
        "MAX_LEVEL" => "1",
        "ROOT_MENU_TYPE" => "top",
        "MENU_CACHE_TYPE" => "N",
        "MENU_CACHE_TIME" => "3600",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_CACHE_GET_VARS" => "",
        "USE_EXT" => "Y",
        "DELAY" => "N",
        "ALLOW_MULTI_SELECT" => "N",
        "CHILD_MENU_TYPE" => "left",
        "IS_MOBILE" => true
      ],
      false
    );
    ?>
    <div class="header-mobile__footer">
      <a href="tel: <?= SiteInfo::getItem('vetLavka', 'phone') ?>" class="header-actions__links-call_phone">
        <?= SiteInfo::getItem('vetLavka', 'phone') ?>
      </a>
      <div class="header-actions__links-call_link js-open-modal" data-modal="#callback-modal">Заказать звонок</div>
    </div>
  </div>
</header>
