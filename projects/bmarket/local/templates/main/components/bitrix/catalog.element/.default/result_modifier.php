<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

/**
 * Получение дополнительных изображений
 */
$images = [];

if ($arResult['DETAIL_PICTURE']["SRC"])
    $images[] = $arResult['DETAIL_PICTURE']["SRC"];

if (!empty($arResult['PROPERTIES']['MORE_PHOTO']["VALUE"]))
    foreach ($arResult['PROPERTIES']['MORE_PHOTO']["VALUE"] as $id)
        if ($path = CFile::GetPath($id))
            $images[] = $path;

$arResult['MORE_PHOTO'] = !empty($images) ? $images : [NO_IMAGE_SRC];

/**
 * Получение информации о начисляемых баллах
 */
if ($price = $arResult['ITEM_PRICES'][$arResult['ITEM_PRICE_SELECTED']]) {
    $bonuses = round($price['PRICE'] / 100 * BONUSES_PERCENT);
    $arResult['COUNT_BONUSES'] = $bonuses;
    $arResult['PRINT_COUNT_BONUSES'] = $bonuses . ' балл' . getEncoding($bonuses);
}

/**
 * Сохранение стоимости товара в кэш
 */
$arResult["PRICE"] = $arResult['ITEM_PRICES'][$arResult['ITEM_PRICE_SELECTED']]['PRICE'];
$cp = $this->__component;
if (is_object($cp))
    $cp->SetResultCacheKeys(['PRICE']);


/**
 * Добавление open graph изображения
 */
$arResult["OPENGRAF_IMAGE"] = current($arResult['MORE_PHOTO']);
$cp = $this->__component;
if (is_object($cp))
    $cp->SetResultCacheKeys(['OPENGRAF_IMAGE']);
