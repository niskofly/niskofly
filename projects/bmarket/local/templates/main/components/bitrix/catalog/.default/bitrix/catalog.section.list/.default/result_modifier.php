<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arResult */

$renderSections = [];

foreach ($arResult["SECTIONS"] as $section)
    $section['IBLOCK_SECTION_ID'] ?
        $renderSections[$section['IBLOCK_SECTION_ID']]['CHILDREN'][] = $section :
        $renderSections[$section['ID']] = $section;

$arResult['RENDER_SECTIONS'] = $renderSections;
?>
