<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
$APPLICATION->SetPageProperty("title", "Заказ детально");
global $USER;

if (!$USER->IsAuthorized())
  LocalRedirect('/');

$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();

$orderId = explode('?', $_REQUEST["ORDER_ID"]);
$orderId = $orderId[0];

if (!$orderId)
  LocalRedirect('/personal/');

$currentLink = '/personal/';

$orderData = CSaleOrder::GetByID($orderId);

if (!$orderData || $orderData['USER_ID'] != $arUser['ID'])
  show404Page();
?>
  <div class="page page--lk-orders">
    <div class="container">

      <!-- Add breadcrumb -->
      <? $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        ".default",
        array()
      ); ?>

      <div class="page__title title">
        <h1 class="seo-title">
          <? $APPLICATION->ShowTitle(false); ?>
        </h1>
      </div>

      <div class="lk-sides">

        <!-- include left side bar -->
        <? include($_SERVER["DOCUMENT_ROOT"] . "/personal/parts/lk-links.php"); ?>

        <div class="lk-content">
          <?
          $arDetParams = array(
            "PATH_TO_LIST" => $arResult["PATH_TO_LIST"],
            "PATH_TO_CANCEL" => '/personal/order/cancel/#ID#/',
            "PATH_TO_COPY" => $arResult["PATH_TO_LIST"] . '?COPY_ORDER=Y&ID=#ID#',
            "PATH_TO_PAYMENT" => '/personal/order/payment/',
            "SET_TITLE" => 'N',
            "ID" => $orderId,
            "ACTIVE_DATE_FORMAT" => 'd.m.y',
            "ALLOW_INNER" => 'Y',
            "ONLY_INNER_FULL" => 'N',
            "CACHE_TYPE" => 'A',
            "CACHE_TIME" => 3600,
            "CACHE_GROUPS" => 'Y',
            "DISALLOW_CANCEL" => 'N',
            "RESTRICT_CHANGE_PAYSYSTEM" => $arParams["RESTRICT_CHANGE_PAYSYSTEM"],
            "REFRESH_PRICES" => $arParams["REFRESH_PRICES"],
            "CUSTOM_SELECT_PROPS" => $arParams["CUSTOM_SELECT_PROPS"],
            "HIDE_USER_INFO" => $arParams["DETAIL_HIDE_USER_INFO"]
          );

          $APPLICATION->IncludeComponent(
            "bitrix:sale.personal.order.detail",
            "",
            $arDetParams,
            false
          );
          ?>
        </div>
      </div>
    </div>

    <!-- Подключение блока bullets из parts -->
    <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>

  </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
