<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
global $USER;

if (!$USER->IsAuthorized())
    LocalRedirect('/auth/');

$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();

$orderId = explode('?', $_REQUEST["ORDER_ID"]);
$orderId = trim($orderId[0]);

if (!$orderId)
    LocalRedirect('/personal/');

/**
 * Проверка на существование заказа и принадлежность текущему пользователю
 */
$orderData = CSaleOrder::GetByID($orderId);
if (!$orderData || $orderData['USER_ID'] != $arUser['ID'])
    show404Page();

CSaleOrder::CancelOrder($orderId, "Y", "Отмена заказа пользователем.");

LocalRedirect("/personal/order/detail/$orderId/");
?>
