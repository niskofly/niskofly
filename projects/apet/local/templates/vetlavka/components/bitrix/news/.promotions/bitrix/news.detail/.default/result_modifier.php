<?
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * Пробрасываем значения для сборки фильтра в обход кеша
 */
$cp = $this->__component;
if (is_object($cp)) {
  $cp->arResult['BINDING_CATEGORY'] = $arResult['PROPERTIES']['BINDING_CATEGORY']['VALUE'];
  $cp->arResult['BIND_PRODUCTS'] = $arResult['PROPERTIES']['BIND_PRODUCTS']['VALUE'];
  $cp->SetResultCacheKeys(array('BINDING_CATEGORY', 'BIND_PRODUCTS'));
}

/**
 * Добавление open graph изображения
 */
$arResult["OPENGRAF_IMAGE"] = $arResult['DETAIL_PICTURE']['SRC'] ?: $arResult['PREVIEW_PICTURE']['SRC'];
$cp = $this->__component;
if (is_object($cp))
  $cp->SetResultCacheKeys(['OPENGRAF_IMAGE']);
