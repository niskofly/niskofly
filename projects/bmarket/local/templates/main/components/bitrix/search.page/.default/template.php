<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>

<form action="" class="form-search" method="get">
    <input type="hidden" name="how" value="<? echo $arResult["REQUEST"]["HOW"] == "d" ? "d" : "r" ?>"/>
    <input type="text" name="q" value="<?= $arResult["REQUEST"]["QUERY"] ?>" class="input form-search__input js-search-input">
    <button type="submit" class="btn form-search__submit" onclick="fbq('track', 'Search', {search_string: $('.js-search-input').val(),});">
        <svg class="icon icon-search ">
            <use xlink:href="#search"></use>
        </svg>
        <span>Найти</span>
    </button>
</form>

<?
global $GOODS_ID;
$GOODS_ID = [];

if (!empty($arResult["SEARCH"])) {
    foreach ($arResult["SEARCH"] as $item):
        $GOODS_ID[] = $item['ITEM_ID'];
    endforeach;
} elseif ($arResult["REQUEST"]["QUERY"]) { ?>
    <div class="section-favorites container " style="margin-top: 45px">
        <div class="section-message container">
            <div class="alert-message">
                <img src="/img/icons/waving-hand.svg" class="alert-message__logo">
                <div class="title title--medium" style="text-align: center">
                    По запросу “<?= $arResult["REQUEST"]["QUERY"] ?>” ничего не найдено
                </div>
            </div>
        </div>
    </div>
<? } ?>
