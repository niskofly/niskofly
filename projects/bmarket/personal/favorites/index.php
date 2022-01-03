<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
global $USER;

if (!$USER->IsAuthorized())
    LocalRedirect('/auth/');

$favorites = (new UserFavoriteProducts())->getFavorites();
?>
<div class="page page--lk">
    <div class="section-header container">
        <div class="title">
            <?= $APPLICATION->ShowTitle(false) ?>
        </div>
    </div>

    <? include($_SERVER['DOCUMENT_ROOT'] . '/personal/includes/menu.php') ?>

    <? if (!empty($favorites)) : ?>
        <div class="section-favorites container js-favorite-products">
            <?
            global $arrFilter;
            $arrFilter['=ID'] = $favorites;
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
                    "PAGE_ELEMENT_COUNT" => 100,
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

    <div class="section-favorites container js-favorite-products-empty"
         style="<? echo !empty($favorites) ? 'display:none' : '' ?>">
        <div class="section-message container">
            <div class="alert-message">
                <img src="/img/icons/waving-hand.svg" class="alert-message__logo">
                <div class="title title--medium">
                    Товары не добавлены в избранное
                </div>
                <div class="alert-message__text">
                    Перейдите в каталог и добавьте понравившиеся товары в избранное.
                </div>
                <div class="alert-message__actions">
                    <a href="/catalog/" class="btn">В каталог</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    __IS_PAGE_FAVORITE__ = true
</script>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
