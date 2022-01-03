<?
/* Главный слайдер */
$obSliders = CIBlockElement::GetList(
  ['SORT' => 'ASC'],
  ['IBLOCK_ID' => SLIDERS_IBLOCK_ID, 'ACTIVE' => 'Y', 'ACTIVE_DATA' => 'Y'],
  false,
  false,
  ['NAME', 'PREVIEW_PICTURE', 'PROPERTY_LINK']
);

$sliders = [];

while ($slider = $obSliders->GetNext())
  $sliders[] = [
    'NAME' => $slider['NAME'],
    'IMG' => CFile::GetPath($slider['PREVIEW_PICTURE']),
    'LINK' => $slider['PROPERTY_LINK_VALUE']
  ];

/* Товары дня */
$productsDayHandler = new ProductDay(CATALOG_ID, PRODUCT_DAY_IBLOCK_ID);
$productsDayList = $productsDayHandler->getProductsDayList();
?>

<div class="container">
  <!-- Slider -->
  <div class="hero-sliders">
    <div class="hero-slider hero-slider--promo">
      <div class="swiper-container js-hero-slider--promo">
        <? if ($sliders): ?>
          <div class="swiper-wrapper">
            <? foreach ($sliders as $slideId => $slideContent): ?>
              <div class="swiper-slide <?= $slideId == 0 ? 'swiper-slide--grey' : '' ?>">
                <div class="promo-wrapper">
                  <div class="promo-wrapper__title" style="display: none"><?= $slideContent['NAME'] ?></div>
                  <div class="promo-wrapper__img">
                    <a href="<?= $slideContent['LINK'] ?>">
                      <img src="<?= $slideContent['IMG'] ?>" alt="<?= $slideContent['NAME'] ?>">
                    </a>
                  </div>
                </div>
              </div>
            <? endforeach; ?>
          </div>
        <? endif; ?>
        <div class="swiper-pagination"></div>
      </div>
    </div>
    <!-- Products day -->
    <? if ($productsDayList): ?>
      <div class="hero-slider hero-slider--daily">
        <div class="swiper-container js-hero-slider--daily">
          <div class="swiper-wrapper">
            <? foreach ($productsDayList as $productId => $product): ?>
              <div class="swiper-slide">
                <div class="daily-card">
                  <div class="daily-card__title"><?= $product['NAME'] ?></div>
                  <? if ($product['PRODUCT_DATA']['PRICE_DATA']['DISCOUNT_PERCENT']): ?>
                    <div class="daily-card__stock">
                      -<?= $product['PRODUCT_DATA']['PRICE_DATA']['DISCOUNT_PERCENT'] ?>%
                    </div>
                  <? endif; ?>
                  <div
                    class="daily-card__timer js-timer"
                    data-timer-time-start="<?= strtotime("now") ?>"
                    data-timer-time-end="<?= strtotime($product['DATA_ACTIVE_TO']) ?>">
                    <div class="daily-card__timer-text">До конца акции</div>
                    <div class="daily-card__timer-time">
                      <span class="js-timer-day"></span>д&nbsp;
                      <span class="js-timer-hour"></span>&nbsp;:
                      <span class="js-timer-min"></span>&nbsp;:
                      <span class="js-timer-sec"></span>
                    </div>
                  </div>
                  <div class="daily-card__img">
                    <img src="<?= $product['PRODUCT_DATA']['IMG'] ?>"
                         alt="<?= $product['PRODUCT_DATA']['NAME'] ?>">
                  </div>
                  <div class="daily-card__body">
                    <a href="<?= $product['PRODUCT_DATA']['DETAIL_URL'] ?>"
                       class="daily-card__name">
                      <?= $product['PRODUCT_DATA']['NAME'] ?>
                    </a>
                  </div>
                  <div class="daily-card__footer">
                    <div class="daily-card__links">
                      <a href="/brands" class="daily-card__manufacturer"><?= $product['PRODUCT_DATA']['BRAND'] ?></a>
                      <div class="daily-card__group">
                        <form action="/api/user/controller-comparison.php" class="js-comparison-form">
                          <input type="hidden" name="action" value="ADD_TO_COMPARE_LIST">
                          <input type="hidden" name="product_id" value="<?= $productId ?>">
                          <button type="submit" class="daily-card__group-icon">
                            <svg class="icon icon-chart ">
                              <use xlink:href="#chart"></use>
                            </svg>
                          </button>
                        </form>
                        <form action="/api/user/controller-favorites.php" class="js-favorites-form">
                          <input type="hidden" name="product_id" value="<?= $productId ?>">
                          <button type="submit" class="daily-card__group-icon">
                            <svg class="icon icon-heart ">
                              <use xlink:href="#heart"></use>
                            </svg>
                          </button>
                        </form>
                      </div>
                    </div>
                    <div class="daily-card__prices">
                      <? if ($product['PRODUCT_DATA']['PRICE_DATA']['DISCOUNT_PERCENT']): ?>
                        <div class="daily-card__price">
                          <?= $product['PRODUCT_DATA']['PRICE_DATA']['DISCOUNT_PRICE'] ?> ₽
                        </div>
                        <div class="daily-card__oldprice">
                          <?= $product['PRODUCT_DATA']['PRICE_DATA']['PRICE'] ?> ₽
                        </div>
                      <? else: ?>
                        <div class="daily-card__price">
                          <?= $product['PRODUCT_DATA']['PRICE_DATA']['PRICE'] ?> ₽
                        </div>
                      <? endif; ?>
                    </div>
                  </div>
                </div>
                <div class="daily-card__loader js-daily-card__loader"></div>
              </div>
            <? endforeach; ?>
          </div>
          <script>
            window.__IS_PAGE_TIMER__ = true;
          </script>
        </div>
      </div>
    <? endif; ?>
  </div>
</div>
