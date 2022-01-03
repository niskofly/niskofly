<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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


$this->setFrameMode(true);
?>
<? $ElementID = $APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "",
    Array(
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
);

$discountId = null;
$propsRequest = CIBlockElement::GetProperty($arParams['IBLOCK_ID'], $ElementID, array("sort" => "asc"), Array("CODE" => "DISCOUNT_ID"));
if ($prop = $propsRequest->Fetch())
    $discountId = (int)$prop["VALUE"];

if ($discountId) {
    $productIds = getProductIdsFromDiscount($discountId);
    if (!empty($productIds)): ?>
        <div class="container">
            <?
            global $arrFilter;
            $arrFilter['=ID'] = $productIds;
            $arDefaultCatalogParams = DEFAULT_CATALOG_COMPONENT_PARAMS;

            $APPLICATION->IncludeComponent(
                'bitrix:catalog.section',
                '.default',
                array(
                    "IBLOCK_TYPE" => $arDefaultCatalogParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arDefaultCatalogParams["IBLOCK_ID"],
                    "ELEMENT_SORT_FIELD" => $arDefaultCatalogParams["ELEMENT_SORT_FIELD"],
                    "ELEMENT_SORT_ORDER" => $arDefaultCatalogParams["ELEMENT_SORT_ORDER"],
                    "ELEMENT_SORT_FIELD2" => $arDefaultCatalogParams["ELEMENT_SORT_FIELD2"],
                    "ELEMENT_SORT_ORDER2" => $arDefaultCatalogParams["ELEMENT_SORT_ORDER2"],
                    "ACTION_VARIABLE" => $arDefaultCatalogParams["ACTION_VARIABLE"],
                    "PRODUCT_ID_VARIABLE" => $arDefaultCatalogParams["PRODUCT_ID_VARIABLE"],
                    "SECTION_ID_VARIABLE" => $arDefaultCatalogParams["SECTION_ID_VARIABLE"],
                    "PRODUCT_QUANTITY_VARIABLE" => $arDefaultCatalogParams["PRODUCT_QUANTITY_VARIABLE"],
                    "PRODUCT_PROPS_VARIABLE" => $arDefaultCatalogParams["PRODUCT_PROPS_VARIABLE"],
                    "FILTER_NAME" => "arrFilter",
                    "PAGE_ELEMENT_COUNT" => 20,
                    "LINE_ELEMENT_COUNT" => 10,
                    "PRICE_CODE" => $arDefaultCatalogParams["PRICE_CODE"],

                    "PRICE_VAT_INCLUDE" => "Y",
                    "USE_PRODUCT_QUANTITY" => "Y",
                    "PRODUCT_PROPERTIES" => [],

                    "OFFERS_CART_PROPERTIES" => [],
                    "OFFERS_FIELD_CODE" => $arDefaultCatalogParams["LIST_OFFERS_FIELD_CODE"],
                    "OFFERS_PROPERTY_CODE" => [],

                    "SECTION_ID" => "",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "SECTION_CODE" => "",
                    "SECTION_URL" => $arDefaultCatalogParams["SECTION_URL"],
                    "DETAIL_URL" => $arDefaultCatalogParams["DETAIL_URL"],

                    "USE_MAIN_ELEMENT_SECTION" => "Y",
                    'CONVERT_CURRENCY' => "Y",
                    'CURRENCY_ID' => $arDefaultCatalogParams['CURRENCY_ID'],
                    'HIDE_NOT_AVAILABLE' => $arDefaultCatalogParams["HIDE_NOT_AVAILABLE"],
                    'HIDE_NOT_AVAILABLE_OFFERS' => $arDefaultCatalogParams["HIDE_NOT_AVAILABLE_OFFERS"],

                    'PRODUCT_DISPLAY_MODE' => "Y",
                    'PRODUCT_BLOCKS_ORDER' => $arDefaultCatalogParams['LIST_PRODUCT_BLOCKS_ORDER'],
                    'PRODUCT_ROW_VARIANTS' => $arDefaultCatalogParams['LIST_PRODUCT_ROW_VARIANTS'],
                    'SHOW_OLD_PRICE' => $arDefaultCatalogParams['SHOW_OLD_PRICE'],


                    "ADD_SECTIONS_CHAIN" => $arDefaultCatalogParams['ADD_SECTIONS_CHAIN'],
                    'ADD_TO_BASKET_ACTION' => $arDefaultCatalogParams['ADD_TO_BASKET_ACTION'],
                ),
                false
            );
            ?>
        </div>
    <? endif;
}
?>
