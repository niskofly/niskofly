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
$this->setFrameMode(true);
?>

<? if ($arResult['DETAIL_PICTURE']['SRC']): ?>
<div class="stock__banner" style="max-width: 1045px">
  <img src="<?= $arResult['DETAIL_PICTURE']['SRC'] ?>" alt="<?= $arResult['NAME'] ?>">
</div>
<?endif;?>
<? if (trim($arResult["DETAIL_TEXT"])): ?>
<div class="page__title title"><h1 class="seo-title"><?= $arResult['NAME'] ?></h1></div>
<div class="stock__description"><? echo $arResult["DETAIL_TEXT"]; ?></div>
<? endif; ?>

