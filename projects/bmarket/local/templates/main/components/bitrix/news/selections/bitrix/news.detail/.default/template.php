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
<? if ($arResult["DETAIL_PICTURE"]["SRC"] || trim($arResult["DETAIL_TEXT"])): ?>
    <div class="container">
        <div class="promo-detail">
            <? if ($arResult["DETAIL_PICTURE"]["SRC"]): ?>
                <div class="promo-detail__image">
                    <img src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>"
                         alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>">
                </div>
            <? endif; ?>
            <? if (trim($arResult["DETAIL_TEXT"])): ?>
                <div class="promo-detail__description">
                    <div class="text-typography">
                        <?= $arResult["DETAIL_TEXT"]; ?>
                    </div>
                </div>
            <? endif; ?>
        </div>
    </div>
<? endif; ?>
