<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

global $USER;

try {
  if ($USER->IsAuthorized()) {
    /* info: При авторизации */
    $favoriteHandler = new UserFavoriteProducts();
    switch ($_POST['action']) {
      case 'favorite';
        $resultFavorite = $favoriteHandler->addOrRemoveProduct($_POST['product_id']);
        die(json_encode(["error" => false, "message" => $resultFavorite]));
        break;

      case 'get_count';
        $favoriteCount = $favoriteHandler->getCountFavorites();
        die(json_encode(["error" => false, "count" => $favoriteCount]));
        break;
    }
  } else {
    /* info: Без авторизации */
    $favoriteCookieHandler = new CookieFieldHandler('favorite_no_auth');
    switch ($_POST['action']) {
      case 'favorite';
        $productID = $_POST['product_id'];

        if (!$response = $favoriteCookieHandler->addElement($productID)) {
          $response = $favoriteCookieHandler->deleteElement($productID);
        }

        die(json_encode(["error" => false, "message" => $response]));
        break;

      case 'get_count';
        $favoriteGetCountCookie = $favoriteCookieHandler->getCountElements();
        die(json_encode(["error" => false, "count" => $favoriteGetCountCookie]));
        break;
    }
  }


} catch (Exception $e) {
  die(json_encode(["error" => true, "message" => $e->getMessage()]));
}
