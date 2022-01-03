<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 */

/* Получение на станице /catalog/ списка категорий */

$svgName = [
  80 => '#first-aid',
  3 => '#stethoscope',
  132 => '#dog',
  103 => '#cat',
  92 => '#hamster',
  125 => '#bird',
  66 => '#fish',
];

$elements = [];

foreach ($arResult['SECTIONS'] as $sectionElement) {
  if ($sectionElement['DEPTH_LEVEL'] == 1) {
    $elements[$sectionElement['ID']] = [
      'NAME' => $sectionElement['NAME'],
      'SVG' => $svgName[$sectionElement['ID']],
      'URL' => $sectionElement['SECTION_PAGE_URL']
    ];
  }
}

$arResult['SECTIONS'] = $elements;

