<?
/* Категории на index странице  */
global $sectionsFilter;
$sectionsFilter['UF_SITE_RESTRICTION_VALUE'] = 'GlobalVet';

$APPLICATION->IncludeComponent(
  "bitrix:catalog.section.list",
  "catalog",
  array(
    "ADD_SECTIONS_CHAIN" => "Y",
    "CACHE_FILTER" => "N",
    "CACHE_GROUPS" => "Y",
    "CACHE_TIME" => "36000000",
    "CACHE_TYPE" => "A",
    "COMPONENT_TEMPLATE" => ".default",
    "COUNT_ELEMENTS" => "Y",
    "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
    "FILTER_NAME" => "sectionsFilter",
    "HIDE_SECTION_NAME" => "N",
    "IBLOCK_ID" => CATALOG_ID,
    "IBLOCK_TYPE" => "catalog",
    "SECTION_CODE" => "",
    "SECTION_FIELDS" => array(0 => "", 1 => "",),
    "SECTION_ID" => "0",
    "SECTION_URL" => "",
    "SECTION_USER_FIELDS" => array(0 => "", 1 => "",),
    "SHOW_PARENT_NAME" => "Y",
    "TOP_DEPTH" => "1",
    "VIEW_MODE" => "TEXT"
  )
);
?>
