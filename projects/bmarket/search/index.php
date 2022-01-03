<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");
?>
<div class="page page--search">
    <? $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        ".default",
        Array()
    ); ?>

    <div class="section-header container">
        <div class="title">
            <h1 class="seo-title">
                <?= $APPLICATION->ShowTitle(false) ?>
            </h1>
        </div>
    </div>
    <div class="container">
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:search.page",
            ".default",
            array(
                "RESTART" => "Y",
                "CHECK_DATES" => "Y",
                "USE_TITLE_RANK" => "Y",
                "DEFAULT_SORT" => "rank",
                "arrFILTER_main" => "",
                "SHOW_WHERE" => "N",
                "SHOW_WHEN" => "N",
                "PAGE_RESULT_COUNT" => "999999999",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_SHADOW" => "Y",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "N",
                "AJAX_OPTION_HISTORY" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "DISPLAY_TOP_PAGER" => "N",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "PAGER_TITLE" => "Результаты поиска",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => "",
                "USE_SUGGEST" => "N",
                "SHOW_ITEM_TAGS" => "N",
                "SHOW_ITEM_DATE_CHANGE" => "N",
                "SHOW_ORDER_BY" => "N",
                "SHOW_TAGS_CLOUD" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "COMPONENT_TEMPLATE" => ".default",
                "NO_WORD_LOGIC" => "N",
                "FILTER_NAME" => "",
                "USE_LANGUAGE_GUESS" => "Y",
                "SHOW_RATING" => "",
                "RATING_TYPE" => "",
                "PATH_TO_USER_PROFILE" => "",
                "COMPOSITE_FRAME_MODE" => "A",
                "COMPOSITE_FRAME_TYPE" => "AUTO",
                "arrFILTER" => array(
                    0 => "iblock_1c_catalog",
                ),
                "arrFILTER_iblock_catalog" => array(
                    0 => "all",
                ),
                "arrFILTER_iblock_content" => array(
                    0 => "4",
                ),
                "arrFILTER_iblock_1c_catalog" => array(
                    0 => "6",
                )
            ),
            false
        );
        ?>
    </div>
    <?
    global $GOODS_ID;

    if (!empty($GOODS_ID)): ?>
        <div class="container" style="margin-top: 45px">
            <?
            global $arrFilter;
            $arrFilter['=ID'] = $GOODS_ID;
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
                    "PAGE_ELEMENT_COUNT" => 300,
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
    <? endif; ?>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
