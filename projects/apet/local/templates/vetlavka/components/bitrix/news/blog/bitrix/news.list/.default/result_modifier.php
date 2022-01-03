<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/* Получение названия разделов */
$nameCategory = [];

$tree = CIBlockSection::GetTreeList(
    ['IBLOCK_ID' => BLOG_ID]
);
while ($section = $tree->GetNext()) {
    $nameCategory[$section['ID']] = $section['NAME'];
}

$arResult['BLOG_DATA'] = [];

foreach ($arResult['ITEMS'] as $arItem) {
    $arResult['BLOG_DATA'][$arItem['ID']] = [
        'ID' => $arItem['ID'],
        'EDIT_LINK' => $arItem['EDIT_LINK'],
        'DELETE_LINK' => $arItem['DELETE_LINK'],
        'IBLOCK_ID' => $arItem["IBLOCK_ID"],
        'DATE' => $arItem['TIMESTAMP_X'] = ConvertDateTime($arResult["TIMESTAMP_X"], "DD.MM.YYYY"),
        'TITLE' => $arItem['NAME'],
        'DESCRIPTION' => $arItem['PREVIEW_TEXT'],
        'BLOG_URL' => $arItem['DETAIL_PAGE_URL'],
        'CHECK_LONG' => $arItem['PROPERTIES']['MAIN_NEWS']['VALUE_XML_ID'],
        'URL_IMG' => $arItem['PREVIEW_PICTURE']['SRC'],
        'NAME_CATEGORY' => $nameCategory[$arItem['IBLOCK_SECTION_ID']]
    ];
}


