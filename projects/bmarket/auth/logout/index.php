<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

global $USER;

if (!$USER->IsAuthorized())
    LocalRedirect('/auth/');

$USER->Logout();
LocalRedirect('/');
?>
