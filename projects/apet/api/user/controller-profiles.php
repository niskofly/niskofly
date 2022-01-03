<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

/**
 * Проверка токена от приложения
 */
if (!check_bitrix_sessid())
    die(json_encode(['error' => true, 'message' => 'Проверка на сессию не прошла']));

$handler = new UserOrderProfiles();

switch ($_POST['ACTION']) {
    case 'CREATE':
        $handler->createProfile($_POST, $_FILES);
        $handler->sendAjaxResultResponse();
        break;
    case 'DELETE':
        $handler->deleteProfile($_POST["PROFILE_ID"]);
        $handler->sendAjaxResultResponse();
        break;
    case 'UPDATE':
        $handler->editProfile($_POST);
        $handler->sendAjaxResultResponse();
        break;
    case 'FILE_LOADING':
        $handler->loadingUserFile($_POST, $_FILES);
        $handler->sendAjaxResultResponse();
        break;
}