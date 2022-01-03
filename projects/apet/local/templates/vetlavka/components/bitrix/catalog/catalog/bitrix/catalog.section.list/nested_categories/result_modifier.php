<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 */

/* Получение на станице /catalog/ списка категорий со вложенными подкатегориями */

$elements = [];

foreach ($arResult['SECTIONS'] as $sectionElement) {
  if ($sectionElement['DEPTH_LEVEL'] == 1) {
    $elements[$sectionElement['ID']] = [
      'NAME' => $sectionElement['NAME'],
      'URL' => $sectionElement['SECTION_PAGE_URL'],
      'IMG' => CFile::GetPath((int)$sectionElement['DETAIL_PICTURE']),
      'ITEMS' => []
    ];
  } else {
    $elements[$sectionElement['IBLOCK_SECTION_ID']]['ITEMS'][] = [
      'NAME' => $sectionElement['NAME'],
      'URL' => $sectionElement['SECTION_PAGE_URL']
    ];
  }
}

$arResult['GATEGORY_SECTIONS'] = $elements;


