<?

use Bitrix\Main\Diag;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\SystemException;

function dd($value)
{
    Diag\Debug::dump($value);
    die();
}

function dump($value)
{
    Diag\Debug::dump($value);
}

function strposa($haystack, $needles = array(), $offset = 0)
{
    $chr = array();
    foreach ($needles as $needle) {
        $res = strpos($haystack, $needle, $offset);
        if ($res !== false) $chr[$needle] = $res;
    }
    if (empty($chr)) return false;
    return min($chr);
}

function getEncoding($value = 1, $status = ['', 'а', 'ов'])
{
    $array = array(2, 0, 1, 1, 1, 2);
    return $status[($value % 100 > 4 && $value % 100 < 20) ? 2 : $array[($value % 10 < 5) ? $value % 10 : 5]];
}

function setActiveClassByLink($url, $class = 'active')
{
    global $APPLICATION;
    return $APPLICATION->GetCurPage() == $url ? $class : '';
}

function getUrlByStr($str, $arParams = ["replace_space" => "-", "replace_other" => "-"])
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

function getCaseConversionStr($str)
{
    return mb_ucfirst(mb_strtolower(trim($str)));
}

function generateRandomString($length = 10)
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
 * Получение масива ссылок для получения предыдущего и следующего элемента
 * Сортировка используется SORT asc
 *
 * @param $elementId
 * @param $sectionId
 * @param null $linkTemplate
 * @return array
 * @throws \Bitrix\Main\Db\SqlQueryException
 */
function getNextPrevLink($elementId, $sectionId, $linkTemplate = null)
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

function formattedPrice($price)
{
    return number_format($price, 0, '.', ' ') . ' р.';
}

function getCurrentUrl()
{
    global $APPLICATION;
    return DOMAIN . $APPLICATION->GetCurPage();
}

/**
 * Получить ID товаров на которые дествует конкретная скидка
 * todo: Отрефакторить для работы только с одной скидкой, оптимизировать выборки
 * @param $discountId
 * @param array $arrFilter
 * @param array $arSelect
 * @return array
 * @throws SystemException
 * @throws \Bitrix\Main\ArgumentException
 * @throws \Bitrix\Main\LoaderException
 * @throws \Bitrix\Main\ObjectPropertyException
 */
function getProductIdsFromDiscount($discountId, $arrFilter = [], $arSelect = [])
{
    if (!Loader::includeModule('sale')) throw new SystemException('Не подключен модуль Sale');

    global $USER;
    $arUserGroups = $USER->GetUserGroupArray();
    if (!is_array($arUserGroups)) $arUserGroups = [$arUserGroups];

    /**
     * Достаем старым методом только ID скидок привязанных к группам пользователей по ограничениям
     */
    $actionsNotTemp = \CSaleDiscount::GetList(
        ["ID" => "ASC"],
        ["USER_GROUPS" => $arUserGroups, 'ID' => $discountId],
        false,
        false,
        ["ID"]
    );
    while ($actionNot = $actionsNotTemp->fetch())
        $actionIds[] = $actionNot['ID'];

    $actionIds = array_unique($actionIds);
    sort($actionIds);

    /**
     * Подготавливаем необходимые переменные для разборчивости кода
     */
    global $DB;
    $conditionLogic = ['Equal' => '=', 'Not' => '!', 'Great' => '>', 'Less' => '<', 'EqGr' => '>=', 'EqLs' => '<='];
    $arSelect = array_merge(["ID", "IBLOCK_ID", "XML_ID"], $arSelect);

    /**
     * Теперь достаем новым методом скидки с условиями.
     * P.S. Старым методом этого делать не нужно из-за очень высокой нагрузки (уже тестировал)
     */
    $actions = \Bitrix\Sale\Internals\DiscountTable::getList(array(
        'select' => array("*"),
        'filter' => array("ACTIVE" => "Y", "USE_COUPONS" => "N", "DISCOUNT_TYPE" => "P", "LID" => SITE_ID,
            "ID" => $actionIds,
            array(
                "LOGIC" => "OR",
                array(
                    "<=ACTIVE_FROM" => $DB->FormatDate(date("Y-m-d H:i:s"), "YYYY-MM-DD HH:MI:SS", \CSite::GetDateFormat("FULL")),
                    ">=ACTIVE_TO" => $DB->FormatDate(date("Y-m-d H:i:s"), "YYYY-MM-DD HH:MI:SS", \CSite::GetDateFormat("FULL"))
                ),
                array(
                    "=ACTIVE_FROM" => false,
                    ">=ACTIVE_TO" => $DB->FormatDate(date("Y-m-d H:i:s"), "YYYY-MM-DD HH:MI:SS", \CSite::GetDateFormat("FULL"))
                ),
                array(
                    "<=ACTIVE_FROM" => $DB->FormatDate(date("Y-m-d H:i:s"), "YYYY-MM-DD HH:MI:SS", \CSite::GetDateFormat("FULL")),
                    "=ACTIVE_TO" => false
                ),
                array(
                    "=ACTIVE_FROM" => false,
                    "=ACTIVE_TO" => false
                ),
            ))
    ));

    /**
     * Перебираем каждую скидку и подготавливаем условия фильтрации для CIBlockElement::GetList
     */
    while ($arrAction = $actions->fetch())
        $arrActions[$arrAction['ID']] = $arrAction;

    foreach ($arrActions as $actionId => $action) {
        /**
         * Набор предустановленных параметров
         */
        $arPredFilter = array_merge(["ACTIVE_DATE" => "Y", "CAN_BUY" => "Y"], $arrFilter);
        $arFilter = $arPredFilter; //Основной фильтр
        $dopArFilter = $arPredFilter; //Фильтр для доп. запроса
        $dopArFilter["=XML_ID"] = array(); //Пустое значения для первой отработки array_merge

        /**
         * Магия генерации фильтра
         */
        foreach ($action['ACTIONS_LIST']['CHILDREN'] as $condition) {
            foreach ($condition['CHILDREN'] as $keyConditionSub => $conditionSub) {
                $cs = $conditionSub['DATA']['value']; //Значение условия
                $cls = $conditionLogic[$conditionSub['DATA']['logic']]; //Оператор условия
                $CLASS_ID = explode(':', $conditionSub['CLASS_ID']);

                if ($CLASS_ID[0] == 'ActSaleSubGrp') {
                    foreach ($conditionSub['CHILDREN'] as $keyConditionSubElem => $conditionSubElem) {
                        $cse = $conditionSubElem['DATA']['value']; //Значение условия
                        $clse = $conditionLogic[$conditionSubElem['DATA']['logic']]; //Оператор условия
                        //$arFilter["LOGIC"]=$conditionSubElem['DATA']['All']?:'AND';
                        $CLASS_ID_EL = explode(':', $conditionSubElem['CLASS_ID']);
                        if ($CLASS_ID_EL[0] == 'CondIBProp') {
                            $arFilter["IBLOCK_ID"] = $CLASS_ID_EL[1];
                            $arFilter[$clse . "PROPERTY_" . $CLASS_ID_EL[2]] = array_merge((array)$arFilter[$clse . "PROPERTY_" . $CLASS_ID_EL[2]], (array)$cse);
                            $arFilter[$clse . "PROPERTY_" . $CLASS_ID_EL[2]] = array_unique($arFilter[$clse . "PROPERTY_" . $CLASS_ID_EL[2]]);
                        } elseif ($CLASS_ID_EL[0] == 'CondIBName') {
                            $arFilter[$clse . "NAME"] = array_merge((array)$arFilter[$clse . "NAME"], (array)$cse);
                            $arFilter[$clse . "NAME"] = array_unique($arFilter[$clse . "NAME"]);
                        } elseif ($CLASS_ID_EL[0] == 'CondIBElement') {
                            $arFilter[$clse . "ID"] = array_merge((array)$arFilter[$clse . "ID"], (array)$cse);
                            $arFilter[$clse . "ID"] = array_unique($arFilter[$clse . "ID"]);
                        } elseif ($CLASS_ID_EL[0] == 'CondIBTags') {
                            $arFilter[$clse . "TAGS"] = array_merge((array)$arFilter[$clse . "TAGS"], (array)$cse);
                            $arFilter[$clse . "TAGS"] = array_unique($arFilter[$clse . "TAGS"]);
                        } elseif ($CLASS_ID_EL[0] == 'CondIBSection') {
                            $arFilter[$clse . "SECTION_ID"] = array_merge((array)$arFilter[$clse . "SECTION_ID"], (array)$cse);
                            $arFilter[$clse . "SECTION_ID"] = array_unique($arFilter[$clse . "SECTION_ID"]);
                        } elseif ($CLASS_ID_EL[0] == 'CondIBXmlID') {
                            $arFilter[$clse . "XML_ID"] = array_merge((array)$arFilter[$clse . "XML_ID"], (array)$cse);
                            $arFilter[$clse . "XML_ID"] = array_unique($arFilter[$clse . "XML_ID"]);
                        } elseif ($CLASS_ID_EL[0] == 'CondBsktAppliedDiscount') { //Условие: Были применены скидки (Y/N)
                            foreach ($arrActions as $tempAction) {
                                if (($tempAction['SORT'] < $action['SORT'] && $tempAction['PRIORITY'] > $action['PRIORITY'] && $cse == 'N') || ($tempAction['SORT'] > $action['SORT'] && $tempAction['PRIORITY'] < $action['PRIORITY'] && $cse == 'Y')) {
                                    $arFilter = false;
                                    break 4;
                                }
                            }
                        }
                    }
                } elseif ($CLASS_ID[0] == 'CondIBProp') {
                    $arFilter["IBLOCK_ID"] = $CLASS_ID[1];
                    $arFilter[$cls . "PROPERTY_" . $CLASS_ID[2]] = array_merge((array)$arFilter[$cls . "PROPERTY_" . $CLASS_ID[2]], (array)$cs);
                    $arFilter[$cls . "PROPERTY_" . $CLASS_ID[2]] = array_unique($arFilter[$cls . "PROPERTY_" . $CLASS_ID[2]]);
                } elseif ($CLASS_ID[0] == 'CondIBName') {
                    $arFilter[$cls . "NAME"] = array_merge((array)$arFilter[$cls . "NAME"], (array)$cs);
                    $arFilter[$cls . "NAME"] = array_unique($arFilter[$cls . "NAME"]);
                } elseif ($CLASS_ID[0] == 'CondIBElement') {
                    $arFilter[$cls . "ID"] = array_merge((array)$arFilter[$cls . "ID"], (array)$cs);
                    $arFilter[$cls . "ID"] = array_unique($arFilter[$cls . "ID"]);
                } elseif ($CLASS_ID[0] == 'CondIBTags') {
                    $arFilter[$cls . "TAGS"] = array_merge((array)$arFilter[$cls . "TAGS"], (array)$cs);
                    $arFilter[$cls . "TAGS"] = array_unique($arFilter[$cls . "TAGS"]);
                } elseif ($CLASS_ID[0] == 'CondIBSection') {
                    $arFilter[$cls . "SECTION_ID"] = array_merge((array)$arFilter[$cls . "SECTION_ID"], (array)$cs);
                    $arFilter[$cls . "SECTION_ID"] = array_unique($arFilter[$cls . "SECTION_ID"]);
                } elseif ($CLASS_ID[0] == 'CondIBXmlID') {
                    $arFilter[$cls . "XML_ID"] = array_merge((array)$arFilter[$cls . "XML_ID"], (array)$cs);
                    $arFilter[$cls . "XML_ID"] = array_unique($arFilter[$cls . "XML_ID"]);
                } elseif ($CLASS_ID[0] == 'CondBsktAppliedDiscount') { //Условие: Были применены скидки (Y/N)
                    foreach ($arrActions as $tempAction) {
                        if (($tempAction['SORT'] < $action['SORT'] && $tempAction['PRIORITY'] > $action['PRIORITY'] && $cs == 'N') || ($tempAction['SORT'] > $action['SORT'] && $tempAction['PRIORITY'] < $action['PRIORITY'] && $cs == 'Y')) {
                            $arFilter = false;
                            break 3;
                        }
                    }
                }
            }
        }

        if ($arFilter !== false && $arFilter != $arPredFilter) {
            if (!isset($arFilter['=XML_ID'])) {
                /**
                 * Делаем запрос по каждому из фильтров, т.к. один фильтр не получится сделать из-за противоречий условий каждой скидки
                 */
                $res = \CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
                while ($ob = $res->GetNextElement()) {
                    $arFields = $ob->GetFields();
                    $poductsArray['IDS'][] = $arFields["ID"];
                }
            } elseif (!empty($arFilter['=XML_ID'])) {
                /**
                 * Подготавливаем массив для отдельного запроса
                 */
                $dopArFilter['=XML_ID'] = array_unique(array_merge($arFilter['=XML_ID'], $dopArFilter['=XML_ID']));
            }
        }
    }

    if (isset($dopArFilter) && !empty($dopArFilter['=XML_ID'])) {
        /**
         * Делаем отдельный запрос по конкретным XML_ID
         */
        $res = \CIBlockElement::GetList(array(), $dopArFilter, false, array("nTopCount" => count($dopArFilter['=XML_ID'])), $arSelect);
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $poductsArray['IDS'][] = $arFields["ID"];
        }
    }

    return array_unique($poductsArray['IDS']);
}

?>
