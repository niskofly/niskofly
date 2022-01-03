<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

/**
 * Проверка токена от приложения
 */

if (!check_bitrix_sessid())
  die(json_encode(['error' => true, 'message' => 'Проверка на сессию не прошла']));

try {
  switch ($_POST['ACTION']) {
    case 'CREATE_MAILING':
      $resultSubscribeMailing = (new UserSubscribe(SUBSCRIBE_MAILING_IBLOCK_ID))->addSubscribeEmail($_POST['EMAIL']);
      die(json_encode(["error" => false, "message" => $resultSubscribeMailing]));
      break;
    case 'CREATE_UPDATES':
      $resultSubscribeUpdates = (new UserSubscribe(SUBSCRIBE_UPDATES_IBLOCK_ID))->addSubscribeEmail($_POST['EMAIL']);
      die(json_encode(["error" => false, "message" => $resultSubscribeUpdates]));
      break;
  }
} catch (Exception $e) {
  die(json_encode(["error" => true, "message" => $e->getMessage()]));
}

