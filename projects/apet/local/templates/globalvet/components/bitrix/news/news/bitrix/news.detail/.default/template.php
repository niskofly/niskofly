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

<div class="section-header container">
  <div class="title"><?= $arResult["NAME"] ?></div>
</div>

<div class="news-detail container">
  <div class="news-detail__content">
    <div class="news-detail__date">
      <?= FormatDate('d.m.yy', MakeTimeStamp($arResult["DATE_CREATE"]) + CTimeZone::GetOffset()); ?></div>
    <div class="text-typography">
      <?= $arResult["DETAIL_TEXT"]; ?>
    </div>
  </div>
  <div class="news-detail__preview">
    <img src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ? $arResult["DETAIL_PICTURE"]["SRC"] : NO_IMAGE_SRC_GLOBALVET ?>"
         alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>"
         title="<?= $arResult["DETAIL_PICTURE"]["TITLE"] ?>">
  </div>
</div>
