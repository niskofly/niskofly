<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * todo: Подумать над верными границами пагинации 123 ... 456 ... 789
 */
$ClientID = 'navigation_' . $arResult['NavNum'];

if (!$arResult["NavShowAlways"]) {
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}

$paginationTemplateUrl = "{$arResult['sUrlPath']}?{$strNavQueryString}PAGEN_{$arResult["NavNum"]}=#PAGE#";

$lazyLoadUrl = $arResult["NavPageNomer"] < $arResult["NavPageCount"] ?
    str_replace('#PAGE#', $arResult["NavPageNomer"] + 1, $paginationTemplateUrl) :
    null;

if ($lazyLoadUrl) :?>
    <a href="<?= $lazyLoadUrl ?>" class="btn btn--transparent catalog__more js-lazy-load-more-link">
        Показать ещё
    </a>
<? endif; ?>

<div class="pagination">
    <?
    /**
     * Вырезаем информацию о предыдущей AJAX загрузке
     */
    $arResult["NavQueryString"] = str_replace('ACTION=AJAX_LAZY', '', $arResult["NavQueryString"]);
    $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
    $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");

    // to show always first and last pages
    $arResult["nStartPage"] = 1;
    $arResult["nEndPage"] = $arResult["NavPageCount"];

    $sPrevHref = '';
    if ($arResult["NavPageNomer"] > 1) {
        if ($arResult["bSavePage"] || $arResult["NavPageNomer"] > 2)
            $sPrevHref = $arResult["sUrlPath"] . '?' . $strNavQueryString . 'PAGEN_' . $arResult["NavNum"] . '=' . ($arResult["NavPageNomer"] - 1);
        else
            $sPrevHref = $arResult["sUrlPath"] . $strNavQueryStringFull;
    }

    if ($sPrevHref): ?>
        <a href="<?= $sPrevHref ?>"
           class="pagination__control pagination__control--prev js-lazy-load-paginate">
            <svg class="icon icon-arrow-l">
                <use xlink:href="#arrow-l"></use>
            </svg>
        </a>
    <? endif; ?>

    <?
    $bFirst = true;
    $bPoints = false;
    do {
        if (
            $arResult["nStartPage"] <= 2 ||
            $arResult["nEndPage"] - $arResult["nStartPage"] <= 1 ||
            abs($arResult['nStartPage'] - $arResult["NavPageNomer"]) <= 2
        ) {
            if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                ?>
                <span class="pagination__page pagination__page--active">
                    <?= $arResult["nStartPage"] ?>
                </span>
            <?
            elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
                ?>
                <a class="pagination__page js-lazy-load-paginate"
                   href="<?= $arResult["sUrlPath"] . $strNavQueryStringFull ?>">
                    <?= $arResult["nStartPage"] ?>
                </a>
            <?
            else:
                ?>
                <a class="pagination__page js-lazy-load-paginate"
                   href="<? echo str_replace("#PAGE#", $arResult['nStartPage'], $paginationTemplateUrl) ?>">
                    <?= $arResult["nStartPage"] ?>
                </a>
            <?
            endif;
            $bFirst = false;
            $bPoints = true;
        } else {
            if ($bPoints) { ?>
                <div class="pagination__page pagination__page--dots">...</div>
                <? $bPoints = false;
            }
        }
        $arResult["nStartPage"]++;
    } while ($arResult["nStartPage"] <= $arResult["nEndPage"]);
    ?>

    <?
    $sNextHref = '';
    if ($arResult["NavPageNomer"] < $arResult["NavPageCount"])
        $sNextHref = $arResult["sUrlPath"] . '?' . $strNavQueryString . 'PAGEN_' . $arResult["NavNum"] . '=' . ($arResult["NavPageNomer"] + 1);

    if ($sNextHref): ?>
        <a href="<?= $sNextHref ?>" class="pagination__control pagination__control--next js-lazy-load-paginate">
            <svg class="icon icon-arrow-r">
                <use xlink:href="#arrow-r"></use>
            </svg>
        </a>
    <? endif; ?>
</div>
