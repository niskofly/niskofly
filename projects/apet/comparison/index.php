<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Сравнение");
$APPLICATION->SetPageProperty("title", "Сравнение");
?>

  <div class="page page--comparison">
    <div class="container">

      <!-- Add breadcrumb -->
      <? $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        ".default",
        array()
      ); ?>

      <div class="page__title title">
        <h1 class="seo-title">
          Сравнение товаров
        </h1>
      </div>

      <? $APPLICATION->IncludeComponent(
        "bitrix:catalog.compare.result",
        ".comparison",
        array(
          "AJAX_MODE" => "N",
          "NAME" => "CATALOG_COMPARE_LIST",
          "IBLOCK_TYPE" => "catalog",
          "IBLOCK_ID" => CATALOG_ID,
          "FIELD_CODE" => array(
            0 => "NAME",
            1 => "PREVIEW_PICTURE",
          ),
          "PROPERTY_CODE" => "",
          "OFFERS_FIELD_CODE" => "",
          "OFFERS_PROPERTY_CODE" => "",
          "ELEMENT_SORT_FIELD" => "sort",
          "ELEMENT_SORT_ORDER" => "asc",
          "DETAIL_URL" => "",
          "BASKET_URL" => "/personal/basket.php",
          "ACTION_VARIABLE" => "action",
          "PRODUCT_ID_VARIABLE" => "id",
          "SECTION_ID_VARIABLE" => "SECTION_ID",
          "PRICE_CODE" => array(
            0 => "ruble",
          ),
          "USE_PRICE_COUNT" => "Y",
          "SHOW_PRICE_COUNT" => "1",
          "PRICE_VAT_INCLUDE" => "Y",
          "DISPLAY_ELEMENT_SELECT_BOX" => "Y",
          "ELEMENT_SORT_FIELD_BOX" => "name",
          "ELEMENT_SORT_ORDER_BOX" => "asc",
          "ELEMENT_SORT_FIELD_BOX2" => "id",
          "ELEMENT_SORT_ORDER_BOX2" => "desc",
          "HIDE_NOT_AVAILABLE" => "N",
          "AJAX_OPTION_SHADOW" => "Y",
          "AJAX_OPTION_JUMP" => "N",
          "AJAX_OPTION_STYLE" => "N",
          "AJAX_OPTION_HISTORY" => "N",
          "CONVERT_CURRENCY" => "Y",
          "CURRENCY_ID" => "RUB",
          "TEMPLATE_THEME" => "blue",
          "COMPONENT_TEMPLATE" => ".comparison",
          "AJAX_OPTION_ADDITIONAL" => ""
        ),
        false
      ); ?>
    </div>

    <!-- Подключение блока bullets из parts -->
    <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>
  </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
