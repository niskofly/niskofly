<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var array $arResult */

/* info: Получение товара данного бренда */

$brandName = $arResult['NAME'];

$query = CIBlockElement::GetList(
  ['ID' => 'ASC'],
  ['IBLOCK_ID' => CATALOG_ID, 'PROPERTY_MARKA_VALUE' => $brandName],
  false,
  false,
  ['ID', 'NAME', 'DETAIL_PICTURE', 'PROPERTY_MARKA']
);

$elementsID = [];

while ($element = $query->GetNext())
    $elementsID[] = $element['ID'];

$arResult['ELEMENTS_IDS'] = $elementsID;
