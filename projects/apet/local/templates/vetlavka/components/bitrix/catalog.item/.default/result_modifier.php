<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 */


/**
 * Получение актуальной и минимальной цены товара
 */
$price = $arResult['ITEM']['ITEM_PRICES'][$arResult['ITEM']['ITEM_PRICE_SELECTED']];
$arResult['ACTUAL_PRICE'] = $arResult['MIN_PRICE'] = ItemsBitrixCart::getFormattedPrice($price['RATIO_PRICE']);
$arResult['OLD_PRICE'] = $arResult['MIN_OLD_PRICE'] = ItemsBitrixCart::getFormattedPrice($price['RATIO_BASE_PRICE'], true);

