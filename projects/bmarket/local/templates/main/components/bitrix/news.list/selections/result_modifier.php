<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * Сохраняем в кеш информацию о товарах подборки
 */
$productsFromSelection = [];
foreach ($arResult['ITEMS'] as $item)
    $productsFromSelection[$item['ID']] = $item['PROPERTIES']['PRODUCTS']['VALUE'];

$this->__component->SetResultCacheKeys(["CACHED_SELECTION_PRODUCTS"]);
$this->__component->arResult["CACHED_SELECTION_PRODUCTS"] = $productsFromSelection;
