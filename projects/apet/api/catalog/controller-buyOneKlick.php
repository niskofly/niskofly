<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

if (!empty($_POST)) {
    try {
        switch ($_POST['ACTION']) {
            case 'ONE_CLICK_BUY_PRODUCT':
                $buyOneClickResult = (new OneClickProductPurchase)->buyOneClick($_POST);
                die(json_encode(["error" => false, "message" => $buyOneClickResult]));
                break;
        }
    } catch (Exception $e) {
        die(json_encode(["error" => true, "message" => $e->getMessage()]));
    }
}