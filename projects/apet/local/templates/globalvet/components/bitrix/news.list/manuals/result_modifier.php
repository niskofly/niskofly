<?php

$arManuals = [];
$arLetters = [];

foreach (array_filter($arResult["ITEMS"], function ($el) {
  return $el["PROPERTIES"]["MANUAL_FILE"]["VALUE"];
}) as $arProduct):
  $letter = mb_substr($arProduct["NAME"], 0, 1);
  $lang = (preg_match("/[а-яА-я]/", $letter)) ? 'RU' : 'EN';

  if (!array_filter($arLetters[$lang], function ($el) use($letter) {
    return $el == $letter;
  })) $arLetters[$lang][] = $letter;

  $arManuals[$lang][] = [
    "NAME" => $arProduct["NAME"],
    "IMAGE" => ($arProduct["PREVIEW_PICTURE"]["SRC"]) ? $arProduct["PREVIEW_PICTURE"]["SRC"] : NO_IMAGE_SRC,
    "FILE" => CFile::getPath($arProduct["PROPERTIES"]["MANUAL_FILE"]["VALUE"]),
    "LETTER" => $letter
  ];
endforeach;

$arResult["LETTERS"] = $arLetters;
$arResult["MANUALS"] = $arManuals;
unset($arLetters, $arManuals);
