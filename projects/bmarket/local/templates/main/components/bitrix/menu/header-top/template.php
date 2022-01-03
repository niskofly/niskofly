<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
    <ul class="nav">
        <? foreach ($arResult as $arItem): ?>
            <li class="nav__item">
                <a href="<?= $arItem["LINK"] ?>"
                   title="<?= $arItem["TEXT"] ?>"
                   class="nav__link <?= $arItem["PARAMS"]["CLASS"] ?>">
                    <? if ($arItem["PARAMS"]["ICON"]): ?>
                        <svg class="icon icon-<?= $arItem["PARAMS"]["ICON"] ?>">
                            <use xlink:href="#<?= $arItem["PARAMS"]["ICON"] ?>"></use>
                        </svg>
                    <? endif ?>
                    <?= $arItem["TEXT"] ?>
                </a>
            </li>
        <? endforeach ?>
    </ul>
<? endif ?>
