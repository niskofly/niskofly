<?
global $sortSetting;
$sortSetting = [
    'SHOW_COUNTER' => [
        'ELEMENT_SORT_FIELD' => 'SHOW_COUNTER',
        'ELEMENT_SORT_ORDER' => 'DESC',
        'NAME' => 'По популярности'
    ],
    'CREATED' => [
        'ELEMENT_SORT_FIELD' => 'DATE_CREATE',
        'ELEMENT_SORT_ORDER' => 'ASC',
        'NAME' => 'По новизне'
    ],
    'CATALOG_PRICE_DOWN' => [
        'ELEMENT_SORT_FIELD' => 'CATALOG_PRICE_1',
        'ELEMENT_SORT_ORDER' => 'DESC',
        'NAME' => 'Цена по убыванию'
    ],
    'CATALOG_PRICE_UP' => [
        'ELEMENT_SORT_FIELD' => 'CATALOG_PRICE_1',
        'ELEMENT_SORT_ORDER' => 'ASC',
        'NAME' => 'Цена по возрастанию'
    ],
];

$actualSorting = [
    'ELEMENT_SORT_FIELD' => 'SORT',
    'ELEMENT_SORT_ORDER' => 'ASC',
];

if ($_COOKIE["SORT_SETTING"] && array_key_exists($_COOKIE["SORT_SETTING"], $sortSetting)) {
    $actualSorting = $sortSetting[$_COOKIE["SORT_SETTING"]];
}

?>