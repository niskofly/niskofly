<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
    <div class="container">
        <div class="btn-back js-toggle-header-collections">
            <svg class="icon icon-arrow-l ">
                <use xlink:href="#arrow-l"></use>
            </svg>
            <span>Назад</span>
        </div>
        <ul class="nav nav--header-collections">
            <? foreach ($arResult as $arItem): ?>
                <li class="nav__item">
                    <a href="<?= $arItem["LINK"] ?>"
                    title="<?= $arItem["TEXT"] ?>"
                    class="nav__link">
                        <?= $arItem["TEXT"] ?>
                    </a>
                </li>
            <? endforeach; ?>
        </ul>
    </div>

<? endif ?>
