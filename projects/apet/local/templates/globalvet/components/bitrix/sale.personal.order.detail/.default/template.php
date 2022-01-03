<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<div class="order__main">
  <div class="order-detail order-detail--lk">
    <a href="/personal/" class="lk-back">
      <span class="lk-back__icon">
        <svg class="icon icon-prev ">
          <use xlink:href="#prev"></use>
        </svg>
      </span>
      <span class="lk-back__text">Вернуться к заказу</span>
    </a>
    <div class="order-detail__header">
      <div class="title title--small order-detail__title">
        Заказ № <?= $arResult["ACCOUNT_NUMBER"] ?>
        от <?= $arResult["DATE_INSERT"]->format('d.m.Y') ?>
      </div>
    </div>
    <div class="order-detail__info">
      <div class="order-detail__info-title">Статус заказа:</div>
      <div class="order-detail__info-status">
        <div class="order-detail__status">
          <div style="color: #445" class="order-detail__status-color"></div>
          <div class="order-detail__status-text"><?= $arResult["STATUS"]["NAME"] ?></div>
        </div>
        <a href="<?= htmlspecialcharsbx($arResult["URL_TO_CANCEL"]) ?>" class="btn btn--ice order-detail__info-cancel">
          Отменить заказ</a>
      </div>
    </div>
    <div class="order-detail__info">
      <div class="order-detail__info-title">Информация о покупателе</div>
      <div class="order-detail__info-text">ФИО: <?= $arResult["ORDER_PROPS"]["FIO"]["VALUE"] ?></div>
      <div class="order-detail__info-text">Email: <?= $arResult["ORDER_PROPS"]["EMAIL"]["VALUE"] ?></div>
      <div class="order-detail__info-text">Телефон: <?= $arResult["ORDER_PROPS"]["PHONE"]["VALUE"] ?></div>
      <div class="order-detail__info-text">Адрес доставки: <?= $arResult["ORDER_PROPS"]["ADDRESS"]["VALUE"] ?></div>
    </div>
    <div class="order-detail__info">
      <div class="order-detail__info-title">Информация о доставке</div>
      <div class="order-detail__info-text">Доставка: <?= $arResult["DELIVERY"]["NAME"] ?></div>
    </div>
    <? foreach ($arResult['PAYMENT'] as $payment): ?>
      <div class="order-detail__info">
        <div class="order-detail__info-title">Информация об оплате</div>
        <div class="order-detail__info-text">Сумма к
          оплате: <?= ItemsBitrixCart::getFormattedPrice($payment['SUM']) ?></div>
        <div class="order-detail__info-text">Статус
          оплаты: <?= $payment['PAID'] == 'Y' ? 'оплачено' : 'не оплачено' ?></div>
        <div class="order-detail__info-text">Способ оплаты: <?= $payment['PAY_SYSTEM_NAME'] ?></div>
      </div>
    <? endforeach; ?>
    <div class="order-detail__footer">
      <a href="/" class="order-detail__action order-detail__action--doc">
        <img src="/img/icons/pdf.svg" alt="Счет на оплату (pdf)">
        <span>Счет на оплату (pdf)</span>
      </a>
      <a href="/" class="order-detail__action order-detail__action--doc">
        <img src="/img/icons/doc.svg" alt="Накладные (pdf)">
        <span>Накладные (pdf)</span>
      </a>
    </div>
  </div>
</div>
<div class="order__sidebar">
  <div class="order__sidebar-products">
    <? foreach ($arResult['BASKET'] as $basketItem): ?>
      <div class="product-order">
        <a href="<?= $basketItem['DETAIL_PAGE_URL'] ?>" class="product-order__preview">
          <img src="<?= $basketItem['PICTURE']['SRC'] ?>" alt="<?= $basketItem['NAME'] ?>">
        </a>
        <div class="product-order__content">
          <a href="<?= $basketItem['DETAIL_PAGE_URL'] ?>" class="product-order__name">
            <?= $basketItem['NAME'] ?>
          </a>
          <? /* Получение название товарного бренда */
          $brandName = null;
          $obBrands = CIBlockElement::GetList(
            ['SORT' => 'ASC'],
            ['IBLOCK_ID' => CATALOG_ID, 'ID' => $basketItem["PRODUCT_ID"], 'ACTIVE' => 'Y'],
            false, false,
            ['ID', 'PROPERTY_BRAND']
          );
          while ($brand = $obBrands->GetNext())
            $brandName = getNameElementById($brand["PROPERTY_BRAND_VALUE"]);
          ?>
          <a href="/brands" class="product-order__brand"><?= $brandName ?></a>
          <div class="product-order__footer">
            <div class="product-order__prices">
              <div class="price"><?= $basketItem['PRICE_FORMATED'] ?></div>
              <? if ($basketItem['DISCOUNT_PRICE']): ?>
                <div class="price-old"><?= $basketItem['BASE_PRICE_FORMATED'] ?></div>
              <? endif; ?>
            </div>
            <div class="product-amount">
              <button type="button" class="product-amount__btn">
                <svg class="icon icon-minus ">
                  <use xlink:href="#minus"></use>
                </svg>
              </button>
              <input type="text" value="<?= $basketItem['QUANTITY'] ?>" class="product-amount__input">
              <button type="button" class="product-amount__btn">
                <svg class="icon icon-plus ">
                  <use xlink:href="#plus"></use>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    <? endforeach; ?>
  </div>
</div>











