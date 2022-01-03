<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Адреса магазинов печальке.net, телефон, график работы, карта.");
$APPLICATION->SetPageProperty("keywords", "контакты, телефон, адрес,");
$APPLICATION->SetPageProperty("title", "Контакты - адреса магазинов печальке.net");
$APPLICATION->SetTitle("Контакты");

$stores = [];
$storesRequest = CCatalogStore::GetList(
    ['SORT' => 'DESC'],
    ['ACTIVE' => 'Y', 'ISSUING_CENTER' => 'Y'],
    false,
    false,
    ["*"]
);
while ($store = $storesRequest->Fetch())
    $stores[] = [
        'ID' => $store['ID'],
        'ADDRESS' => $store['ADDRESS'],
        'SCHEDULE' => $store['SCHEDULE'],
        'COORDINATES' => implode(',', [$store['GPS_N'], $store['GPS_S']])
    ];

?>
<div class="page page--contacts">
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

    <? if (!empty($stores)): ?>
        <div class="section-addresses container">
            <h2 class="title title--small section-addresses__title">Адреса магазинов «Печальке.net»</h2>
            <div class="section-addresses__list">
                <? foreach ($stores as $store) { ?>
                    <div class="section-addresses__card">
                        <div class="section-addresses__card-details">
                            <div class="section-addresses__card-point">
                                <img src="/img/icons/map.svg" class="icon">
                                <?= $store['ADDRESS'] ?>
                            </div>
                            <? if (trim($store['SCHEDULE'])): ?>
                                <div class="section-addresses__card-time">
                                    <?= $store['SCHEDULE'] ?>
                                </div>
                            <? endif; ?>
                        </div>
                        <div class="section-addresses__card-map js-simple-map"
                             id="js-simple-map-<?= $store['ID'] ?>"
                             data-icon="islands#redShoppingIcon"
                             data-coordinates="<?= $store['COORDINATES'] ?>">
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    <? endif; ?>

    <div class="section-contacts container">
        <div class="section-contacts__person">
            <? $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                ".default",
                Array(
                    "AREA_FILE_SHOW" => "file",
                    "COMPONENT_TEMPLATE" => ".default",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO",
                    "EDIT_TEMPLATE" => "",
                    "PATH" => "/includes/contacts/bank-details.php"
                )
            ); ?>
        </div>
        <div class="section-contacts__point">
            <div class="section-contacts__title">
                Офис
            </div>
            <div class="section-contacts__point-text">
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
            </div>
        </div>
        <div class="section-contacts__feedbacks">
            <div class="section-contacts__feedback">
                <div class="section-contacts__title">
                    Телефон
                </div>
                <div class="section-contacts__feedback-content">
                    <? if ($contactPhone = SiteInfo::getItem('contactPhone')): ?>
                        <a href="tel:<?= SiteInfo::getClearPhone($contactPhone) ?>"
                           class="section-contacts__feedback-contact">
                            <?= $contactPhone ?>
                        </a>
                    <? endif; ?>

                    <div class="social-links">
                        <? if ($viber = SiteInfo::getItem('viber')): ?>
                            <a href="<?= $viber ?>" target="_blank" class="social-links__link">
                                <img src="/img/icons/viber.svg" class="social-links__link-icon"/>
                            </a>
                        <? endif; ?>

                        <? if ($wathsap = SiteInfo::getItem('wathsap')): ?>
                            <a href="<?= $wathsap ?>" target="" class="social-links__link">
                                <img src="/img/icons/wathsap.svg" class="social-links__link-icon"/>
                            </a>
                        <? endif; ?>
                    </div>
                </div>
            </div>

            <? if ($orderEmail = SiteInfo::getItem('orderEmail')): ?>
                <div class="section-contacts__feedback">
                    <div class="section-contacts__title">
                        Эл. почта
                    </div>
                    <a href="mailto:<?= $orderEmail ?>"
                       class="section-contacts__feedback-contact">
                        <?= $orderEmail ?>
                    </a>
                </div>
            <? endif; ?>
        </div>
    </div>
</div>
<script src="<?= YANDEX_MAP_SRC ?>"></script>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
