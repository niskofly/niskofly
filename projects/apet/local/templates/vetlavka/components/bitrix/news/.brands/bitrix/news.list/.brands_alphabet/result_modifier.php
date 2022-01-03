<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arResult['BRANDS'] = [];
$brands = [];

foreach ($arResult['ITEMS'] as $item) {
  /* todo: по фиксить через iblock получать 1 букву */
  $firstCharacter = getFirstLetter($item["NAME"]);
  $lang = preg_match('/[а-яёА-ЯЁ]+/u', $firstCharacter) ? 'ru' : 'en';

  $brands[$lang][$firstCharacter][] = [
    "NAME" => $item["NAME"],
    "PREVIEW_TEXT" => $item["PREVIEW_TEXT"],
    "DETAIL_PAGE_URL" => $item["DETAIL_PAGE_URL"],
    "SRC" => $item["PREVIEW_PICTURE"]["SRC"] ?: '/img/no-image.png'
  ];
}

ksort($brands['ru']);
ksort($brands['en']);

$arResult['BRANDS'] = $brands;
