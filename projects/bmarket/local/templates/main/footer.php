<footer class="footer">
    <div class="footer__top">
        <div class="container footer__container">
            <a href="/" class="logo footer__logo">
                <img src="/img/logo.png" alt="Бубльгум"/>
            </a>

            <div class="footer__contacts">
                <div class="footer__contacts-title">Адреса магазинов в Череповце</div>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    ".default",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "COMPONENT_TEMPLATE" => ".default",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/includes/footer/addresses.php"
                    )
                ); ?>
            </div>

            <div class="footer__navigation">
                <?
                $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "footer-column",
                    array(
                        "COMPONENT_TEMPLATE" => "footer-column",
                        "MAX_LEVEL" => "1",
                        "ROOT_MENU_TYPE" => "footer-left",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(),
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N"
                    ),
                    false
                );
                ?>

                <?
                $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "footer-column",
                    array(
                        "COMPONENT_TEMPLATE" => "footer-column",
                        "MAX_LEVEL" => "1",
                        "ROOT_MENU_TYPE" => "footer-right",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(),
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N"
                    ),
                    false
                );
                ?>
            </div>
            <div class="footer__feedback">
                <div class="footer__feedback-section">
                    <div class="footer__feedback-contact">/bubblegum_che</div>
                    <div class="social-links social-links--footer">
                        <? if ($vk = SiteInfo::getItem('vk')): ?>
                            <a href="<?= $vk ?>" class="social-links__link" target="_blank">
                                <img src="/img/icons/vk.svg" class="social-links__link-icon"/>
                            </a>
                        <? endif; ?>

                        <? if ($instagram = SiteInfo::getItem('instagram')): ?>
                            <a href="<?= $instagram ?>" class="social-links__link" target="_blank">
                                <img src="/img/icons/instagram.svg" class="social-links__link-icon"/>
                            </a>
                        <? endif; ?>
                    </div>
                </div>

                <div class="footer__feedback-section">
                    <? if ($phone = SiteInfo::getItem('phone')): ?>
                        <a href="tel:<?= SiteInfo::getClearPhone($phone) ?>" class="footer__feedback-contact">
                            <?= $phone ?>
                        </a>
                    <? endif; ?>
                    <div class="social-links social-links--footer">
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
        </div>
    </div>

    <div class="footer__bottom">
        <div class="container footer__container">
            <div class="footer__info footer__info--bottom">
                <div class="footer__info-text">
                    © <?= date('Y') ?> «Печальке.net»
                </div>
                <?
                $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "bottom",
                    array(
                        "COMPONENT_TEMPLATE" => "bottom",
                        "MAX_LEVEL" => "1",
                        "ROOT_MENU_TYPE" => "bottom",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(),
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N"
                    ),
                    false
                );
                ?>
            </div>

            <a href="https://wbest.ru/?utm_source=site-client&utm_medium=banner&utm_campaign=wbest&utm_content=bubblegum.market"
               class="footer__dev">
                <span class="footer__dev-label">Сделано в</span>
                <img src="/img/icons/webest.svg" alt="webest" class="footer__dev-logo"/>
            </a>
        </div>
    </div>
</footer>
<?
global $ASSETS_VERSION;

include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/modals.php");

/**
 * Lazy load images
 */
include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/lazy-load-script.php");
?>

<script src="<?= SITE_TEMPLATE_PATH ?>/js/app.min.js?ver=<?= $ASSETS_VERSION ?>"></script>

<?
include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/scripts.php");

/**
 * Подключение метрик сайта
 */
include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/metrics.php");
?>

<? if ($APPLICATION->GetCurPage(false) === '/'): ?>
    <script>
        VkSendProductEvent(window.vkPriceId, 'view_home')
    </script>
<? endif; ?>
</body>
</html>
