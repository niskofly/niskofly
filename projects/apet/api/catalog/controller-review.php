<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

/**
 * Проверка токена от приложения
 */
if (!check_bitrix_sessid())
    die(json_encode(['error' => true, 'message' => 'Проверка на сессию не прошла']));


global $USER;

if (!$USER->IsAuthorized())
    die(json_encode([['error' => true, 'message' => 'Для добавления отзыва нужна авторизация на сайте']]));

$handler = new AddElementFromBitrix(REVIEW_IBLOCK_ID);

$dataReviewForm = [];

switch ($_POST['ACTION']) {
    case 'CREATE':
        $dataReviewForm = [
            "NAME" => "Дата: " . date("d.m.Y H:i:s") . " " . $_POST["THEME"],
            "PREVIEW_TEXT" => $_POST['REVIEW'],
            "ACTIVE" => "N",
            "PROPERTY_VALUES" => [
                "COUNT_STAR" => $_POST["COUNT_STAR"],
                "TITLE" => $_POST["THEME"],
                "DATE" => date("d.m.Y H:i:s"),
                "BIND_PRODUCT" => $_POST["BIND_PRODUCT"],
                "BIND_USER" => $USER->GetId(),
                "FILES" => AddElementFromBitrix::getSavedFileArray($_FILES['FILES']),
                "EMAIL" => $_POST['EMAIL'],
            ],
        ];
        break;
}
$handler->insert($dataReviewForm, $_POST['USER_RESPONSE']);
$handler->sendAdminNotification($_POST);
$handler->sendAjaxResultResponse();