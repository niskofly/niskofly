<?
/** @global CMain $APPLICATION */

use Bitrix\Main\Page\Asset;

/* Главный слайдер */
$sliders = [];
$obSliders = CIBlockElement::GetList(
  ['SORT' => 'ASC'],
  ['IBLOCK_ID' => SLIDERS_IBLOCK_ID, 'ACTIVE' => 'Y', 'PROPERTY_SITE_RESTRICTION_VALUE' => 'GlobalVet', 'ACTIVE_DATA' => 'Y'],
  false,
  false,
  ['*']
);

while ($obSlider = $obSliders->GetNextElement()) {
  $fieldsSlider = $obSlider->GetFields();
  $propertiesSlider = $obSlider->GetProperties();
  $sliders[] = [
    'IMG' => CFile::GetPath($fieldsSlider['PREVIEW_PICTURE']),
    'NAME' => $fieldsSlider['NAME'],
    'LINK' => $propertiesSlider['LINK']['VALUE']
  ];
}

/* Товары дня */
$productsDayHandler = new ProductDay(CATALOG_ID, PRODUCT_DAY_IBLOCK_ID);
try {
  $productsDayList = $productsDayHandler->getProductsDayList();
  $productsDayElement = array_shift($productsDayList);
} catch (Exception $e) {
  die(json_encode(["error" => true, "message" => $e->getMessage()]));
}
//dump($productsDayElement);
?>

<div class="section-intro container">
  <!-- Slider -->
  <div data-slider-id="home-intro"
       class="swiper-container section-intro__slider js-slider <?= $productsDayElement ?: 'section-intro__slider--full' ?>">
    <div class="swiper-pagination"></div>
    <? if ($sliders): ?>
      <div class="swiper-wrapper">
        <? foreach ($sliders as $slider): ?>
          <div style="background-image: url('<?= $slider["IMG"]; ?>')"
               class="swiper-slide section-intro__slider-slide"
               alt="<?= $slider['NAME'] ?>"
               title="<?= $slider['NAME'] ?>">
          </div>
        <? endforeach; ?>
      </div>
    <? endif; ?>
  </div>
  <!-- Products day -->
  <? if ($productsDayElement): ?>
    <div class="card-promo section-intro__promo">
      <div class="card-promo__header">
        <div class="card-promo__title">Акция</div>
        <a href="/catalog/promo/" class="card-promo__link-all">Все акции</a>
      </div>
      <div class="card-promo__preview">
        <a href="" class="card-promo__image">
          <img alt="<?= $productsDayElement['PRODUCT_DATA']['NAME'] ?>"
               src="<?= $productsDayElement['PRODUCT_DATA']['IMG'] ?>">
        </a>
        <div class="card-promo__discount">
          <? if ($productsDayElement['PRODUCT_DATA']['PRICE_DATA']['DISCOUNT_PERCENT'] > 0): ?>
            <div class="card-promo__discount-number">
              <?= $productsDayElement['PRODUCT_DATA']['PRICE_DATA']['DISCOUNT_PERCENT'] ?>%
            </div>
          <? endif; ?>
          <div class="card-promo__discount-label">
            До конца акции
          </div>
          <div class="card-promo__discount-timer js-timer"
               data-timer-time-start="<?= strtotime("now") ?>"
               data-timer-time-end="<?= strtotime($productsDayElement['DATA_ACTIVE_TO']) ?>">
            <span class="js-timer-day"></span>д&nbsp;
            <span class="js-timer-hour"></span>&nbsp;:
            <span class="js-timer-min"></span>&nbsp;:
            <span class="js-timer-sec"></span>
          </div>
        </div>
      </div>
      <div class="card-promo__detail">
        <a href="<?= $productsDayElement['PRODUCT_DATA']['DETAIL_URL'] ?>" class="card-promo__name">
          <?= $productsDayElement['PRODUCT_DATA']['NAME'] ?>
        </a>
        <a href="<?= $productsDayElement['PRODUCT_DATA']['DETAIL_URL'] ?>"
           class="btn btn--medium btn--white card-promo__link-more">
          подробнее
          <span class="btn__icon-round">
          <svg class="icon icon-next ">
            <use xlink:href="#next"></use>
          </svg>
      </span>
        </a>
      </div>
    </div>
  <? endif; ?>
</div>
