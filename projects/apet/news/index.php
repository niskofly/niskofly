<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Свежие новости интернет-магазина «Ветлавка», сеть зоомагазинов осуществляет продажу товаров для животных.");
$APPLICATION->SetPageProperty("keywords", "новости,");
$APPLICATION->SetTitle("Новости компании");
$APPLICATION->SetPageProperty("title", "Свежие новости зоомагазина — «Ветлавка»");
?>

<div class="page page--news-list">
  <div class="container">
    <!-- Add breadcrumb -->
    <? $APPLICATION->IncludeComponent(
      "bitrix:breadcrumb",
      ".default",
      array()
    );
    ?>

    <!-- Restriction contents on site -->
    <?
    getFilterRestrictionSite();
    ?>

    <!-- Output content in news page -->
    <? $APPLICATION->IncludeComponent(
      "bitrix:news",
      "news",
      array(
        "COMPONENT_TEMPLATE" => "news",
        "IBLOCK_ID" => NEWS_ID,
        "IBLOCK_TYPE" => "news",
        "NEWS_COUNT" => "14",
        "USE_SEARCH" => "N",
        "USE_RSS" => "N",
        "USE_RATING" => "N",
        "USE_CATEGORIES" => "N",
        "USE_REVIEW" => "N",
        "USE_FILTER" => "Y",
        "FILTER_NAME" => "arrFilter",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "SORT",
        "SORT_ORDER2" => "ASC",
        "CHECK_DATES" => "Y",
        "SEF_MODE" => "Y",
        "SEF_FOLDER" => "/news/",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "Y",
        "SET_LAST_MODIFIED" => "Y",
        "SET_TITLE" => "Y",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "Y",
        "ADD_ELEMENT_CHAIN" => "Y",
        "USE_PERMISSIONS" => "N",
        "STRICT_SECTION_CHECK" => "Y",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "USE_SHARE" => "N",
        "PREVIEW_TRUNCATE_LEN" => "",
        "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "LIST_FIELD_CODE" => array(
          0 => "",
          1 => "",
        ),
        "LIST_PROPERTY_CODE" => array(
          0 => "",
          1 => "MAXIMUM_PRODUCTIVITY",
          2 => "MAXIMUM_MIXTURE_PRESSURE",
          3 => "SITE_RESTRICTION",
        ),
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "DISPLAY_NAME" => "Y",
        "META_KEYWORDS" => "-",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "-",
        "DETAIL_SET_CANONICAL_URL" => "N",
        "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
        "DETAIL_FIELD_CODE" => array(
          0 => "",
          1 => "",
        ),
        "DETAIL_PROPERTY_CODE" => array(
          0 => "",
          1 => "MAXIMUM_PRODUCTIVITY",
          2 => "MAXIMUM_MIXTURE_PRESSURE",
          3 => "ENGINE_POWER",
          4 => "BASIC_DESCRIPTION",
          5 => "MORE_PHOTO",
          6 => "SITE_RESTRICTION",
        ),
        "DETAIL_DISPLAY_TOP_PAGER" => "N",
        "DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
        "DETAIL_PAGER_TITLE" => "Страница",
        "DETAIL_PAGER_TEMPLATE" => "",
        "DETAIL_PAGER_SHOW_ALL" => "N",
        "PAGER_TEMPLATE" => ".default",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "Каталог",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "SET_STATUS_404" => "N",
        "SHOW_404" => "Y",
        "FILE_404" => "",
        "SEF_URL_TEMPLATES" => array(
          "news" => "",
          "section" => "",
          "detail" => "#ELEMENT_CODE#/",
        )
      ),
      false
    );
    ?>
  </div>
  <!-- Подключение блока bullets из parts -->
  <? include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/all-pages/footer-bullets.php") ?>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
