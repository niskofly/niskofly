<?
$query = CIBlockSection::GetByID($arResult["IBLOCK_SECTION_ID"]);
if ($arRes = $query->GetNext())
  $arResult["SECTION_NAME"] = $arRes['NAME'];
