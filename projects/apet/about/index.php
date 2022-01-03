<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "В августе 2016 года в г. Краснодар был открыт первый зоомагазин федеральной розничной сети Globalvet - ВЕТЛАВКА. Работает интернет магазин в Москве, доставка осуществляется по Москве и московской области.");
$APPLICATION->SetPageProperty("keywords", "о магазине, о компании,");
$APPLICATION->SetTitle("О нашем магазине");
$APPLICATION->SetPageProperty("title", "О нашем зоомагазине — «Ветлавка»");
?>

  <div class="page page--about">
    <div class="container">

      <!-- Add breadcrumb -->
      <? $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        ".default",
        array()
      );
      ?>

      <!-- Add content for page about -->
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
          "PATH" => "/about/content/about_text.php"
        )
      );
      ?>

    </div>

    <!-- Подключение блока bullets из parts -->
    <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>
  </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
