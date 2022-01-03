<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$this->setFrameMode(true);
?>

<? if ($arResult["PROPERTIES"]["BANNER_DETAIL"]["VALUE"]): ?>
  <div style="background-image: url(<?= CFile::getPath($arResult["PROPERTIES"]["BANNER_DETAIL"]["VALUE"]); ?>)"
       class="catalog-promo container"></div>
<? endif; ?>

<div class="section-stock-info container">
  <div class="catalog-description catalog-description--stock">
    <div class="catalog-description__date"><?= $arResult["PROPERTIES"]["PERIOD"]["VALUE"]; ?></div>
    <div class="title catalog-description__title"><?= $arResult["NAME"]; ?></div>
    <? if ($arResult["DETAIL_TEXT"]): ?>
      <div class="text-typography"><?= $arResult["DETAIL_TEXT"]; ?></div>
    <? endif; ?>
  </div>
</div>
