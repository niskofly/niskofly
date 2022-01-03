<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

CModule::IncludeModule('iblock');

$catalogSections = [];
$dbSection = CIBlockSection::GetTreeList(
    ['IBLOCK_ID' => CATALOG_ID, 'ACTIVE' => 'Y', 'UF_SITE_RESTRICTION_VALUE' => getSiteName()],
    ['ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'CODE', 'SECTION_ID', 'NAME', 'SECTION_PAGE_URL']
);

while ($section = $dbSection->GetNext())
    if (!$section['IBLOCK_SECTION_ID'])
        $catalogSections[$section['ID']] = [
            'TEXT' => $section['NAME'],
            'LINK' => $section['SECTION_PAGE_URL'],
        ];

$catalogChildMenu = ['Каталог', '/catalog/', $catalogSections, ['DROPDOWN_MENU_ID' => 'catalog'], ''];
array_unshift($aMenuLinks, $catalogChildMenu);
