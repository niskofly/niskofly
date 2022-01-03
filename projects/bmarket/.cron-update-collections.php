<?php
$_SERVER["DOCUMENT_ROOT"] = __DIR__;

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);
define("BX_CRONTAB", true);
define('BX_NO_ACCELERATOR_RESET', true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

@set_time_limit(0);
@ignore_user_abort(true);
@ini_set('memory_limit', '1600M');

(new XmlParserHandler())->updateCollections();
