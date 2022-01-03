<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Условия доставки и оплаты заказов в зоомагазине «Ветлавка». Вы можете самостоятельно сделать заказ на сайте в любое удобное для вас время. Либо заказать товар по телефону: 8-495-777-54-90.");
$APPLICATION->SetPageProperty("keywords", "Доставка и оплата,");
$APPLICATION->SetTitle("Доставка и оплата");
$APPLICATION->SetPageProperty("title", "Доставка и оплата в зоомагазине — «Ветлавка»");
?>

  <div class="page page--text-page">
    <div class="container">

      <!-- Add breadcrumb -->
      <? $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        ".default",
        array()
      );
      ?>

      <!-- Add content for page delivery-and-payment -->
      <?
      $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        ".default",
        array(
          "AREA_FILE_SHOW" => "file",
          "COMPONENT_TEMPLATE" => ".default",
          "COMPOSITE_FRAME_MODE" => "A",
          "COMPOSITE_FRAME_TYPE" => "AUTO",
          "EDIT_TEMPLATE" => "",
          "PATH" => "/delivery-and-payment/content/delivery-and-payment_text.php"
        )
      );
      ?>

    </div>

    <!-- Подключение блока bullets из parts -->
    <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>
  </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
