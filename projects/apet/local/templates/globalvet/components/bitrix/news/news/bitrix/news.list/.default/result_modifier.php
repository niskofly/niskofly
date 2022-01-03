<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arResult['NEWS_DATA'] = [];
foreach ($arResult['ITEMS'] as $arItem) {
    $id = $arItem['ID'];
    $editId = $arItem['EDIT_LINK'];
    $deleteId = $arItem['DELETE_LINK'];
    $iblockId = $arItem["IBLOCK_ID"];
    $date = $arItem['TIMESTAMP_X'] = ConvertDateTime($arResult["TIMESTAMP_X"], "DD.MM.YYYY");
    $title = $arItem['NAME'];
    $description = $arItem['PREVIEW_TEXT'];
    $newsUrl = $arItem['DETAIL_PAGE_URL'];
    $checkLongNews = $arItem['PROPERTIES']['MAIN_NEWS']['VALUE_XML_ID'];
    $imgUrl = $arItem['PREVIEW_PICTURE']['SRC'];

    $arResult['NEWS_DATA'][$id] = [
        'ID' => $id,
        'EDIT_LINK' => $editId,
        'DELETE_LINK' => $deleteId,
        'IBLOCK_ID' => $iblockId,
        'DATE' => $date,
        'TITLE' => $title,
        'DESCRIPTION' => $description,
        'NEWS_URL' => $newsUrl,
        'CHECK_LONG' => $checkLongNews,
        'URL_IMG' => $imgUrl,
    ];
}
