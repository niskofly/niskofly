<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetPageProperty("keywords", "интернет-зоомагазин, ветлавка, товары для животных, зоотовары, глобалВет,");
$APPLICATION->SetPageProperty("description", "Интернет - зоомагазин «Ветлавка» входит в состав группы компаний Globalvet. В нашем ассортименте вы найдете все необходимое для вашего питомца!");
$APPLICATION->SetTitle("Главная");
$APPLICATION->SetPageProperty("title", "Ветлавка | Интернет-зоомагазин товаров для домашних животных | ГлобалВет");
?>

<div class="page page--home">
  <!-- Top block side -->
  <div class="hero">
    <?
    /* Include sliders */
    include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/pages/home/sliders.php");
    ?>

    <?
    /* Include brands */
    include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/pages/home/brands.php");
    ?>
  </div>


  <?
  /* Include brands */
  include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/pages/home/populars-products.php");
  ?>


  <?
  /* Include dry food products info: Временно скрыто */
  //include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/pages/home/food-products.php");
  ?>


  <?
  /* Include catalogs */
  include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/pages/home/catalogs.php");
  ?>


  <?
  /* Include The best products */
  include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/pages/home/best-products.php");
  ?>


  <?
  /* Include help selection */
  // include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/pages/home/help-selection.php");
  ?>


  <?
  /* Include blog info: Временно скрыто */
  //include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/pages/home/blog.php");
  ?>


  <!-- Подключение блока bullets из parts -->
  <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>
</div>

<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>
