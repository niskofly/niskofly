<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

/**
 * Проверка токена от приложения
 */
if (!check_bitrix_sessid())
    die(json_encode(['error' => true, 'message' => 'Проверка на сессию не прошла']));

$handler = new AuthByPhoneBitrix();

try {
    switch ($_POST['ACTION']) {
        /* Регистрация нового пользователя */
        case 'USER_CREATE':
            $messageCreate = $handler->registrationUser($_POST);
            die(json_encode(["error" => false, "message" => $messageCreate]));
            break;

        /* Повторное отправление кода при регистрации */
        case 'RESEND_USER_CODE':
            $messageResend = $handler->updateUserProfileAccessCode($_POST);
            die(json_encode(["error" => false, "message" => $messageResend]));
            break;

        /* Авторизация пользователя */
        case 'USER_AUTH':
            $messageAuth = $handler->authorizationUser($_POST);
            die(json_encode(["error" => false, "message" => $messageAuth]));
            break;

        /* Восстановление доступа к профилю */
        case 'USER_RECOVERY':
            $messageRecovery = $handler->updateUserProfileAccessCode($_POST);
            die(json_encode(["error" => false, "message" => $messageRecovery]));
            break;

    }
} catch (Exception $e) {
    die(json_encode(["error" => true, "message" => $e->getMessage()]));
}





