<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
global $USER;

if (!$USER->IsAuthorized())
    LocalRedirect('/auth/');

$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();

$orderId = explode('?', $_REQUEST["ORDER_ID"]);
$orderId = trim($orderId[0]);

if (!$orderId)
    LocalRedirect('/personal/');


/**
 * Проверка на существование заказа и принадлежность текущему пользователю
 */
$orderData = CSaleOrder::GetByID($orderId);
if (!$orderData || $orderData['USER_ID'] != $arUser['ID'])
    show404Page();
?>
<div class="page page--lk">
    <div class="section-header container">
        <div class="title">
            <?= $APPLICATION->ShowTitle(false) ?>
        </div>
    </div>

    <? include($_SERVER['DOCUMENT_ROOT'] . '/personal/includes/menu.php') ?>

    <?
    $arDetParams = array(
        "PATH_TO_LIST" => '/personal/order/',
        "PATH_TO_CANCEL" => '/personal/order/cancel/#ID#/',
        "PATH_TO_COPY" => '/personal/order/?COPY_ORDER=Y&ID=#ID#',
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
    );

    $APPLICATION->IncludeComponent(
        "bitrix:sale.personal.order.detail",
        "",
        $arDetParams,
        false
    );
    ?>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
