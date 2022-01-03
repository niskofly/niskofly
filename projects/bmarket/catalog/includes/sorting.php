<?
$sortingOptions = [
    'POPULAR' => [
        'NAME' => 'Сначала популярное',
        'FIELD' => 'SHOW_COUNTER',
        'ORDER' => 'DESC',
    ],
    'NEW' => [
        'NAME' => 'Сначала новые',
        'FIELD' => 'DATE_CREATE',
        'ORDER' => 'ASC',
    ],
    'CHEAPER' => [
        'NAME' => 'Сначала подешевле',
        'FIELD' => 'catalog_PRICE_' . PRICE_ID,
        'ORDER' => 'ASC',
    ],
    'EXPENSIVE' => [
        'NAME' => 'Сначала подороже',
        'FIELD' => 'catalog_PRICE_' . PRICE_ID,
        'ORDER' => 'DESC',
    ],
    'DISCOUNTS' => [
        'NAME' => 'Сначала со скидками',
        'FIELD' => '',
        'ORDER' => '',
    ],
    'ALPHABETICALLY' => [
        'NAME' => 'От А до Я',
        'FIELD' => 'NAME',
        'ORDER' => 'ASC',
    ],
    'ALPHABETICALLY_BACK' => [
        'NAME' => 'От Я до А',
        'FIELD' => 'NAME',
        'ORDER' => 'DESC',
    ],
];

/**
 * todo: Разобратьсо с сортировками - Сначала новые, Сначала популярное, Сначала со скидками
 */
$cookieCode = 'CATALOG_SORTING';
$selectSortingCode = $_COOKIE[$cookieCode] && array_key_exists($_COOKIE[$cookieCode], $sortingOptions) ?
    $_COOKIE[$cookieCode] :
    key($sortingOptions);

if ($setting = $sortingOptions[$selectSortingCode]) {
    $sortField = $setting['FIELD'];
    $sortFieldOrder = $setting['ORDER'];
}
?>

<? if (!$onlySortingParams): ?>
    <div class="custom-select custom-select--sorting js-custom-select">
        <button class="custom-select__header js-custom-select-toggle">
            <span class="custom-select__selected js-custom-select-render">
                <?echo $setting ? $setting['NAME'] : ''?>
            </span>
            <span class="custom-select__arrow">
                <svg class="icon icon-arrow-d ">
                    <use xlink:href="#arrow-d"></use>
                </svg>
            </span>
        </button>
        <div class="custom-select__body js-custom-select-list">
            <? foreach ($sortingOptions as $code => $option): ?>
                <label class="custom-select__option">
                    <input name="SORTING"
                           type="radio"
                        <? echo $selectSortingCode == $code ? 'checked="true"' : '' ?>
                           class="js-catalog-sorting"
                           value="<?= $code ?>">
                    <span class="custom-select__label">
                        <?= $option['NAME'] ?>
                    </span>
                </label>
            <? endforeach; ?>
        </div>
    </div>
<? endif ?>
