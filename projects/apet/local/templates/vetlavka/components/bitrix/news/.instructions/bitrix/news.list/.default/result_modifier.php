<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arResult['INSTRUCTIONS'] = [];
$instructions = [];

foreach ($arResult['ITEMS'] as $item) {
  if ($item['PROPERTIES']['INSTRUCTION_FILE']['VALUE']) {
    $firstCharacter = getFirstLetter($item['NAME']);
    $lang = preg_match('/[а-яёА-ЯЁ]+/u', $firstCharacter) ? 'ru' : 'en';

    $instructions[$lang][$firstCharacter][] = [
      'ID' => $item['ID'],
      'NAME' => $item['NAME'],
      'INSTRUCTION_FILE' => CFile::GetPath($item['PROPERTIES']['INSTRUCTION_FILE']['VALUE']),
      'PREVIEW_TEXT' => $item["PREVIEW_TEXT"],
      'IMG' => $item["PREVIEW_PICTURE"]["SRC"]
    ];
  }
}

$arResult['INSTRUCTIONS'] = $instructions;
