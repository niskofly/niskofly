<?

use Bitrix\Main\Diag;
use Bitrix\Main\Application;

function dd($value)
{
  Diag\Debug::dump($value);
  die();
}

function dump($value)
{
  Diag\Debug::dump($value);
}

/**
 * @param $haystack
 * @param array $needles
 * @param int $offset
 * @return bool
 */
function strposa($haystack, $needles = array(), $offset = 0): bool
{
  $chr = array();
  foreach ($needles as $needle) {
    $res = strpos($haystack, $needle, $offset);
    if ($res !== false) $chr[$needle] = $res;
  }
  if (empty($chr)) return false;
  return min($chr);
}

/**
 * @param int $value
 * @param string[] $status
 * @return string
 */
function getEncoding($value = 1, $status = ['', 'а', 'ов']): string
{
  $array = array(2, 0, 1, 1, 1, 2);
  return $status[($value % 100 > 4 && $value % 100 < 20) ? 2 : $array[($value % 10 < 5) ? $value % 10 : 5]];
}

/**
 * @param $url
 * @param $class
 * @return string
 */
function setActiveClassByLink($url, $class): string
{
  global $APPLICATION;
  $current_url = $APPLICATION->GetCurPage();
  return $current_url == $url ? $class : '';
}

/**
 * @param $str
 * @param string[] $arParams
 * @return string
 */
function getUrlByStr($str, $arParams = ["replace_space" => "-", "replace_other" => "-"]): string
{
  return Cutil::translit($str, "ru", $arParams);
}

if (!function_exists('mb_ucfirst')) {
  function mb_ucfirst($string, $enc = 'UTF-8')
  {
    return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc) .
      mb_substr($string, 1, mb_strlen($string, $enc), $enc);
  }
}

/**
 * @param $str
 * @return string
 */
function getCaseConversionStr($str): string
{
  return mb_ucfirst(mb_strtolower(trim($str)));
}

/**
 * @param int $length
 * @return string
 */
function generateRandomString($length = 10): string
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

/**
 * Получение массива ссылок для получения предыдущего и следующего элемента
 * Сортировка используется SORT asc
 * @param $elementId
 * @param $sectionId
 * @param null $linkTemplate
 * @return array
 * @throws \Bitrix\Main\Db\SqlQueryException
 */
function getNextPrevLink($elementId, $sectionId, $linkTemplate = null): array
{
  $arLinks = [
    'PREV_LINK' => null,
    'NEXT_LINK' => null
  ];

  /**
   * Запрос на получение предыдущего элемента
   */
  $reqPrev = "SELECT ID, NAME, CODE FROM b_iblock_element WHERE ACTIVE = 'Y' AND ID < "
    . $elementId . " AND IBLOCK_SECTION_ID = " . $sectionId . " ORDER BY ID DESC LIMIT 1";
  $arPrevInfo = Application::getConnection()
    ->query($reqPrev)
    ->fetch();
  if ($arPrevInfo) {
    $arLinks['PREV_LINK'] = $arPrevInfo['CODE'];
  }

  /**
   * Запрос на получение следующего элемента
   */
  $reqNext = "SELECT ID, NAME, CODE FROM b_iblock_element WHERE ACTIVE = 'Y' AND ID > "
    . $elementId . " AND IBLOCK_SECTION_ID = " . $sectionId . " ORDER BY ID ASC LIMIT 1";
  $arNextInfo = Application::getConnection()
    ->query($reqNext)
    ->fetch();
  if ($arNextInfo) {
    $arLinks['NEXT_LINK'] = $arNextInfo['CODE'];
  }

  /**
   * Генерация ссылки по шаблону, если он задан
   */
  if ($linkTemplate) {
    foreach ($arLinks as $key => $code) {
      if ($code)
        $arLinks[$key] = str_replace('#CODE#', $code, $linkTemplate);
    }
  }

  return $arLinks;
}

/**
 * Получение предыдущего/следующего элемента
 * @param $elementId
 * @param $sectionId
 * @param null $linkTemplate
 * @return null[]
 * @throws \Bitrix\Main\Db\SqlQueryException
 */
function getNextPrevLinkCatalog($elementId, $sectionId, $linkTemplate = null): array
{
  $arLinks = [
    'PREV_LINK' => null,
    'NEXT_LINK' => null
  ];
  $catalogCroupId = IikoHandler::getRegionalPriceId();

  /**
   * Запрос на получение предыдущего элемента
   */
  $reqPrev = "SELECT BE.ID, BE.NAME, CODE FROM b_iblock_element BE, b_catalog_price CP WHERE BE.ID = CP.PRODUCT_ID AND BE.ACTIVE = 'Y' AND BE.ID < "
    . $elementId . " AND BE.IBLOCK_SECTION_ID = " . $sectionId . " AND CP.CATALOG_GROUP_ID = " . $catalogCroupId . " AND CP.PRICE != 0 ORDER BY ID DESC LIMIT 1";
  $arPrevInfo = Application::getConnection()
    ->query($reqPrev)
    ->fetch();
  if ($arPrevInfo) {
    $arLinks['PREV_LINK'] = $arPrevInfo['CODE'];
  }

  /**
   * Запрос на получение следующего элемента
   */
  $reqNext = "SELECT BE.ID, BE.NAME, CODE FROM b_iblock_element BE, b_catalog_price CP WHERE BE.ID = CP.PRODUCT_ID AND BE.ACTIVE = 'Y' AND BE.ID > "
    . $elementId . " AND BE.IBLOCK_SECTION_ID = " . $sectionId . " AND CP.CATALOG_GROUP_ID = " . $catalogCroupId . " AND CP.PRICE != 0 ORDER BY ID ASC LIMIT 1";
  $arNextInfo = Application::getConnection()
    ->query($reqNext)
    ->fetch();
  if ($arNextInfo) {
    $arLinks['NEXT_LINK'] = $arNextInfo['CODE'];
  }

  /**
   * Генерация ссылки по шаблону, если он задан
   */
  if ($linkTemplate) {
    foreach ($arLinks as $key => $code) {
      if ($code)
        $arLinks[$key] = str_replace('#CODE#', $code, $linkTemplate);
    }
  }

  return $arLinks;
}

/**
 * Отображение 404 страницы
 */
function show404Page()
{
  global $APPLICATION;
  CHTTP::SetStatus("404 Not Found");
  @define("ERROR_404", "Y");

  $rsSites = CSite::GetByID(SITE_ID);
  $arSite = $rsSites->Fetch();
  require $_SERVER['DOCUMENT_ROOT'] . "/404.php";
  die();
}

/**
 * Получить ID родительского раздела, для конкретной категории
 * @param $sectionId
 * @return mixed
 */
function getParentSectionId($sectionId)
{
  $dbSection = CIBlockSection::GetList([], ['ID' => $sectionId]);
  $section = $dbSection->GetNext();

  static $resultSectionID;
  if ($section['DEPTH_LEVEL'] == 1)
    $resultSectionID = $section['ID'];
  else
    getParentSectionId($section['IBLOCK_SECTION_ID']);

  return $resultSectionID;
}

/**
 * Форматирование цены
 * @param $price
 * @return string
 */
function formattedPrice($price): string
{
  return number_format($price, 0, '.', ' ') . ' р.';
}

/**
 * Получение url страницы
 * @return string
 */
function getCurrentUrl(): string
{
  global $APPLICATION;
  return DOMAIN . $APPLICATION->GetCurPage();
}

/**
 * Получение массива с алфавитом
 * @return string[][]
 */
function getAlphabets(): array
{
  return [
    'ru' => [
      'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р',
      'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
    ],
    'en' => [
      'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
      'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
    ]
  ];
}

/**
 * Получение название элемента по его id
 * @param $id
 * @return mixed
 */
function getNameElementById($id)
{
  $obResult = CIBlockElement::GetByID($id);
  if ($result = $obResult->GetNext())
    return $result['NAME'];
}

/**
 * Получение ссылки элемента по его id
 * @param $id
 * @return mixed
 */
function getLinkElementById($id)
{
  $obResult = CIBlockElement::GetByID($id);
  if ($result = $obResult->GetNext())
    return $result['DETAIL_PAGE_URL'];
}

/**
 * Получение первой буквы
 * @param $string
 * @return string
 */
function getFirstLetter($string): string
{
  return mb_substr($string, 0, 1, 'UTF-8');
}

/**
 * Получение товаров со скодкой
 * @param null $catalogId
 * @return array|null
 */
function getDiscountProductsId($catalogId = null): ?array
{
  $catalogId = !$catalogId && defined(CATALOG_ID) ? CATALOG_ID : $catalogId;
  if (!$catalogId)
    return null;

  $obAllProducts = CIBlockElement::GetList(
    ['SORT' => 'ASC'],
    ['IBLOCK_ID' => $catalogId, 'ACTIVE' => 'Y', 'ACTIVE_DATA' => 'Y'],
    false,
    false,
    ['*']
  );

  while ($product = $obAllProducts->GetNext()) {
    $price = CCatalogProduct::GetOptimalPrice($product['ID']);
    if ($price['RESULT_PRICE']['DISCOUNT'])
      $discountProductId[] = $product['ID'];
  }

  return !empty($discountProductId) ? $discountProductId : null;
}

/**
 * Ограничение контента между сайтами
 * @param null $arrFilter
 * @return array|mixed|null
 */
function getFilterRestrictionSite($arrFilter = null): ?array
{
  if (!$arrFilter) {
    global $arrFilter;
    $arrFilter = [];
  }

  $siteName = null;

  switch (SITE_ID) {
    case 's1':
      $siteName = 'Vetlavka';
      break;
    case 's2':
      $siteName = 'GlobalVet';
      break;
  }

  if ($siteName)
    $arrFilter['PROPERTY_SITE_RESTRICTION_VALUE'] = $siteName;

  return $arrFilter;
}

/**
 * Получение название сайта
 * @return string|null
 */
function getSiteName(): ?string
{
  $siteName = null;

  switch (SITE_ID) {
    case 's1':
      $siteName = 'Vetlavka';
      break;
    case 's2':
      $siteName = 'GlobalVet';
      break;
  }
  return $siteName;
}

?>
