<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Оформление заказа");
$APPLICATION->SetPageProperty("title", "Оформление заказа");
?>

    <div class="page page--cart">
        <div class="container">

            <!-- Add breadcrumb -->
            <? $APPLICATION->IncludeComponent(
                "bitrix:breadcrumb",
                ".default",
                array()
            ); ?>

            <? $APPLICATION->IncludeComponent(
                "webest:sale.order.ajax",
                ".custom",
                array(
                    "ADDITIONAL_PICT_PROP_8" => "-",
                    "ALLOW_AUTO_REGISTER" => "Y",
                    "ALLOW_NEW_PROFILE" => "Y",
                    "ALLOW_USER_PROFILES" => "Y",
                    "BASKET_IMAGES_SCALING" => "standard",
                    "BASKET_POSITION" => "before",
                    "COMPATIBLE_MODE" => "Y",
                    "DELIVERIES_PER_PAGE" => "8",
                    "DELIVERY_FADE_EXTRA_SERVICES" => "Y",
                    "DELIVERY_NO_AJAX" => "Y",
                    "DELIVERY_NO_SESSION" => "Y",
                    "DELIVERY_TO_PAYSYSTEM" => "d2p",
                    "DISABLE_BASKET_REDIRECT" => "Y",
                    "PATH_TO_AUTH" => "/user/authorization",
                    "PATH_TO_BASKET" => "basket.php",
                    "PATH_TO_PAYMENT" => "payment.php",
                    "PATH_TO_PERSONAL" => "/personal/",
                    "PAY_FROM_ACCOUNT" => "Y",
                    "ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
                    "PAY_SYSTEMS_PER_PAGE" => "8",
                    "PICKUPS_PER_PAGE" => "5",
                    "PRODUCT_COLUMNS_HIDDEN" => array(),
                    "PRODUCT_COLUMNS_VISIBLE" => array(
                        0 => "PREVIEW_PICTURE",
                        1 => "DETAIL_PICTURE",
                        2 => "PREVIEW_TEXT",
                        3 => "PROPS",
                        4 => "NOTES",
                        5 => "DISCOUNT_PRICE_PERCENT_FORMATED",
                        6 => "PRICE_FORMATED",
                        7 => "PROPERTY_BRAND",
                    ),
                    "PROPS_FADE_LIST_1" => array(),
                    "SEND_NEW_USER_NOTIFY" => "Y",
                    "SERVICES_IMAGES_SCALING" => "standard",
                    "SET_TITLE" => "Y",
                    "SHOW_BASKET_HEADERS" => "N",
                    "SHOW_COUPONS_BASKET" => "Y",
                    "SHOW_COUPONS_DELIVERY" => "Y",
                    "SHOW_COUPONS_PAY_SYSTEM" => "Y",
                    "SHOW_DELIVERY_INFO_NAME" => "Y",
                    "SHOW_DELIVERY_LIST_NAMES" => "Y",
                    "SHOW_DELIVERY_PARENT_NAMES" => "Y",
                    "SHOW_MAP_IN_PROPS" => "N",
                    "SHOW_NEAREST_PICKUP" => "N",
                    "SHOW_NOT_CALCULATED_DELIVERIES" => "L",
                    "SHOW_ORDER_BUTTON" => "final_step",
                    "SHOW_PAY_SYSTEM_INFO_NAME" => "Y",
                    "SHOW_PAY_SYSTEM_LIST_NAMES" => "Y",
                    "SHOW_STORES_IMAGES" => "N",
                    "SHOW_TOTAL_ORDER_BUTTON" => "Y",
                    "SHOW_VAT_PRICE" => "Y",
                    "SKIP_USELESS_BLOCK" => "N",
                    "TEMPLATE_LOCATION" => "popup",
                    "TEMPLATE_THEME" => "site",
                    "USE_CUSTOM_ADDITIONAL_MESSAGES" => "N",
                    "USE_CUSTOM_ERROR_MESSAGES" => "Y",
                    "USE_CUSTOM_MAIN_MESSAGES" => "N",
                    "USE_PREPAYMENT" => "N",
                    "USE_YM_GOALS" => "N",
                    "USER_CONSENT" => "N",
                    "USER_CONSENT_ID" => "0",
                    "USER_CONSENT_IS_CHECKED" => "Y",
                    "USER_CONSENT_IS_LOADED" => "N",
                    "COMPONENT_TEMPLATE" => ".custom",
                    "ALLOW_APPEND_ORDER" => "Y",
                    "SPOT_LOCATION_BY_GEOIP" => "Y",
                    "USE_PRELOAD" => "Y",
                    "SHOW_PICKUP_MAP" => "Y",
                    "PICKUP_MAP_TYPE" => "yandex",
                    "SHOW_COUPONS" => "Y",
                    "PROPS_FADE_LIST_2" => array(),
                    "ACTION_VARIABLE" => "soa-action",
                    "EMPTY_BASKET_HINT_PATH" => "/",
                    "USE_PHONE_NORMALIZATION" => "Y",
                    "ADDITIONAL_PICT_PROP_1" => "-",
                    "HIDE_ORDER_DESCRIPTION" => "N",
                    "USE_ENHANCED_ECOMMERCE" => "N",
                    "MESS_SUCCESS_PRELOAD_TEXT" => "Вы заказывали в нашем интернет-магазине, поэтому мы заполнили все данные автоматически.<br />Если все заполнено верно, нажмите кнопку \"#ORDER_BUTTON#\".",
                    "MESS_FAIL_PRELOAD_TEXT" => "Вы заказывали в нашем интернет-магазине, поэтому мы заполнили все данные автоматически.<br />Обратите внимание на развернутый блок с информацией о заказе. Здесь вы можете внести необходимые изменения или оставить как есть и нажать кнопку \"#ORDER_BUTTON#\".",
                    "MESS_DELIVERY_CALC_ERROR_TITLE" => "Не удалось рассчитать стоимость доставки.",
                    "MESS_DELIVERY_CALC_ERROR_TEXT" => "Вы можете продолжить оформление заказа, а чуть позже менеджер магазина свяжется с вами и уточнит информацию по доставке.",
                    "MESS_PAY_SYSTEM_PAYABLE_ERROR" => "Вы сможете оплатить заказ после того, как менеджер проверит наличие полного комплекта товаров на складе. Сразу после проверки вы получите письмо с инструкциями по оплате. Оплатить заказ можно будет в личном кабинете.",
                    "ADDITIONAL_PICT_PROP_4" => "-",
                    "ADDITIONAL_PICT_PROP_18" => "-"
                ),
                false
            ); ?>
        </div>

        <!-- Подключение блока bullets из parts -->
        <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>

    </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
