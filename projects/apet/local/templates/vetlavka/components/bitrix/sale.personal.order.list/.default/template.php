<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main,
  Bitrix\Main\Localization\Loc,
  Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);
?>

<? if (!empty($arResult['ORDERS'])): ?>
  <table class="lk-content__table">
    <tr>
      <th>Номер заказа</th>
      <th>Товаров в заказе</th>
      <th>Сумма</th>
      <th>Оплата и доставка</th>
      <th>Статус заказа</th>
      <th></th>
    </tr>
    <? foreach ($arResult['ORDERS'] as $order):
      $status_id = $order['ORDER']['STATUS_ID'];
      $orderUrl = htmlspecialcharsbx($order['ORDER']["URL_TO_DETAIL"]);
      ?>
      <tr>
        <!-- Order number and date -->
        <td>
          <a href="<?= $orderUrl ?>" class="lk-content__link">
            № <?= $order['ORDER']['ID'] ?>
            <br>
            от <?= $order['ORDER']['DATE_INSERT']->format($arParams['ACTIVE_DATE_FORMAT']) ?>
          </a>
        </td>
        <!-- Count elements in basket -->
        <td>
          <a href="<?= $orderUrl ?>" class="lk-content__link"><?= $order['COUNT_BASKET_ITEMS'] ?></a>
        </td>
        <!-- Basket price -->
        <td>
          <a href="<?= $orderUrl ?>" class="lk-content__link"><?= $order['COST'] ?></a>
        </td>
        <!-- Method payment and delivery -->
        <td>
          <a href="<?= $orderUrl ?>" class="lk-content__link">
            Оплата: <?= $order['PAYMENT_NAME'] ?>
            <br>
            Доставка: <?= $order['DELIVERY_NAME'] ?>
          </a>
        </td>
        <!-- Status order -->
        <td>
          <a href="<?= $orderUrl ?>" class="lk-content__link"><?= $order['STATUS_NAME'] ?></a>
        </td>
        <!-- Button element url -->
        <td>
          <a href="<?= $orderUrl ?>" class="lk-content__link">
            <div class="lk-arrow">
              <svg class="icon icon-right ">
                <use xlink:href="#right"></use>
              </svg>
            </div>
          </a>
        </td>
      </tr>
    <? endforeach; ?>
  </table>
<? else: ?>
  <table class="lk-content__table">
    <tr>
      <td>Вы еще ничего не купили в нашем магазине</td>
    </tr>
  </table>
<? endif; ?>
