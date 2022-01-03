<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Действующие акции в интернет-магазине печальке.net.");
$APPLICATION->SetPageProperty("keywords", "Акции,");
$APPLICATION->SetPageProperty("title", "Акции в интернет-магазине печальке.net");
$APPLICATION->SetTitle("Акции");
?>
<div class="page page--stocks">
    <? $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        ".default",
        Array()
    ); ?>

    <div class="section-header container">
        <div class="title">
            <h1 class="seo-title">
                <?= $APPLICATION->ShowTitle(false) ?>
            </h1>
        </div>
    </div>

    <? $APPLICATION->IncludeComponent(
        "bitrix:news",
        "promo",
        array(
            "COMPONENT_TEMPLATE" => "promo",
            "IBLOCK_TYPE" => "1c_catalog",
            "IBLOCK_ID" => "8",
            "NEWS_COUNT" => "20",
            "USE_SEARCH" => "N",
            "USE_RSS" => "N",
            "USE_RATING" => "N",
            "USE_CATEGORIES" => "N",
            "USE_REVIEW" => "N",
            "USE_FILTER" => "N",
            "SORT_BY1" => "ACTIVE_FROM",
            "SORT_ORDER1" => "DESC",
            "SORT_BY2" => "SORT",
            "SORT_ORDER2" => "ASC",
            "CHECK_DATES" => "Y",
            "SEF_MODE" => "Y",
            "SEF_FOLDER" => "/promo/",
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
            "ADD_SECTIONS_CHAIN" => "N",
            "ADD_ELEMENT_CHAIN" => "Y",
            "USE_PERMISSIONS" => "N",
            "STRICT_SECTION_CHECK" => "N",
            "DISPLAY_DATE" => "N",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "N",
            "USE_SHARE" => "N",
            "PREVIEW_TRUNCATE_LEN" => "",
            "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
            "LIST_FIELD_CODE" => array(
                0 => "",
                1 => "",
            ),
            "LIST_PROPERTY_CODE" => array(
                0 => "",
                1 => "",
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
                1 => "",
            ),
            "DETAIL_DISPLAY_TOP_PAGER" => "N",
            "DETAIL_DISPLAY_BOTTOM_PAGER" => "N",
            "DETAIL_PAGER_TITLE" => "Страница",
            "DETAIL_PAGER_TEMPLATE" => "",
            "DETAIL_PAGER_SHOW_ALL" => "N",
            "PAGER_TEMPLATE" => ".default",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "Y",
            "PAGER_TITLE" => "Новости",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "SET_STATUS_404" => "Y",
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
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
