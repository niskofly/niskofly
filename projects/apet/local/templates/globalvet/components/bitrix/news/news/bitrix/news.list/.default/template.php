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

<div class="card-articles">
  <? foreach ($arResult["NEWS_DATA"] as $arItem): ?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>

    <a href="<?= $arItem['NEWS_URL'] ?>" class="card-article" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
      <span class="card-article__preview">
        <img src="<?= $arItem['URL_IMG'] ? $arItem['URL_IMG'] : NO_IMAGE_SRC_GLOBALVET ?>"
             alt="<?= $arItem['TITLE'] ?>">
      </span>
      <span class="card-article__detail">
        <span class="card-article__title"><?= $arItem['TITLE'] ?></span>
        <span class="card-article__date"><?= $arItem['DATE'] ?></span>
      </span>
    </a>
  <? endforeach; ?>
</div>
