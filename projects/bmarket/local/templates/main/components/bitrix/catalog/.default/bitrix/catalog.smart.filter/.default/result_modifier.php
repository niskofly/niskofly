<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arResult */

/**
 * Сборка элементов для фильтра только с одним значением
 */
$oneOptionsFilters = [];
foreach ($arResult["ITEMS"] as $kye => $arItem) {
    /**
     * Тип отображения - Радиокнопки
     */
    if ($arItem['DISPLAY_TYPE'] == 'K') {
        $oneOptionsFilters[] = $arItem;
        unset($arResult['ITEMS'][$kye]);
    }
}
$arResult["ONE_OPTIONS_FILTER"] = $oneOptionsFilters;
?>
