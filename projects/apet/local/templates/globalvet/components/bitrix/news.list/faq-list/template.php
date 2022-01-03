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
$faqListClass = ($GLOBALS["faqListClass"]) ?: "help";
?>
<div class="faq-list faq-list--<?=$faqListClass;?>">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
  <div class="faq js-toggle-slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    <button
      type="button"
      class="faq__button js-toggle-slide-btn">
      <span class="faq__button-question"><?=$arItem["NAME"];?></span>
      <span class="faq__button-icon">
        <svg class="icon icon-plus ">
          <use xlink:href="#plus"></use>
        </svg>
        <svg class="icon icon-minus icon--active">
          <use xlink:href="#minus"></use>
        </svg>
      </span>
    </button>
    <div class="faq__text js-toggle-slide-content"><?=$arItem["PREVIEW_TEXT"];?></div>
	</div>
<?endforeach;?>
</div>
