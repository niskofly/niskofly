<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Условия доставки и оплаты в магазине печальке.net");
$APPLICATION->SetPageProperty("keywords", "доставка, оплата,");
$APPLICATION->SetPageProperty("title", "Доставка и оплата в магазине печальке.net");
$APPLICATION->SetTitle("Доставка и оплата");
$APPLICATION->SetPageProperty('body-css-class', 'body--white');
?>
<div class="page page--delivery-payment">
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

    <div class="container">
        <div class="purple-sections">
            <div class="purple-section">
                <div class="text-typography">
                    <h3>
                        Банковской картой
                    </h3>
                    <p>
                        Для выбора оплаты товара с помощью банковской карты на соответствующей странице необходимо
                        нажать кнопку Оплатить банковской картой. Оплата происходит через ПАО СБЕРБАНК с использованием
                        банковских карт следующих платёжных систем:
                    </p>
                    <img src="/img/payments.png">
                </div>
            </div>
            <div class="purple-section">
                <div class="text-typography">
                    <h3>
                        Контакты
                    </h3>
                    <p>
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "COMPONENT_TEMPLATE" => ".default",
                                "COMPOSITE_FRAME_MODE" => "A",
                                "COMPOSITE_FRAME_TYPE" => "AUTO",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/includes/contacts/office.php"
                            )
                        ); ?>
                    </p>
                </div>

                <div class="link-icons">
                    <? if ($contactPhone = SiteInfo::getItem('contactPhone')): ?>
                        <a class="link-icon" href="tel:<?= SiteInfo::getClearPhone($contactPhone) ?>">
                            <span class="link-icon__image"><img src="/img/phone.svg"></span>
                            <span class="link-icon__text"><?= $contactPhone ?></span>
                        </a>
                    <? endif; ?>

                    <? if ($orderEmail = SiteInfo::getItem('orderEmail')): ?>
                        <a class="link-icon" href="mailto:<?= $orderEmail ?>">
                            <span class="link-icon__image"><img src="/img/mail.svg"></span>
                            <span class="link-icon__text"><?= $orderEmail ?></span>
                        </a>
                    <? endif; ?>
                </div>
            </div>
            <div class="purple-section">
                <div class="text-typography">
                    <h3>
                        Реквизиты
                    </h3>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "COMPONENT_TEMPLATE" => ".default",
                            "COMPOSITE_FRAME_MODE" => "A",
                            "COMPOSITE_FRAME_TYPE" => "AUTO",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/includes/delivery-payment/bank-details.php"
                        )
                    ); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="purple-section">
            <div class="text-typography">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    ".default",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "COMPONENT_TEMPLATE" => ".default",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/includes/delivery-payment/text.php"
                    )
                ); ?>
            </div>
        </div>

        <div class="purple-section">
            <div class="text-typography">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    ".default",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "COMPONENT_TEMPLATE" => ".default",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/includes/delivery-payment/text-2.php"
                    )
                ); ?>
            </div>
        </div>

        <div class="purple-section">
            <div class="text-typography">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    ".default",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "COMPONENT_TEMPLATE" => ".default",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/includes/delivery-payment/text-3.php"
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
