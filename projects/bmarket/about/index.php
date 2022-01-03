<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Уникальные сладости и напитки со всего мира, которые не производятся в России и их не найдёшь на полках обычных магазинов.");
$APPLICATION->SetPageProperty("keywords", "о нас,");
$APPLICATION->SetPageProperty("title", "О нас - интернет-магазин печальке.net");
$APPLICATION->SetTitle("О нас");
?>
<div class="page page--about">
    <? $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        ".default",
        Array()
    ); ?>
    <div class="article container">
        <div class="article__main">
            <div class="title article__title">
                <h1 class="seo-title">
                    <?= $APPLICATION->ShowTitle(false) ?>
                </h1>
            </div>
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
        <div class="article__sidebar">
            <ul class="nav nav--sidebar">
                <li class="nav__item">
                    <a href="/delivery-payment/"
                       title="Доставка и оплата"
                       class="nav__link">
                        Доставка и оплата
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/refund-exchange/"
                       title="Возврат и обмен"
                       class="nav__link">
                        Возврат и обмен
                    </a>
                </li>
                <li class="nav__item">
                    <a href="/contacts/"
                       title="Контакты"
                       class="nav__link">
                        Контакты
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
