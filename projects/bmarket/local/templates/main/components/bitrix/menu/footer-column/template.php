<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
    <ul class="nav nav--footer">
        <? foreach ($arResult as $arItem): ?>
            <li class="nav__item">
                <a href="<?= $arItem["LINK"] ?>"
                   title="<?= $arItem["TEXT"] ?>"
                   class="nav__link nav__link--footer">
                    <? if ($arItem["PARAMS"]["ICON"]): ?>
                        <svg class="icon icon-<?= $arItem["PARAMS"]["ICON"] ?>">
                            <use xlink:href="#<?= $arItem["PARAMS"]["ICON"] ?>"></use>
                        </svg>
                    <? endif ?>

                    <? if ($arItem["PARAMS"]["IMG"]): ?>
                        <img src="<?= $arItem["PARAMS"]["IMG"] ?>" class="icon"/>
                    <? endif ?>

                    <span><?= $arItem["TEXT"] ?></span>
                </a>
            </li>
        <? endforeach ?>
    </ul>
<? endif ?>
