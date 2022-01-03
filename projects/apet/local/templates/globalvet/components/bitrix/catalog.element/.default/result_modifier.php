<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

global $productName;
$productName = $arResult['NAME'];

/**
 * Получение детальной фотографии товара
 */
$arResult['IMAGE'] = NO_IMAGE_SRC;

if ($arResult['DETAIL_PICTURE'])
    $arResult['IMAGE'] = $arResult['DETAIL_PICTURE']['SRC'];

if (!$arResult['DETAIL_PICTURE'] && $arResult['PREVIEW_PICTURE'])
    $arResult['IMAGE'] = $arResult['PREVIEW_PICTURE']['SRC'];


/**
 * Получение актуальной и минимальной цены товара
 */
$price = $arResult['ITEM_PRICES'][$arResult['ITEM_PRICE_SELECTED']];
$arResult['ACTUAL_PRICE'] = $arResult['MIN_PRICE'] = ItemsBitrixCart::getFormattedPrice($price['RATIO_PRICE']);
$arResult['OLD_PRICE'] = $arResult['MIN_OLD_PRICE'] = ItemsBitrixCart::getFormattedPrice($price['RATIO_BASE_PRICE'], true);


/**
 * Добавление open graph изображения
 */
$arResult["OPENGRAF_IMAGE"] = $arResult['IMAGE'];
$cp = $this->__component;
if (is_object($cp))
    $cp->SetResultCacheKeys(array('OPENGRAF_IMAGE'));


/**
 * Получение отзыва о определенном товаре
 */
$reviewElements = CIBlockElement::GetList(
  ['PROPERTY_DATE' => 'desc', 'SORT' => 'asc'],
  [
    'IBLOCK_ID' => REVIEWS_ID,
    'ACTIVE' => 'Y',
    '=PROPERTY_BIND_PRODUCT' => $arParams['ELEMENT_ID']
  ]
);

while ($reviewElement = $reviewElements->GetNextElement()) {
  $fields = $reviewElement->GetFields();
  $props = $reviewElement->GetProperties();
  $user = CUser::GetByID($props['BIND_USER']['VALUE'])->Fetch();

  $arResult['REVIEWS'][] = [
    'USER' => $fields['USER_NAME'],
    'USER_IMG' => CFile::GetPath($user["PERSONAL_PHOTO"]) ? CFile::GetPath($user["PERSONAL_PHOTO"]) : NO_USER_PHOTO_SRC,
    'TEXT' => TruncateText($fields['PREVIEW_TEXT'], 300),
    'DATE' => $props['DATE']['VALUE'],
    'COUNT_STAR' => $props['COUNT_STAR']['VALUE']
  ];
}
