<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$APPLICATION->RestartBuffer();
unset($arResult["COMBO"]);

/**
 * Fix to search page
 */
if ($_POST['q']) {
  $arResult['FILTER_URL'] = $arResult['FILTER_URL'] . '?q=' . $_POST['q'];
}

echo CUtil::PHPToJSObject($arResult, true);
?>
