<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Подписки на поступления");
$APPLICATION->SetPageProperty("title", "Подписки на поступления");

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
      </h1>
    </div>

    <div class="lk-sides">

      <!-- include left side bar -->
      <? include($_SERVER["DOCUMENT_ROOT"] . "/personal/parts/lk-links.php"); ?>

      <? $APPLICATION->IncludeComponent(
        "bitrix:catalog.product.subscribe.list",
        "",
        [
          "CACHE_TIME" => "3600",
          "CACHE_TYPE" => "A",
          "LINE_ELEMENT_COUNT" => "3"
        ]
      ); ?>
    </div>
  </div>

  <!-- Подключение блока bullets из parts -->
  <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
