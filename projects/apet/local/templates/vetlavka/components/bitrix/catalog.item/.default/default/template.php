<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */
?>

<div class="product-card product-card--stock  js-product-card">
  <div class="product-header">
    <!-- Скидка на товар -->
    <? if ($price['PERCENT']): ?>
      <div class="product-header__stock">
        -<?= $price['PERCENT'] ?>%
      </div>
    <? endif; ?>
    <!-- Картинка товара -->
    <? if ($item['PREVIEW_PICTURE']['SRC']): ?>
      <a href="<?= $item['DETAIL_PAGE_URL'] ?>"
         class="product-header__img"
         title="<?= $productTitle ?>">
        <img loading="lazy"
             class="product-big__image lazyload"
             src="<?= $item['PREVIEW_PICTURE']['SRC'] ? $item['PREVIEW_PICTURE']['SRC'] : NO_IMAGE_SRC_VETLAVKA ?>"
             alt="<?= $productTitle ?>"/>
      </a>
    <? endif; ?>
  </div>

  <div class="product-body">
    <!-- Тег товара -->
    <? if ($arResult['ITEM']['PROPERTIES']['TEG']): ?>
      <div class="product-body__tag">
        <?= $arResult['ITEM']['PROPERTIES']['TEG']['VALUE']; ?>
      </div>
    <? endif; ?>
    <!-- Титульный текст товара -->
    <? if ($productTitle): ?>
      <a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="product-body__title"
         title="<?= $productTitle ?>">
        <?= $productTitle ?>
      </a>
    <? endif; ?>
  </div>

  <div class="product-footer">
    <div class="product-links">
      <!-- Бренд товара -->
      <? if ($item['PROPERTIES']['BRAND']['VALUE']): ?>
        <a href="<?= getLinkElementById($item['PROPERTIES']['BRAND']['VALUE']) ?>" class="product-links__manufacturer">
          <?= getNameElementById($item['PROPERTIES']['BRAND']['VALUE']) ?>
        </a>
      <? endif; ?>
      <div class="product-links__group">
        <!-- Кнопка добавление в сравнение -->
        <?
        $methodCompare = null;
        $isActiveProduct = null;
        if (array_key_exists($item["ID"], $_SESSION['CATALOG_COMPARE_LIST'][$item["IBLOCK_ID"]]['ITEMS'])) {
          $methodCompare = 'DELETE_FROM_COMPARE_LIST';
          $isActiveProduct = 'active';
        } else {
          $methodCompare = 'ADD_TO_COMPARE_LIST';
        }
        ?>
        <form action="/api/user/controller-comparison.php" class="js-comparison-form product-links__group-form">
          <input type="hidden" name="action" value="<?= $methodCompare ?>">
          <input type="hidden" name="product_id" value="<?= $item['ID'] ?>">
          <button class="product-links__group-icon <?= $isActiveProduct ?>" type="submit">
            <svg class="icon icon-chart ">
              <use xlink:href="#chart"></use>
            </svg>
            <img src="/img/icons/chart-color.svg" class="product-links__icon"/>
          </button>
        </form>
        <!-- Кнопка добавление в избранное -->
        <?
        /* info: Определение статуса товара */
        global $USER;
        $productFavoriteStatus = null;

        if ($USER->IsAuthorized())
          $favorites = (new UserFavoriteProducts())->getFavorites();
        else
          $favorites = (new CookieFieldHandler('favorite_no_auth'))->getElements();

        if (in_array($item['ID'], $favorites))
          $productFavoriteStatus = "product-links__group-icon--active";
        ?>
        <form action="/api/user/controller-favorites.php" class="js-favorites-form product-links__group-form">
          <input type="hidden" name="product_id" value="<?= $item['ID'] ?>">
          <button class="product-links__group-icon <?= $productFavoriteStatus ?>" type="submit">
            <svg class="icon icon-heart ">
              <use xlink:href="#heart"></use>
            </svg>
            <svg class="icon icon-heart-color ">
              <use xlink:href="#heart-color"></use>
            </svg>
          </button>
        </form>
      </div>
    </div>

    <div class="product-action">
      <? if ($item['OFFERS'] || $item["CAN_BUY"] && $item['PRODUCT']['QUANTITY'] > 0): ?>
        <!-- Окончательная цена товара -->
        <? if ($item['OFFERS'][0]["PRICES"]["ruble"]["PRINT_DISCOUNT_VALUE"] || $arResult['ACTUAL_PRICE']): ?>
          <div class="product-action__price">
            <div class="product-big__price">
              <?=
              $item['OFFERS'][0]["PRICES"]["ruble"]["PRINT_DISCOUNT_VALUE"]
                ? $item['OFFERS'][0]["PRICES"]["ruble"]["PRINT_DISCOUNT_VALUE"]
                : $arResult['ACTUAL_PRICE']
              ?>
            </div>
          </div>
        <? endif; ?>
        <!-- Цена до скидки -->
        <? if ($item['OFFERS'][0]["PRICES"]["ruble"]["DISCOUNT_DIFF"] || $item['PRICES']['ruble']['DISCOUNT_DIFF']): ?>
          <div class="product-action__oldprice">
            <?=
            $item['OFFERS'][0]["PRICES"]["ruble"]["PRINT_VALUE"]
              ? $item['OFFERS'][0]["PRICES"]["ruble"]["PRINT_VALUE"]
              : $arResult['OLD_PRICE'];
            ?>
          </div>
        <? endif; ?>
      <? endif; ?>
      <!-- Кнопка добавления товара в корзину -->
      <? if ($item['OFFERS'] || $item["CAN_BUY"] && $item['PRODUCT']['QUANTITY'] > 0): ?>
        <form action="/api/catalog/controller-addToCart.php" class="js-add-to-card product-action__form">
          <input type="hidden" name="ACTION" value="BUY_PRODUCT">
          <input type="hidden"
                 name="PRODUCT_ID"
                 value="<?= $item['OFFERS'][0]['ID'] ? $item['OFFERS'][0]['ID'] : $item['ID'] ?>">
          <input type="hidden" name="QUANTITY" value="1">
          <input type="hidden"
                 name="PRODUCT_NAME"
                 value="<?= $item['OFFERS'][0]['NAME'] ? $item['OFFERS'][0]['NAME'] : $item['NAME'] ?>">
          <input type="hidden"
                 name="PRODUCT_BRAND"
                 value="<?= getNameElementById($item['PROPERTIES']['BRAND']['VALUE']) ?>">
          <input type="hidden" name="PRODUCT_IMG" value="<?= $item['PREVIEW_PICTURE']['SRC'] ?>">
          <div class="product-action__button">
            <button class="btn">В корзину</button>
          </div>
        </form>
      <? else: ?>
        <form action="/api/catalog/controller-arrival.php" class="js-form-sender">
          <?= bitrix_sessid_post() ?>
          <input type="hidden" name="ACTION" value="CREATE_ARRIVAL_DEFAULT">
          <input type="hidden"
                 name="PRODUCT_ID"
                 value="<?= $item['OFFERS'][0]['ID'] ?: $item['ID'] ?>">
          <button class="btn btn--outline">Уведомить</button>
        </form>

        <? /* info: переделано на стандартных компонент
          <div class="modals">
          <div id="arrival-modal-<?= $arResult['ITEM']['ID'] ?>" class="modal modal--arrival animated">
            <button class="modal__close js-close-modal">
              <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
              </svg>
            </button>
            <div class="modal__body">
              <div class="modal__title">Уведомить о поступлении товара</div>
              <div class="modal__description">Оставьте свой email и мы оповестим Вас об поступлении данного товара</div>
              <div class="modal-product">
                <div class="modal-product__img">
                  <img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $item['NAME'] ?>"/>
                </div>
                <div class="modal-product__info">
                  <div class="modal-product__info-name">
                    <?= $item['NAME'] ?>
                  </div>
                  <a href="/brands/"
                     class="modal-product__info-dev link">
                    <?= getNameElementById($item['PROPERTIES']['BRAND']['VALUE']) ?>
                  </a>
                </div>
              </div>
              <form action="/api/catalog/controller-arrival.php" class="modal__form form-default js-form-send">
                <?= bitrix_sessid_post() ?>
                <input type="hidden" name="ACTION" value="CREATE_ARRIVAL">
                <input type="hidden"
                       name="BIND_PRODUCT"
                       value="<?= $item['OFFERS'][0]['ID'] ? $item['OFFERS'][0]['ID'] : $item['ID'] ?>">

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
                    <input class="" name="IS_SEND_SMS" type="checkbox" value="Y" checked/>
                    <span class="checkbox__indicator">
                      <svg class="icon icon-check ">
                        <use xlink:href="#check"></use>
                      </svg>
                    </span>
                    <span class="checkbox__description">Уведомлять по SMS</span>
                  </label>
                </div>
                <div class="modal__submit">
                  <button class="btn" type="submit">Отправить</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      */ ?>

      <? endif; ?>
    </div>
  </div>
</div>
