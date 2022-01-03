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
<form action="<? echo $arResult["FORM_ACTION"] ?>" class="form form--filter js-catalog-filter-form">
  <input type="hidden" name="ajax" value="y">
  <? foreach ($arResult["HIDDEN"] as $arItem): ?>
    <input type="hidden"
           name="<? echo $arItem["CONTROL_NAME"] ?>"
           id="<? echo $arItem["CONTROL_ID"] ?>"
           value="<? echo $arItem["HTML_VALUE"] ?>"/>
  <? endforeach; ?>

  <div class="form__header">
    <div class="form__title">
      <div class="form__title-text">Фильтр</div>
      <div class="form__title-number js-filter-count-elements">0</div>
    </div>
    <button type="button" class="btn btn--small form__reset js-filter-reset">Сбросить</button>
    <button type="button" class="form__close js-catalog-filter-hide">
      <svg class="icon icon-46">
        <use xlink:href="#46"></use>
      </svg>
    </button>
  </div>

  <?
  /**
   * prices
   */
  foreach ($arResult["ITEMS"] as $key => $arItem) :
    $key = $arItem["ENCODED_ID"];
    if (isset($arItem["PRICE"])):
      if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
        continue;
      ?>
      <div class="form__section js-toggle-slide">
        <button type="button" class="form__toggle js-toggle-slide-btn active">
          <svg class="icon icon-plus ">
            <use xlink:href="#plus"></use>
          </svg>
          <span class="form__section-title">Цена</span>
        </button>
        <div class="form__inputs js-toggle-slide-content">
          <input
            type="text"
            name="range_price"
            value=""
            class="js-range-price"
            data-min="0"
            data-max="<?= $arItem['VALUES']['MAX']['VALUE'] ?>"
            data-from="0"
            data-to="<?= $arItem['VALUES']['MAX']['VALUE'] ?>"
          />
          <div class="form__inputs-prices">
            <div class="form__inputs-price">
              <input
                class="input js-filter-option js-price-from"
                type="number"
                min="0"
                name="<?= $arItem['VALUES']['MIN']['CONTROL_NAME'] ?>"
                placeholder="<?= $arItem['VALUES']['MIN']['VALUE'] ?>"
                value="0"
              />
              <div class="rubl">i</div>
            </div>
            <div class="form__inputs-price">
              <input
                class="input js-filter-option js-price-to"
                type="number"
                max="<?= $arItem['VALUES']['MAX']['VALUE'] ?>"
                name="<?= $arItem['VALUES']['MAX']['CONTROL_NAME'] ?>"
                placeholder="<?= $arItem['VALUES']['MAX']['VALUE'] ?>"
                value="<?= $arItem['VALUES']['MAX']['VALUE'] ?>"
              />
              <div class="rubl">i</div>
            </div>
          </div>
        </div>
      </div>
    <?endif;
  endforeach;

  /**
   * not prices
   */
  foreach ($arResult["ITEMS"] as $key => $arItem) :
    if (
      empty($arItem["VALUES"])
      || isset($arItem["PRICE"])
    )
      continue;

    if (
      $arItem["DISPLAY_TYPE"] == "A"
      && (
        $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
      )
    )
      continue;
    ?>

    <?
    $arCur = current($arItem["VALUES"]);
    switch ($arItem["DISPLAY_TYPE"]) {
      /**
       * Числа
       */
      case "P":
        ?>
        <div class="form__section js-toggle-slide" style="display: none">
          <button type="button" class="form__toggle js-toggle-slide-btn">
            <svg class="icon icon-plus ">
              <use xlink:href="#plus"></use>
            </svg>
            <span class="form__section-title"><?= $arItem['NAME'] ?></span>
          </button>
          <div class="form__inputs js-toggle-slide-content js-filter-inputs-group">
            <?
            foreach ($arItem['VALUES'] as $val => $option):
              ?>
              <div class="form__group">
                <label class="checkbox"
                       data-label="<?= $option['VALUE']; ?>"
                       for="<?= $option["CONTROL_ID"] ?>">
                  <input
                    type="checkbox"
                    value="<?= $option['HTML_VALUE'] ?>"
                    name="<?= $option['CONTROL_NAME'] ?>"
                    class="js-filter-option"
                    id="<?= $option['CONTROL_ID'] ?>"
                    <? echo $option['CHECKED'] ? 'checked="checked"' : '' ?>
                  />
                  <span class="checkbox__view">
                  <svg class="icon icon-checkmark ">
                    <use xlink:href="#checkmark"></use>
                  </svg>
                </span>
                  <span class="checkbox__text"><?= $option['VALUE']; ?></span>
                </label>
                <div class="input-group__error"></div>
              </div>
            <? endforeach; ?>
          </div>
        </div>
        <?
        break;
      /**
       * Вывод списков выбора
       */
      default:
        ?>
        <?
        /**
         * Список
         */
        ?>
        <div class="form__section js-toggle-slide">
          <button type="button" class="form__toggle js-toggle-slide-btn">
            <svg class="icon icon-plus ">
              <use xlink:href="#plus"></use>
            </svg>
            <span class="form__section-title"><?= $arItem['NAME'] ?></span>
          </button>
          <div class="form__inputs js-toggle-slide-content">
            <?
            foreach ($arItem['VALUES'] as $val => $option):
              ?>
              <div class="form__group">
                <label class="checkbox <? echo $option['DISABLED'] ? 'checkbox--disabled' : '' ?>"">
                <input
                  type="checkbox"
                  value="<?= $option['HTML_VALUE'] ?>"
                  name="<?= $option['CONTROL_NAME'] ?>"
                  class="js-filter-option"
                  <? echo $option['CHECKED'] ? 'checked="checked"' : '' ?>
                />
                <span class="checkbox__view">
                  <svg class="icon icon-checkmark ">
                    <use xlink:href="#checkmark"></use>
                  </svg>
                </span>
                <span class="checkbox__text"><?= $option['VALUE']; ?></span>
                </label>
                <div class="input-group__error"></div>
              </div>
            <? endforeach; ?>
          </div>
        </div>
      <?
    }
    ?>
  <?
  endforeach;
  ?>
</form>
