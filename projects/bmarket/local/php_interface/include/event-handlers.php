<?php
/**
 * Вырезать системные скрипты Bitrix
 *
 * Отключено для композита
 */
//AddEventHandler("main", "OnEndBufferContent", "deleteKernelJs");
function deleteKernelJs(&$content)
{
    global $USER, $APPLICATION;
    if ($USER->IsAdmin() || (is_object($USER) && $USER->IsAuthorized()) || strpos($APPLICATION->GetCurDir(), "/bitrix/") !== false) return;
    if ($APPLICATION->GetProperty("save_kernel") == "Y") return;

    $arPatternsToRemove = Array(
        '/<script.+?src=".+?kernel_main\/kernel_main_v1\.js\?\d+"><\/script\>/',
        '/<script.+?src=".+?loadext\/loadext.min\.js\?\d+"><\/script\>/',
        '/<script.+?src=".+?kernel_main_polyfill_promise\/kernel_main_polyfill_promise_v1\.js\?\d+"><\/script\>/',
        '/<script.+?src=".+?loadext\/extension.min\.js\?\d+"><\/script\>/',
        '/<script.+?src=".+?bitrix\/js\/main\/core\/core[^"]+"><\/script\>/',
        '/<script.+?>BX\.(setCSSList|setJSList)\(\[.+?\]\).*?<\/script>/',
        '/<script.+?>if\(\!window\.BX\)window\.BX.+?<\/script>/',
        '/<script[^>]+?>\(window\.BX\|\|top\.BX\)\.message[^<]+<\/script>/',
    );

    $content = preg_replace($arPatternsToRemove, "", $content);
    $content = preg_replace("/\n{2,}/", "\n\n", $content);
}

/**
 * Вырезать системные стили Bitrix
 */
AddEventHandler("main", "OnEndBufferContent", "deleteKernelCss");
function deleteKernelCss(&$content)
{
    global $USER, $APPLICATION;
    if ((is_object($USER) && $USER->IsAuthorized()) || strpos($APPLICATION->GetCurDir(), "/bitrix/") !== false) return;
    if ($APPLICATION->GetProperty("save_kernel") == "Y") return;

    $arPatternsToRemove = Array(
        '/<link.+?href=".+?kernel_main\/kernel_main_v1\.css\?\d+"[^>]+>/',
        '/<link.+?href=".+?bitrix\/js\/main\/core\/css\/core[^"]+"[^>]+>/',
        '/<link.+?href=".+?bitrix\/templates\/[\w\d_-]+\/styles.css[^"]+"[^>]+>/',
        '/<link.+?href=".+?bitrix\/templates\/[\w\d_-]+\/template_styles.css[^"]+"[^>]+>/',
    );

    $content = preg_replace($arPatternsToRemove, "", $content);
    $content = preg_replace("/\n{2,}/", "\n\n", $content);
}

/**
 * Добавление внутренего счёта при регистрации пользователя
 */
AddEventHandler("main", "OnAfterUserAdd", "AddUserLoyaltyCard");
function AddUserLoyaltyCard($userData)
{
    $user = CUser::GetByLogin($userData["LOGIN"])->Fetch();
    (new XmlParserHandler())->updateLoyaltyCards($user);
}
AddEventHandler("sale", "OnSaleOrderSaved", "AddPropExternalPayment");
function AddPropExternalPayment()
{
  global $USER;
    $orderData = \Bitrix\Sale\Order::getList([
  'select' => ['ID','SUM_PAID'],
  'filter' => ['=USER_ID' => $USER->GetID()],
  'order' => ['ID' => 'DESC'],
  'limit' => 1
]);
if ($order = $orderData->fetch())
{
    $lastOrderId=$order['ID'];
  $sum_paid=$order['SUM_PAID'];
}

if ($sum_paid>0){
	if (CModule::IncludeModule('sale')) {
		if ($arOrderProps = CSaleOrderProps::GetByID(24)) {
			$db_vals = CSaleOrderPropsValue::GetList(array(), array('ORDER_ID' => $lastOrderId, 'ORDER_PROPS_ID' => $arOrderProps['ID']));
			if ($arVals = $db_vals->Fetch()) {
				CSaleOrderPropsValue::Update($arVals['ID'], array(
					'NAME' => $arVals['NAME'],
					'CODE' => $arVals['CODE'],
					'ORDER_PROPS_ID' => $arVals['ORDER_PROPS_ID'],
					'ORDER_ID' => $arVals['ORDER_ID'],
					'VALUE' => 'Y',
				));
			} else {
				CSaleOrderPropsValue::Add(array(
					'NAME' => $arOrderProps['NAME'],
					'CODE' => $arOrderProps['CODE'],
					'ORDER_PROPS_ID' => $arOrderProps['ID'],
					'ORDER_ID' => $lastOrderId,
					'VALUE' => 'Y',
				));
			}
		}
	}
}

}
