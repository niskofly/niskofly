<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION, $arTheme;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
  "webest:menu.sections",
  "",
  [
    "IS_SEF" => "Y",
    "IBLOCK_TYPE" => "catalog",
    "SEF_BASE_URL" => "/catalog/",
    "SECTION_PAGE_URL" => "#SECTION_CODE_PATH#/",
    "DETAIL_PAGE_URL" => "/product/#ELEMENT_CODE#",
    "IBLOCK_ID" => CATALOG_ID,
    "DEPTH_LEVEL" => 3,
    "MENU_CACHE_TIME" => "3600000",
    "MENU_CACHE_TYPE" => "A",
    "MENU_CACHE_USE_GROUPS" => "N",
    "CACHE_SELECTED_ITEMS" => "N",
    "ALLOW_MULTI_SELECT" => "Y",
  ],
  false,
);
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>
