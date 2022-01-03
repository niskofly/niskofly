<?
/** @var array $arResult */
/** @var array $arParams */

$arResultMenu = [];
$oldParentLink;
$oldTwoParentLink;
$isFirstElement = true;

foreach ($arResult as $id => $item) {
  switch ($item['DEPTH_LEVEL']) {
    case 1:
      $oldParentLink = $item['LINK'];
      $arResultMenu[$item['LINK']] = ['NAME' => $item['TEXT'], 'LINK' => $item['LINK'], 'IS_ONE' => $isFirstElement];
      $isFirstElement = false;
      break;
    case 2:
      $oldTwoParentLink = $item['LINK'];
      $arResultMenu[$oldParentLink]['CATEGORIES'][$item['LINK']] = [
        'NAME' => $item['TEXT'],
        'LINK' => $item['LINK'],
        'IMG' => CFile::GetPath($item['PARAMS']['DETAIL_PICTURE']) ?: '/img/no-image.png'
      ];
      break;
    case 3:
      $arResultMenu[$oldParentLink]['CATEGORIES'][$oldTwoParentLink]['SUB_CATEGORIES'][] = ['NAME' => $item['TEXT'], 'LINK' => $item['LINK']];
      break;
  }
}
$arResult['MENU'] = $arResultMenu;
