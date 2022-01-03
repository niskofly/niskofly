<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
    <? foreach ($arResult as $arItem): ?>
        <a href="<?= $arItem["LINK"] ?>"
           title="<?= $arItem["TEXT"] ?>"
           class="footer__info-text">
            <?= $arItem["TEXT"] ?>
        </a>
    <? endforeach ?>
<? endif ?>
