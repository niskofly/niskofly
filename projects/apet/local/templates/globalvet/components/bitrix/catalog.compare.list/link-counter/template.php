<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

$itemCount = count($arResult);
?>
<a href="/catalog/compare/" class="user-menu__button">
  <svg class="icon icon-chart ">
    <use xlink:href="#chart"></use>
  </svg>
  <span>Сравнение</span>
  <span class="user-menu__button-amount js-compare-counter"><?=($itemCount) ? $itemCount : ''; ?></span>
</a>
