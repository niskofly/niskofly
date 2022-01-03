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

<div class="catalog-filters js-filter">
  <form action="<? echo $arResult["FORM_ACTION"] ?>" class="js-catalog-filter-form">
    <input type="hidden" name="ajax" value="y">
    <? foreach ($arResult["HIDDEN"] as $arItem): ?>
      <input type="hidden"
             name="<? echo $arItem["CONTROL_NAME"] ?>"
             id="<? echo $arItem["CONTROL_ID"] ?>"
             value="<? echo $arItem["HTML_VALUE"] ?>"/>
    <? endforeach; ?>

    <div class="clear-filters">
      <div class="clear-filters__span">Фильтр
        <!-- <span class="js-filter-count-elements">0</span> -->
      </div>
      <button type="button" class="clear-filters__btn js-filter-reset">Сбросить</button>
      <!--
      <button type="button" class="filter-close js-filter-close">
        <svg class="icon icon-close">
          <use xlink:href="#close"></use>
        </svg>
      </button>
      -->
    </div>

    <?
    /**
     * render prices block
     */
    foreach ($arResult["ITEMS"] as $key => $arItem) :
      $key = $arItem["ENCODED_ID"];
      if (isset($arItem["PRICE"])):
        if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
          continue;
        ?>

        <!-- Вкладка элемента -->
        <div class="filter-item">
          <div class="filter-item__heading">
            <svg class="icon icon-plus ">
              <use xlink:href="#plus"></use>
            </svg>
            <div class="filter-item__heading-description">Цена</div>
          </div>
          <!-- контент элемента -->
          <div class="filter-item__body filter-item__body--price js-filter-section-inputs">
            <div class="range">
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
              <div class="range-fields">
                <input type="text"
                       id="<?= $arItem['VALUES']['MIN']['CONTROL_ID'] ?>"
                       placeholder="<?= $arItem['VALUES']['MIN']['VALUE'] ?>"
                       value="<?= $arItem['VALUES']['MIN']['HTML_VALUE'] ?>"
                       name="<?= $arItem['VALUES']['MIN']['CONTROL_NAME'] ?>"
                       class="input js-filter-option range-input__field range-input__field--left js-price-from"/>
                <input type="text"
                       id="<?= $arItem['VALUES']['MAX']['CONTROL_ID'] ?>"
                       placeholder="<?= $arItem['VALUES']['MAX']['VALUE'] ?>"
                       value="<?= $arItem['VALUES']['MAX']['HTML_VALUE'] ?>"
                       name="<?= $arItem['VALUES']['MAX']['CONTROL_NAME'] ?>"
                       class="input js-filter-option range-input__field range-input__field--right js-price-to"/>
              </div>
            </div>
          </div>
        </div>

      <?endif;
    endforeach;

    /**
     * render not prices block
     */
    foreach ($arResult["ITEMS"] as $key => $arItem) :
      if (empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
        continue;

      if ($arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
        continue;
      ?>

      <?
      $arCur = current($arItem["VALUES"]);
      switch ($arItem["DISPLAY_TYPE"]) {
        /* Displaying the hidden menu item */
        case "P":
          ?>
          <div class="filter-item" style="display: none;">
            <div class="filter-item__body js-filter-inputs-group">
              <? foreach ($arItem['VALUES'] as $val => $option): ?>
                <label class="checkbox checkbox--outline"
                       data-label="<?= $option['VALUE']; ?>"
                       for="<?= $option["CONTROL_ID"] ?>">
                  <input type="checkbox"
                         value="<?= $option['HTML_VALUE'] ?>"
                         name="<?= $option['CONTROL_NAME'] ?>"
                         class="js-filter-option"
                         id="<?= $option['CONTROL_ID'] ?>"
                    <? echo $option['CHECKED'] ? 'checked="checked"' : '' ?>
                  >
                  <span class="checkbox__indicator">
                    <svg class="icon icon-check ">
                      <use xlink:href="#check"></use>
                    </svg>
                  </span>
                  <span class="checkbox__description"><?= $option['VALUE']; ?></span>
                </label>
              <? endforeach; ?>
            </div>
          </div>
          <?
          break;
        /* Displaying the main menu item */
        default:
          ?>
          <div class="filter-item">
            <div class="filter-item__heading js-filter-section-toggle">
              <div class="filter-item-toggle"></div>
              <div class="filter-item__heading-description">
                <?= $arItem['NAME'] ?>
              </div>
            </div>
            <div class="filter-item__body js-filter-inputs-group">
              <? foreach ($arItem['VALUES'] as $val => $option): ?>
                <label class="checkbox checkbox--outline"
                       data-label="<?= $option['VALUE']; ?>"
                       for="<?= $option["CONTROL_ID"] ?>">
                  <input type="checkbox"
                         value="<?= $option['HTML_VALUE'] ?>"
                         name="<?= $option['CONTROL_NAME'] ?>"
                         class="js-filter-option"
                         id="<?= $option['CONTROL_ID'] ?>"
                    <? echo $option['CHECKED'] ? 'checked="checked"' : '' ?>
                  >
                  <span class="checkbox__indicator">
                    <svg class="icon icon-check ">
                      <use xlink:href="#check"></use>
                    </svg>
                  </span>
                  <span class="checkbox__description"><?= $option['VALUE']; ?></span>
                </label>
              <? endforeach; ?>
            </div>
          </div>
        <?
      }
      ?>
    <? endforeach; ?>
  </form>
</div>


