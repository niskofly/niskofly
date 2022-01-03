<?
define("NO_AGENT_CHECK", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$response = [
    'error' => true,
    'message' => 'Некорректный запрос'
];

$subscribeManager = new \Bitrix\Catalog\Product\SubscribeManager;
$contactTypes = $subscribeManager->contactTypes;

$subscribeData = array(
    'USER_CONTACT' => $_POST["EMAIL"],
    'ITEM_ID' => $_POST["PRODUCT_ID"],
    'SITE_ID' => 's1',
    'CONTACT_TYPE' => \Bitrix\Catalog\SubscribeTable::CONTACT_TYPE_EMAIL,
    'USER_ID' => $userId ? $userId : false,
);

$subscribeId = $subscribeManager->addSubscribe($subscribeData);

if ($subscribeId) {
    $response = ['error' => false, 'message' => 'Вы успешно подписались на уведомление о поступлении товара.'];
} else {
    $errorObject = current($subscribeManager->getErrors());
    $response = ['error' => true, 'message' => $errorObject->getMessage()];
}

die(json_encode($response));
