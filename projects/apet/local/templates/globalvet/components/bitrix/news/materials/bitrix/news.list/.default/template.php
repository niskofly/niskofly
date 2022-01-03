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

<div class="card-materials">
  <? foreach ($arResult["ITEMS"] as $arItem): ?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <a href="<?= $arItem["DETAIL_PAGE_URL"]; ?>" class="card-material" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
    <span class="card-material__header">
      <span class="title title--small card-material__title"><?= $arItem["NAME"]; ?></span>
      <span class="card-material__text"><?= TruncateText($arItem["PREVIEW_TEXT"], 100); ?></span>
    </span>
      <span class="card-material__footer">
      <span class="card-material__date">
        <?= FormatDate('d.m.yy', MakeTimeStamp($arItem["DATE_CREATE"]) + CTimeZone::GetOffset()); ?></span>
    </span>
    </a>
  <? endforeach; ?>
</div>
