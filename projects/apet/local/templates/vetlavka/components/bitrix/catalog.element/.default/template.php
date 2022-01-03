<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var array $item
 * @var array $price
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

$nameProduct = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
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

?>

  <!-- Название товара -->
  <div class="page__title title">
    <h1 class="seo-title">
      <?= $nameProduct ?>
    </h1>
  </div>
  <!-- Слайдер -->
  <div class="product">
    <div class="product-slider">
      <div class="swiper-container gallery-top js-product-slider">
        <!-- Отображение img -->
        <div class="swiper-wrapper">
          <? if ($arResult['MORE_PHOTO']): ?>
            <? foreach ($arResult['MORE_PHOTO'] as $photoElement): ?>
              <div class="swiper-slide">
                <img src="<?= $photoElement['SRC'] ?>"
                     alt="<?= $arResult['DETAIL_PICTURE']['ALT'] ?>"
                     title="<?= $arResult['DETAIL_PICTURE']['TITLE'] ?>">
              </div>
            <? endforeach; ?>
          <? endif; ?>
        </div>
        <!-- Информация о скидке -->
        <?
        /* Получение товары дня */
        $productsDayHandler = new ProductDay(CATALOG_ID, PRODUCT_DAY_IBLOCK_ID);
        $productsDayList = $productsDayHandler->getProductsDayList();
        ?>
        <div class="product-stock">
          <!-- $productsDayList[$arResult['ID']] todo: получение информации о товаре , добавить таймер -->
          <? if (array_key_exists($arResult['ID'], $productsDayList)): ?>
            <div class="product-stock__timing">
              <div class="product-stock__desc">до конца акции</div>
              <div class="product-stock__time">00:02:23</div>
            </div>
          <? endif; ?>
          <? if ($price['PERCENT']): ?>
            <div class="product-stock__percent">-<?= $price['PERCENT'] ?>%</div>
          <? endif; ?>
        </div>
        <!-- Контроль слайдера -->
        <div class="swiper-controls">
          <div class="swiper-button-prev">
            <svg class="icon icon-left ">
              <use xlink:href="#left"></use>
            </svg>
          </div>
          <div class="swiper-button-next">
            <svg class="icon icon-right ">
              <use xlink:href="#right"></use>
            </svg>
          </div>
        </div>
      </div>
      <!-- Отображение нижних img -->
      <div class="swiper-container gallery-thumbs js-product-thumbs">
        <div class="swiper-wrapper">
          <? if ($arResult['MORE_PHOTO']): ?>
            <? foreach ($arResult['MORE_PHOTO'] as $photoElement): ?>
              <div class="swiper-slide">
                <img src="<?= $photoElement['SRC'] ?>" alt="">
              </div>
            <? endforeach; ?>
          <? endif; ?>
        </div>
      </div>
    </div>

    <!-- Информация о товаре -->
    <div class="product-info">
      <div class="product-info__action">
        <div class="product-action__head">
          <!-- Маркеры рейтинга -->
          <div class="rating-stars">
            <? for ($i = 0; $i < 5; $i++): ?>
              <? if ($i < round($arResult['PROPERTIES']['RATING_REVIEW']['VALUE']) ?: 0): ?>
                <div class="rating-stars__icon rating-stars__icon--marked">
                  <svg class="icon icon-trace ">
                    <use xlink:href="#trace"></use>
                  </svg>
                </div>
              <? else: ?>
                <div class="rating-stars__icon">
                  <svg class="icon icon-trace ">
                    <use xlink:href="#trace"></use>
                  </svg>
                </div>
              <? endif; ?>
            <? endfor; ?>
          </div>
          <!-- Кнопки: -->
          <div class="product-action__links">
            <!-- Сравнение -->
            <?
            $methodCompare = '';
            if (!(array_key_exists($arResult["ID"], $_SESSION['CATALOG_COMPARE_LIST'][$arResult["IBLOCK_ID"]]['ITEMS'])))
              $methodCompare = 'ADD_TO_COMPARE_LIST';
            else
              $methodCompare = 'DELETE_FROM_COMPARE_LIST';
            ?>
            <form action="/api/user/controller-comparison.php" class="js-comparison-form product-links__group-form">
              <input type="hidden" name="action" value="<?= $methodCompare ?>">
              <input type="hidden" name="product_id" value="<?= $arResult['ID'] ?>">
              <button class="product-action__links-item" type="submit">
                <svg class="icon icon-chart ">
                  <use xlink:href="#chart"></use>
                </svg>
              </button>
            </form>
            <!-- Избранное -->
            <form action="/api/user/controller-favorites.php" class="js-favorites-form">
              <input type="hidden" name="product_id" value="<?= $arResult['ID'] ?>">
              <button class="product-action__links-item" type="submit">
                <svg class="icon icon-heart ">
                  <use xlink:href="#heart"></use>
                </svg>
              </button>
            </form>
            <!-- Поделиться -->
            <button class="product-action__links-item js-open-modal" data-modal="#share-modal">
              <svg class="icon icon-share ">
                <use xlink:href="#share"></use>
              </svg>
            </button>
          </div>
        </div>
        <!-- Модальное окно для написания отзыва -->
        <div class="product-action__body">
          <a class="link link--bold js-open-modal" data-modal="#review-modal">
            Поделитесь отзывом
          </a>
        </div>
      </div>

      <!-- Характеристика товара -->
      <? if ($arResult['FIRST_PROPERTY_LIST']): ?>
        <div class="product-characteristic">
          <? $i = 1; ?>
          <? foreach ($arResult['FIRST_PROPERTY_LIST'] as $name => $value):
            if ($i > 6) break;
            if ($name === "Файлы") continue;
            ?>
            <div class="product-characteristic__item">
              <div class="product-characteristic__item-key"><?= $name ?></div>
              <div class="product-characteristic__item-divider"></div>
              <div class="product-characteristic__item-value"><?= $value ?></div>
            </div>
            <?
            $i++;
          endforeach; ?>
          <a href="#product-info" class="product-characteristic__more link js-anchor">Больше информации</a>
        </div>
      <? endif; ?>
      <!-- Модальное окно для уведомления о снижение цены info: Временно скрыто
      <button data-modal="#price-drop-modal" class="product-lowprice js-open-modal">
        <svg class="icon icon-notification ">
          <use xlink:href="#notification"></use>
        </svg>
        Узнать о снижении цены
      </button>
      -->
      <!-- Аналогичные продукты info: Временно скрыто
      <a href="#product-similar" class="product-similar js-anchor">Смотреть аналоги</a>
       -->
    </div>

    <!-- Торговое предложения -->
    <div class="product-suggestions">
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
            'ruble' => [
              'PRINT_DISCOUNT_VALUE' => $arResult['OLD_PRICE'],
              'DISCOUNT_DIFF' => $arResult['PRICES']['Битрикс VetLavka.ru']['DISCOUNT_DIFF'],
              'PRINT_VALUE' => $arResult['ACTUAL_PRICE'],
              'VALUE_VAT' => $arResult['PRICES']['Битрикс VetLavka.ru']['VALUE_VAT'],
              'DISCOUNT_VALUE_VAT' => $arResult['PRICES']['Битрикс VetLavka.ru']['DISCOUNT_VALUE_VAT'],
            ]
          ],
        ];
      }
      ?>

      <? foreach ($arResult['OFFERS'] ? $arResult['OFFERS'] : $productData as $offer): ?>
        <div class="suggestion-cards">
          <!-- Блок покупки товара -->
          <div
            class="suggestion-card <?= $offer["PRICES"]["ruble"]["PRINT_VALUE"] ? 'suggestion-card--stock' : '' ?>">
            <div class="suggestion-card__head">
              <!-- Название товара -->
              <div
                class="suggestion-card__title"><?= $offer['NAME'] . ' ' . $offer["PROPERTIES"]["VOLUME"]["VALUE"] ?></div>
              <!-- Цены -->
              <div class="suggestion-card__price">
                <!-- Цена со скидокой -->
                <? if ($offer["PRICES"]["ruble"]["VALUE_VAT"] == $offer["PRICES"]["ruble"]["DISCOUNT_VALUE_VAT"]): ?>
                  <?= $offer["PRICES"]["ruble"]["PRINT_VALUE"] ?>
                <? else: ?>
                  <?= $offer["PRICES"]["ruble"]["PRINT_VALUE"]; ?>
                  <span class="suggestion-card__price-old">
                    <?= $offer["PRICES"]["ruble"]["PRINT_DISCOUNT_VALUE"]; ?>
                  </span>
                <? endif; ?>
              </div>
              <? if ($offer["PRODUCT"]["AVAILABLE"] == "Y" && $offer["PRICES"]["ruble"]['PRINT_DISCOUNT_VALUE']): ?>
                <!-- Покупка в клик -->
                <a class="suggestion-card__link link js-open-modal" data-modal="#one-click-modal-<?= $offer['ID'] ?>">Купить
                  в 1 клик</a>
              <? endif; ?>
            </div>

            <div class="suggestion-card__body">
              <!-- Кол-во товара доступного -->
              <div class="suggestion-card__status">
                <div class="suggestion-card__status-span">
                  <svg class="icon icon-check ">
                    <use xlink:href="#check"></use>
                  </svg>
                </div>
                <?
                $statusQuantity = null;

                if ($offer["PRICES"]["ruble"]["PRINT_DISCOUNT_VALUE"]) {
                  if ($offer["PRODUCT"]["QUANTITY"] >= 10)
                    $statusQuantity = "Много";

                  if ($offer["PRODUCT"]["QUANTITY"] <= 2)
                    $statusQuantity = "Мало";

                  if ($offer["PRODUCT"]["QUANTITY"] < 10 && $offer["PRODUCT"]["QUANTITY"] > 2)
                    $statusQuantity = "Достаточно";
                } else {
                  $statusQuantity = "Недоступно";
                }
                ?>
                <?= $statusQuantity ?>
              </div>
              <? if ($offer["PRODUCT"]["AVAILABLE"] == "Y" && $offer["PRICES"]["ruble"]['PRINT_DISCOUNT_VALUE']): ?>
                <!-- Выбор кол-во товаров -->
                <div class="suggestion-card__counter">
                  <div class="counter js-counter">
                    <input type="hidden"
                           value="<?= $offer["PRODUCT"]["QUANTITY"]; ?>"
                           class="js-product-quantity-available">
                    <input type="hidden"
                           value="<?= $offer["ID"]; ?>"
                           class="js-product-id">

                    <button type="button" class="counter__button counter__button-minus js-counter-btn"
                            data-btn-type-counter="minus"></button>

                    <div class="counter__label js-count-product">
                      <span class="js-counter-value">1</span>
                    </div>

                    <button type="button" class="counter__button counter__button-plus js-counter-btn"
                            data-btn-type-counter="plus"></button>
                  </div>
                </div>

                <div class="suggestion-card__btn">
                  <form action="/api/catalog/controller-addToCart.php"
                        class="js-add-to-card js-buy-card-<?= $offer['ID'] ?>">
                    <input type="hidden" name="ACTION" value="BUY_PRODUCT">
                    <input type="hidden" name="PRODUCT_ID" value="<?= $offer["ID"] ?>">
                    <input type="hidden" name="QUANTITY" value="1" class="js-product-quantity-input">
                    <input type="hidden" name="PRODUCT_NAME" value="<?= $offer["NAME"] ?>">
                    <input type="hidden" name="PRODUCT_BRAND"
                           value="<?= $arResult['PROPERTIES']['BRAND']['VALUE'] ?>">
                    <input type="hidden" name="PRODUCT_IMG"
                           value="<?= $offer["DETAIL_PICTURE"]["SRC"] ?>">
                    <button class="btn">В корзину</button>
                  </form>
                </div>
              <? else: ?>
                <form action="/api/catalog/controller-arrival.php" class="js-form-send">
                  <?= bitrix_sessid_post() ?>
                  <input type="hidden" name="ACTION" value="CREATE_ARRIVAL_DEFAULT">
                  <input type="hidden"
                         name="PRODUCT_ID"
                         value="<?= $offer['OFFERS'][0]['ID'] ?: $offer['ID'] ?>">
                  <button class="btn btn--outline">Уведомить</button>
                </form>
              <? endif; ?>
            </div>
          </div>
        </div>

        <!--
        Modals windows
        -->
        <div class="modals">

          <div id="share-modal" class="modal modal--one-click animated">
            <button class="modal__close js-close-modal">
              <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
              </svg>
            </button>
            <div class="modal__body">
              <div class="modal__title">Поделиться</div>
              <div class="modal__content form-default">
                <div class="modal__socials">
                  <div class="js-social modal__socials-item" data-share-social="fb">
                    <img src="/img/icons/share-fb.svg" alt="">
                  </div>
                  <div class="js-social modal__socials-item" data-share-social="vk">
                    <img src="/img/icons/share-vk.svg" alt="">
                  </div>
                  <div class="js-social modal__socials-item" data-share-social="od">
                    <img src="/img/icons/share-odn.svg" alt="">
                  </div>
                </div>

                <div class="modal__input">
                  <div class="modal__input-label">Ссылка на товар</div>
                  <div data-input-group="name" class="input-group">
                    <input name="share-link" type="text" placeholder="Ссылка" class="input"/>
                    <div class="input-group__error"></div>
                  </div>
                </div>
                <div class="modal__submit">
                  <div class="btn js-follow-share-link">Перейти</div>
                  <div class="btn js-copy-share-link">Скопировать</div>
                </div>
              </div>
            </div>
          </div>


          <!--
          Кол-во на складах
          -->


          <div id="amount-modal" class="modal modal--one-click animated">
            <button class="modal__close js-close-modal">
              <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
              </svg>
            </button>

            <div class="modal__body">
              <div class="modal__title">Склады</div>
              <div class="modal__content form-default">
                <div class="modal__amount">
                  <? foreach ($arResult['AMOUNT_LIST'] as $amountItem): ?>
                    <div class="amount__item">
                      <div class="amount__name"><?= $amountItem['NAME'] ?></div>
                      <div class="amount_amount"><?= $amountItem['AMOUNT_STATUS'] ?></div>
                    </div>
                  <? endforeach; ?>
                </div>
              </div>
            </div>

            <!-- todo: Оформить стили в sass -->
            <style>
              .amount__item {
                display: flex;
                justify-content: space-between;
                border-bottom: 1px dashed #000000;
                margin: 13px 0;
              }
            </style>
          </div>


          <!--
          Покупка в клик
          -->

          <div id="one-click-modal-<?= $offer['ID'] ?>" class="modal modal--one-click animated">
            <button class="modal__close js-close-modal">
              <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
              </svg>
            </button>
            <div class="modal__body">
              <div class="modal__title">Купить в 1 клик</div>
              <form action="/api/catalog/controller-buyOneKlick.php"
                    class="modal__form form-default  js-form-sender js-buy-card-<?= $offer['ID'] ?>">
                <?= bitrix_sessid_post() ?>
                <input type="hidden"
                       name="ACTION"
                       value="ONE_CLICK_BUY_PRODUCT">
                <input type="hidden"
                       name="PRODUCT_ID"
                       value="<?= $offer['ID'] ?>">
                <input type="hidden" name="QUANTITY" value="1" class="js-product-quantity-input">

                <div class="modal__input">
                  <div data-input-group="name" class="input-group">
                    <input name="NAME"
                           type="text"
                           placeholder="ФИО"
                           class="input"/>
                    <div class="input-group__error"></div>
                  </div>
                </div>
                <div class="modal__input">
                  <div data-input-group="name" class="input-group">
                    <input name="PHONE"
                           type="text"
                           placeholder="* Телефон"
                           class="input"/>
                    <div class="input-group__error"></div>
                  </div>
                </div>
                <div class="modal__input">
                  <div data-input-group="name" class="input-group">
                    <input name="EMAIL"
                           type="text"
                           placeholder="email"
                           class="input"/>
                    <div class="input-group__error"></div>
                  </div>
                </div>
                <div class="modal__checkbox">
                  <label class="checkbox">
                    <input class="js-form-sender-checkbox" name="checkbox" type="checkbox" value="Y" checked/>
                    <span class="checkbox__indicator">
                        <svg class="icon icon-check ">
                          <use xlink:href="#check"></use>
                        </svg>
                    </span>
                    <span class="checkbox__description">Согласен на обработку&#8194;
                      <a href="/politic/" class="link">персональных данных</a>
                    </span>
                  </label>
                </div>
                <div class="modal__submit">
                  <button class="btn" type="submit">Отправить</button>
                </div>
              </form>
            </div>
          </div>

          <!--
          Информирование о снижении цены
          -->

          <div id="price-drop-modal" class="modal modal--price-drop animated">
            <button class="modal__close js-close-modal">
              <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
              </svg>
            </button>
            <div class="modal__body">
              <div class="modal__title">Уведомить о снижении цены</div>
              <div class="modal__description">Оставьте свой email и мы оповестим Вас о снижении цены на данный товар
              </div>
              <form action="/api/catalog/controller-priceDrop.php" class="modal__form form-default js-form-sender">
                <?= bitrix_sessid_post() ?>
                <input type="hidden"
                       name="ACTION"
                       value="CREATE">
                <input type="hidden"
                       name="THEME"
                       value="<?= $offer['NAME'] ?>">
                <input type="hidden"
                       name="BIND_PRODUCT"
                       value="<?= $arResult['ID'] ?>">
                <input type="hidden"
                       name="USER_RESPONSE"
                       value="Вы успешно подписались на уведомление">
                <div class="modal__input">
                  <div data-input-group="name" class="input-group">
                    <input name="EMAIL" type="text" placeholder="email" class="input"/>
                    <div class="input-group__error"></div>
                  </div>
                </div>
                <div class="modal__checkbox">
                  <label class="checkbox">
                    <input name="CHECKBOX_IS_SMS" type="checkbox" value="Y"/>
                    <span class="checkbox__indicator">
                  <svg class="icon icon-check ">
                    <use xlink:href="#check"></use>
                  </svg>
              </span>
                    <span class="checkbox__description">Уведомлять по SMS</span>
                  </label>
                </div>
                <div class="modal__submit">
                  <button class="btn">Отправить</button>
                </div>
              </form>
            </div>
          </div>

          <!--
          Форма отправки отзыва о товаре
          -->

          <div id="review-modal" class="modal modal--review animated">
            <button class="modal__close js-close-modal">
              <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
              </svg>
            </button>
            <div class="modal__body">
              <div class="modal__title">Поделитесь отзывом</div>
              <form action="/api/catalog/controller-review.php" data-reset-form="Y"
                    class="modal__form form-default js-form-sender">
                <?= bitrix_sessid_post() ?>
                <input type="hidden"
                       name="ACTION"
                       value="CREATE">
                <input type="hidden"
                       name="THEME"
                       value="<?= $offer['NAME'] ?>">
                <input type="hidden"
                       name="BIND_PRODUCT"
                       value="<?= $arResult['ID'] ?>">
                <input type="hidden"
                       name="USER_RESPONSE"
                       value="Ваш отзыв будет опубликован после проверки модератором.">

                <div class="modal-product">
                  <div class="modal-product__picture">
                    <div class="modal-product__img">
                      <img src="<?= $offer["DETAIL_PICTURE"]["SRC"] ?>" alt=""/>
                    </div>

                    <div class="modal-product__rating js-product-rating">
                      <input type="hidden" class="js-count-star" name="COUNT_STAR" value="1">
                      <!-- rating-stars__icon--marked -->
                      <div class="rating-stars js-rating-stars">
                        <div class="rating-stars__icon js-input-rating-item" data-star-id="1">
                          <svg class="icon icon-trace ">
                            <use xlink:href="#trace"></use>
                          </svg>
                        </div>
                        <div class="rating-stars__icon js-input-rating-item" data-star-id="2">
                          <svg class="icon icon-trace ">
                            <use xlink:href="#trace"></use>
                          </svg>
                        </div>
                        <div class="rating-stars__icon js-input-rating-item" data-star-id="3">
                          <svg class="icon icon-trace ">
                            <use xlink:href="#trace"></use>
                          </svg>
                        </div>
                        <div class="rating-stars__icon js-input-rating-item" data-star-id="4">
                          <svg class="icon icon-trace ">
                            <use xlink:href="#trace"></use>
                          </svg>
                        </div>
                        <div class="rating-stars__icon js-input-rating-item" data-star-id="5">
                          <svg class="icon icon-trace ">
                            <use xlink:href="#trace"></use>
                          </svg>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal-product__info">
                    <div class="modal-product__info-name ">
                      <?= $offer['NAME'] ?>
                    </div>
                    <a href="/brands"
                       class="modal-product__info-dev link"><?= $arResult["PROPERTIES"]["BRAND"]["VALUE"] ?></a>
                  </div>
                </div>

                <div class="modal__input">
                  <!-- Ввод email -->
                  <div data-input-group="text" class="input-group">
                    <input name="EMAIL" type="text" placeholder="Email" class="input"/>
                    <div class="input-group__error"></div>
                  </div>
                  <!-- Ввод отзыва -->
                  <div data-input-group="textarea" class="input-group">
                    <textarea name="REVIEW" placeholder="Ваш отзыв" class="input textarea"></textarea>
                    <div class="input-group__error"></div>
                  </div>
                </div>

                <!-- Загрузка фото -->
                <label class="modal-upload js-input-files">
                  <input type="file" name="FILES[]" multiple="multiple">
                  <span class="modal-upload__icon">
                    <svg class="icon icon-plus ">
                      <use xlink:href="#plus"></use>
                    </svg>
                  </span>
                  <span class="modal-upload__text js-input-files-count-area">Загрузить фото</span>
                </label>

                <div class="modal__approval">
                  <div class="modal__checkbox">
                    <label class="checkbox">
                      <input class="js-form-sender-checkbox" name="checkbox" type="checkbox" value="Y" checked/>
                      <span class="checkbox__indicator">
                        <svg class="icon icon-check ">
                          <use xlink:href="#check"></use>
                        </svg>
                      </span>
                      <span class="checkbox__description">Согласен на обработку&#8194;
                      <a href="#" class="link">персональных данных</a></span>
                    </label>
                  </div>
                  <div class="modal__submit">
                    <button class="btn" type="submit">Отправить</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <!--
          Форма оставления вопроса
          -->

          <div id="question-modal" class="modal modal--question animated">
            <button class="modal__close js-close-modal">
              <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
              </svg>
            </button>
            <div class="modal__body">
              <div class="modal__title">Задать вопрос</div>
              <form action="/api/catalog/controller-question.php" class="modal__form form-default js-form-sender">
                <?= bitrix_sessid_post() ?>
                <input type="hidden"
                       name="ACTION"
                       value="CREATE">
                <input type="hidden"
                       name="THEME"
                       value="<?= $offer['NAME'] ?>">
                <input type="hidden"
                       name="BIND_PRODUCT"
                       value="<?= $offer['ID'] ?>">
                <input type="hidden"
                       name="USER_RESPONSE"
                       value="Ваш вопрос успешно отправлен.">
                <div class="modal__input">
                  <div data-input-group="text" class="input-group">
                    <input name="EMAIL" type="text" placeholder="Email" class="input"/>
                    <div class="input-group__error"></div>
                  </div>
                  <div data-input-group="textarea" class="input-group">
                    <textarea name="QUESTION" placeholder="Ваш вопрос" class="input textarea"></textarea>
                    <div class="input-group__error"></div>
                  </div>
                </div>

                <label class="modal-upload js-input-files">
                  <input type="file" name="FILES[]" multiple="multiple">
                  <span class="modal-upload__icon">
                    <svg class="icon icon-plus ">
                      <use xlink:href="#plus"></use>
                    </svg>
                  </span>
                  <span class="modal-upload__text js-input-files-count-area">Загрузить фото</span>
                </label>

                <div class="modal__approval">
                  <div class="modal__checkbox">
                    <label class="checkbox">
                      <input class="js-form-sender-checkbox" name="checkbox" type="checkbox" value="Y" checked/>
                      <span class="checkbox__indicator">
                        <svg class="icon icon-check ">
                          <use xlink:href="#check"></use>
                        </svg>
                      </span>
                      <span class="checkbox__description">Согласен на обработку&#8194;
                        <a href="#" class="link">персональных данных</a>
                      </span>
                    </label>
                  </div>
                  <div class="modal__submit">
                    <button class="btn" type="submit">Отправить</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      <? endforeach; ?>

      <div class="suggestion-bullets">

        <!-- info: Временно скрыто
        <div class="suggestion-bullet">
          <div class="suggestion-bullet__icon">
            <svg class="icon icon-sale ">
              <use xlink:href="#sale"></use>
            </svg>
          </div>
          <div class="suggestion-bullet__description">При покупке от 50 шт. - скидка&nbsp;10%</div>
        </div>-->

        <!-- info: Временно скрыто
        <div class="suggestion-bullet">
          <div class="suggestion-bullet__icon suggestion-bullet__icon&#45;&#45;delivery">
            <svg class="icon icon-del ">
              <use xlink:href="#del"></use>
            </svg>
          </div>
          <div class="suggestion-bullet__description">Доставка по Москве, 2-3 дня</div>
        </div>-->

        <div class="suggestion-bullet">
          <div class="suggestion-bullet__icon">
            <svg class="icon icon-paw ">
              <use xlink:href="#paw"></use>
            </svg>
          </div>
          <div class="suggestion-bullet__description">
            В наличии в&nbsp;
            <a class="js-open-modal" data-modal="#amount-modal"><?= $arResult['AMOUNT_COUNT'] ?> магазинах</a>
          </div>
        </div>

        <!-- info: Временно скрыто
        <div class="suggestion-bullet">
          <div class="suggestion-bullet__icon">
            <svg class="icon icon-cart ">
              <use xlink:href="#cart"></use>
            </svg>
          </div>
          <div class="suggestion-bullet__description">Самовывоз, сегодня до 18:00</div>
        </div>-->
      </div>
    </div>
  </div>

  <!-- Табы -->
  <div id="product-info" class="product-tabs">
    <div class="js-tabs">
      <!-- Вкладки -->
      <div class="tabs-wrapper">
        <div class="tabs__action product-tabs__action">
          <? if (trim($arResult['DESCRIPTION']) || $arResult['FIRST_PROPERTY_LIST_BIG'] || $arResult['FIRST_PROPERTY_LIST']): ?>
            <button data-tab="description" class="js-tab-action tab-action tab-action--text active">Описание</button>
          <? endif; ?>
          <? if ($arResult['FIRST_PROPERTY_LIST']): ?>
            <button data-tab="feature" class="js-tab-action tab-action tab-action--text">Характеристики</button>
          <? endif; ?>
          <? if (trim($arResult['STRUCTURE'])): ?>
            <button data-tab="composition" class="js-tab-action tab-action tab-action--text">Состав</button>
          <? endif; ?>
          <? if (trim($arResult['INSTRUCTIONS'] || $arResult['INSTRUCTION_FILE'])): ?>
            <button data-tab="instruction" class="js-tab-action tab-action tab-action--text">Инструкция</button>
          <? endif; ?>
          <button data-tab="reviews" class="js-tab-action tab-action tab-action--text">Отзывы</button>
          <button data-tab="question" class="js-tab-action tab-action tab-action--text">Задать вопрос</button>
        </div>
      </div>

      <? if (trim($arResult['DESCRIPTION']) || $arResult['FIRST_PROPERTY_LIST_BIG'] || $arResult['FIRST_PROPERTY_LIST']): ?>
        <!-- Описание -->
        <div data-tab-content="description" class="tab product-tabs__tab product-tabs__tab_description js-tab">
          <?= $arResult['DESCRIPTION'] ?>

          <? if ($arResult['FIRST_PROPERTY_LIST_BIG']): ?>
            <? foreach ($arResult['FIRST_PROPERTY_LIST_BIG'] as $name => $value): ?>
              <h2><?= $name ?></h2>
              <div style="margin: 31px 0;"><?= $value ?></div>
            <? endforeach; ?>
          <? endif; ?>
        </div>
      <? endif; ?>

      <!-- Характеристики -->
      <? if ($arResult['FIRST_PROPERTY_LIST']): ?>
        <div data-tab-content="feature" class="tab product-tabs__tab product-tabs__tab_composition js-tab">
          <div class="tab-characteristic__elements">
            <? foreach ($arResult['FIRST_PROPERTY_LIST'] as $name => $value): ?>
              <div class="tab-characteristic__element">
                <div class="product-characteristic__item">
                  <div class="product-characteristic__item-key"><?= $name ?></div>
                  <div class="product-characteristic__item-divider"></div>
                  <div class="product-characteristic__item-value"><?= $value ?></div>
                </div>
              </div>
            <? endforeach; ?>
          </div>
        </div>
      <? endif; ?>

      <!-- Состав -->
      <? if (trim($arResult['STRUCTURE'])): ?>
        <div data-tab-content="composition" class="tab product-tabs__tab product-tabs__tab_composition js-tab">
          <?= $arResult['STRUCTURE'] ?>
        </div>
      <? endif; ?>

      <!-- Инструкция -->
      <? if (trim($arResult['INSTRUCTIONS'] || $arResult['INSTRUCTION_FILE'])): ?>
        <div data-tab-content="instruction" class="tab product-tabs__tab product-tabs__tab_instruction js-tab">
          <div class="product-sides">
            <!-- Текст -->
            <div class="product-sides__left">
              <?= $arResult['INSTRUCTIONS'] ?>
            </div>
            <!-- Файл -->
            <div class="product-sides__right">
              <div class="tab-aside">
                <div class="tab-aside__head">
                  <svg class="icon icon-doc ">
                    <use xlink:href="#doc"></use>
                  </svg>
                  <div class="tab-aside__head_span">Оригинальная инструкция</div>
                </div>
                <div class="tab-aside__body">
                  <a class="btn" href="<?= $arResult['INSTRUCTION_FILE'] ?>" target="_blank">Скачать (pdf)</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <? endif; ?>

      <!-- Отзывы -->
      <div data-tab-content="reviews" class="tab product-tabs__tab js-tab">
        <div class="product-sides">
          <div class="product-sides__left">
            <div class="reviews-items">
              <? if ($arResult['REVIEWS']): ?>
                <? foreach ($arResult['REVIEWS'] as $reviewElement): ?>
                  <div class="review-item">
                    <div class="review__avatar">
                      <img src="<?= $reviewElement['USER_IMG'] ?>" alt="">
                    </div>
                    <div class="review__content">
                      <div class="review-head">
                        <div class="review-head__name"><?= $reviewElement['USER'] ?></div>
                        <div class="review-head__date"><?= $reviewElement['DATE'] ?></div>
                        <div class="rating-stars">
                          <? for ($i = 0; $i < 5; $i++): ?>
                            <? if ($i < round($reviewElement['COUNT_STAR']) ?: 0): ?>
                              <div class="rating-stars__icon rating-stars__icon--marked">
                                <svg class="icon icon-trace ">
                                  <use xlink:href="#trace"></use>
                                </svg>
                              </div>
                            <? else: ?>
                              <div class="rating-stars__icon">
                                <svg class="icon icon-trace ">
                                  <use xlink:href="#trace"></use>
                                </svg>
                              </div>
                            <? endif; ?>
                          <? endfor; ?>
                        </div>
                      </div>
                      <div class="review-body">
                        <div class="review-body__text">
                          <?= $reviewElement['TEXT'] ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <? endforeach; ?>
              <? endif; ?>
            </div>
          </div>
          <div class="product-sides__right">
            <div class="tab-aside tab-aside--reviews">
              <div class="tab-aside__head">
                <svg class="icon icon-comments ">
                  <use xlink:href="#comments"></use>
                </svg>
                <div class="tab-aside__head_span">Оцените данный товар</div>
              </div>
              <div class="tab-aside__rating">
                <div class="rating-stars">
                  <div class="rating-stars__icon">
                    <svg class="icon icon-trace ">
                      <use xlink:href="#trace"></use>
                    </svg>
                  </div>
                  <div class="rating-stars__icon">
                    <svg class="icon icon-trace ">
                      <use xlink:href="#trace"></use>
                    </svg>
                  </div>
                  <div class="rating-stars__icon">
                    <svg class="icon icon-trace ">
                      <use xlink:href="#trace"></use>
                    </svg>
                  </div>
                  <div class="rating-stars__icon">
                    <svg class="icon icon-trace ">
                      <use xlink:href="#trace"></use>
                    </svg>
                  </div>
                  <div class="rating-stars__icon">
                    <svg class="icon icon-trace ">
                      <use xlink:href="#trace"></use>
                    </svg>
                  </div>
                </div>
              </div>
              <div class="tab-aside__body">
                <button data-modal="#review-modal" class="btn js-open-modal">Поделиться отзывом</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Задать вопрос -->
      <div data-tab-content="question" class="tab product-tabs__tab js-tab">
        <div class="product-sides">
          <!-- Перечень вопросов -->
          <div class="product-sides__left">
            <? if ($arResult['QUESTIONS']): ?>
              <div class="product-faqs">
                <!-- Элемент -->
                <? foreach ($arResult['QUESTIONS'] as $questionId => $questionElement): ?>
                  <div class="collapse js-toggle-element <?= $questionId == 0 ? 'toggle-element--open' : '' ?>">
                    <button class="collapse-header js-toggle-element-action">
                      <div class="collapse-header__title"><?= $questionElement['NAME'] ?></div>
                      <div class="collapse-header__icon"></div>
                    </button>
                    <div class="collapse-body js-toggle-element-body">
                      <div class="collapse-body__text"><?= $questionElement['TEXT'] ?></div>
                    </div>
                  </div>
                <? endforeach; ?>
              </div>
            <? endif; ?>
          </div>

          <div class="product-sides__right">
            <div class="tab-aside tab-aside--reviews">
              <div class="tab-aside__head">
                <div class="tab-aside__head_span">Остались вопросы?</div>
              </div>
              <div class="tab-aside__rating">
                <div class="tab-aside__rating_span">Мы вам поможем</div>
              </div>
              <div class="tab-aside__body">
                <button data-modal="#question-modal" class="btn js-open-modal">Задать вопрос</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    window.__RATING_REVIEW__ = <?= $arResult['PROPERTIES']['RATING_REVIEW']['VALUE'] ?: 0?>
  </script>

  <script>
    window.__CURRENT_PAGE_URL__ = '<?= (CMain::IsHTTPS())
      ? "https://" . $_SERVER["HTTP_HOST"] . $APPLICATION->GetCurUri()
      : "http://" . $_SERVER["HTTP_HOST"] . $APPLICATION->GetCurUri() ?>'
  </script>
  <div id="product-similar"></div>
<?
unset($actualItem, $itemIds);
