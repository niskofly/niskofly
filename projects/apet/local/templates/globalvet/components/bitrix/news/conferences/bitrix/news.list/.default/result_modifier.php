<?
foreach ($arResult["ITEMS"] as &$item):
  $query = CIBlockSection::GetByID($item["IBLOCK_SECTION_ID"]);
  if ($arRes = $query->GetNext())
    $item["SECTION_NAME"] = $arRes['NAME'];
endforeach;
