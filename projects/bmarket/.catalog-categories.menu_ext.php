<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

CModule::IncludeModule("iblock");
$arSections = [];

$rsSection = CIBlockSection::GetTreeList(
    ['IBLOCK_ID' => CATALOG_ID, 'ACTIVE' => 'Y'],
    ['ID', 'NAME', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'IBLOCK_TYPE_ID', 'CODE', 'DEPTH_LEVEL', 'SECTION_PAGE_URL']
);

while ($arSection = $rsSection->GetNext()) {
    if($arSection["DEPTH_LEVEL"] > 2)
        continue;

    if (!$arSection["IBLOCK_SECTION_ID"]) {
        $arSections[$arSection["ID"]]['TEXT'] = $arSection['NAME'];
        $arSections[$arSection["ID"]]['LINK'] = $arSection['SECTION_PAGE_URL'];
        $arSections[$arSection["ID"]]['CODE'] = "catalog-section-{$arSection['CODE']}";
    } else {
        $arSections[$arSection["IBLOCK_SECTION_ID"]]["ADDITIONAL_LINKS"][$arSection['ID']] = [
            "TEXT" => $arSection['NAME'],
            "LINK" => $arSection['SECTION_PAGE_URL'],
            'CODE' => "catalog-section-{$arSection['CODE']}"
        ];
    }
}

$aMenuLinksExt = [];
foreach ($arSections as $sectionId => $arSection) {
    $aMenuLinksExt[] = [
        $arSection['TEXT'],
        $arSection['LINK'],
        $arSection["ADDITIONAL_LINKS"],
        ['CODE' => $arSection['CODE']],
        ""
    ];
}
$aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);
?>
