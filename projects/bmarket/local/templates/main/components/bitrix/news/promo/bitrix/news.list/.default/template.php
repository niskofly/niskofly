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
?>
<div class="section-stocks container js-simple-pagination-wrapper">
    <div class="stock-cards js-lazy-load-content">
        <!-- items-container -->
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <?
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
               id="<?= $this->GetEditAreaId($arItem['ID']); ?>"
               title="<?= $arItem["NAME"] ?>"
               class="stock-card">
                <span class="stock-card__preview">
                    <img alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                         src="<? echo $arItem["PREVIEW_PICTURE"]["SRC"] ?: NO_IMAGE_SRC ?>">
                </span>
                <span class="stock-card__title">
                    <?= $arItem["NAME"] ?>
                </span>
            </a>
        <? endforeach; ?>
        <!-- items-container -->
    </div>
    <div class="js-lazy-load-more-pagination">
        <!-- pagination-container -->
        <?= $arResult["NAV_STRING"] ?>
        <!-- pagination-container -->
    </div>
</div>
