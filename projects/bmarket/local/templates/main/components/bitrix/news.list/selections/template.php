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
$this->setFrameMode(true);
ob_start();

foreach ($arResult["ITEMS"] as $key => $arItem) {
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <? if ($key == count($arResult["ITEMS"]) - 1): ?>
        #SELECTIONS_BANNER#
    <? endif; ?>

    <div data-slider-id="default" class="container swiper-container slider-products js-slider"
         id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
        <div class="slider-products__header">
            <div class="slider-products__header-info">
                <div class="title">
                    <? if ($arItem["PREVIEW_PICTURE"]["SRC"]): ?>
                        <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                             alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                             class="title__icon" itemprop="contentUrl">
                    <?endif; ?>
                    <span><?= $arItem["NAME"] ?></span>
                </div>
                <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="slider-products__link">
                    Посмотреть все
                </a>
            </div>
            <div class="slider-pagination"></div>
        </div>
        #SELECTIONS_PRODUCTS<?= $arItem['ID'] ?>#
    </div>
<? }

$this->__component->SetResultCacheKeys(["CACHED_TPL"]);
$this->__component->arResult["CACHED_TPL"] = @ob_get_contents();
ob_get_clean();
?>
