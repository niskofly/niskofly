<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

/**
 * Проверка токена от приложения
 */
if (!check_bitrix_sessid())
    die(json_encode(['error' => true, 'message' => 'Проверка на сессию не прошла']));

$handler = new AddElementFromBitrix(NOTIFY_GOODS_ARRIVE_IBLOCK_ID);

global $USER;

switch ($_POST['ACTION']) {
    case 'CREATE_ARRIVAL_DEFAULT':
        $response = [];

        $subscribeData = array(
            'USER_CONTACT' => $USER->getEmail() ?: false,
            'ITEM_ID' => $_POST['PRODUCT_ID'],
            'SITE_ID' => 's1',
            'CONTACT_TYPE' => \Bitrix\Catalog\SubscribeTable::CONTACT_TYPE_EMAIL,
            'USER_ID' => $USER->GetID() ?: false,
        );
        $subscribeID = (new \Bitrix\Catalog\Product\SubscribeManager)->addSubscribe($subscribeData);

        if ($subscribeData)
            $response = ["error" => false, "message" => "Подписка на товар оформлена"];
        else
            $response = ["error" => true, "message" => "При оформлении подписки на товар произошла ошибка"];

        die(json_encode($response));
        break;

    case 'CREATE_ARRIVAL':
        $dataArrivalForm = [];

        $dataArrivalForm = [
            "NAME" => "Дата: " . date("d.m.Y H:i:s") . " " . $_POST["THEME"],
            "PREVIEW_TEXT" => 'Уведомить о поступлении товара',
            "PROPERTY_VALUES" => [
                "EMAIL" => $_POST['EMAIL'],
                "BIND_USER" => $USER->GetId(),
                "BIND_PRODUCT" => $_POST["BIND_PRODUCT"],
                "IS_SEND_SMS" => $_POST["IS_SEND_SMS"] ? 'Да' : 'Нет'
            ],
        ];
        $handler->insert($dataArrivalForm, $_POST['USER_RESPONSE']);
        $handler->sendAdminNotification($_POST);
        $handler->sendAjaxResultResponse();
        break;
}

