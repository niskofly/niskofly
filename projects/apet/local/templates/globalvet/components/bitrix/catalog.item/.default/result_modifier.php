<?
/**
 * Получение фотографии товара
 */
$arResult['ITEM']['PREVIEW_PICTURE']['SRC'] = !!$arResult['ITEM']['PREVIEW_PICTURE']['ID'] ? $arResult['ITEM']['PREVIEW_PICTURE']['SRC'] : NO_IMAGE_SRC;
$arResult['ITEM']['IMAGE_CLASS'] = !!$arResult['ITEM']['PREVIEW_PICTURE']['ID'] ? '' : 'product-card--no-photo';


/**
 * Получение актуальной и минимальной цены товара
 */
$price = $arResult['ITEM']['ITEM_PRICES'][$arResult['ITEM']['ITEM_PRICE_SELECTED']];
$arResult['ACTUAL_PRICE'] = $arResult['MIN_PRICE'] = ItemsBitrixCart::getFormattedPrice($price['RATIO_PRICE']);
$arResult['OLD_PRICE'] = $arResult['MIN_OLD_PRICE'] = ItemsBitrixCart::getFormattedPrice($price['RATIO_BASE_PRICE'], true);
