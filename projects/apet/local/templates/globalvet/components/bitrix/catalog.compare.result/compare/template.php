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

$isAjax = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $isAjax = (
    (isset($_POST['ajax_action']) && $_POST['ajax_action'] == 'Y')
    || (isset($_POST['compare_result_reload']) && $_POST['compare_result_reload'] == 'Y')
  );
}

?>
<div class="section-compare container" id="bx_catalog_compare_block">
  <?
  if ($isAjax):
    $APPLICATION->RestartBuffer();
  endif;
  ?>

  <!-- info: сайдбар -->
  <div class="section-compare__sidebar">
    <div class="section-compare__tabs">
      <a href="<?= $arResult['COMPARE_URL_TEMPLATE'] . 'DIFFERENT=N'; ?>"
         class="btn btn--small btn--white section-compare__tab<?= !$arResult['DIFFERENT'] ? 'section-compare__tab--active' : '' ?>">
        Все характеристики</a>
      <a href="<?= $arResult['COMPARE_URL_TEMPLATE'] . 'DIFFERENT=Y'; ?>"
         class="btn btn--small btn--white section-compare__tab<?= $arResult['DIFFERENT'] ? 'section-compare__tab--active' : '' ?> ">
        Отличия</a>
    </div>
    <ul class="section-compare__props section-compare__props--labels">
      <!-- info: Свойства продукта -->
      <?
      foreach ($arResult["SHOW_PROPERTIES"] as $code => $arProperty):
      $showRow = true;
      if ($arResult['DIFFERENT']):
        $arCompare = array();
        foreach ($arResult["ITEMS"] as $arElement):
          $arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
          if (is_array($arPropertyValue)):
            sort($arPropertyValue);
            $arPropertyValue = implode(" / ", $arPropertyValue);
          endif;
          $arCompare[] = $arPropertyValue;
        endforeach;
        unset($arElement);
        $showRow = (count(array_unique($arCompare)) > 1);
      endif;

      if ($showRow):
      ?>
      <li class="section-compare__prop"><?= $arProperty["NAME"] ?>
        <?
        endif;
        endforeach;
        ?>
    </ul>
  </div>

  <!-- info: Слайдеры -->
  <div class="section-compare__slider">
    <div class="section-compare__slider-controls">
      <span class="btn btn--medium btn--white section-compare__slider-control js-clear-comparison-list">Очистить список</span>
    </div>

    <div class="swiper-container section-compare__slider-products js-slider-compare js-fixed-section">
      <div class="swiper-wrapper">
        <? foreach ($arResult["ITEMS"] as $arElement): ?>
          <div class="swiper-slide section-compare__slide">
            <div class="section-compare__product">
              <div class="card-product">
                <a href="<?= $arElement["DETAIL_PAGE_URL"] ?>" class="card-product__preview">
                  <span class="discount card-product__discount">-5%</span>
                  <img
                    src="<?= ($arElement["PREVIEW_PICTURE"]["SRC"]) ? $arElement["PREVIEW_PICTURE"]["SRC"] : NO_IMAGE_SRC ?>"/>
                </a>
                <div class="card-product__main">
                  <a href="/" class="card-product__title"><?= $arElement["NAME"] ?></a>
                  <div class="card-product__actions">
                    <a href="/" class="card-product__brand"><?= $arElement["DISPLAY_PROPERTIES"]["BRAND"]["DISPLAY_VALUE"] ?></a>
                    <div class="user-menu card-product__user-menu">
                      <button type="button" class="user-menu__button">
                        <svg class="icon icon-chart ">
                          <use xlink:href="#chart"></use>
                        </svg>
                      </button>
                      <button type="button" class="user-menu__button user-menu__button--active">
                        <svg class="icon icon-heart ">
                          <use xlink:href="#heart"></use>
                        </svg>
                      </button>
                    </div>
                  </div>
                  <div class="card-product__footer">
                    <div class="card-product__prices">
                      <div class="card-product__price">
                        <? $currentPrice = current($arElement['PRICE_MATRIX']['MIN_PRICES']); ?>
                        <?= CCurrencyLang::CurrencyFormat($currentPrice['PRICE'], $currentPrice['CURRENCY']) ?>
                      </div>
                      <div class="price-old">От 9940 р.</div>
                    </div>
                    <button type="button" class="btn btn--medium btn--ice card-product__buy">Уведомить</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?
          # удалить товар из сравнения
          /*
        ?>
        <a onclick="CatalogCompareObj.delete('<?= CUtil::JSEscape($arElement['~DELETE_URL']) ?>');"
             href="javascript:void(0)"><?= GetMessage("CATALOG_REMOVE_PRODUCT") ?></a>
          */ ?>

        <?
        endforeach;
        unset($arElement);
        ?>

      </div>
    </div>

    <div class="swiper-container section-compare__slider-props js-slider-compare-info">
      <div class="swiper-wrapper">
        <? foreach ($arResult["ITEMS"] as $arElement): ?>
          <div class="swiper-slide">
            <ul class="section-compare__props">
              <?
              foreach ($arResult["SHOW_PROPERTIES"] as $code => $arProperty):
                $showRow = true;
                if ($arResult['DIFFERENT']):
                  $arCompare = array();
                  foreach ($arResult["ITEMS"] as $arEl):
                    $arPropertyValue = $arEl["DISPLAY_PROPERTIES"][$code]["VALUE"];
                    if (is_array($arPropertyValue)):
                      sort($arPropertyValue);
                      $arPropertyValue = implode(" / ", $arPropertyValue);
                    endif;
                    $arCompare[] = $arPropertyValue;
                  endforeach;

                  unset($arEl);
                  $showRow = (count(array_unique($arCompare)) > 1);
                endif;
                if ($showRow):
                  $productProp = (is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]) ? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]) : $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]);
                  ?>
                  <li class="section-compare__prop"><?= ($productProp) ? $productProp : '-'; ?></li>
                <? endif;
              endforeach;
              ?>
            </ul>
          </div>
        <?
        endforeach;
        unset($arElement);
        ?>
      </div>
    </div>
  </div>

  <?
  if ($isAjax) {
    die();
  }
  ?>
</div>

<script type="text/javascript">
  var CatalogCompareObj = new BX.Iblock.Catalog.CompareClass("bx_catalog_compare_block", '<?=CUtil::JSEscape($arResult['~COMPARE_URL_TEMPLATE']); ?>');
</script>
