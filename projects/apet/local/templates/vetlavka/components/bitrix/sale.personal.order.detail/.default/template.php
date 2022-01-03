<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>


<div class="lk-order lk-order--info">
  <div class="lk-order__head">
    <div class="lk-order__arrow">
      <a href="/personal/" class="lk-arrow">
        <svg class="icon icon-left ">
          <use xlink:href="#left"></use>
        </svg>
      </a>
    </div>
    <div class="lk-content__title">
      Заказ № <?= $arResult["ACCOUNT_NUMBER"] ?>
      от <?= $arResult["DATE_INSERT"]->format('d.m.Y') ?>
    </div>
  </div>

  <div class="lk-order__body">
    <div class="lk-order__row">
      <table class="lk-order__table">
        <tr>
          <td class="lk-order__cell lk-order__cell--key">Статус заказа</td>
          <td class="lk-order__cell lk-order__cell--value"><?= $arResult["STATUS"]["NAME"] ?></td>
        </tr>
      </table>
      <a href="<?= htmlspecialcharsbx($arResult["URL_TO_CANCEL"]) ?>"
         class="lk-order__link lk-order__link--grey link link--bold">Отменить
      </a>
    </div>

    <div class="lk-order__row">
      <div class="lk-content__title lk-content__title--body">Информция о покупателе</div>
      <table class="lk-order__table">
        <tr>
          <td class="lk-order__cell lk-order__cell--key">ФИО</td>
          <td class="lk-order__cell lk-order__cell--value"><?= $arResult["ORDER_PROPS"]["FIO"]["VALUE"] ?></td>
        </tr>
        <tr>
          <td class="lk-order__cell lk-order__cell--key">email:</td>
          <td class="lk-order__cell lk-order__cell--value"><?= $arResult["ORDER_PROPS"]["EMAIL"]["VALUE"] ?></td>
        </tr>
        <tr>
          <td class="lk-order__cell lk-order__cell--key">Телефон</td>
          <td class="lk-order__cell lk-order__cell--value"><?= $arResult["ORDER_PROPS"]["PHONE"]["VALUE"] ?></td>
        </tr>
        <tr>
          <td class="lk-order__cell lk-order__cell--key">Адрес</td>
          <td class="lk-order__cell lk-order__cell--value"><?= $arResult["ORDER_PROPS"]["ADDRESS"]["VALUE"] ?></td>
        </tr>
      </table>
    </div>

    <div class="lk-order__row">
      <div class="lk-content__title lk-content__title--body">Информция о доставке</div>
      <table class="lk-order__table">
        <tr>
          <td class="lk-order__cell lk-order__cell--key">Доставка</td>
          <td class="lk-order__cell lk-order__cell--value"><?= $arResult["DELIVERY"]["NAME"] ?></td>
        </tr>
        <? if ($arResult['RENDER_PROPS']['ADDRESS']): ?>
          <tr>
            <td class="lk-order__cell lk-order__cell--key">Адрес доставки</td>
            <td class="lk-order__cell lk-order__cell--value"><?= $arResult['RENDER_PROPS']['ADDRESS']['VALUE'] ?></td>
          </tr>
        <? endif; ?>
      </table>
      <a href="#" class="lk-order__link link link--bold">Показать на карте</a>
    </div>

    <div class="lk-order__row">
      <div class="lk-content__title lk-content__title--body">Информация об оплате</div>
      <table class="lk-order__table">
        <? foreach ($arResult['PAYMENT'] as $payment): ?>
          <tr>
            <td class="lk-order__cell lk-order__cell--key">Сумма к оплате</td>
            <td
              class="lk-order__cell lk-order__cell--value"><?= ItemsBitrixCart::getFormattedPrice($payment['SUM']) ?>
            </td>
          </tr>

          <tr>
            <td class="lk-order__cell lk-order__cell--key">Статус оплаты</td>
            <td class="lk-order__cell lk-order__cell--value">
              <?= $payment['PAID'] == 'Y' ? 'оплачено' : 'не оплачено' ?>
            <td>
          </tr>

          <tr>
            <td class="lk-order__cell lk-order__cell--key">Способ оплаты</td>
            <td class="lk-order__cell lk-order__cell--value"><?= $payment['PAY_SYSTEM_NAME'] ?></td>
          </tr>

          <?= $payment["BUFFERED_OUTPUT"]; ?>
        <? endforeach; ?>
      </table>
      <a href="#" class="lk-order__link"></a>
    </div>
  </div>
</div>

<div class="lk-order lk-order--items">
  <? foreach ($arResult['BASKET'] as $basketItem): ?>
    <div class="lk-order__item">
      <div class="order-card">
        <div class="order-card__pic">
          <a href="<?= $basketItem['DETAIL_PAGE_URL'] ?>">
            <img src="<?= $basketItem['PICTURE']['SRC'] ?>" alt="<?= $basketItem['NAME'] ?>"/>
          </a>
        </div>
        <div class="order-card__content">
          <div class="order-card__title">
            <?= $basketItem['NAME'] ?>
          </div>
          <? /* Получение название товарного бренда */
          $brandName = null;
          $qrStores = CIBlockElement::GetList(
            ['SORT' => 'ASC'],
            ['IBLOCK_ID' => CATALOG_ID, 'ID' => $basketItem["PRODUCT_ID"], 'ACTIVE' => 'Y'],
            false, false,
            ['ID', 'PROPERTY_BRAND']
          );
          while ($element = $qrStores->GetNext())
            $brandName = getNameElementById($element["PROPERTY_BRAND_VALUE"]);
          ?>
          <div class="order-card__manufacturer"><?= $brandName ?></div>
          <div class="order-card__row">
            <div class="order-card__price"><?= $basketItem['PRICE'] ?></div>
            <? if ($basketItem['DISCOUNT_PRICE']): ?>
              <div class="order-card__old-price"><?= $basketItem['BASE_PRICE'] ?></div>
            <? endif; ?>
          </div>
        </div>
        <button class="order-card__delete">
          <svg class="icon icon-close ">
            <use xlink:href="#close"></use>
          </svg>
        </button>
      </div>
    </div>
  <? endforeach; ?>
</div>

