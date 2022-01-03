<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Политика конфиденциальности зоомагазина ООО «ВЕТЛАВКА» является юридическим лицом, зарегистрированным в соответствии с действующим законодательством РФ.");
$APPLICATION->SetPageProperty("keywords", "Политика конфиденциальности,");
$APPLICATION->SetTitle("Политика конфиденциальности");
$APPLICATION->SetPageProperty("title", "Политика конфиденциальности зоомагазина — «Ветлавка»");
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
          "PATH" => "/politic/content/politic_text.php"
        )
      );
      ?>

      <!-- Подключение блока bullets из parts -->
      <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>

    </div>
  </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
