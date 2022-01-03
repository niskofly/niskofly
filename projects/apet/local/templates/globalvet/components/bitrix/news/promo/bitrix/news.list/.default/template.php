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
<div class="card-stocks">
  <? foreach ($arResult["ITEMS"] as $arItem): ?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
       class="card-stock"
       id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
    <span class="card-stock__preview">
      <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
           alt="<?= $arItem["NAME"]; ?>"
           title="<?= $arItem["NAME"]; ?>">
    </span>
      <span class="card-stock__detail">
      <span class="card-stock__date">3.06.2020 – 30.06.2020</span>
      <span class="title title--small card-stock__title"><?= $arItem["NAME"]; ?></span>
    </span>
    </a>
  <? endforeach; ?>
</div>
