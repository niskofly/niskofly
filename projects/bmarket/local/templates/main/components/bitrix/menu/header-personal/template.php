<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
    <li class="nav__item">
        <a href="/personal" class="nav__link nav__link--user-menu">
            <svg class="icon icon-user ">
                <use xlink:href="#user"></use>
            </svg>
            <span>Мой профиль</span>
        </a>
        <ul class="nav nav--user-menu">
            <? foreach ($arResult as $arItem): ?>
                <li class="nav__item">
                    <a href="<?= $arItem["LINK"] ?>"
                       title="<?= $arItem["TEXT"] ?>"
                       class="nav__link <?= $arItem["PARAMS"]["CLASS"] ?>">
                        <?= $arItem["TEXT"] ?>
                    </a>
                </li>
            <? endforeach ?>
        </ul>
    </li>
<? endif ?>
