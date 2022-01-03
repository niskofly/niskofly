<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

/**
 * Проверка токена от приложения
 */
if (!check_bitrix_sessid())
    die(json_encode(['error' => true, 'message' => 'Проверка на сессию не прошла']));

global $USER;

if (!$USER->IsAuthorized())
    die(json_encode([['error' => true, 'message' => 'Для написания вопроса нужна авторизация на сайте']]));

$handler = new AddElementFromBitrix(QUESTION_IBLOCK_ID);

$dataQuestionForm = [];

switch ($_POST['ACTION']) {
    case 'CREATE':
        $dataQuestionForm = [
            "NAME" => "Дата: " . date("d.m.Y H:i:s") . " " . $_POST["THEME"],
            "PREVIEW_TEXT" => $_POST['QUESTION'],
            "PROPERTY_VALUES" => [
                "DATE" => date("d.m.Y H:i:s"),
                "EMAIL" => $_POST['EMAIL'],
                "FILES" => AddElementFromBitrix::getSavedFileArray($_FILES['FILES']),
                "BIND_USER" => $USER->GetId(),
                "BIND_PRODUCT" => $_POST["BIND_PRODUCT"],
            ],
        ];
        break;
}
$handler->insert($dataQuestionForm, $_POST['USER_RESPONSE']);
$handler->sendAdminNotification($_POST);
$handler->sendAjaxResultResponse();