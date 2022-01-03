<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

CModule::IncludeModule("iblock");

$aMenuLinksExt = [];
$resource = CIBlockElement::GetList(
    ["ACTIVE_FROM" => "DESC", "SORT" => "ASC",],
    ["IBLOCK_ID" => 7, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y",],
    false,
    false,
    ["ID", "NAME", "DETAIL_PAGE_URL"]
);
while ($item = $resource->GetNext()) {
    $aMenuLinksExt[] = [
        $item['NAME'],
        $item['DETAIL_PAGE_URL'],
        "",
        [],
        ""
    ];
}

$aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);
?>
