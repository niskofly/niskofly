<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
  die();

global $ASSETS_VERSION;
$ASSETS_VERSION = "1.00";

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
  <?
  /**
   * open graph
   */
  include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/open-graph.php");
  ?>
  <link rel="shortcut icon" type="image/x-icon" href="/img/favicon/favicon.ico"/>
  <link href="/img/favicon/apple-icon-114x114.png" rel="apple-touch-icon" sizes="114x114"/>
  <link href="/img/favicon/apple-icon-120x120.png" rel="apple-touch-icon" sizes="120x120"/>
  <link href="/img/favicon/apple-icon-144x144.png" rel="apple-touch-icon" sizes="144x144"/>
  <link href="/img/favicon/apple-icon-152x152.png" rel="apple-touch-icon" sizes="152x152"/>
  <link href="/img/favicon/apple-icon-180x180.png" rel="apple-touch-icon" sizes="180x180"/>
  <link href="/img/favicon/android-icon-192x192.png" type="image/png" rel="icon" sizes="192x192"/>
  <link href="/img/favicon/favicon-32x32.png" type="image/png" rel="icon" sizes="32x32"/>
  <link href="/img/favicon/favicon-96x96.png" type="image/png" rel="icon" sizes="96x96"/>
  <link href="/img/favicon/favicon-16x16.png" type="image/png" rel="icon" sizes="16x16"/>
  <link href="/img/favicon/manifest.json" rel="manifes"/>
  <script type="text/javascript">window.suggestmeyes_loaded = true;</script>
  <? $APPLICATION->ShowHead(); ?>
  <link href="<?= SITE_TEMPLATE_PATH ?>/css/app.min.css?ver=<?= $ASSETS_VERSION ?>" rel="stylesheet" media="all"/>
</head>

<body>

<div id="panel">
  <? $APPLICATION->ShowPanel(); ?>
</div>

<?
/**
 * SVG ICONS
 */
include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/svg-icons.php");
?>

<div class="wrapper">
  <header class="header">
    <div class="header__top">
      <div class="container">
        <div class="header__top-info">
          <div class="header__top-contacts">
            <button type="button" data-win="location"
                    class="header__top-location js-open-custom-window">
              <span>Москва</span>
              <svg class="icon icon-down ">
                <use xlink:href="#down"></use>
              </svg>
            </button>
            <a href="tel:<?= SiteInfo::getItem('globalVet', 'phone') ?>"
               class="header__phone">
              <?= SiteInfo::getItem('globalVet', 'phone') ?></a>
          </div>
          <?
          $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "header",
            array(
              "COMPONENT_TEMPLATE" => "header",
              "MAX_LEVEL" => "1",
              "ROOT_MENU_TYPE" => "header",
              "MENU_CACHE_TYPE" => "N",
              "MENU_CACHE_TIME" => "3600",
              "MENU_CACHE_USE_GROUPS" => "Y",
              "MENU_CACHE_GET_VARS" => "",
              "USE_EXT" => "Y",
              "DELAY" => "N",
              "ALLOW_MULTI_SELECT" => "N",
              "CHILD_MENU_TYPE" => "left",
            ),
            false
          );
          ?>
        </div>
        <div class="window-location js-window-location">
          <div class="window-location__header">
            <div class="window-location__title">Ваш город <span>Москва</span>?</div>
          </div>
          <div class="window-location__actions">
            <button type="button" class="btn btn--medium btn--ice window-location__action">Нет</button>
            <button type="button" class="btn btn--medium btn--blue window-location__action">Да</button>
          </div>
        </div>
      </div>
    </div>
    <div class="header__bottom">
      <div class="container">
        <div class="header__bottom-navigation">
          <a href="/" class="header__logo">
            <img src="/img/logo_globalvet_gv.png"/>
          </a>
          <?
          $APPLICATION->IncludeComponent(
            "bitrix:search.title",
            "header",
            array(
              "SHOW_INPUT" => "Y",
              "INPUT_ID" => "title-search-input",
              "CONTAINER_ID" => "title-search",
              "PRICE_CODE" => array(
                0 => "BASE",
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
                0 => "iblock_catalog",
              ),
              "CATEGORY_0_iblock_catalog" => array(
                0 => "all",
              ),
              "CATEGORY_OTHERS_TITLE" => "Также",
              "COMPONENT_TEMPLATE" => "header"
            ),
            false
          );
          ?>
          <div class="user-menu header__user-menu">
            <?
            /* Сравнение товара */
            $APPLICATION->IncludeComponent(
              "bitrix:catalog.compare.list",
              "link-counter",
              array(
                "AJAX_MODE" => "Y",
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => CATALOG_ID,
                "POSITION_FIXED" => "N",
                "POSITION" => "top left",
                "DETAIL_URL" => "",
                "COMPARE_URL" => "/catalog/compare/",
                "NAME" => "CATALOG_COMPARE_LIST",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "N",
                "AJAX_OPTION_HISTORY" => "N",
                "ACTION_VARIABLE" => "action",
                "PRODUCT_ID_VARIABLE" => "id",
                "COMPONENT_TEMPLATE" => "link-counter",
                "AJAX_OPTION_ADDITIONAL" => ""
              ),
              false
            );

            /* Избранное */
            $countFavorites = null;
            try {
              $countFavorites = (new UserFavoriteProducts())->getCountFavorites();
            } catch (Exception $e) {
              $isCountFavouriteException = true;
            }
            ?>
            <a href="/favorites/" class="user-menu__button">
              <svg class="icon icon-heart ">
                <use xlink:href="#heart"></use>
              </svg>
              <span>Избранное</span>
              <span
                class="user-menu__button-amount js-favorites-counter"><?= ($countFavorites) ? $countFavorites : ''; ?></span>
            </a>

            <div class="user-menu__button user-menu__button--spacer"></div>

            <!-- Пользователь -->
            <a href="<?= $USER->IsAuthorized() ? '/personal/' : '/auth/'; ?>"
               class="user-menu__button">
              <svg class="icon icon-user ">
                <use xlink:href="#user"></use>
              </svg>
              <span><?= $USER->IsAuthorized() ? $USER->GetLogin() : 'Кабинет'; ?></span>
            </a>
            <?
            /* Малая корзина */
            $cntBasketItems = ItemsBitrixCart::getCountBasketItems();
            $cntBasketItems = $cntBasketItems ?: '';
            ?>
            <a href="/order/"
               class="user-menu__button js-small-basket<?= ($cntBasketItems) ? '' : ' user-menu__button--empty'; ?>">
              <svg class="icon icon-bag ">
                <use xlink:href="#bag"></use>
              </svg>
              <span>Корзина</span>
              <span class="user-menu__button-amount js-small-basket-counter"><?= $cntBasketItems; ?></span>
            </a>
          </div>
        </div>

        <?
        $APPLICATION->IncludeComponent(
          "bitrix:menu",
          "catalog",
          array(
            "COMPONENT_TEMPLATE" => "catalog",
            "MAX_LEVEL" => "3",
            "ROOT_MENU_TYPE" => "header_catalog",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_CACHE_GET_VARS" => "",
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "N",
            "CHILD_MENU_TYPE" => "left",
          ),
          false
        );
        ?>
      </div>
    </div>
  </header>
