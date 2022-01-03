<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

/**
 * Подготовка информации для вывода в списке заказов
 */
foreach ($arResult['ORDERS'] as $key => $order) {
  $status_id = $order['ORDER']['STATUS_ID'];
  $countBasketItems = count($order['BASKET_ITEMS']);
  $arResult['ORDERS'][$key]['COUNT_BASKET_ITEMS'] = $countBasketItems . ' товар' . getEncoding($countBasketItems);

  $arResult['ORDERS'][$key]['COST'] = ItemsBitrixCart::getFormattedPrice($order['ORDER']['PRICE'] - $order['ORDER']['SUM_PAID']);
  $arResult['ORDERS'][$key]['STATUS_NAME'] = $arResult['INFO']['STATUS'][$status_id]['NAME'];
  $arResult['ORDERS'][$key]['DELIVERY_NAME'] = end($order['SHIPMENT'])['DELIVERY_NAME'];
  $arResult['ORDERS'][$key]['PAYMENT_NAME'] = end($order['PAYMENT'])['PAY_SYSTEM_NAME'];
  $arResult['ORDERS'][$key]['COUNT_BASKET_ITEMS'] = $countBasketItems . ' товар' . getEncoding($countBasketItems);
}
