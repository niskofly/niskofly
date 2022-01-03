<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var array $arResult */

global $latterFilter;

$propertyValue = 57; //Property значение первой буквы
$latterFilter = $arResult['ITEMS'][$propertyValue]['VALUES'];

/* info: Получение брентов */
global $brandIDisFilter;

foreach ($arResult['ITEMS']['706']['VALUES'] as $itemListID => $itemValues) {
  $obBrandItem = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    ['IBLOCK_ID' => BRANDS_IBLOCK_ID, 'ACTIVE' => 'Y', 'PROPERTY_LIST_ID' => $itemListID],
    false,
    false,
    ['ID']
  );

  $brandIDisFilter[] = $obBrandItem->GetNext()['ID'];
}





