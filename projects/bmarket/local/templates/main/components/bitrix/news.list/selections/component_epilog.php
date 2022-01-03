<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$replacerProductsList = function ($matches) use ($APPLICATION, $arResult) {
    ob_start();
    $selectionId = $matches[1];
    $productsId = $arResult['CACHED_SELECTION_PRODUCTS'][$selectionId];

    if (!empty($productsId)) {
        global $arrFilter;
        $arrFilter['=ID'] = $productsId;

        $arDefaultCatalogParams = DEFAULT_CATALOG_COMPONENT_PARAMS;

        $APPLICATION->IncludeComponent(
            'bitrix:catalog.section',
            'slider',
            array(
                "NO_INIT_SLIDER" => "Y",
                "SET_TITLE" => "N",
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
                "PAGE_ELEMENT_COUNT" => 10,
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
    }

    return ob_get_clean();
};

$replacerBanner = function () use ($APPLICATION) {
    ob_start();

    if ($APPLICATION->GetCurPage(false) === '/'):
        ?>
        <div class="section-collections container"><? $APPLICATION->IncludeComponent(
                "bitrix:advertising.banner",
                ".default",
                Array(
                    "CACHE_TIME" => "0",
                    "CACHE_TYPE" => "A",
                    "COMPONENT_TEMPLATE" => ".default",
                    "NOINDEX" => "Y",
                    "QUANTITY" => "1",
                    "TYPE" => "home_bottom_full"
                )
            ); ?></div>
    <?
    endif;
    return ob_get_clean();
};

/**
 * Добавление в вывод списков товаров по подборкам
 */
$content = preg_replace_callback(
    "/#SELECTIONS_PRODUCTS([\\d]+)#/is" . BX_UTF_PCRE_MODIFIER,
    $replacerProductsList,
    $arResult["CACHED_TPL"]
);

/**
 * Добавление в вывод настраиваемого баннера
 */
$content = preg_replace_callback(
    "/#SELECTIONS_BANNER#/is" . BX_UTF_PCRE_MODIFIER,
    $replacerBanner,
    $content
);

echo $content;
