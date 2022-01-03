<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 */
global $APPLICATION;

/* delayed function must return a string */
if (empty($arResult))
    return "";

$pageTitle = end($arResult)['TITLE'];
$strReturn = '';
$strReturn .= '<div class="bread-crumbs">';
$itemSize = count($arResult);

for ($index = 0; $index < $itemSize; $index++) {
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

    if ($arResult[$index]["LINK"] <> "" && $index != $itemSize - 1) {
        $strReturn .= '<a href="' . $arResult[$index]["LINK"] . '" class="bread-crumb" title="' . $title . '"><span>' . $title . '</span></a>';
    } else {
        $strReturn .= '<div class="bread-crumb" >' . $title . '</div>';
    }
}

$strReturn .= '</div>';
return $strReturn;
?>
