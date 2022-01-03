<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
    <div class="container header-catalog__container">
        <ul class="nav nav--header-catalog js-custom-bar">
            <? foreach ($arResult as $arItem): ?>
                <li class="nav__item">
                    <button
                       data-id="<?= $arItem["PARAMS"]["CODE"] ?>"
                       class="nav__link js-header-catalog-link">
                        <?= $arItem["TEXT"] ?>
                    </button>
                </li>
            <? endforeach; ?>
        </ul>

        <div class="header-catalog__subnavs js-custom-bar">
            <? foreach ($arResult as $arItem): ?>
                <ul class="nav nav--header-subcatalog js-header-subcatalog js-header-subcatalog-<?= $arItem["PARAMS"]["CODE"] ?>">
                    <? foreach ($arItem['ADDITIONAL_LINKS'] as $arSubItem): ?>
                        <li class="nav__item">
                            <a href="<?= $arSubItem["LINK"] ?>"
                               title="<?= $arSubItem["TEXT"] ?>"
                               class="nav__link">
                                <?= $arSubItem["TEXT"] ?>
                            </a>
                        </li>
                    <? endforeach; ?>
                </ul>
            <? endforeach; ?>
        </div>
    </div>
<? endif ?>
