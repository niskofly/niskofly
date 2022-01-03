<?
define("NO_AGENT_CHECK", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$response = [
    'error' => true,
    'message' => 'Некорректный запрос'
];

$action = $_POST['ACTION'] ?: $_GET['ACTION'];

switch ($action) {
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
            'eCommerceProduct' => ItemsBitrixCart::getECommerceData($settings),
            'product' => [
                'countBasketItems' => $countBasketItems,
                'name' => $_POST['PRODUCT_NAME'],
                'id' => $_POST['PRODUCT_ID'],
                'isFavorite' => UserFavoriteProducts::checkInFavorite($_POST['PRODUCT_ID']),
                'image' => $_POST['PRODUCT_IMAGE'],
                'price' => $_POST['PRODUCT_PRICE'],
                'quantity' => $_POST['QUANTITY'],
                'basketPrice' => ItemsBitrixCart::getBasketPrice()
            ]
        ];
        break;

    case 'REMOVE_BASKET_ITEM':
        if (!$_POST['BASKET_ITEM_ID'])
            break;

        $countBasketItems = ItemsBitrixCart::removeBasketItem($_POST['BASKET_ITEM_ID']);
        $response = [
            'error' => false,
            'countBasketItems' => $countBasketItems
        ];

        break;

    case 'UPDATE_BASKET_ITEM':
        if (!$_POST['BASKET_ITEM_ID'])
            break;

        $countBasketItems = ItemsBitrixCart::updateBasketItem($_POST['BASKET_ITEM_ID'], $_POST['QUANTITY']);
        $response = [
            'error' => false,
            'countBasketItems' => $countBasketItems
        ];

        break;
}

die(json_encode($response));
