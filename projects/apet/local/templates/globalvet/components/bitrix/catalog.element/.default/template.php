<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */
$this->setFrameMode(true);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
  'ID' => $mainId,
  'DISCOUNT_PERCENT_ID' => $mainId . '_dsc_pict',
  'STICKER_ID' => $mainId . '_sticker',
  'BIG_SLIDER_ID' => $mainId . '_big_slider',
  'BIG_IMG_CONT_ID' => $mainId . '_bigimg_cont',
  'SLIDER_CONT_ID' => $mainId . '_slider_cont',
  'OLD_PRICE_ID' => $mainId . '_old_price',
  'PRICE_ID' => $mainId . '_price',
  'DISCOUNT_PRICE_ID' => $mainId . '_price_discount',
  'PRICE_TOTAL' => $mainId . '_price_total',
  'SLIDER_CONT_OF_ID' => $mainId . '_slider_cont_',
  'QUANTITY_ID' => $mainId . '_quantity',
  'QUANTITY_DOWN_ID' => $mainId . '_quant_down',
  'QUANTITY_UP_ID' => $mainId . '_quant_up',
  'QUANTITY_MEASURE' => $mainId . '_quant_measure',
  'QUANTITY_LIMIT' => $mainId . '_quant_limit',
  'BUY_LINK' => $mainId . '_buy_link',
  'ADD_BASKET_LINK' => $mainId . '_add_basket_link',
  'BASKET_ACTIONS_ID' => $mainId . '_basket_actions',
  'NOT_AVAILABLE_MESS' => $mainId . '_not_avail',
  'COMPARE_LINK' => $mainId . '_compare_link',
  'TREE_ID' => $mainId . '_skudiv',
  'DISPLAY_PROP_DIV' => $mainId . '_sku_prop',
  'DISPLAY_MAIN_PROP_DIV' => $mainId . '_main_sku_prop',
  'OFFER_GROUP' => $mainId . '_set_group_',
  'BASKET_PROP_DIV' => $mainId . '_basket_prop',
  'SUBSCRIBE_LINK' => $mainId . '_subscribe',
  'TABS_ID' => $mainId . '_tabs',
  'TAB_CONTAINERS_ID' => $mainId . '_tab_containers',
  'SMALL_CARD_PANEL_ID' => $mainId . '_small_card_panel',
  'TABS_PANEL_ID' => $mainId . '_tabs_panel'
);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
  ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
  : $arResult['NAME'];

$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
  ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
  : $arResult['NAME'];

$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
  ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
  : $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers) {
  $actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
    ? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
    : reset($arResult['OFFERS']);
} else {
  $actualItem = $arResult;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
# -------------------------------------------------------------------- #

$SESSION_COMPARE_LIST = $_SESSION["CATALOG_COMPARE_LIST"][CATALOG_ID]["ITEMS"];

$userBasket = [];
if (ItemsBitrixCart::getUserBasket()->getBasketItems()):
  foreach (ItemsBitrixCart::getUserBasket()->getBasketItems() as $basketItem):
    $userBasket[$basketItem->getField('PRODUCT_ID')] = intval($basketItem->getField('QUANTITY'));
  endforeach;
else:
  unset($userBasket);
endif;
?>

  <div class="product-detail container">
    <div class="product-detail__order">

      <!-- info: Галерея -->
      <div class="product-gallery">
        <?
        if ($arResult["PROPERTIES"]["GALLERY"]["VALUE"]):
          $countGalleryItems = count($arResult["PROPERTIES"]["GALLERY"]["VALUE"]);
          $galleryItems = [];

          foreach ($arResult["PROPERTIES"]["GALLERY"]["VALUE"] as $galleryItem):
            $arFile = CFile::GetFileArray($galleryItem);
            $arFile["IS_VIDEO"] = preg_match('/^video/', $arFile["CONTENT_TYPE"]);
            $galleryItems[] = $arFile;
          endforeach;
          ?>
          <div class="swiper-container product-gallery__preview js-gallery-preview">
            <div class="swiper-wrapper">
              <? foreach ($galleryItems as $galleryItem): ?>
                <div
                  class="swiper-slide product-gallery__slide<? if ($galleryItem["IS_VIDEO"]): ?> js-video<? endif; ?>">
                  <? if ($galleryItem["IS_VIDEO"]): ?>
                    <button type="button" class="product-gallery__slide-play js-video-play">
                      <svg class="icon icon-play">
                        <use xlink:href="#play"></use>
                      </svg>
                      <svg class="icon icon-pause">
                        <use xlink:href="#pause"></use>
                      </svg>
                    </button>
                    <video class="product-gallery__slide-video js-video-player">
                      <source src="<?= $galleryItem["SRC"] ?>" type='video/mp4;'>
                    </video>
                  <? else: ?>
                    <a href="<?= $galleryItem["SRC"] ?>" class="product-gallery__image js-modal-photo">
                      <img src="<?= $galleryItem["SRC"] ?>">
                    </a>
                  <? endif; ?>
                </div>
              <? endforeach; ?>
            </div>
          </div>
          <div class="product-gallery__thumbs">
            <div class="swiper-container js-gallery-thumbs">
              <div class="swiper-wrapper">
                <? foreach ($galleryItems as $galleryItem): ?>
                  <div style="background-image: url(<?= $galleryItem["SRC"]; ?>)"
                       class="swiper-slide product-gallery__thumb">
                    <? if ($galleryItem["IS_VIDEO"]): ?>
                      <div class="product-gallery__thumb-play">
                        <svg class="icon icon-play">
                          <use xlink:href="#play"></use>
                        </svg>
                      </div>
                      <video class="product-gallery__thumb-video">
                        <source src="<?= $galleryItem["SRC"] ?>" type='video/mp4;'>
                      </video>
                    <? endif; ?>
                  </div>
                <? endforeach; ?>
              </div>
            </div>
            <div class="product-gallery__controls">
              <button type="button" class="slider-control product-gallery__control js-product-gallery-prev">
                <svg class="icon icon-prev ">
                  <use xlink:href="#prev"></use>
                </svg>
              </button>
              <button type="button" class="slider-control product-gallery__control js-product-gallery-next">
                <svg class="icon icon-next ">
                  <use xlink:href="#next"></use>
                </svg>
              </button>
            </div>
          </div>
        <? endif; ?>
        <div class="btn btn--small btn--white-border product-gallery__note">Минимальная сумма покупки всего 5000₽</div>
      </div>

      <!-- info: Торговые предложения -->
      <div class="product-purchases">
        <div class="product-purchases__list">
          <?
          $productData = [];

          if (!$arResult['OFFERS']) {
            $productData[] = [
              'ID' => $arResult['ID'],
              'NAME' => $arResult['NAME'],
              'PRODUCT' => [
                'QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
                'AVAILABLE' => $arResult['PRODUCT']['AVAILABLE'],
              ],
              'DETAIL_PICTURE' => [
                'SRC' => $arResult['DETAIL_PICTURE']['SRC']
              ],
              'PRICES' => [
                'BASE' => [
                  'PRINT_DISCOUNT_VALUE' => $arResult['OLD_PRICE'],
                  'DISCOUNT_DIFF' => $arResult['PRICES']['ruble']['DISCOUNT_DIFF'],
                  'PRINT_VALUE' => $arResult['ACTUAL_PRICE'],
                  'VALUE_VAT' => $arResult['VALUE_VAT']
                ]
              ],
            ];
          }
          ?>

          <? foreach ($arResult['OFFERS'] ? $arResult['OFFERS'] : $productData as $item): ?>
            <div class="product-purchase js-product">
              <div class="product-purchase__detail">
                <div class="product-purchase__title"><?= $item["NAME"]; ?></div>
                <div class="product-purchase__available">
                  <div class="product-purchase__available-icon">
                    <svg class="icon icon-checkmark ">
                      <use xlink:href="#checkmark"></use>
                    </svg>
                  </div>
                  <div class="product-purchase__available-label">В наличии:</div>
                  <div class="product-purchase__available-number"><?= $item["PRODUCT"]["QUANTITY"]; ?></div>
                </div>
              </div>
              <div class="product-purchase__cost">
                <div class="product-purchase__price">
                  <?= $item["PRICES"]["BASE"]["PRINT_VALUE"]; ?>
                </div>

                <? if ($item["PRODUCT"]["AVAILABLE"] == "Y"): ?>
                  <div class="product-amount js-counter">
                    <input type="hidden"
                           value="<?= $item["PRODUCT"]["QUANTITY"]; ?>"
                           class="js-product-quantity-available">
                    <input type="hidden"
                           value="<?= $item["ID"]; ?>"
                           class="js-product-id">

                    <button type="button" class="product-amount__btn js-counter-btn" data-btn-type-counter="minus">
                      <svg class="icon icon-minus">
                        <use xlink:href="#minus"></use>
                      </svg>
                    </button>

                    <input
                      type="text"
                      name="QUANTITY_INPUT"
                      readonly
                      value="0"
                      class="product-amount__input js-counter-value">

                    <button type="button" class="product-amount__btn js-counter-btn" data-btn-type-counter="plus">
                      <svg class="icon icon-plus">
                        <use xlink:href="#plus"></use>
                      </svg>
                    </button>
                  </div>
                <? endif; ?>
              </div>
              <div class="product-purchase__controls">
                <? if ($item["PRODUCT"]["AVAILABLE"] == "Y"): ?>
                  <button type="button" class="product-purchase__buy-click js-open-modal"
                          data-modal="#modal-one-click-<?= $item["ID"]; ?>">
                    Купить в 1 клик
                  </button>

                  <form action="/api/order/add-to-cart.php" class="js-add-to-card js-buy-card-<?= $item["ID"]; ?>">
                    <input type="hidden" name="ACTION" value="BUY_PRODUCT">
                    <input type="hidden" name="PRODUCT_ID" value="<?= $item["ID"]; ?>">
                    <input type="hidden" name="QUANTITY" value="1" class="js-product-quantity-input">
                    <input type="hidden" name="PRODUCT_NAME" value="<?= $item['NAME'] ?>">
                    <input type="hidden" name="PRODUCT_BRAND"
                           value="<?= getNameElementById($arResult['PROPERTIES']['BRAND']['VALUE']) ?>">
                    <button type="submit" class="btn btn--medium btn--blue product-purchase__buy">В корзину</button>
                  </form>
                <? else: ?>
                  <button type="button" class="btn btn--medium btn--blue product-purchase__buy">Уведомить</button>
                <? endif; ?>
              </div>
            </div>

            <!-- info: Модальное окна -->
            <div class="modals">

              <!-- info: Модальное - Оставить вопрос -->
              <div id="modal-question" class="modal modal--review animated">
                <button type="button" class="modal__close js-close-modal">
                  <svg class="icon icon-close ">
                    <use xlink:href="#close"></use>
                  </svg>
                </button>
                <div class="modal__header">
                  <div class="title title--medium modal__title">Оставить вопрос</div>
                  <div class="modal__header-text">Оставьте свой вопрос и наш менеджер свяжется с Вами в ближайшее время
                  </div>
                </div>
                <div class="modal__main">
                  <form action="/api/catalog/question.php" class="form form--review js-form-sender">
                    <?= bitrix_sessid_post() ?>
                    <input type="hidden"
                           name="ACTION"
                           value="CREATE_QUESTION">
                    <input type="hidden"
                           name="THEME"
                           value="<?= $item["NAME"]; ?>">
                    <input type="hidden"
                           name="BIND_PRODUCT"
                           value="<?= $arResult['ID'] ?>">
                    <div class="input-groups">
                      <div class="input-group js-group-label">
                        <div class="input-group__wrapper">
                          <label class="input-group__label">Ваше имя</label>
                          <input name="NAME"
                                 type="text"
                                 class="input js-group-label__input"/>
                        </div>
                        <div class="input-group__error"></div>
                      </div>
                      <div class="input-group">
                        <textarea name="QUESTION"
                                  placeholder="Ваш отзыв"
                                  class="input form__textarea">
                        </textarea>
                        <div class="input-group__error"></div>
                      </div>
                      <div class="input-group">
                        <label class="input-photo input-photo--modal js-input-files">
                          <input type="file" name="FILES[]" multiple="multiple">
                          <span class="input-photo__icon">
                            <svg class="icon icon-plus ">
                                <use xlink:href="#plus"></use>
                            </svg>
                          </span>
                          <span class="input-photo__text">Добавить фото</span>
                        </label>
                      </div>
                    </div>
                    <div class="form__actions">
                      <label class="checkbox form__term">
                        <input type="checkbox"
                               class="js-form-sender-checkbox"
                               name="term"
                               value="Y"
                               checked="checked"/>
                        <span class="checkbox__view">
                          <svg class="icon icon-checkmark ">
                              <use xlink:href="#checkmark"></use>
                          </svg>
                        </span>
                        <span class="checkbox__text">
                          Согласен на обработку
                          <a href="/politic/">персональных данных</a>
                        </span>
                      </label>
                      <button type="submit" class="btn btn--blue btn--medium form__submit">Отправить</button>
                    </div>
                  </form>
                </div>
              </div>

              <!-- info: Модальное - Уведомить о снижении цены -->
              <div id="modal-price-notify" class="modal modal--notify animated">
                <button type="button" class="modal__close js-close-modal">
                  <svg class="icon icon-close ">
                    <use xlink:href="#close"></use>
                  </svg>
                </button>
                <div class="modal__header">
                  <div class="title title--medium modal__title">Уведомить о снижении цены</div>
                  <div class="modal__header-text">
                    <p>Оставьте свой email и мы оповестим Вас о</p>
                    <p>снижении цены на данный товар</p>
                  </div>
                </div>
                <div class="modal__main">
                  <form action="/api/catalog/price-drop.php" class="form form--product-notify js-form-sender">
                    <?= bitrix_sessid_post() ?>
                    <input type="hidden"
                           name="ACTION"
                           value="CREATE">
                    <input type="hidden"
                           name="THEME"
                           value="<?= $item['NAME'] ?>">
                    <input type="hidden"
                           name="BIND_PRODUCT"
                           value="<?= $arResult['ID'] ?>">
                    <div class="input-groups">
                      <div class="input-group js-group-label">
                        <div class="input-group__wrapper">
                          <label class="input-group__label">email</label>
                          <input name="EMAIL" type="email" class="input js-group-label__input"/>
                        </div>
                        <div class="input-group__error"></div>
                      </div>
                      <div class="input-group">
                        <label class="checkbox">
                          <input type="checkbox"
                                 name="CHECKBOX_IS_SMS"
                                 value="Y"
                                 checked="checked"/>
                          <span class="checkbox__view">
                            <svg class="icon icon-checkmark ">
                                <use xlink:href="#checkmark"></use>
                            </svg></span><span class="checkbox__text">Уведомлять по SMS</span>
                        </label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn--big btn--blue">Отправить</button>
                  </form>
                </div>
              </div>

              <!-- info: Модальное окно- Покупка в один клик -->
              <div id="modal-one-click-<?= $item["ID"]; ?>" class="modal modal--default animated">
                <div class="modal__header">
                  <div class="title title--medium modal__title">Купить в 1 клик</div>
                  <button type="button" class="modal__close js-close-modal">
                    <svg class="icon icon-close ">
                      <use xlink:href="#close"></use>
                    </svg>
                  </button>
                </div>
                <div class="modal__main">
                  <form action="/api/order/buy-one-click.php"
                        class="form form--modal-default js-form-sender js-buy-card-<?= $item["ID"]; ?>">
                    <?= bitrix_sessid_post() ?>
                    <input type="hidden"
                           name="ACTION"
                           value="ONE_CLICK_BUY_PRODUCT">
                    <input type="hidden"
                           name="PRODUCT_ID"
                           value="<?= $item['ID'] ?>">
                    <input type="hidden" name="QUANTITY" value="1" class="js-product-quantity-input">
                    <!-- todo: Продолжить -->
                    <div class="input-groups">
                      <div class="input-group js-group-label">
                        <div class="input-group__wrapper">
                          <label class="input-group__label">Ваше имя</label>
                          <input name="NAME" type="text" class="input js-group-label__input"/>
                        </div>
                        <div class="input-group__error"></div>
                      </div>
                      <div class="input-group js-group-label">
                        <div class="input-group__wrapper">
                          <label class="input-group__label">Телефон</label>
                          <input name="PHONE" type="text" class="input js-group-label__input"/>
                        </div>
                        <div class="input-group__error"></div>
                      </div>
                      <div class="input-group js-group-label">
                        <div class="input-group__wrapper">
                          <label class="input-group__label">Email</label>
                          <input name="EMAIL" type="email" class="input js-group-label__input"/>
                        </div>
                        <div class="input-group__error"></div>
                      </div>
                    </div>
                    <div class="form__actions">
                      <label class="checkbox form__term">
                        <input class="js-form-sender-checkbox"
                               type="checkbox"
                               name="checkbox"
                               value="Y"
                               checked="checked"/>
                        <span class="checkbox__view">
                                <svg class="icon icon-checkmark ">
                                    <use xlink:href="#checkmark"></use>
                                </svg></span><span class="checkbox__text">Согласен на обработку <a href="/">персональных
                                    данных</a></span>
                      </label>
                      <button type="submit" class="btn btn--blue btn--medium form__submit">Отправить</button>
                    </div>
                  </form>
                </div>
              </div>

              <!-- info: Модальное окно - Поделитесь отзывом -->
              <div id="modal-review" class="modal modal--review animated js-modal-review">
                <button type="button" class="modal__close js-close-modal">
                  <svg class="icon icon-close ">
                    <use xlink:href="#close"></use>
                  </svg>
                </button>
                <div class="modal__header">
                  <div class="title title--medium modal__title">Поделитесь отзывом</div>
                </div>
                <div class="modal__main">
                  <div class="product-order">
                    <span class="product-order__preview">
                      <img src="<?= CFile::GetPath($arResult["PROPERTIES"]["GALLERY"]["VALUE"][0]) ?>"
                           alt="<?= $item["NAME"]; ?>"/>
                    </span>
                    <div class="product-order__content">
                      <span class="product-order__name"><?= $item["NAME"]; ?></span>
                      <a href="/brands/" class="product-order__brand">
                        <?= getNameElementById($arResult['PROPERTIES']['BRAND']['VALUE']) ?>
                      </a>
                    </div>
                  </div>
                  <form action="/api/catalog/review.php" data-reset-form="Y" class="form form--review js-form-sender">
                    <?= bitrix_sessid_post() ?>
                    <input type="hidden"
                           name="ACTION"
                           value="CREATE">
                    <input type="hidden"
                           name="THEME"
                           value="<?= $item["NAME"]; ?>">
                    <input type="hidden"
                           name="BIND_PRODUCT"
                           value="<?= $arResult['ID'] ?>">
                    <div class="input-groups">
                      <div class="input-group input-group--rating">

                        <div class="input-group js-product-rating">
                          <input type="hidden" class="js-count-stars" name="COUNT_STAR" value="1">

                          <div class="rating js-rating-stars">
                            <div class="rating-stars__icon js-rating-star" data-star-id="1">
                              <svg class="icon icon-rate ">
                                <use xlink:href="#rate"></use>
                              </svg>
                            </div>
                            <div class="rating-stars__icon js-rating-star" data-star-id="2">
                              <svg class="icon icon-rate ">
                                <use xlink:href="#rate"></use>
                              </svg>
                            </div>
                            <div class="rating-stars__icon js-rating-star" data-star-id="3">
                              <svg class="icon icon-rate ">
                                <use xlink:href="#rate"></use>
                              </svg>
                            </div>
                            <div class="rating-stars__icon js-rating-star" data-star-id="4">
                              <svg class="icon icon-rate ">
                                <use xlink:href="#rate"></use>
                              </svg>
                            </div>
                            <div class="rating-stars__icon js-rating-star" data-star-id="5">
                              <svg class="icon icon-rate ">
                                <use xlink:href="#rate"></use>
                              </svg>
                            </div>
                          </div>
                          <div class="input-group__error"></div>
                        </div>
                        <div class="input-group__error"></div>
                      </div>
                      <div class="input-group">
                        <textarea name="REVIEW" placeholder="Ваш отзыв" class="input form__textarea"></textarea>
                        <div class="input-group__error"></div>
                      </div>
                      <div class="input-group">
                        <label class="input-photo input-photo--modal js-input-files">
                          <input type="file" name="FILES[]" multiple="multiple">
                          <span class="input-photo__icon">
                          <svg class="icon icon-plus ">
                              <use xlink:href="#plus"></use>
                          </svg>
                        </span>
                          <span class="input-photo__text">Добавить фото</span>
                        </label>
                      </div>
                    </div>
                    <div class="form__actions">
                      <label class="checkbox form__term">
                        <input class="js-form-sender-checkbox" type="checkbox" name="checkbox" value="Y" checked/>
                        <span class="checkbox__view">
                        <svg class="icon icon-checkmark ">
                            <use xlink:href="#checkmark"></use>
                        </svg>
                        </span>
                        <span class="checkbox__text">Согласен на обработку
                          <a href="/politic/">персональных данных</a>
                        </span>
                      </label>
                      <button type="submit" class="btn btn--blue btn--medium form__submit">Отправить</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <? endforeach; ?>
        </div>

        <!-- info: Информация и снижении цены -->
        <div class="product-purchases__info">
          <button type="button" class="product-purchases__info-notification js-open-modal"
                  data-modal="#modal-price-notify">
            <svg class="icon icon-call ">
              <use xlink:href="#call"></use>
            </svg>
            <span>Узнать о снижении цены</span>
          </button>
          <span class="btn btn--small btn--white-border product-purchases__info-similar">
            <span>Смотреть аналоги</span>
            <!-- <span class="btn__num-round">2</span> -->
          </span>
        </div>
      </div>
    </div>

    <!-- info: Информация о продукте -->
    <div class="product-detail__info">
      <div class="product-detail__controls">
        <div class="product-detail__controls-header">
          <!-- info: Рейтинги -->
          <div class="rating rating--show">
            <? for ($i = 0; $i < 5; $i++): ?>
              <? if ($i < round($arResult['PROPERTIES']['RATING_REVIEW']['VALUE']) ?: 0): ?>
                <svg class="icon icon-rate  is--active ">
                  <use xlink:href="#rate"></use>
                </svg>
              <? else: ?>
                <svg class="icon icon-rate ">
                  <use xlink:href="#rate"></use>
                </svg>
              <? endif; ?>
            <? endfor; ?>
          </div>

          <div class="user-menu product-detail__controls-menu">
            <!-- info: Кнопка добавления в сравнение -->
            <?
            $isActiveCompare = false;
            if (!(array_key_exists($arResult["ID"], $_SESSION['CATALOG_COMPARE_LIST'][$arResult["IBLOCK_ID"]]['ITEMS']))) {
              $methodCompare = 'ADD_TO_COMPARE_LIST';
            } else {
              $methodCompare = 'DELETE_FROM_COMPARE_LIST';
              $isActiveCompare = true;
            }
            ?>
            <div class="js-product-compare">
              <input type="hidden" name="product_id" value="<?= $arResult["ID"] ?>">
              <input type="hidden" name="method" value="<?= $methodCompare ?>">
              <button type="button"
                      class="user-menu__button <?= $isActiveCompare ? 'user-menu__button--active' : '' ?>">
                <svg class="icon icon-chart ">
                  <use xlink:href="#chart"></use>
                </svg>
              </button>
            </div>
            <!-- info: Кнопка добавления в избранное -->
            <?
            $isActiveFavorite = false;
            try {
              $isActiveFavorite = (new UserFavoriteProducts())->checkInFavorite($item["ID"]);
            } catch (Exception $e) {
              $isFavoritesException = true;
            }
            ?>
            <div class="js-product-favourite">
              <input type="hidden" name="product_id" value="<?= $item["ID"] ?>">
              <button type="button"
                      class="user-menu__button <?= $isActiveFavorite ? 'user-menu__button--active' : '' ?>">
                <svg class="icon icon-heart ">
                  <use xlink:href="#heart"></use>
                </svg>
              </button>
            </div>
            <!-- info: Кнопка поделиться -->
            <button type="button" class="user-menu__button js-open-modal" data-modal="#modal-share">
              <svg class="icon icon-share ">
                <use xlink:href="#share"></use>
              </svg>
            </button>
          </div>
        </div>
        <!-- info: Кнопка открытия окна -->
        <button type="button"
                class="product-detail__controls-review js-open-modal"
                data-modal="#modal-review">
          Поделитесь отзывом
        </button>
      </div>

      <!-- info: свойства продукта -->
      <div class="product-props product-detail__props">
        <?
        $arExceptions = [1 => "GALLERY", "MANUAL_FILE", "MANUAL", "STRUCTURE"];
        $arProductProps = array_filter($arResult["PROPERTIES"], function ($v) use ($arExceptions) {
          return !array_search($v["CODE"], $arExceptions);
        });
        foreach ($arProductProps as $arProp):
          if ($arProp["VALUE"]):
            ?>
            <div class="product-prop">
              <div class="product-prop__name"><?= $arProp["NAME"]; ?></div>
              <div class="product-prop__space"></div>
              <div class="product-prop__value"><?= $arProp["VALUE"]; ?></div>
            </div>
          <?
          endif;
        endforeach;
        ?>
      </div>
      <div class="product-detail__contacts">
        <div class="product-detail__contacts-item">
          <svg class="icon icon-sale ">
            <use xlink:href="#sale"></use>
          </svg>
          <div class="product-detail__contacts-text">При покупке от 50 шт. - скидка 10%</div>
        </div>
        <div class="product-detail__contacts-item">
          <svg class="icon icon-paw ">
            <use xlink:href="#paw"></use>
          </svg>
          <div class="product-detail__contacts-text">В наличии в <a href="/">57 магазинах</a></div>
        </div>
        <div class="product-detail__contacts-item">
          <svg class="icon icon-truck ">
            <use xlink:href="#truck"></use>
          </svg>
          <div class="product-detail__contacts-text">Доставка по Москве, 2-3 дня</div>
        </div>
        <div class="product-detail__contacts-item">
          <svg class="icon icon-cart ">
            <use xlink:href="#cart"></use>
          </svg>
          <div class="product-detail__contacts-text">Самовывоз, сегодня до 18:00</div>
        </div>
      </div>
    </div>

  </div>

  <!--
  info: Табы
  -->

  <div class="tabs container js-tabs">
    <div class="tabs__buttons">
      <button type="button" data-tab="characteristic" class="tabs__button js-tab-action active">Характеристики</button>
      <? if ($arResult["PREVIEW_TEXT"]): ?>
        <button type="button" data-tab="description" class="tabs__button js-tab-action">Описание</button>
      <? endif; ?>
      <? if ($arResult["PROPERTIES"]["STRUCTURE"]["~VALUE"]["TEXT"]): ?>
        <button type="button" data-tab="composition" class="tabs__button js-tab-action">Состав</button>
      <? endif; ?>
      <? if ($arResult["PROPERTIES"]["MANUAL"]["~VALUE"]["TEXT"]): ?>
        <button type="button" data-tab="instruction" class="tabs__button js-tab-action">Инструкция</button>
      <? endif; ?>
      <button type="button" data-tab="reviews" class="tabs__button js-tab-action">Отзывы</button>
      <button type="button" data-tab="question" class="tabs__button js-tab-action">Задать вопрос</button>
    </div>
    <div data-tab-content="characteristic" class="tabs__tab js-tab active">
      <div class="tabs__tab-wrapper">
        <div class="product-props product-props--tabs">
          <? foreach ($arProductProps as $arProp): ?>
            <? if ($arProp["VALUE"]): ?>
              <div class="product-prop">
                <div class="product-prop__name"><?= $arProp["NAME"]; ?></div>
                <div class="product-prop__space"></div>
                <div class="product-prop__value"><?= $arProp["VALUE"]; ?></div>
              </div>
            <? endif; ?>
          <? endforeach; ?>
        </div>
      </div>
    </div>

    <!-- info: Таб-описание -->
    <? if ($arResult["PREVIEW_TEXT"]): ?>
      <div data-tab-content="description" class="tabs__tab js-tab">
        <div class="tabs__tab-wrapper">
          <div class="tabs__tab-content"><?= $arResult["PREVIEW_TEXT"]; ?></div>
        </div>
      </div>
    <? endif; ?>

    <!-- info: Таб-состав -->
    <? if ($arResult["PROPERTIES"]["STRUCTURE"]["~VALUE"]["TEXT"]): ?>
      <div data-tab-content="composition" class="tabs__tab js-tab">
        <div class="tabs__tab-wrapper">
          <div class="tabs__tab-content"><?= $arResult["PROPERTIES"]["STRUCTURE"]["~VALUE"]["TEXT"]; ?></div>
        </div>
      </div>
    <? endif; ?>

    <!-- info: Таб-инструкция -->
    <? if ($arResult["PROPERTIES"]["MANUAL"]["~VALUE"]["TEXT"]):
      $arManualFile = CFile::GetFileArray($arResult["PROPERTIES"]["MANUAL_FILE"]["VALUE"]);
      ?>
      <div data-tab-content="instruction" class="tabs__tab js-tab">
        <div class="tabs__tab-wrapper">
          <div class="tabs__tab-content"><?= $arResult["PROPERTIES"]["MANUAL"]["~VALUE"]["TEXT"]; ?></div>
          <? if ($arManualFile): ?>
            <div class="tabs__tab-sidebar">
              <img src="/img/icons/pdf.svg" alt="Оригинальная инструкция" class="tabs__tab-icon">
              <div class="tabs__tab-title">Оригинальная инструкция</div>
              <a href="<?= $arManualFile["SRC"]; ?>" class="btn btn--medium btn--blue tabs__tab-button">Скачать pdf</a>
            </div>
          <? endif; ?>
        </div>
      </div>
    <? endif; ?>

    <!-- info: Таб-отзыва -->
    <? if ($arResult['REVIEWS']): ?>
      <div data-tab-content="reviews" class="tabs__tab js-tab">
        <div class="tabs__tab-wrapper">
          <div class="tabs__tab-content">
            <? foreach ($arResult['REVIEWS'] as $review): ?>
              <div class="review tabs__tab-review">
                <img src="<?= $review['USER_IMG'] ?>" alt="<?= $review['USER'] ?>" class="review__image">
                <div class="review__content">
                  <div class="review__header">
                    <div class="review__name"><?= $review['USER'] ?></div>
                    <div class="review__date"><?= $review['DATE'] ?></div>

                    <div class="rating rating--show">
                      <? for ($i = 0; $i < 5; $i++): ?>
                        <? if ($i < round($review['COUNT_STAR']) ?: 0): ?>
                          <svg class="icon icon-rate is--active">
                            <use xlink:href="#rate"></use>
                          </svg>
                        <? else: ?>
                          <svg class="icon icon-rate ">
                            <use xlink:href="#rate"></use>
                          </svg>
                        <? endif; ?>
                      <? endfor; ?>
                    </div>
                  </div>
                  <div class="review__text"><?= $review['TEXT'] ?></div>
                </div>
              </div>
            <? endforeach; ?>
          </div>
          <div class="tabs__tab-sidebar"><img src="/img/icons/doc.svg" alt="Оригинальная инструкция"
                                              class="tabs__tab-icon">
            <div class="tabs__tab-title">Оцените данный продукт</div>
            <button type="button" class="btn btn--medium btn--blue tabs__tab-button js-open-modal"
                    data-modal="#modal-review">Поделитесь отзывом
            </button>
          </div>
        </div>
      </div>
    <? endif; ?>

    <div data-tab-content="question" class="tabs__tab js-tab">
      <div class="tabs__tab-wrapper">
        <div class="tabs__tab-content tabs__tab-content--faq">
          <div class="tabs__tab-title">Часто задаваемые вопросы по товару</div>
          <?
          global $faqListClass;
          $faqListClass = "product-detail";
          $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "faq-list",
            array(
              "ACTIVE_DATE_FORMAT" => "d.m.Y",
              "ADD_SECTIONS_CHAIN" => "N",
              "AJAX_MODE" => "N",
              "AJAX_OPTION_ADDITIONAL" => "",
              "AJAX_OPTION_HISTORY" => "N",
              "AJAX_OPTION_JUMP" => "N",
              "AJAX_OPTION_STYLE" => "Y",
              "CACHE_FILTER" => "N",
              "CACHE_GROUPS" => "Y",
              "CACHE_TIME" => "36000000",
              "CACHE_TYPE" => "A",
              "CHECK_DATES" => "Y",
              "DETAIL_URL" => "",
              "DISPLAY_BOTTOM_PAGER" => "Y",
              "DISPLAY_DATE" => "Y",
              "DISPLAY_NAME" => "Y",
              "DISPLAY_PICTURE" => "Y",
              "DISPLAY_PREVIEW_TEXT" => "Y",
              "DISPLAY_TOP_PAGER" => "N",
              "FIELD_CODE" => array(
                0 => "",
                1 => "",
              ),
              "FILTER_NAME" => "",
              "HIDE_LINK_WHEN_NO_DETAIL" => "N",
              "IBLOCK_ID" => QUESTION_ID,
              "IBLOCK_TYPE" => "content",
              "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
              "INCLUDE_SUBSECTIONS" => "Y",
              "MESSAGE_404" => "",
              "NEWS_COUNT" => "100",
              "PAGER_BASE_LINK_ENABLE" => "N",
              "PAGER_DESC_NUMBERING" => "N",
              "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
              "PAGER_SHOW_ALL" => "N",
              "PAGER_SHOW_ALWAYS" => "N",
              "PAGER_TEMPLATE" => ".default",
              "PAGER_TITLE" => "Новости",
              "PARENT_SECTION" => "",
              "PARENT_SECTION_CODE" => "",
              "PREVIEW_TRUNCATE_LEN" => "",
              "PROPERTY_CODE" => array(
                0 => "",
                1 => "",
              ),
              "SET_BROWSER_TITLE" => "Y",
              "SET_LAST_MODIFIED" => "N",
              "SET_META_DESCRIPTION" => "Y",
              "SET_META_KEYWORDS" => "Y",
              "SET_STATUS_404" => "N",
              "SET_TITLE" => "Y",
              "SHOW_404" => "N",
              "SORT_BY1" => "ACTIVE_FROM",
              "SORT_BY2" => "SORT",
              "SORT_ORDER1" => "DESC",
              "SORT_ORDER2" => "ASC",
              "STRICT_SECTION_CHECK" => "N",
              "COMPONENT_TEMPLATE" => "faq-list"
            ),
            false
          );
          ?>
        </div>
        <div class="tabs__tab-sidebar tabs__tab-sidebar--image">
          <img src="/img/tab-sidebar.png" alt="Остались вопросы?" class="tabs__tab-image">
          <div class="tabs__tab-title">Остались вопросы?</div>
          <div class="tabs__tab-text">Мы оперативно ответим на них</div>
          <button type="button" class="btn btn--medium btn--blue tabs__tab-button js-open-modal"
                  data-modal="#modal-question">Задать вопрос
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    window.__RATING_REVIEW__ = <?= $arResult['PROPERTIES']['RATING_REVIEW']['VALUE'] ?: 0?>
  </script>

  <script>
    window.__CURRENT_PAGE_URL__ = '<?= (CMain::IsHTTPS()) ? "https://" : "http://" . $_SERVER["HTTP_HOST"] . $APPLICATION->GetCurUri() ?>'
  </script>
<?
unset($actualItem, $itemIds, $galleryItems);
