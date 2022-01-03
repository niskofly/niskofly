<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
/** @global CMain $APPLICATION */

$frame = $this->createFrame()->begin("");
$injectId = $arParams['UNIQ_COMPONENT_ID'];

if (isset($arResult['REQUEST_ITEMS'])) {
    CJSCore::Init(array('ajax'));

    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedParameters = $signer->sign(
        base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
        'bx.bd.products.recommendation'
    );
    $signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');
    ?>
    <div id="<?= $injectId ?>">
        <div class="container swiper-container slider-products">
            <? if ($arParams['TITLE']): ?>
                <div class="slider-products__header">
                    <div class="slider-products__header-info">
                        <? if ($arParams['TITLE']) : ?>
                            <div class="title"><?= $arParams['TITLE'] ?></div>
                        <? endif; ?>
                    </div>
                </div>
            <? endif ?>
        </div>
        <div class="container">
            <div class="loader-section">
                <div class="loader">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                </div>
                <div class="loader-section__text">
                    Ищем товары
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        BX.ready(function () {
            bx_rcm_get_from_cloud(
                '<?=CUtil::JSEscape($injectId)?>',
                <?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
                {
                    'parameters': '<?=CUtil::JSEscape($signedParameters)?>',
                    'template': '<?=CUtil::JSEscape($signedTemplate)?>',
                    'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
                    'rcm': 'yes'
                }
            );
        });
    </script>

    <?
    $frame->end();
    return;
}

if (!empty($arResult['ITEMS'])) { ?>
    <div id="<?= $injectId ?>_items">
        <div data-slider-id="default" class="container swiper-container slider-products js-slider">
            <div class="slider-products__header">
                <div class="slider-products__header-info">
                    <div class="title">
                        Вас может заинтересовать это
                    </div>
                </div>
            </div>
            <?
            $productsId = [];
            foreach ($arResult['ITEMS'] as $arItem) {
                $productsId[] = $arItem['ID'];
            }

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
            ?>
        </div>
    </div>
    <script>
        document.dispatchEvent(new CustomEvent('initAjaxSliders'))
        document.dispatchEvent(new CustomEvent('reInitProductCounters'))
        window.initSliders()
    </script>
    <?
}

$frame->end();
