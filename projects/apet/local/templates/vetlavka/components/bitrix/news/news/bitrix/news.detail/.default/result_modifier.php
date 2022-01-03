<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var array $arResult */

/* info: Получение двух случайных новостей в правую часть */

$elementsNews = CIBlockElement::GetList(
    ['RAND' => 'rand'],
    [
        'IBLOCK_ID' => [NEWS_ID],
        'ACTIVE' => 'Y',
        'ACTIVE_DATE' => 'Y',
        '!ID' => $arResult['ID'],
    ],
    false,
    ['nTopCount' => 2],
    [
        //
    ]
);

while ($obElementsNews = $elementsNews->GetNextElement()) {
    $fieldsElement = $obElementsNews->GetFields();

    $arResult['NEWS_RIGHT'][] = [
        'NAME_NEWS' => $fieldsElement['NAME'],
        'URL_NEWS' => $fieldsElement['DETAIL_PAGE_URL'],
        'IMG_NEWS' => CFile::GetPath($fieldsElement['PREVIEW_PICTURE']),
        'DATE_NEWS' => $fieldsElement['CREATED_DATE'],
    ];
}
