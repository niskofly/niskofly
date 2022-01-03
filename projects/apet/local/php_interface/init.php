<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/wsrubi.smtp/classes/general/wsrubismtp.php");
define('NO_IMAGE_SRC_VETLAVKA', '/img/no-image.png');
define('NO_IMAGE_SRC_GLOBALVET', '/img/no-image.png');

define('YANDEX_MAP_SRC', '//api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=ddd3730b-6500-4ad2-8af2-36d72cbbca77');
define('DOMAIN', '');

define('NEWS_ID', '1');
define('BLOG_ID', '2');
define('BRANDS_ID', '3');
define('CATALOG_ID', '29');
define('OFFERS_ID', '30');

define('REVIEW_IBLOCK_ID', '6');
define('QUESTION_IBLOCK_ID', '7');
define('PRICE_DROP_IBLOCK_ID', '8');
define('SUBSCRIBE_MAILING_IBLOCK_ID', '9');
define('SUBSCRIBE_UPDATES_IBLOCK_ID', '10');
define('PROMOTIONS_IBLOCK_ID', '11');
define('BRANDS_IBLOCK_ID', '12');
define('SLIDERS_IBLOCK_ID', '13');
define('PRODUCT_DAY_IBLOCK_ID', '14');
define('CALL_ORDERS_IBLOCK_ID', '15');
define('POINTS_OF_DELIVERY_IBLOCK_ID', '16');
define('HELP_IBLOCK_ID', '17');
define('VACANCY_IBLOCK_ID', 19);
define('CONFERENCES_IBLOCK_ID', 20);
define('MATERIALS_IBLOCK_ID', 21);
define('NOTIFY_GOODS_ARRIVE_IBLOCK_ID', '26');

define('SMS_KEY', '02E33097-B047-8409-2123-4F154C5239D2');

define('RECAPTCHA_SITE_KEY', '');
define('RECAPTCHA_SECRET_KEY', '');

/**
 * Подключение обработчиков событий
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/event-handlers.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/event-handlers.php");

/**
 * Подключение регистрации пользователей
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/AuthByPhoneBitrix.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/AuthByPhoneBitrix.php");

/**
 * Подключение сервиса SMS.RU
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/sms.ru.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/sms.ru.php");

/**
 * Подключение элемента карточки
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/ItemsBitrixCart.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/ItemsBitrixCart.php");

/**
 * Подключение избранных товаров
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/UserFavoriteProducts.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/UserFavoriteProducts.php");

/**
 * Подключение подписок
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/UserSubscribe.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/UserSubscribe.php");

/**
 * Подключение профилей заказа
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/UserOrderProfiles.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/UserOrderProfiles.php");

/**
 * Подключение профилей заказа
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/ProductDay.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/ProductDay.php");

/**
 * Подключение обработки покупки в один клик
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/OneClickProductPurchase.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/OneClickProductPurchase.php");

/**
 * Подключение загрузки скидок на товары
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/DiscountProductsLoading.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/DiscountProductsLoading.php");

/**
 * Подключение обработки брендов
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/BrandsUpdate.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/BrandsUpdate.php");

/**
 * Подключение обработки данных в cookie
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/CookieFieldHandler.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/CookieFieldHandler.php");

/**
 * Helpers
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/helpers.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/helpers.php");

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/helpers/AddElementFromBitrix.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/helpers/AddElementFromBitrix.php");

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/helpers/SiteInfo.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/helpers/SiteInfo.php");

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/helpers/AdminNotification.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/helpers/AdminNotification.php");

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/FakeGenerator/FakeGenerator.php"))
  require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/include/classes/FakeGenerator/FakeGenerator.php");
