<?php

define('SMSRU_KEY', 'D2A04D18-A6AC-90C4-0B96-C24097981566');
define('NO_IMAGE_SRC', '/img/no_photo.png');
define('YANDEX_MAP_SRC', '//api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=ddd3730b-6500-4ad2-8af2-36d72cbbca77');
define('CATALOG_ID', 6);
define('POLICY_LINK', '/privacy-policy/');
define('DOMAIN', 'http://dev.bubblegum.market');

define('RECAPTCHA_SITE_KEY', '');
define('RECAPTCHA_SECRET_KEY', '');

define('PRICE_CODE', 'Розничная');
define('PRICE_ID', 2);

/**
 * Процент от стоимости товара начисляемый на бонусный счёт
 */
define('BONUSES_PERCENT', 5);

/**
 * Настройки для компонентов каталога по умолчанию
 */
define('DEFAULT_CATALOG_COMPONENT_PARAMS', [
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
    "PRICE_CODE" => [PRICE_CODE],
    "FILTER_PRICE_CODE" => [PRICE_CODE],
    "LIST_OFFERS_FIELD_CODE" => ['NAME'],
    "DETAIL_URL" => "/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
    "CURRENCY_ID" => "RUB",
    "HIDE_NOT_AVAILABLE" => "N",
    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
    "LIST_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
    "ADD_TO_BASKET_ACTION" => "ADD",
    "IBLOCK_TYPE" => CATALOG_TYPE,
    "IBLOCK_ID" => CATALOG_ID
]);

/**
 * Подключение обработчиков событий
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/event-handlers.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/event-handlers.php");

/**
 * Подключение класса для доп обработки товара
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/ItemsBitrixCart.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/ItemsBitrixCart.php");

/**
 * Подключение класса управления избранными товарами
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/UserFavoriteProducts.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/UserFavoriteProducts.php");

/**
 * Класс для работы с сервисом SMS.RU
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/sms.ru.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/sms.ru.php");

/**
 * Класс для авторизации и регистрации пользователя по номеру телефона
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/AuthByPhoneSms.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/AuthByPhoneSms.php");

/**
 * Подключение обработчика бонусного счёта пользователя
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/BonusUser.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/BonusUser.php");

/**
 * Подключение обработчика парсинга XML для создания подборок и импорта бонусных счетов пользователей
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/XmlParserHandler.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/XmlParserHandler.php");

/**
 * Подключение обработчика парсинга для создания элементов в Bitrix
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/helpers/AddElementFromBitrix.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/helpers/AddElementFromBitrix.php");

/**
 * Helpers
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/helpers.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/helpers.php");

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/helpers/SiteInfo.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/helpers/SiteInfo.php");

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/helpers/AdminNotification.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/helpers/AdminNotification.php");

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/FakeGenerator/FakeGenerator.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/FakeGenerator/FakeGenerator.php");
