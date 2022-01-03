<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Обработка персональных данных осуществляется нами на законной и справедливой основе, действуя разумно и добросовестно и на основе принципов.");
$APPLICATION->SetPageProperty("keywords", "Политика конфиденциальности,");
$APPLICATION->SetPageProperty("title", "Политика конфиденциальности | Печальке.net");
$APPLICATION->SetTitle("Политика конфиденциальности");
$APPLICATION->SetPageProperty('body-css-class', 'body--white');
?>
<div class="page page--privacy-policy">
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

    <div class="article container">
        <div class="article__main">
            <div class="text-typography">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    ".default",
                    array(
                        "AREA_FILE_SHOW" => "sect",
                        "AREA_FILE_SUFFIX" => "page_description_inc",
                        "EDIT_TEMPLATE" => "text",
                        "PATH" => "",
                        "AREA_FILE_RECURSIVE" => "Y"
                    ),
                    false
                ); ?>
            </div>
        </div>
    </div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
