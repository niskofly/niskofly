<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

/**
 * Получение информации о прикреплённых галереях изображений
 */
foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $imgId)
  if ($imgId)
    $arResult['MORE_PHOTO'][] = [
      'SRC' => CFile::GetPath($imgId),
    ];


/**
 * Получение название бренда по id
 */
$arResult['PROPERTIES']['BRAND']['VALUE'] = getNameElementById($arResult['PROPERTIES']['BRAND']['VALUE']);


/**
 * Получение данных продукта для отображения
 */
$arResult['FIRST_PROPERTY_LIST'] = [];
$arResult['FIRST_PROPERTY_LIST_BIG'] = [];

$settingBigProperty = ['PORYADOK_PRIMENENIYA', 'POKAZANIYA_K_PRIMENENIYU', 'PREIMUSHCHESTVA']; /* info: отображать в большом блоке */
$settingDisplayNone = ['MARKA', 'SOSTAV', 'INSTRUKTSIYA', 'FILES', 'VID_NOMENKLATURY']; /* info: не отображать в списке */
$settingUrlElement = ['BRAND']; /* info: элементы с url */

foreach ($arResult['DISPLAY_PROPERTIES'] as $code => $item) {
  if (!in_array($code, $settingDisplayNone)) {
    if (in_array($code, $arParams['PROPERTY_CODE']) && $item['VALUE']) {
      if (in_array($code, $settingBigProperty)) {
        $arResult['FIRST_PROPERTY_LIST_BIG'][$item['NAME']] = $item['HINT']
          ? $item['VALUE'] . ' ' . $item['HINT']
          : $item['VALUE'];
      } else {
        if (in_array($code, $settingUrlElement)) {
          $brandName = $item['LINK_ELEMENT_VALUE'][$item['VALUE']]['NAME'];
          $brandLink = $item['LINK_ELEMENT_VALUE'][$item['VALUE']]['DETAIL_PAGE_URL'];
          $arResult['FIRST_PROPERTY_LIST'][$item['NAME']] = '<a href="' . $brandLink . ' " class="brand_link">' . $brandName . '</a>';
        } else {
          if (is_array($item['VALUE'])) {
            $arResult['FIRST_PROPERTY_LIST'][$item['NAME']] = $item['HINT']
              ? $item['VALUE'][0] . ' ' . $item['HINT']
              : $item['VALUE'][0];
          } else {
            $arResult['FIRST_PROPERTY_LIST'][$item['NAME']] = $item['HINT']
              ? $item['VALUE'] . ' ' . $item['HINT']
              : $item['VALUE'];
          }
        }
      }
    }
  }
}

/**
 * Получение описание
 */
$arResult['DESCRIPTION'] = $arResult['PROPERTIES']['OPISANIE_DLYA_INTERNET_MAGAZINA']['VALUE'];
//$arResult['DESCRIPTION'] = $arResult['DETAIL_TEXT'] ?: $arResult['PREVIEW_TEXT'];


/**
 * Получение состава
 */
$arResult['STRUCTURE'] = $arResult['PROPERTIES']['SOSTAV']['~VALUE'];


/**
 * Получение инструкции файла и получение инструкции INSTRUCTIONS
 */
foreach ($arResult['PROPERTIES']['FILES']['VALUE'] as $filesNum => $fileId) {
  $arResult['INSTRUCTION_FILE'] = CFile::GetPath($fileId);
  $arResult['INSTRUCTIONS'] = $arResult['PROPERTIES']['FILES']['DESCRIPTION'][$filesNum];
}


/**
 * Получение актуальной и минимальной цены товара
 */
$price = $arResult['ITEM_PRICES'][$arResult['ITEM_PRICE_SELECTED']];
$arResult['ACTUAL_PRICE'] = $arResult['MIN_PRICE'] = ItemsBitrixCart::getFormattedPrice($price['RATIO_PRICE']);
$arResult['OLD_PRICE'] = $arResult['MIN_OLD_PRICE'] = ItemsBitrixCart::getFormattedPrice($price['RATIO_BASE_PRICE'], true);


/**
 * Получение отзыва о определенном товаре todo: Получить id товара
 */
$reviewElements = CIBlockElement::GetList(
  ['PROPERTY_DATE' => 'desc', 'SORT' => 'asc'],
  [
    'IBLOCK_ID' => REVIEW_IBLOCK_ID,
    'ACTIVE' => 'Y',
    '=PROPERTY_BIND_PRODUCT' => $arParams['ELEMENT_ID']
  ]
);

while ($reviewElement = $reviewElements->GetNextElement()) {
  $fields = $reviewElement->GetFields();
  $props = $reviewElement->GetProperties();
  $user = CUser::GetByID($props['BIND_USER']['VALUE'])->Fetch();

  $arResult['REVIEWS'][] = [
    'USER' => $fields['USER_NAME'],
    'USER_IMG' => CFile::GetPath($user["PERSONAL_PHOTO"]),
    'TEXT' => TruncateText($fields['PREVIEW_TEXT'], 300),
    'DATE' => FormatDate("d F", MakeTimeStamp($props['DATE']['VALUE'])),
    'COUNT_STAR' => $props['COUNT_STAR']['VALUE']
  ];
}

/**
 * Получение вопросов по товару todo: Получение id товара
 */
$questionElements = CIBlockElement::GetList(
  ['PROPERTY_DATE' => 'desc', 'SORT' => 'asc'],
  [
    'IBLOCK_ID' => QUESTION_IBLOCK_ID,
    'ACTIVE' => 'Y',
    '=PROPERTY_BIND_PRODUCT' => $arParams['ELEMENT_ID']
  ]
);

while ($questionElement = $questionElements->GetNextElement()) {
  $fields = $questionElement->GetFields();
  $props = $questionElement->GetProperties();
  $user = CUser::GetByID($props['BIND_USER']['VALUE'])->Fetch();
  $arResult['QUESTIONS'][] = [
    'NAME' => TruncateText($fields['PREVIEW_TEXT'], 300),
    'TEXT' => TruncateText($fields['DETAIL_TEXT'], 300),
  ];
}


/**
 * Получение информации об товаров на складах
 */
$arResult['AMOUNT_COUNT'] = 0;
$arResult['AMOUNT_LIST'] = [];

$stores = CCatalogStoreProduct::GetList([], ["PRODUCT_ID" => $arParams['ELEMENT_ID']], false, false, []);
while ($store = $stores->GetNext()) {
  if ($store['AMOUNT'] != 0) {
    $arResult['AMOUNT_COUNT']++;

    $amountStatus = null;
    
    if ($store['AMOUNT'] >= 10)
      $amountStatus = "Много";
    if ($store['AMOUNT'] <= 2)
      $amountStatus = "Мало";
    if ($store['AMOUNT'] < 10 && $store['AMOUNT'] > 2)
      $amountStatus = "Достаточно";

    $arResult['AMOUNT_LIST'][] = [
      'NAME' => $store['STORE_NAME'],
      'AMOUNT_STATUS' => $amountStatus
    ];
  }
}


/**
 * Добавление open graph изображения
 */
$arResult["OPENGRAF_IMAGE"] = $arResult['DETAIL_PICTURE']['SRC'] ?: $arResult['PREVIEW_PICTURE']['SRC'];
$cp = $this->__component;
if (is_object($cp))
  $cp->SetResultCacheKeys(array('OPENGRAF_IMAGE'));
