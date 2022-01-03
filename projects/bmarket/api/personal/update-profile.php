<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

/**
 * Проверка токена от приложения
 */
if (!check_bitrix_sessid())
    die(json_encode([
        'error' => true,
        'message' => 'Проверка на сессию не прошла'
    ]));


/**
 * Проверка на авторизацию пользователя
 */
global $USER;
if (!$USER->IsAuthorized())
    die(json_encode([
        'error' => 1,
        'message' => 'Вы не авторизованы'
    ]));

$response = [
    'error' => true,
    'message' => 'Дейстивие не найдено'
];

switch ($_POST['ACTION']) {
    case('UPDATE_USER_INFO'):
        /**
         * Валидация
         */
        $isError = false;
        $required = ['NAME', 'EMAIL'];
        foreach ($required as $field) {
            if (!trim($_POST[$field]))
                die(json_encode([
                    'error' => true,
                    'message' => 'Не заполнено обязательное поле!'
                ]));
        }

        $arName = explode(' ', trim($_POST['NAME']));

        $user = new CUser;
        $fields = [
            'NAME' => $arName[0],
            'LAST_NAME' => "{$arName[1]} {$arName[2]}",
            'EMAIL' => $_POST['EMAIL'],
            'PERSONAL_BIRTHDAY' => $_POST['BIRTHDAY'] ?
                preg_replace('/(\d{4})-(\d{2})-(\d{2})/', '$3.$2.$1', $_POST['BIRTHDAY']) :
                ''
        ];

        if ($user->Update($USER->GetID(), $fields))
            $response = [
                'error' => false,
                'message' => $_POST['USER_RESPONSE'] ?: 'Данные успешно обновленны'
            ];
        else
            $response = [
                'error' => true,
                'message' => $user->LAST_ERROR
            ];
        break;
}

die(json_encode($response));
