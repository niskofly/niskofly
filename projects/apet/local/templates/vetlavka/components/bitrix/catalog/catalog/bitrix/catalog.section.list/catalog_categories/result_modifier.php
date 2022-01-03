<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 */

/* Получение на станице /catalog/element списка категорий */

$sectionsCatalog = [];
foreach ($arResult['SECTIONS'] as $arOneSection) {
  if ($arOneSection['RELATIVE_DEPTH_LEVEL'] > 1) {
    $arResult['SECTIONS'] = $sectionsCatalog;
  }
}
