<?php

$arBrands = [];
$arLetters = [];

foreach ($arResult["ITEMS"] as $arBrand):
  $letter = mb_substr($arBrand["NAME"], 0, 1);
  $lang = (preg_match("/[а-яА-я]/", $letter)) ? 'RU' : 'EN';

  if (!array_filter($arLetters[$lang], function ($el) use ($letter) {
    return $el == $letter;
  })) $arLetters[$lang][] = $letter;

  $arBrands[$lang][$letter]["ITEMS"][] = [
    "NAME" => $arBrand["NAME"],
    "IMAGE" => ($arBrand["PREVIEW_PICTURE"]["SRC"]) ? $arBrand["PREVIEW_PICTURE"]["SRC"] : NO_IMAGE_SRC,
  ];
  sort($arLetters[$lang]);
  ksort($arBrands[$lang]);
endforeach;

$arResult["LETTERS"] = $arLetters;
$arResult["BRANDS"] = $arBrands;
unset($arLetters, $arBrands);
