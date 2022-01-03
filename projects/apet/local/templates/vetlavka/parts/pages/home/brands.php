<?
/* Вывод брендов */
$brands = [];
$obBrands = CIBlockElement::GetList(
  ['SORT' => 'ASC'],
  ['IBLOCK_ID' => BRANDS_IBLOCK_ID, 'ACTIVE' => 'Y', 'ACTIVE_DATA' => 'Y', 'PROPERTY_IS_SHOW_MAIN_PAGE_VALUE' => "Да"],
  false,
  ['nTopCount' => 15],
  ['*']
);
while ($obBrand = $obBrands->GetNextElement()) {
  $fieldsBrand = $obBrand->GetFields();
  $brands[] = [
    'IMG' => CFile::GetPath($fieldsBrand['PREVIEW_PICTURE']) ?: '/img/no-image.png',
    'NAME' => $fieldsBrand['NAME'],
    'LINK' => $fieldsBrand['DETAIL_PAGE_URL']
  ];
}
?>

<? if ($brands): ?>
  <div class="hero-developers__slider">
    <div class="container">
      <div class="manufacturers-slider">
        <button class="swiper-button-prev-unique">
          <svg class="icon icon-left ">
            <use xlink:href="#left"></use>
          </svg>
        </button>
        <div class="swiper-container js-manufacturers-slider">
          <div class="swiper-wrapper">
            <? foreach ($brands as $brand): ?>
              <div class="swiper-slide">
                <a href="<?= $brand['LINK'] ?>">
                  <img src="<?= $brand['IMG'] ?>" alt="<?= $brand['NAME'] ?>">
                </a>
              </div>
            <? endforeach; ?>
          </div>
        </div>
        <button class="swiper-button-next-unique">
          <svg class="icon icon-right ">
            <use xlink:href="#right"></use>
          </svg>
        </button>
      </div>
    </div>
  </div>
<? endif; ?>
