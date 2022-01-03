<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
/** @var array $arCurSection */

$this->setFrameMode(true);
?>

<? $ElementID = $APPLICATION->IncludeComponent(
  "bitrix:news.detail",
  "",
  array(
    "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
    "DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
    "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
    "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
    "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
    "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
    "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
    "META_KEYWORDS" => $arParams["META_KEYWORDS"],
    "META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
    "BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
    "SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
    "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
    "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
    "SET_TITLE" => $arParams["SET_TITLE"],
    "MESSAGE_404" => $arParams["MESSAGE_404"],
    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
    "SHOW_404" => $arParams["SHOW_404"],
    "FILE_404" => $arParams["FILE_404"],
    "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
    "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
    "ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
    "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
    "DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
    "DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
    "PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
    "PAGER_SHOW_ALWAYS" => "N",
    "PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
    "PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
    "CHECK_DATES" => $arParams["CHECK_DATES"],
    "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
    "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
    "IBLOCK_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
    "USE_SHARE" => $arParams["USE_SHARE"],
    "SHARE_HIDE" => $arParams["SHARE_HIDE"],
    "SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
    "SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
    "SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
    "SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
    "ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : ''),
    'STRICT_SECTION_CHECK' => (isset($arParams['STRICT_SECTION_CHECK']) ? $arParams['STRICT_SECTION_CHECK'] : ''),
  ),
  $component
); ?>

<!-- Include settings sorting catalog  -->
<? include($_SERVER["DOCUMENT_ROOT"] . "/catalog/parts/sorting.php"); ?>

<div class="catalog-sides">
  <?
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
    "HIDE_NOT_AVAILABLE" => "Y",
    "HIDE_NOT_AVAILABLE_OFFERS" => "Y",
    "LIST_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
    "ADD_TO_BASKET_ACTION" => "ADD",
    "IBLOCK_TYPE" => 'catalog',
    "SEF_MODE" => 'N',
    "IBLOCK_ID" => CATALOG_ID,
    "FILTER_NAME" => 'arrFilter'
  ];

  global $sortSetting;
  global $PRE_FILTER;
  global $SHARE_PRODUCTS;
  $PRE_FILTER['=ID'] = $SHARE_PRODUCTS;

  /* Фильтр */

  $APPLICATION->IncludeComponent(
    "bitrix:catalog.smart.filter",
    ".default",
    array(
      "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
      "IBLOCK_ID" => $arParams["IBLOCK_ID"],
      "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
      "PREFILTER_NAME" => 'PRE_FILTER',
      "FILTER_NAME" => $arParams["FILTER_NAME"],
      "PRICE_CODE" => $arParams["~PRICE_CODE"],
      "CACHE_TYPE" => $arParams["CACHE_TYPE"],
      "CACHE_TIME" => $arParams["CACHE_TIME"],
      "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
      "SAVE_IN_SESSION" => "N",
      "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
      "XML_EXPORT" => "N",
      "SECTION_TITLE" => "NAME",
      "SECTION_DESCRIPTION" => "DESCRIPTION",
      'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
      "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
      'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
      'CURRENCY_ID' => $arParams['CURRENCY_ID'],
      "SEF_MODE" => $arParams["SEF_MODE"],
      "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
      "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
      "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
    ),
    $component,
    array('HIDE_ICONS' => 'Y')
  );
  ?>

  <!-- Сортировка -->
  <div class="catalog-content">
    <div class="catalog-options">
      <div class="catalog-sorting stock-sorting">
        <div class="dropdown">
          <div class="dropdown__description">Сортировать по:</div>
          <?
          if (isset($sortSetting) && !empty($sortSetting)):
            ?>
            <div class="custom-select js-custom-select">
              <button class="custom-select__header js-custom-select-toggle">
                <span class="custom-select__selected js-custom-select-render">Популярности</span>
                <span class="custom-select__arrow">
                        <svg class="icon icon-hesrts-active ">
                          <use xlink:href="#hesrts-active"></use>
                        </svg>
                </span>
              </button>
              <div class="custom-select__body js-custom-select-list">
                <? foreach ($sortSetting as $key => $option) : ?>
                  <label class="custom-select__option">
                    <input name="test"
                           type="checkbox"
                           class="js-catalog-sorting"
                           value="<?= $key ?>"
                      <? if ($_COOKIE["SORT_SETTING"] == $key) { ?> checked <? } ?>
                    >
                    <span class="custom-select__label"><?= $option['NAME'] ?></span>
                  </label>
                <? endforeach; ?>
              </div>
            </div>
          <? endif; ?>
        </div>
      </div>
    </div>

    <!-- Отображение товаров -->
    <?
    if ($SHARE_PRODUCTS) {
      $APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        ".default",
        array(
          "HIDE_SECTION_DESCRIPTION" => "Y",
          "SET_TITLE" => "N",
          "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
          "IBLOCK_ID" => $arParams["IBLOCK_ID"],
          "ELEMENT_SORT_FIELD" => $actualSorting["ELEMENT_SORT_FIELD"],
          "ELEMENT_SORT_ORDER" => $actualSorting["ELEMENT_SORT_ORDER"],
          "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
          "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
          "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
          "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
          "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
          "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
          "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
          "FILTER_NAME" => "arrFilter",
          "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
          "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
          "PRICE_CODE" => $arParams["PRICE_CODE"],
          "PRICE_VAT_INCLUDE" => "Y",
          "USE_PRODUCT_QUANTITY" => "Y",
          "PRODUCT_PROPERTIES" => [],
          "OFFERS_CART_PROPERTIES" => [],
          "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
          "OFFERS_PROPERTY_CODE" => [],
          "SECTION_ID" => "",
          "SHOW_ALL_WO_SECTION" => "Y",
          "SECTION_CODE" => "",
          "SECTION_URL" => $arParams["SECTION_URL"],
          "DETAIL_URL" => $arParams["DETAIL_URL"],
          "USE_MAIN_ELEMENT_SECTION" => "Y",
          'CONVERT_CURRENCY' => "Y",
          'CURRENCY_ID' => $arParams['CURRENCY_ID'],
          'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
          'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],
          'PRODUCT_DISPLAY_MODE' => "Y",
          'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
          'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
          'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
          "ADD_SECTIONS_CHAIN" => $arParams['ADD_SECTIONS_CHAIN'],
          'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
        ),
        false
      );
    } else {
      ?><p>Товары отсутствуют</p><?
    }
    ?>
  </div>
</div>



