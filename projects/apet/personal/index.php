<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
$APPLICATION->SetPageProperty("title", "Личный кабинет");

global $USER;
if (!$USER->IsAuthorized())
  LocalRedirect('/user/authorization/');
?>
  <div class="page page--lk-orders">
    <div class="container">

      <!-- Add breadcrumb -->
      <? $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        ".default",
        array()
      ); ?>

      <div class="page__title title">
        <h1 class="seo-title">
          <? $APPLICATION->ShowTitle(false); ?>
          <h1 class="seo-title">
      </div>

      <div class="lk-sides">

        <!-- include left side bar -->
        <? include($_SERVER["DOCUMENT_ROOT"] . "/personal/parts/lk-links.php"); ?>

        <div class="lk-content">
          <?
          $_REQUEST["show_all"] = 'Y';

          $APPLICATION->IncludeComponent(
            "bitrix:sale.personal.order",
            ".default",
            array(
              "ACTIVE_DATE_FORMAT" => "d.m.Y",
              "ALLOW_INNER" => "Y",
              "CACHE_GROUPS" => "Y",
              "CACHE_TIME" => "3600",
              "CACHE_TYPE" => "A",
              "CUSTOM_SELECT_PROPS" => array(),
              "DETAIL_HIDE_USER_INFO" => array(),
              "DISALLOW_CANCEL" => "N",
              "HISTORIC_STATUSES" => array(
                0 => "F",
              ),
              "NAV_TEMPLATE" => "",
              "ONLY_INNER_FULL" => "N",
              "ORDERS_PER_PAGE" => "9000",
              "ORDER_DEFAULT_SORT" => "ID",
              "PATH_TO_BASKET" => "/personal/order/make/",
              "PATH_TO_CATALOG" => "/catalog/",
              "PATH_TO_PAYMENT" => "/personal/order/payment/",
              "PROP_1" => array(),
              "REFRESH_PRICES" => "N",
              "RESTRICT_CHANGE_PAYSYSTEM" => array(),
              "SAVE_IN_SESSION" => "Y",
              "SEF_MODE" => "Y",
              "SET_TITLE" => "N",
              "STATUS_COLOR_F" => "gray",
              "STATUS_COLOR_N" => "green",
              "STATUS_COLOR_PSEUDO_CANCELLED" => "red",
              "COMPONENT_TEMPLATE" => ".default",
              "SEF_FOLDER" => "",
              "SEF_URL_TEMPLATES" => array(
                "list" => "index.php",
                "detail" => "order/detail/#ID#/",
                "cancel" => "order/cancel/#ID#/",
              )
            ),
            false
          );
          ?>
        </div>
      </div>
    </div>

    <!-- Подключение блока bullets из parts -->
    <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>

  </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
