<?
define("NO_AGENT_CHECK", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


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
        break;

    case 'REMOVE_BASKET_ITEM':
        if (!$_POST['BASKET_ITEM_ID'])
            break;

        $countBasketItems = ItemsBitrixCart::removeBasketItem($_POST['BASKET_ITEM_ID']);
        break;

    case 'UPDATE_BASKET_ITEM':
        if (!$_POST['BASKET_ITEM_ID'])
            break;

        $countBasketItems = ItemsBitrixCart::updateBasketItem($_POST['BASKET_ITEM_ID'], $_POST['QUANTITY']);
        break;
}
