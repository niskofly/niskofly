<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/* Получение брендов */
$brands = [];
$obBrands = CIBlockElement::GetList(
  ['SORT' => 'ASC'],
  ['IBLOCK_ID' => BRANDS_ID, 'ACTIVE' => 'Y', 'ACTIVE_DATA' => 'Y'],
  false,
  ['nTopCount' => 15],
  ['*']
);

while ($obBrand = $obBrands->GetNext()) {
  /* Вывод брендов при наличии картинкой */
  if ($obBrand['PREVIEW_PICTURE'])
    $brands[] = [
      'IMG' => CFile::GetPath($obBrand['PREVIEW_PICTURE']),
      'NAME' => $obBrand['NAME'],
    ];
}
?>

<? if (!empty($arResult)): ?>
  <ul class="header-nav">
    <? foreach ($arResult['MENU'] as $urlFirst => $itemFirst): ?>
      <li class="header-nav__item">
        <a href="<?= $urlFirst ?>" class="header-nav__link">
          <?= $itemFirst['NAME'] ?></a>
        <div class="window-catalog">
          <div class="container">
            <div class="window-catalog__wrapper">
              <div class="window-catalog__content">
                <div class="window-catalog__sections">
                  <? foreach ($itemFirst['CATEGORIES'] as $urlCategory => $contentCategory): ?>
                    <div class="window-catalog__section">
                      <a href="<?= $urlCategory ?>" class="window-catalog__section-header">
                        <? if ($contentCategory['IMG']): ?>
                          <img src="<?= $contentCategory['IMG'] ?>"
                               alt="<?= $contentCategory['NAME'] ?>"
                               class="window-catalog__section-image"/>
                        <? endif; ?>
                        <span class="window-catalog__section-title"><?= $contentCategory['NAME'] ?></span>
                      </a>
                      <? if ($contentCategory['SUB_CATEGORIES']): ?>
                        <ul class="window-catalog__section-links">
                          <? foreach ($contentCategory['SUB_CATEGORIES'] as $urlSubCategory => $contentSubCategory): ?>
                            <li>
                              <a href="<?= $contentSubCategory['LINK'] ?>"
                                 class="window-catalog__section-link">
                                <?= $contentSubCategory['NAME'] ?>
                              </a>
                            </li>
                          <? endforeach; ?>
                        </ul>
                        <a href="<?= $urlCategory ?>" class="window-catalog__section-all">
                          Смотреть больше</a>
                      <? else: ?>
                        <ul class="window-catalog__section-links">
                          <li>Нету категорий</li>
                        </ul>
                      <? endif; ?>
                    </div>
                  <? endforeach; ?>
                </div>
              </div>
              <!-- Вывод брендов в слайдере -->
              <div class="window-catalog__slider">
                <button type="button"
                        class="slider-control window-catalog__slider-control js-catalog-window-brands-prev">
                  <svg class="icon icon-up-prev ">
                    <use xlink:href="#up-prev"></use>
                  </svg>
                </button>
                <div data-slider-id="catalog-window-brands"
                     class="swiper-container window-catalog__slider-container js-slider">
                  <div class="swiper-wrapper">
                    <? foreach ($brands as $brand): ?>
                      <div class="swiper-slide window-catalog__slider-slide">
                        <img src="<?= $brand['IMG'] ?>"
                             alt="<?= $brand['NAME'] ?>"
                             class="window-catalog__slider-image"/>
                      </div>
                    <? endforeach; ?>
                  </div>
                </div>
                <button type="button"
                        class="slider-control window-catalog__slider-control js-catalog-window-brands-next">
                  <svg class="icon icon-down-next ">
                    <use xlink:href="#down-next"></use>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </li>
    <? endforeach; ?>
  </ul>
<? endif ?>
