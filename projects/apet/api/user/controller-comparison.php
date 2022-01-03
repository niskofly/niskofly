<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

switch ($_POST['ACTION']) {
  case 'CREAR_LIST':
    unset($_SESSION['CATALOG_COMPARE_LIST']);
    break;

  case 'GET_COUNT':
    $compareCount = 0;
    foreach ($_SESSION['CATALOG_COMPARE_LIST'] as $compareIBlock)
      foreach ($compareIBlock['ITEMS'] as $compareItem)
        $compareCount++;

    die(json_encode(['error' => false, 'count' => $compareCount]));
    break;
}

$_REQUEST["ajax_action"] = "Y";

$APPLICATION->IncludeComponent(
  "bitrix:catalog.compare.list",
  "",
  [
    "ACTION_VARIABLE" => "action",
    "AJAX_MODE" => "Y",
    "AJAX_OPTION_ADDITIONAL" => "",
    "AJAX_OPTION_HISTORY" => "N",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "Y",
    "COMPARE_URL" => "/catalog/comparison/",
    "COMPONENT_TEMPLATE" => ".default",
    "DETAIL_URL" => "",
    "IBLOCK_ID" => CATALOG_ID,
    "IBLOCK_TYPE" => "catalog",
    "NAME" => 'CATALOG_COMPARE_LIST',
    "POSITION" => "top left",
    "POSITION_FIXED" => "Y",
    "PRODUCT_ID_VARIABLE" => "product_id"
  ]
);
