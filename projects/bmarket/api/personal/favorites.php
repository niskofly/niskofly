<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$handler = new UserFavoriteProducts();
$handler->addOrRemoveProduct($_POST['PRODUCT_ID']);
echo $handler->getResponse();
