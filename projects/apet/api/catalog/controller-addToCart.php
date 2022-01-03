<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$response = [
  'error' => true,
  'message' => 'Некорректный запрос'
];

if (!empty($_POST)) {
  switch ($_POST['ACTION']) {
    case "GET_COUNT":
      $cntBasketItems = ItemsBitrixCart::getCountBasketItems();
      $response = [
        'count' => $cntBasketItems,
        'error' => false,
      ];
      break;

    case 'BUY_PRODUCT':
      if (!$_POST['PRODUCT_ID'])
        break;

      $settings = [
        'product_id' => $_POST['PRODUCT_ID'],
        'quantity' => $_POST['QUANTITY']
      ];

      $countBasketItems = ItemsBitrixCart::handlerBuy($settings);
      $response = [
        'error' => false,
        'message' => "Товар добавлен в корзину",
        'countBasketItems' => $countBasketItems,
        'eCommerceData' => ItemsBitrixCart::getECommerceData($settings),
        'product' => [
          'name' => $_POST['PRODUCT_NAME'],
          'brand' => $_POST['PRODUCT_BRAND'],
          'img' => $_POST['PRODUCT_IMG'],
        ]
      ];
      break;

    case 'UPDATE_BASKET_ITEM':
      if (!$_POST['BASKET_ITEM_ID'])
        break;

      $countBasketItems = ItemsBitrixCart::updateBasketItem($_POST['BASKET_ITEM_ID'], $_POST['QUANTITY']);
      $response = [
        'error' => false,
        'message' => $countBasketItems,
      ];
      break;

    case 'REMOVE_BASKET_ITEM':
      if (!$_POST['BASKET_ITEM_ID'])
        break;

      $countBasketItems = ItemsBitrixCart::removeBasketItem($_POST['BASKET_ITEM_ID']);
      $response = [
        'error' => false,
        'message' => $countBasketItems,
      ];
      break;
  }
  die(json_encode($response));
}
