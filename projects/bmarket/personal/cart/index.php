<?
define("HIDE_SIDEBAR", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");

/**
 * Управление товарами в корзине
 */
include $_SERVER['DOCUMENT_ROOT'] . '/personal/cart/includes/cart-product-handler.php'
?>
<div class="page page--order">
    <?
    $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        ".default",
        Array()
    );
    ?>
    <div class="section-header container">
        <div class="title">
            <h1 class="seo-title">
                Корзина
            </h1>
        </div>
    </div>
    <? $APPLICATION->IncludeComponent(
        "bitrix:sale.basket.basket",
        ".default",
        array(
            "COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
            "COLUMNS_LIST" => array(
                0 => "NAME",
                1 => "DISCOUNT",
                2 => "PRICE",
                3 => "QUANTITY",
                4 => "SUM",
                5 => "PROPS",
                6 => "DELETE",
                7 => "DELAY",
            ),
            "AJAX_MODE" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "AJAX_OPTION_HISTORY" => "N",
            "PATH_TO_ORDER" => "/personal/order/make/",
            "HIDE_COUPON" => "N",
            "QUANTITY_FLOAT" => "N",
            "PRICE_VAT_SHOW_VALUE" => "Y",
            "TEMPLATE_THEME" => "site",
            "SET_TITLE" => "Y",
            "AJAX_OPTION_ADDITIONAL" => "",
            "OFFERS_PROPS" => array(
                0 => "SIZES_SHOES",
                1 => "SIZES_CLOTHES",
                2 => "COLOR_REF",
            ),
            "COMPONENT_TEMPLATE" => ".default",
            "DEFERRED_REFRESH" => "N",
            "USE_DYNAMIC_SCROLL" => "Y",
            "SHOW_FILTER" => "Y",
            "SHOW_RESTORE" => "Y",
            "COLUMNS_LIST_EXT" => array(
                0 => "PREVIEW_PICTURE",
                1 => "DISCOUNT",
                2 => "DELETE",
                3 => "DELAY",
                4 => "TYPE",
                5 => "SUM",
            ),
            "COLUMNS_LIST_MOBILE" => array(
                0 => "PREVIEW_PICTURE",
                1 => "DISCOUNT",
                2 => "DELETE",
                3 => "DELAY",
                4 => "TYPE",
                5 => "SUM",
            ),
            "TOTAL_BLOCK_DISPLAY" => array(
                0 => "top",
            ),
            "DISPLAY_MODE" => "extended",
            "PRICE_DISPLAY_MODE" => "Y",
            "SHOW_DISCOUNT_PERCENT" => "Y",
            "DISCOUNT_PERCENT_POSITION" => "bottom-right",
            "PRODUCT_BLOCKS_ORDER" => "props,sku,columns",
            "USE_PRICE_ANIMATION" => "Y",
            "LABEL_PROP" => array(),
            "USE_PREPAYMENT" => "N",
            "CORRECT_RATIO" => "Y",
            "AUTO_CALCULATION" => "Y",
            "ACTION_VARIABLE" => "basketAction",
            "COMPATIBLE_MODE" => "Y",
            "EMPTY_BASKET_HINT_PATH" => "/",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO",
            "ADDITIONAL_PICT_PROP_6" => "-",
            "BASKET_IMAGES_SCALING" => "adaptive",
            "USE_GIFTS" => "Y",
            "GIFTS_PLACE" => "BOTTOM",
            "GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
            "GIFTS_HIDE_BLOCK_TITLE" => "Y",
            "GIFTS_TEXT_LABEL_GIFT" => "Подарок",
            "GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
            "GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
            "GIFTS_SHOW_OLD_PRICE" => "N",
            "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
            "GIFTS_MESS_BTN_BUY" => "Выбрать",
            "GIFTS_MESS_BTN_DETAIL" => "Подробнее",
            "GIFTS_PAGE_ELEMENT_COUNT" => "99999",
            "GIFTS_CONVERT_CURRENCY" => "N",
            "GIFTS_HIDE_NOT_AVAILABLE" => "N",
            "USE_ENHANCED_ECOMMERCE" => "N"
        ),
        false
    ); ?>

    <? $APPLICATION->IncludeComponent(
        "bitrix:sale.gift.basket",
        ".default",
        array(
            "ACTION_VARIABLE" => "action",
            "ADDITIONAL_PICT_PROP_2" => "MORE_PHOTO",
            "ADDITIONAL_PICT_PROP_3" => "MORE_PHOTO",
            "ADD_PROPERTIES_TO_BASKET" => "Y",
            "BASKET_URL" => "/personal/basket.php",
            "BLOCK_TITLE" => "Выберите один из подарков",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "CART_PROPERTIES_2" => array(
                0 => "",
                1 => "CML2_MANUFACTURER",
                2 => "",
            ),
            "CART_PROPERTIES_3" => array(
                0 => "COLOR_REF",
                1 => "SIZES_SHOES",
                2 => "SIZES_CLOTHES",
                3 => "CML2_MANUFACTURER",
                4 => "",
            ),
            "COMPONENT_TEMPLATE" => ".default",
            "CONVERT_CURRENCY" => "N",
            "DEPTH" => "",
            "DETAIL_URL" => "/example/#SECTION_ID#/#ELEMENT_ID#/",
            "HIDE_BLOCK_TITLE" => "N",
            "HIDE_NOT_AVAILABLE" => "N",
            "IBLOCK_ID" => "6",
            "IBLOCK_TYPE" => "1c_catalog",
            "LINE_ELEMENT_COUNT" => "99999",
            "MESS_BTN_BUY" => "Выбрать",
            "MESS_BTN_DETAIL" => "Подробнее",
            "MESS_BTN_SUBSCRIBE" => "Подписаться",
            "OFFER_TREE_PROPS_3" => array(
                0 => "COLOR_REF",
                1 => "SIZES_SHOES",
                2 => "SIZES_CLOTHES",
            ),
            "PAGE_ELEMENT_COUNT" => "9999",
            "PARTIAL_PRODUCT_PROPERTIES" => "N",
            "PRICE_CODE" => array(
                0 => "BASE",
                1 => "Розничная",
            ),
            "PRICE_VAT_INCLUDE" => "Y",
            "PRODUCT_ID_VARIABLE" => "id",
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "PRODUCT_QUANTITY_VARIABLE" => "",
            "PRODUCT_SUBSCRIPTION" => "N",
            "PROPERTY_CODE_2" => array(
                0 => "",
                1 => "BRAND_REF",
                2 => "ARTNUMBER",
                3 => "MATERIAL",
                4 => "COLOR",
                5 => "",
            ),
            "PROPERTY_CODE_3" => array(
                0 => "ARTNUMBER",
                1 => "COLOR_REF",
                2 => "SIZES_SHOES",
                3 => "SIZES_CLOTHES",
                4 => "",
            ),
            "SECTION_CODE" => "",
            "SECTION_ELEMENT_CODE" => "",
            "SECTION_ELEMENT_ID" => "",
            "SECTION_ID" => "",
            "SHOW_DISCOUNT_PERCENT" => "Y",
            "SHOW_FROM_SECTION" => "N",
            "SHOW_IMAGE" => "Y",
            "SHOW_NAME" => "Y",
            "SHOW_OLD_PRICE" => "N",
            "SHOW_PRICE_COUNT" => "1",
            "SHOW_PRODUCTS_2" => "Y",
            "TEMPLATE_THEME" => "blue",
            "TEXT_LABEL_GIFT" => "Подарок",
            "USE_PRODUCT_QUANTITY" => "N",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO",
            "SHOW_PRODUCTS_6" => "Y",
            "PROPERTY_CODE_6" => array(
                0 => "",
                1 => "",
            ),
            "CART_PROPERTIES_6" => array(
                0 => "",
                1 => "",
            ),
            "ADDITIONAL_PICT_PROP_6" => "MORE_PHOTO"
        ),
        false
    ); ?>
</div>

<script>
    window.__BASKET_CART_PAGE__ = true
</script>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
