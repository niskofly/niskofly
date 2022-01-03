<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Избранные товары");
$APPLICATION->SetPageProperty("title", "Избранные товары");

global $USER;

$isAuthUser = $USER->IsAuthorized();

try {
  if ($isAuthUser)
    $favorites = (new UserFavoriteProducts())->getFavorites();
  else
    $favorites = (new CookieFieldHandler('favorite_no_auth'))->getElements();
} catch (Exception $e) {
  $isFavouriteException = true;
}
?>

<div class="page page--wishlist">
  <div class="container">
    <!-- Add breadcrumb -->
    <? $APPLICATION->IncludeComponent(
      "bitrix:breadcrumb",
      ".default",
      array()
    ); ?>

    <!-- Title page -->
    <div class="page__title title">
      <h1 class="seo-title">
        <? $APPLICATION->ShowTitle(false); ?>
      </h1>
    </div>

    <!-- Block favourites content -->
    <div class="js-favourite-container">
      <? if ($favorites && !empty($favorites)) {
        $arParams = [
          "ELEMENT_SORT_FIELD" => "sort",
          "ELEMENT_SORT_ORDER" => "asc",
          "ELEMENT_SORT_FIELD2" => "id",
          "ELEMENT_SORT_ORDER2" => "desc",
          "ACTION_VARIABLE" => "action",
          "PRODUCT_ID_VARIABLE" => "id",
          "SECTION_ID_VARIABLE" => "SECTION_ID",
          "PRODUCT_QUANTITY_VARIABLE" => "quantity",
          "PRODUCT_PROPS_VARIABLE" => "prop",
          "PAGE_ELEMENT_COUNT" => "99999",
          "LINE_ELEMENT_COUNT" => "3",
          "LIST_PRODUCT_ROW_VARIANTS" => [],
          "PRICE_CODE" => array('Битрикс VetLavka.ru'),
          "FILTER_PRICE_CODE" => array('Битрикс VetLavka.ru'),
          "LIST_OFFERS_FIELD_CODE" => ['NAME'],
          "DETAIL_URL" => "/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
          "CURRENCY_ID" => "RUB",
          "HIDE_NOT_AVAILABLE" => "N",
          "HIDE_NOT_AVAILABLE_OFFERS" => "N",
          "LIST_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
          "ADD_TO_BASKET_ACTION" => "ADD",
          "IBLOCK_TYPE" => "catalog",
          "IBLOCK_ID" => CATALOG_ID,
          "FILTER_NAME" => "arrFilter",
          "PRICE_VAT_INCLUDE" => "Y",
          "USE_PRODUCT_QUANTITY" => "Y",
          "USE_MAIN_ELEMENT_SECTION" => "Y",
          "CONVERT_CURRENCY" => "Y",
          "PRODUCT_DISPLAY_MODE" => "Y",
        ];

        global $arrFilter;
        $arrFilter['=ID'] = $favorites;

        $res = $APPLICATION->IncludeComponent(
          "bitrix:catalog.section",
          ".favorite",
          array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
            "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
            "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
            "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
            "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
            "FILTER_NAME" => $arParams["FILTER_NAME"],
            "SET_TITLE" => $arParams["SET_TITLE"],
            "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
            "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
            "USE_PRODUCT_QUANTITY" => $arParams["USE_PRODUCT_QUANTITY"],
            "PRODUCT_PROPERTIES" => [],
            "OFFERS_CART_PROPERTIES" => [],
            "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
            "OFFERS_PROPERTY_CODE" => [],
            "SECTION_ID" => "",
            "SECTION_CODE" => "",
            "SECTION_URL" => $arParams["SECTION_URL"],
            "DETAIL_URL" => $arParams["DETAIL_URL"],
            "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
            'CONVERT_CURRENCY' => $arParams["CONVERT_CURRENCY"],
            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
            'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
            'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
            'PRODUCT_DISPLAY_MODE' => $arParams["PRODUCT_DISPLAY_MODE"],
            'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
            'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
            "ADD_SECTIONS_CHAIN" => $arParams['ADD_SECTIONS_CHAIN'],
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
          ),
          false
        );
      } else { ?>
        <p>Избранные товары отсутствуют</p>
      <? } ?>
    </div>
  </div>
  <!-- Подключение блока bullets из parts -->
  <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>
</div>

<script>
  window.__IS_PAGE_FAVORITE__ = true;
</script>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
