<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Информация по сотрудничеству с магазином «Ветлавка»");
$APPLICATION->SetPageProperty("keywords", "Сотрудничество,");
$APPLICATION->SetTitle("Сотрудничество");
$APPLICATION->SetPageProperty("title", "Сотрудничество с зоомагазином — «Ветлавка»");
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
          "PATH" => "/cooperation/content/cooperation_text.php"
        )
      );
      ?>

    </div>

    <!-- Подключение блока bullets из parts -->
    <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>
  </div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
