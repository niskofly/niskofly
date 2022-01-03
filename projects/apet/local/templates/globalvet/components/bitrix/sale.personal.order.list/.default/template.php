<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main,
  Bitrix\Main\Localization\Loc,
  Bitrix\Main\Page\Asset;

Loc::loadMessages(__FILE__);
?>

<table class="lk-orders__table">
  <thead>
  <th>Номер заказа</th>
  <th>Товаров в заказе</th>
  <th>Сумма</th>
  <th>Оплата и доставка</th>
  <th>Статус заказа</th>
  <th></th>
  </thead>

  <? if (!empty($arResult['ORDERS'])): ?>
    <tbody>
    <? foreach ($arResult['ORDERS'] as $order):
      $status_id = $order['ORDER']['STATUS_ID'];
      $orderUrl = htmlspecialcharsbx($order['ORDER']["URL_TO_DETAIL"]);
      ?>
      <tr onclick="location.href='/'">
        <td>
          <p>№ <?= $order['ORDER']['ID'] ?></p>
          <p>от <?= $order['ORDER']['DATE_INSERT']->format($arParams['ACTIVE_DATE_FORMAT']) ?></p>
        </td>
        <td><a href="<?= $orderUrl ?>"><?= $order['COUNT_BASKET_ITEMS'] ?></a></td>
        <td><a href="<?= $orderUrl ?>"><?= $order['COST'] ?></a></td>
        <td>
          <p>Оплата: <?= $order['PAYMENT_NAME'] ?></p>
          <p>Доставка: <?= $order['DELIVERY_NAME'] ?></p>
        </td>
        <td><?= $order['STATUS_NAME'] ?></td>
        <td>
          <a href="<?= $orderUrl ?>" class="lk-orders__table-btn">
              <svg class="icon icon-next ">
                <use xlink:href="#next"></use>
              </svg>
          </a>
        </td>
      </tr>
    <? endforeach; ?>
    </tbody>
  <? else: ?>
    <tbody>
    <tr>
      <td>Вы еще ничего не купили в нашем магазине</td>
    </tr>
    </tbody>
  <? endif; ?>
</table>
