<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$frame = $this->createFrame()->begin("");

if ($arResult["BANNER"]):
    $class = !in_array($arResult["BANNER_PROPERTIES"]["TYPE_SID"], ['home_header_full']) ? 'collections__item--half' : '';
    ?>
    <div class="collections__item <?= $class ?>"><? echo $arResult["BANNER"]; ?></div>
<? endif;
$frame->end();
