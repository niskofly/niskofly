<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;
if (empty($arResult))
    return "";

$strReturn = '';
$strReturn .= '<div class="breadcrumb container"><ul class="breadcrumb__list">';
$itemSize = count($arResult);

for ($index = 0; $index < $itemSize; $index++) {
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

    if ($arResult[$index]["LINK"] <> "" && $index != $itemSize - 1) {
        $strReturn .= '<li class="breadcrumb__item">
                            <a href="' . $arResult[$index]["LINK"] . '" class="breadcrumb__item" title="' . $title . '"><span>' . $title . '</span></a>
                       </li>';
        $strReturn .= '<li class="breadcrumb__item"><span>-</span></li>';
    } else {
        $strReturn .= '<li class="breadcrumb__item" >' . $title . '</li>';
    }
}

$strReturn .= '</ul></div>';
return $strReturn;
?>
