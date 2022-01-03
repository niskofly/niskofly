<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Хотите пробудить живые эмоции ваших друзей, родственников, любимых. Загляните к нам. Мы продаем оригинальные подарки и необычные сладости на все случаи жизни, праздники и юбилеи.");
$APPLICATION->SetPageProperty("keywords", "Печальке, подарки, сюрпризы, вкусные сладости, приколы,");
$APPLICATION->SetPageProperty("title", "Печальке.net - оригинальные подарки и необычные сладости на все случаи жизни");
$APPLICATION->SetTitle("Печальке.net");
?>
<div class="page page--home">
    <? $APPLICATION->IncludeComponent(
        "bitrix:advertising.banner",
        "slider",
        Array(
            "CACHE_TIME" => "0",
            "CACHE_TYPE" => "A",
            "COMPONENT_TEMPLATE" => "slider",
            "NOINDEX" => "Y",
            "QUANTITY" => "10",
            "TYPE" => "home_general"
        )
    ); ?>

    <? $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        ".default",
        Array(
            "AREA_FILE_SHOW" => "file",
            "COMPONENT_TEMPLATE" => ".default",
            "COMPOSITE_FRAME_MODE" => "A",
            "COMPOSITE_FRAME_TYPE" => "AUTO",
            "EDIT_TEMPLATE" => "",
            "PATH" => "/includes/home/notes.php"
        )
    ); ?>

    <div class="section-collections container">
        <div class="collections">
            <? $APPLICATION->IncludeComponent(
                "bitrix:advertising.banner",
                ".default",
                Array(
                    "CACHE_TIME" => "0",
                    "CACHE_TYPE" => "A",
                    "COMPONENT_TEMPLATE" => ".default",
                    "NOINDEX" => "Y",
                    "QUANTITY" => "1",
                    "TYPE" => "home_header_full"
                )
            ); ?>

            <? $APPLICATION->IncludeComponent(
                "bitrix:advertising.banner",
                ".default",
                Array(
                    "CACHE_TIME" => "0",
                    "CACHE_TYPE" => "A",
                    "COMPONENT_TEMPLATE" => ".default",
                    "NOINDEX" => "Y",
                    "QUANTITY" => "1",
                    "TYPE" => "home_header_left_half"
                )
            ); ?>

            <? $APPLICATION->IncludeComponent(
                "bitrix:advertising.banner",
                ".default",
                Array(
                    "CACHE_TIME" => "0",
                    "CACHE_TYPE" => "A",
                    "COMPONENT_TEMPLATE" => ".default",
                    "NOINDEX" => "Y",
                    "QUANTITY" => "1",
                    "TYPE" => "home_header_right_half"
                )
            ); ?>
        </div>
    </div>

    <?
    global $SELECTIONS_FILTER;
    $SELECTIONS_FILTER = ['PROPERTY_SHOW_ON_HOME_PAGE_VALUE' => 'Да'];

    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "selections",
        array(
            "COMPONENT_TEMPLATE" => ".default",
            "IBLOCK_TYPE" => "1c_catalog",
            "IBLOCK_ID" => "7",
            "NEWS_COUNT" => "20",
            "SORT_BY1" => "ACTIVE_FROM",
            "SORT_ORDER1" => "DESC",
            "SORT_BY2" => "SORT",
            "SORT_ORDER2" => "ASC",
            "FILTER_NAME" => "SELECTIONS_FILTER",
            "FIELD_CODE" => array(
                0 => "",
                1 => "",
            ),
            "PROPERTY_CODE" => array(
                0 => "PRODUCTS",
                1 => "",
            ),
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "N",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "PREVIEW_TRUNCATE_LEN" => "",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "SET_TITLE" => "N",
            "SET_BROWSER_TITLE" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_LAST_MODIFIED" => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
            "HIDE_LINK_WHEN_NO_DETAIL" => "N",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "INCLUDE_SUBSECTIONS" => "N",
            "STRICT_SECTION_CHECK" => "N",
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "N",
            "PAGER_TEMPLATE" => ".default",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "PAGER_TITLE" => "Новости",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "SET_STATUS_404" => "N",
            "SHOW_404" => "N",
            "MESSAGE_404" => ""
        ),
        false
    ); ?>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
