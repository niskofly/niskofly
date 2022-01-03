<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

/**
 * Проверка токена от приложения
 */
if (!check_bitrix_sessid())
    die(json_encode(['error' => true, 'msg' => 'Проверка на сессию не прошла']));

$handler = new AuthByPhoneSms();

switch ($_POST['AUTH_ACTION']) {
    case 'SEND_USER_CODE':
    case 'RESEND_USER_CODE':
        $handler->sendUserAuthCode($_POST['PHONE']);
        break;
    case 'AUTH_BY_CODE':
        $handler->authUserBySMSCode($_POST['PHONE'], $_POST['CODE']);
        break;
}

$handler->sendAjaxResultResponse();
