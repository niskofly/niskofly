<?
$sections = [
    'mdzh' => [
        'name' => 'МДЖ',
        'filter' => ['=SECTION_ID' => 49],
    ],
    'krs' => [
        'name' => 'КРС',
        'filter' => ['=SECTION_ID' => 43],
    ],
    'loshadi' => [
        'name' => 'Лошади',
        'filter' => ['=SECTION_ID' => 46],
    ],
    'pishchevaya_industriya' => [
        'name' => 'Пищевая индустрия',
        'filter' => ['=SECTION_ID' => 56],
    ],
    'ptitsy' => [
        'name' => 'Птицы',
        'filter' => ['=SECTION_ID' => 58],
    ],
    'svini' => [
        'name' => 'Свиньи',
        'filter' => ['=SECTION_ID' => 61],
    ],
];
?>

<div class="section-popular js-tabs container">
    <div class="section-header">
        <div class="title title--medium">
            Популярные товары
        </div>
        <a href="/catalog/" class="section-header__link">Перейти в каталог</a>
    </div>

    <div class="nav-subsection">
        <?
        $isFirst = true;
        foreach ($sections as $key => $settings): ?>
            <button
                    data-tab="<?= $key ?>"
                    class="btn btn--small btn--ice nav-subsection__btn js-tab-action <? if ($isFirst) { ?>active<? } ?> ">
                <?= $settings['name'] ?>
            </button>
            <?
            $isFirst = false;
        endforeach;
        ?>
    </div>

    <? foreach ($sections as $key => $settings): ?>

        <div data-tab-content="<?= $key ?>"
             class="tab js-tab<? if (array_key_first($sections) == $key): ?> active<? endif; ?>">
            <?
            global $arrFilter;
            $arrFilter = $settings['filter'];

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
                "PAGE_ELEMENT_COUNT" => "20",
                "LINE_ELEMENT_COUNT" => "13",
                "LIST_PRODUCT_ROW_VARIANTS" => [],
                "PRICE_CODE" => array('Битрикс типовое'),
                "FILTER_PRICE_CODE" => array('Битрикс типовое'),
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

            $APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "product_home",
                array(
                    "TAB_CODE" => $key,
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
            ?>
        </div>
    <? endforeach; ?>
</div>
