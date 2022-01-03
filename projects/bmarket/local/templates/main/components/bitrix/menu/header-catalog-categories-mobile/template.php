<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>

        <div class="header-catalog-mobile js-header-menu-catalog">
            <ul class="nav nav--header-catalog-mobile">
                <? foreach ($arResult as $arItem): ?>
                    <li class="nav__item">
                        <button
                        data-id="<?= $arItem["PARAMS"]["CODE"] ?>"
                        class="nav__link js-header-catalog-link-mobile">
                            <div><?= $arItem["TEXT"] ?></div>
                            <svg class="icon icon-arrow-r ">
                                <use xlink:href="#arrow-r"></use>
                            </svg>
                        </button>
                    </li>
                <? endforeach; ?>
            </ul>
        </div>


        <div class="header-menu-subcatalog js-header-menu-subcatalog">
            <div class="btn-back js-subcatalog-back">
                <svg class="icon icon-arrow-l ">
                    <use xlink:href="#arrow-l"></use>
                </svg>
                <span>Назад</span>
            </div>
            <? foreach ($arResult as $arItem): ?>
                <ul class="nav nav--header-subcatalog-mobile js-header-subcatalog-mobile js-header-subcatalog-mobile-<?= $arItem["PARAMS"]["CODE"] ?>">
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

<? endif ?>
