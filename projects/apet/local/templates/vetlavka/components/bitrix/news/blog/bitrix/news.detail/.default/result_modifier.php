<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var array $arResult */

/* Получение названия разделов */
$nameCategory = [];

$tree = CIBlockSection::GetTreeList(
    ['IBLOCK_ID' => BLOG_ID]
);
while ($section = $tree->GetNext()) {
    $nameCategory[$section['ID']] = $section['NAME'];
}

/* Добавление название и даты блога */
$arResult['DATA_CATEGORY'] = [
    'NAME_CATEGORY' => $nameCategory[$arResult['IBLOCK_SECTION_ID']],
    'DATE_CREATE_BLOG' => $arResult['TIMESTAMP_X'] = ConvertDateTime($arResult["TIMESTAMP_X"], "DD.MM.YYYY")
];

/* Получение двух случайных новостей в правую часть */
$elementsNews = CIBlockElement::GetList(
    ['RAND' => 'rand'],
    [
        'IBLOCK_ID' => [BLOG_ID],
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

    $arResult['BLOG_RIGHT'][] = [
        'NAME_BLOG' => $fieldsElement['NAME'],
        'TEXT_BLOG' => $fieldsElement['DETAIL_TEXT'],
        'URL_BLOG' => $fieldsElement['DETAIL_PAGE_URL'],
        'IMG_BLOG' => CFile::GetPath($fieldsElement['PREVIEW_PICTURE']),
        'DATE_BLOG' => $fieldsElement['CREATED_DATE'],
        'NAME_CATEGORY' => $nameCategory[$fieldsElement['IBLOCK_SECTION_ID']]
    ];
}

