<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arResult */
/** @var array $arParams */

/* Получение брендов */
$brands = [];
$obBrands = CIBlockElement::GetList(
  ['SORT' => 'ASC'],
  ['IBLOCK_ID' => BRANDS_IBLOCK_ID, 'ACTIVE' => 'Y', 'ACTIVE_DATA' => 'Y'],
  false,
  ['nTopCount' => 15],
  ['NAME', 'PREVIEW_PICTURE']
);
while ($brand = $obBrands->GetNext())
  $brands[] = [
    'IMG' => $brand['PREVIEW_PICTURE']
      ? CFile::GetPath($brand['PREVIEW_PICTURE'])
      : '/img/no-image.png',
    'NAME' => $brand['NAME'],
  ];
?>

<? if ($arResult['MENU']): ?>
  <? if ($arParams['IS_MOBILE']): ?>
    <!-- info: Отображение мобильного меню -->
    <div class="header-catalog-mobile">
      <div class="nav">
        <? foreach ($arResult['MENU'] as $urlFirst => $itemFirst): ?>
          <? if ($itemFirst['IS_ONE']): ?>
            <div class="nav__wrapper">
              <div class="nav__item nav__item--plus js-header-catalog-link-mobile">
                <?= $itemFirst['NAME'] ?>
                <svg width="5" height="10" viewBox="0 0 5 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0L5 5L0 10V0Z" fill="#46382C"/>
                </svg>
              </div>
              <div class="header-menu-subcatalog js-header-menu-subcatalog">
                <div class="nav nav--subcatalog">
                  <div class="nav__item nav__item--back js-subcatalog-back">
                    <svg width="5" height="10" viewBox="0 0 5 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M5 0L0 5L5 10V0Z" fill="#46382C"/>
                    </svg>
                    <?= $itemFirst['NAME'] ?>
                  </div>
                  <? foreach ($itemFirst['CATEGORIES'] as $urlItemFirst => $contentItemFirst): ?>
                    <a href="<?= $urlItemFirst ?>" class="nav__item"><?= $contentItemFirst['NAME'] ?></a>
                  <? endforeach; ?>
                </div>
              </div>
            </div>
          <? endif; ?>
        <? endforeach; ?>

        <? foreach ($arResult['MENU'] as $url => $item): ?>
          <? if (!$item['IS_ONE']): ?>
            <div class="nav__wrapper">
              <div class="nav__item js-header-catalog-link-mobile">
                <?= $item['NAME'] ?>
                <svg width="5" height="10" viewBox="0 0 5 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0L5 5L0 10V0Z" fill="#46382C"/>
                </svg>
              </div>
              <div class="header-menu-subcatalog js-header-menu-subcatalog">
                <div class="nav nav--subcatalog">
                  <div class="nav__item nav__item--back js-subcatalog-back">
                    <svg width="5" height="10" viewBox="0 0 5 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M5 0L0 5L5 10V0Z" fill="#46382C"/>
                    </svg>
                    <?= $item['NAME'] ?>
                  </div>
                  <? foreach ($item['CATEGORIES'] as $urlCatalog => $itemCatalog): ?>
                    <a href="<?= $urlCatalog ?>" class="nav__item"><?= $itemCatalog['NAME'] ?></a>
                  <? endforeach; ?>
                </div>
              </div>
            </div>
          <? endif; ?>
        <? endforeach; ?>
      </div>
    </div>
  <? else: ?>
    <!-- info: Отображение стандартного меню -->
    <div class="container header-navigation__container">
      <div class="header-navigation__list">
        <? foreach ($arResult['MENU'] as $urlFirst => $itemFirst): ?>
          <? if ($itemFirst['IS_ONE']): ?>
            <div class="header-navigation__list-item header-navigation__list-item--hoverable">
              <svg class="icon icon-plus-outline ">
                <use xlink:href="#plus-outline"></use>
              </svg>
              <a href="<?= $itemFirst['LINK'] ?>" class="header-navigation__list-item_span">
                <?= $itemFirst['NAME'] ?>
              </a>
              <div class="header-subnav">
                <div class="container">
                  <div class="header-subnav__wrapper">
                    <div class="header-tabs js-tabs">
                      <div class="tabs__actions header-tabs__actions">
                        <? foreach ($itemFirst['CATEGORIES'] as $urlItemFirst => $contentItemFirst): ?>
                          <button data-tab="<?= $urlItemFirst ?>" class="header__tab js-tab-action active">
                            <?= $contentItemFirst['NAME'] ?>
                          </button>
                        <? endforeach; ?>
                      </div>
                      <? foreach ($itemFirst['CATEGORIES'] as $urlTab => $contentTab): ?>
                        <div data-tab-content="<?= $urlTab ?>" class="tab js-tab tab--show">
                          <div class="subnav__tab">
                            <div class="subnav-links">
                              <? foreach ($contentTab['SUB_CATEGORIES'] as $urlTabElement => $contentTabElement): ?>
                                <a href="<?= $contentTabElement['LINK'] ?>" class="subnav-link">
                                  <?= $contentTabElement['NAME'] ?>
                                </a>
                              <? endforeach; ?>
                            </div>
                          </div>
                        </div>
                      <? endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <? endif; ?>
        <? endforeach; ?>

        <div class="header-navigation__group">
          <? foreach ($arResult['MENU'] as $url => $item): ?>
            <? if (!$item['IS_ONE']): ?>
              <div class="header-navigation__group-item header-navigation__list-item--hoverable">
                <a href="<?= $item['LINK'] ?>" class="header-navigation__list-item_span">
                  <?= $item['NAME'] ?>
                </a>
                <div class="header-subnav">
                  <div class="container">
                    <div class="header-subnav__wrapper">
                      <div class="subnav-categories">
                        <? foreach ($item['CATEGORIES'] as $urlCatalog => $itemCatalog): ?>
                          <div class="subnav-category">
                            <div class="subnav-category__img">
                              <a href="<?= $urlCatalog ?>">
                                <img src="<?= $itemCatalog['IMG'] ?>" alt=""/>
                              </a>
                            </div>
                            <div class="subnav-category__content">
                              <div class="subnav-category__title">
                                <!-- todo: Оформить стили в sass -->
                                <a href="<?= $urlCatalog ?>" class="subnav-category__link" style="font-size: 19px">
                                  <?= $itemCatalog['NAME'] ?>
                                </a>
                              </div>
                              <? foreach ($itemCatalog['SUB_CATEGORIES'] as $urlSubCatalog => $itemSubCatalog): ?>
                                <a href="<?= $itemSubCatalog['LINK'] ?>"
                                   class="subnav-category__link"><?= $itemSubCatalog['NAME'] ?>
                                </a>
                              <? endforeach; ?>
                            </div>
                          </div>
                        <? endforeach; ?>
                      </div>
                      <!-- info: Временно скрыто -->
                      <div class="header-subnav__slider" style="display: none">
                        <button
                          type="button"
                          class="swiper-button-prev">
                          <svg class="icon icon-top ">
                            <use xlink:href="#top"></use>
                          </svg>
                        </button>
                        <div class="swiper-container header-subnav__slider-container js-header-brand-slider">
                          <div class="swiper-wrapper">
                            <? foreach ($brands as $brand): ?>
                              <div class="swiper-slide">
                                <img src="<?= $brand['IMG'] ?>" alt="<?= $brand['NAME'] ?>"
                                     class="header-subnav__slider-image"/>
                              </div>
                            <? endforeach; ?>
                          </div>
                        </div>
                        <button
                          type="button"
                          class="swiper-button-next">
                          <svg class="icon icon-down ">
                            <use xlink:href="#down"></use>
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <? endif; ?>
          <? endforeach; ?>
        </div>
      </div>
    </div>
  <? endif; ?>
<? endif; ?>
