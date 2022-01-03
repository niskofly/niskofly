<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

global $USER;
$USER->Logout();
LocalRedirect('/');

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
