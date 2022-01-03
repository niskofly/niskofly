<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

/**
 * Проверка токена от приложения
 */
if (!check_bitrix_sessid())
    die(json_encode(['error' => true, 'message' => 'Проверка на сессию не прошла']));

global $USER;

if (!$USER->IsAuthorized())
    die(json_encode(['error' => true, 'message' => 'Нету авторизации']));

if (!empty($_POST)) {
    switch ($_POST['ACTION']) {
        case 'EDIT_USER_INFO':
            $userFio = explode(" ", trim($_POST['NAME']));
            $fields = [
                'NAME' => $userFio[0],
                'LAST_NAME' => $userFio[1],
                'SECOND_NAME' => $userFio[2],
                'EMAIL' => $_POST['EMAIL']
            ];

            $user = new CUser;
            if ($user->Update($USER->GetID(), $fields))
                $response = ['error' => false, 'message' => $_POST['USER_RESPONSE'] ?: 'Данные изменены'];
            else
                $response = ['error' => true, 'message' => $user->LAST_ERROR];

            die(json_encode($response));
            break;

        case 'EDIT_USER_PASSWORD':
            $handler = new AuthByPhoneBitrix();
            try {
                $messageChange = $handler->changePassword($_POST);
                die(json_encode(["error" => false, "message" => $messageChange]));
            } catch (Exception $e) {
                die(json_encode(["error" => true, "message" => $e->getMessage()]));
            }
            break;

        case 'UPDATE_USER_PHOTO':
            if (empty($_FILES['USER_PHOTO']['tmp_name']))
                die(json_encode(['error' => true, 'message' => 'Выберите файл для загрузки']));

            $file = $_FILES['USER_PHOTO'];
            if ($_POST['OLD_USER_PHOTO']) {
                $file['del'] = "Y";
                $file['old_file'] = $_POST['OLD_USER_PHOTO'];
            }

            $user = new CUser;
            if ($user->Update($USER->GetID(), ['PERSONAL_PHOTO' => $file])) {
                $updateUser = CUser::GetByID($USER->GetID())->Fetch();
                $newPhotoSrc = CFile::GetPath($updateUser['PERSONAL_PHOTO']);
                $response = ['error' => false, 'newPhotoSrc' => $newPhotoSrc];
            } else {
                $response = ['error' => true, 'message' => $user->LAST_ERROR];
            }
            die(json_encode($response));
            break;
    }
}
