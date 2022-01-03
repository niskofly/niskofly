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

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

if (0 < $arResult["SECTIONS_COUNT"]):
?>
  <div class="nav-subsection nav-subsection--blog">
<?
  foreach ($arResult['SECTIONS'] as &$arSection):
    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
    $CLASS_ACTIVE = (strpos($APPLICATION->GetCurPage(false), $arSection['CODE'])) ? ' active' : '';
?>
    <a
      href="/<?=$arSection['IBLOCK_CODE']."/".$arSection['CODE']; ?>/"
      class="btn btn--small nav-subsection__btn<?=$CLASS_ACTIVE;?>"
      id="<?=$this->GetEditAreaId($arSection['ID']); ?>"><?=$arSection['NAME']; ?></a>
<? endforeach; ?>
  </div>
<? endif; ?>
