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
$isHideClearFilterBtn = $arResult['SEF_DEL_FILTER_URL'] == $arResult['FILTER_URL'];
?>
<form action="<? echo $arResult["FORM_ACTION"] ?>" class="js-catalog-filter">
    <input type="hidden" name="ajax" value="y">

    <? foreach ($arResult["HIDDEN"] as $arItem): ?>
        <input type="hidden"
               name="<? echo $arItem["CONTROL_NAME"] ?>"
               id="<? echo $arItem["CONTROL_ID"] ?>"
               value="<? echo $arItem["HTML_VALUE"] ?>"/>
    <? endforeach; ?>

    <div class="form__actions">
        <button type="reset" class="btn btn--transparent form__action js-catalog-filter-reset"
            <? echo $isHideClearFilterBtn ? 'style="display:none"' : '' ?>>
            Сбросить фильтры
        </button>
    </div>

    <?/*
    todo: Скрытие фильтра по наличию товаров
    ?>
    <div class="form__section form__section--first">
        <div class="form__section-header">
            <div class="form__section-title">Наличие</div>
        </div>
        <div class="form__group">
            <label class="checkbox">
                <input type="checkbox"
                       name="AVAILABLE"
                    <? if ($_COOKIE['HIDE_NOT_AVAILABLE'] == 'Y') { ?> checked <? } ?>
                       value="Y"
                       class="checkbox__input js-catalog-filter-available">
                <span class="checkbox__view">
                    <svg class="icon icon-check ">
                      <use xlink:href="#check"></use>
                    </svg>
                </span>
                <span class="checkbox__text">В наличии</span>
            </label>
            <div class="input-group__error"></div>
        </div>
    </div>
    <?*/?>
    <?
    /**
     * Фильтр по ценам отключен, нет визуальной реализации
     */
    foreach ($arResult["ITEMS"] as $key => $arItem) :
        if (!isset($arItem["PRICE"]))
            continue;

        if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
            continue;

        $settings = [
            'min' => $arItem['VALUES']['MIN']['VALUE'],
            'currentMin' => $arItem['VALUES']['MIN']['HTML_VALUE'],
            'max' => $arItem['VALUES']['MAX']['VALUE'],
            'currentMax' => $arItem['VALUES']['MAX']['HTML_VALUE'],
        ]
        ?>
        <div class="form__section form__section--first">
            <div class="form__section-header">
                <div class="form__section-title">Цена, ₽</div>
            </div>
            <div class="form__group">
                <input class="form__group-range js-range-slider" data-settings='<?= json_encode($settings) ?>'>
                <div class="form__group-input">
                    <input value="<?= $arItem['VALUES']['MIN']['HTML_VALUE'] ?: $arItem['VALUES']['MIN']['VALUE'] ?>  ₽"
                           class="input input--filter js-input-range-from">
                    <input value="<?= $arItem['VALUES']['MAX']['HTML_VALUE'] ?: $arItem['VALUES']['MAX']['VALUE'] ?>  ₽"
                           class="input input--filter js-input-range-to">

                    <input type="hidden"
                           name="<?= $arItem['VALUES']['MIN']['CONTROL_NAME'] ?>"
                           value="<?= $arItem['VALUES']['MIN']['HTML_VALUE'] ?>"
                           class="input input--filter js-input-range-from js-input-range-from-result">
                    <input type="hidden"
                           name="<?= $arItem['VALUES']['MAX']['CONTROL_NAME'] ?>"
                           value="<?= $arItem['VALUES']['MAX']['HTML_VALUE'] ?>"
                           class="input input--filter js-input-range-to js-input-range-to-result">
                </div>
            </div>
        </div>
    <?
    endforeach;

    /**
     * Вывод фильтра только с одним значением, тип отображения - Радиокнопки
     */
    if (!empty($arResult["ONE_OPTIONS_FILTER"])):?>
        <div class="form__section"><? foreach ($arResult["ONE_OPTIONS_FILTER"] as $arItem):
                if (empty($arItem["VALUES"]))
                    continue;

                $option = current($arItem["VALUES"]);
                ?>
                <div class="form__group">
                    <label class="checkbox" <? echo $option['DISABLED'] ? 'checkbox--disabled' : '' ?>
                           for="<? echo $option["CONTROL_ID"] ?>">
                        <input
                            type="checkbox"
                            value="<?= $option['HTML_VALUE'] ?>"
                            name="<?= $option['CONTROL_NAME'] ?>"
                            class="checkbox__input js-catalog-filter-option"
                            id="<?= $option['CONTROL_ID'] ?>"
                            <? echo $option['CHECKED'] ? 'checked="checked"' : '' ?>
                        />
                        <span class="checkbox__view">
                            <svg class="icon icon-check ">
                                <use xlink:href="#check"></use>
                            </svg>
                        </span>
                        <span class="checkbox__text">
                            <?= $arItem['NAME']; ?>
                        </span>
                    </label>
                </div>
            <? endforeach; ?></div>
    <? endif;

    foreach ($arResult["ITEMS"] as $key => $arItem) :
        if (empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
            continue;

        if ($arItem["DISPLAY_TYPE"] == "A"
            && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
            continue;
        ?>
        <div class="form__section <? echo count($arItem['VALUES']) > 6 ? 'js-input-groups' : '' ?>">
            <div class="form__section-header">
                <div class="form__section-title">
                    <?= $arItem['NAME'] ?>
                </div>
            </div>
            <? foreach ($arItem['VALUES'] as $val => $option): ?>
                <div class="form__group">
                    <label class="checkbox" <? echo $option['DISABLED'] ? 'checkbox--disabled' : '' ?>
                           for="<? echo $option["CONTROL_ID"] ?>">
                        <input
                            type="checkbox"
                            value="<?= $option['HTML_VALUE'] ?>"
                            name="<?= $option['CONTROL_NAME'] ?>"
                            class="checkbox__input js-catalog-filter-option"
                            id="<?= $option['CONTROL_ID'] ?>"
                            <? echo $option['CHECKED'] ? 'checked="checked"' : '' ?>
                        />
                        <span class="checkbox__view">
                            <svg class="icon icon-check ">
                                <use xlink:href="#check"></use>
                            </svg>
                        </span>
                        <span class="checkbox__text">
                            <?= $option['VALUE']; ?>
                        </span>
                    </label>
                </div>
            <? endforeach; ?>

            <? if (count($arItem['VALUES']) > 6) : ?>
                <button type="button" class="form__group-toggle js-toggle-input-group">
                    <span class="js-toggle-input-group-text">Показать все</span>
                    <img src="/img/icons/arrow-d.svg" class="icon">
                </button>
            <? endif; ?>
        </div>
    <? endforeach; ?>
</form>
