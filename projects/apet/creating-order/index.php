<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "как  сделать заказ, как заказать,");
$APPLICATION->SetPageProperty("description", "Информация как оформить заказ в зоомагазине с доставкой — «Ветлавка».");
$APPLICATION->SetTitle("Как сделать заказ");
$APPLICATION->SetPageProperty("title", "Как сделать заказ в зоомагазине «Ветлавка»");
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

      <!-- Add content for page creating-order -->
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
          "PATH" => "/creating-order/content/creating-order_text.php"
        )
      );
      ?>

    </div>

    <!-- Подключение блока bullets из parts -->
    <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>
  </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
