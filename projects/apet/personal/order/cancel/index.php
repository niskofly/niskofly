<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetPageProperty("title", "Отмена заказа");
$APPLICATION->SetTitle('Отмена заказа');

if (!$USER->IsAuthorized()) {
  LocalRedirect('/auth/');
}


$orderId = explode('?', $_REQUEST["ORDER_ID"]);
$orderId = $orderId[0];

if (!$orderId) {
  LocalRedirect('/personal/');
}

/**
 * Установка url для отображения активной ссылки в личном кабинете
 */
$currentLink = '/personal/';

/**
 * Проверка на существование заказа и принадлежность текущему пользователю
 */
global $USER;
$orderData = CSaleOrder::GetByID($orderId);
if (!$orderData || $orderData['USER_ID'] != $USER->GetID()) {
  show404Page();
}
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
          $APPLICATION->IncludeComponent(
            "bitrix:sale.personal.order.cancel",
            ".default",
            array(
              "PATH_TO_LIST" => "/personal/",
              "PATH_TO_DETAIL" => "/personal/order/detail/{\$orderId}/",
              "SET_TITLE" => "N",
              "ID" => $orderId,
            ),
            false
          );
          ?>
        </div>
      </div>
    </div>

    <!-- Подключение блока bullets из parts -->
    <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>

  </div>
<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>
