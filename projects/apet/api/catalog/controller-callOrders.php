<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

/**
 * Проверка токена от приложения
 */
if (!check_bitrix_sessid())
    die(json_encode(['error' => true, 'message' => 'Проверка на сессию не прошла']));

global $USER;

if (!$USER->IsAuthorized())
    die(json_encode([['error' => true, 'message' => 'Для заказа звонка нужна авторизация']]));


$handler = new AddElementFromBitrix(CALL_ORDERS_IBLOCK_ID);

$dataCallOrdersForm = [];

switch ($_POST['ACTION']) {
    case 'ADD_CALL_ORDERS':
        $dataCallOrdersForm = [
            "NAME" => "Дата: " . date("d.m.Y H:i:s") . " " . $_POST["THEME"],
            "PROPERTY_VALUES" => [
                "DATE" => date("d.m.Y H:i:s"),
                "USER_NAME" => $_POST["name"],
                "USER_PHONE" => $_POST["phone"],
            ],
        ];
        break;
}
$handler->insert($dataCallOrdersForm, $_POST['USER_RESPONSE']);
$handler->sendAdminNotification($_POST);
$handler->sendAjaxResultResponse();