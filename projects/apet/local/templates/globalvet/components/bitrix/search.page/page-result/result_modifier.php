<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $searchId;
$searchId = [];

foreach ($arResult["SEARCH"] as $item) {
  $searchId[] = $item['ITEM_ID'];
}
