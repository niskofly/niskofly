<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

global $ASSETS_VERSION;
$ASSETS_VERSION = "1.0";

/**
 * Файл для указания версии assets
 */
if (file_exists($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/version-value.php"))
    include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/version-value.php");

global $USER;
?>
<!DOCTYPE html>
<html>
<head>
    <? $APPLICATION->ShowHead(); ?>
    <title><? $APPLICATION->ShowTitle(); ?></title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width"/>
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="yandex-verification" content="4671d55b949e95c7"/>
    <meta name="facebook-domain-verification" content="vf3wvbjipyfdblclhqxdgxouahp31p"/>

    <?
    /**
     * open graph
     */
    include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/open-graph.php");
    ?>
    <link type="image/x-icon" href="/img/favicon/favicon.ico" rel="shortcut icon"/>
    <link href="/img/favicon/apple-icon-114x114.png" rel="apple-touch-icon" sizes="114x114"/>
    <link href="/img/favicon/apple-icon-120x120.png" rel="apple-touch-icon" sizes="120x120"/>
    <link href="/img/favicon/apple-icon-144x144.png" rel="apple-touch-icon" sizes="144x144"/>
    <link href="/img/favicon/apple-icon-152x152.png" rel="apple-touch-icon" sizes="152x152"/>
    <link href="/img/favicon/apple-icon-180x180.png" rel="apple-touch-icon" sizes="180x180"/>
    <link type="image/png" href="/img/favicon/android-icon-192x192.png" rel="icon" sizes="192x192"/>
    <link type="image/png" href="/img/favicon/favicon-32x32.png" rel="icon" sizes="32x32"/>
    <link type="image/png" href="/img/favicon/favicon-96x96.png" rel="icon" sizes="96x96"/>
    <link type="image/png" href="/img/favicon/favicon-16x16.png" rel="icon" sizes="16x16"/>
    <link href="/img/favicon/manifest.json" rel="manifes"/>

    <link href="<?= SITE_TEMPLATE_PATH ?>/css/app.min.css?ver=<?= $ASSETS_VERSION ?>" rel="stylesheet" media="all"/>
    <script type="text/javascript">
        window.dataLayer = window.dataLayer || [];
        var _tmr = _tmr || [];
        function gtag(){dataLayer.push(arguments);}
    </script>

    <script>
        window.vkPriceId = 'VK-RTRG-532395-aXg6M'

        VkSendProductEvent = function () {
            var data = arguments
            var timerId = setInterval(function () {
                if (!window.pixelVk.ProductEvent)
                    return;

                window.pixelVk.ProductEvent(...data)
                clearInterval(timerId)
            }, 500)
        }

        VkAddRetargeting = function (id) {
            var timerId = setInterval(function () {
                if (!window.VK)
                    return;

                window.VK.Retargeting.Add(id);
                clearInterval(timerId)
            }, 500)
        }
    </script>
     <script type='application/ld+json'>
    {
      "@context": "http://www.schema.org",
      "@type": "WebSite",
      "name": "печальке.net",
      "alternateName": "Печальке.net - оригинальные подарки и необычные сладости",
      "url": "https://печальке.net"
    }
</script>
<script type='application/ld+json'>
	[ {
	"@context": "http://www.schema.org",
	"@type": "LocalBusiness",
	"name": "Печальке.net - оригинальные подарки и необычные сладости",
	"url": "https://печальке.net/",
	"logo": "https://печальке.net/img/logo.png",
	"image": "https://печальке.net/img/logo.png",
	"telephone" : [ "+7 921 685-29-70", "+7 (8202) 598-903" ],
	"description": "Печальке.net - интернет-магазин необычных подарков и сувениров для любимых друзей, родственников, знаковых и коллег. У нас вы найдете сувенир или сладкий подарок на любой праздник  ☎ Звоните: +7 921 685-29-70.",
	"priceRange": "50-100000RUB",
	"address": {
	"@type": "PostalAddress",
	"streetAddress": "ул. Ленинградская, 1, ТРЦ Северо-западный 1 этаж",
	"addressLocality": "Череповец",
	"addressRegion": "Вологодская область",
	"postalCode": "162626",
	"addressCountry": "Россия"
	},
	"aggregateRating" : {
	"@type" : "AggregateRating",
	"ratingValue" : "4.5",
	"ratingCount" : "4642"
	},
	"geo": {
	"@type": "GeoCoordinates",
	"latitude": "59.099688",
	"longitude": "37.913307"
	},
	"openingHours": "Mo, Tu, We, Th, Fr, Sa, Su 10:00-21:00",
	"contactPoint": {
	"@type": "ContactPoint",
	"telephone": "+7 921 685-29-70",
	"email" : "shop@печальке.net",
	"contactType": "customer service"
	}
}, {
"@context" : "http://schema.org",
  "@type": "LocalBusiness",
	"name": "Печальке.net - оригинальные подарки и необычные сладости",
	"url": "https://печальке.net/",
	"logo": "https://печальке.net/img/logo.png",
	"image": "https://печальке.net/img/logo.png",
	"telephone" : [ "+7 921 685-29-70", "+7 (8202) 598-903" ],
	"description": "Печальке.net - интернет-магазин необычных подарков и сувениров для любимых друзей, родственников, знаковых и коллег. У нас вы найдете сувенир или сладкий подарок на любой праздник  ☎ Звоните: +7 921 685-29-70",
	"priceRange": "50-100000RUB",
	"address": {
        "@type": "PostalAddress",
        "streetAddress": "ул. Горького, 32, ТДК Этажи, этаж 2, павильон № 75",
        "addressLocality": "Череповец",
        "addressRegion": "Вологодская область",
        "postalCode": "162614",
        "addressCountry": "Россия"
	},
	"aggregateRating" : {
        "@type" : "AggregateRating",
        "ratingValue" : "4.8",
        "ratingCount" : "7557"
	},
	"geo": {
        "@type": "GeoCoordinates",
        "latitude": "59.132925",
        "longitude": "37.923992"
	},
	"openingHours": "Mo, Tu, We, Th, Fr, Sa, Su 10:00-20:00",
	"contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+7 921 685-29-70",
        "email" : "shop@печальке.net",
        "contactType": "customer service"
	}
}]

</script>
</head>
<body class="body js-body <? $APPLICATION->ShowProperty('body-css-class') ?>">
<div id="panel">
    <? $APPLICATION->ShowPanel(); ?>
</div>
<?
/**
 * SVG ICONS
 */
include($_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/parts/svg-icons.php");
?>
<header class="header js-header">
    <div class="header__top">
        <div class="container header__container">
            <div class="header__info">
                <? if ($phone = SiteInfo::getItem('phone')): ?>
                    <a href="tel:<?= SiteInfo::getClearPhone($phone) ?>" class="header__info-item">
                        <?= $phone ?>
                    </a>
                <? endif; ?>

                <? if ($email = SiteInfo::getItem('email')): ?>
                    <a href="mailto:<?= $email ?>" class="header__info-item">
                        <?= $email ?>
                    </a>
                <? endif; ?>

                <div class="header__info-item">
                    <img src="/img/icons/box-2.svg"/>
                    <p>Доставка в любой город России</p>
                </div>
            </div>

            <?
            $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "header-top",
                array(
                    "COMPONENT_TEMPLATE" => "header-top",
                    "MAX_LEVEL" => "1",
                    "ROOT_MENU_TYPE" => "top",
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
    </div>

    <div class="header__mobile">
        <div class="container header__container">
            <button type="button" class="btn header__btn-burger js-toggle-burger-menu">
                <img src="/img/icons/menu1.svg" class="icon btn__icon-menu"/>
                <img src="/img/icons/close.svg" class="icon btn__icon-close"/>
            </button>
            <a href="/" class="logo header__logo">
                <img src="/img/logo.png" alt="Бубльгум"/>
            </a>
            <ul class="nav">
                <? include $_SERVER['DOCUMENT_ROOT'] . '/includes/header/small-basket.php' ?>
            </ul>
        </div>
    </div>

    <div class="header__bottom">
        <div class="header-collections js-header-collections">
            <? $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "selections",
                array(
                    "COMPONENT_TEMPLATE" => "selections",
                    "MAX_LEVEL" => "1",
                    "ROOT_MENU_TYPE" => "selections",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(),
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N"
                ),
                false
            ); ?>
        </div>

        <div class="header-catalog js-header-catalog">
            <? $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "header-catalog-categories",
                array(
                    "COMPONENT_TEMPLATE" => "header-catalog-categories",
                    "MAX_LEVEL" => "2",
                    "ROOT_MENU_TYPE" => "catalog-categories",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(),
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N"
                ),
                false
            ); ?>
        </div>

        <div class="header-menu js-header-menu">
            <div class="header-catalog-wrapper">

                <form action="/search/" method="get" class="form-search header__form-search">
                    <input type="text" name="q" class="input form-search__input js-header-mobile-search-input"/>
                    <button type="submit" class="btn form-search__submit"
                            onclick="fbq('track', 'Search', {search_string: $('.js-header-mobile-search-input').val(),});">
                        <svg class="icon icon-search ">
                            <use xlink:href="#search"></use>
                        </svg>
                        <span>Найти</span>
                    </button>
                </form>


                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "header-catalog-categories-mobile",
                    array(
                        "COMPONENT_TEMPLATE" => "header-catalog-categories",
                        "MAX_LEVEL" => "2",
                        "ROOT_MENU_TYPE" => "catalog-categories",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array(),
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N"
                    ),
                    false
                ); ?>

                <ul class="nav">
                    <li class="nav__item">
                        <button type="button" class="nav__link nav__link--user-menu js-toggle-header-collections">
                            <svg class="icon icon-copy ">
                                <use xlink:href="#copy"></use>
                            </svg>
                            <span>Подборки</span>
                        </button>
                    </li>

                    <? global $USER;
                    if ($USER->IsAuthorized()) {
                        $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "header-personal",
                            array(
                                "COMPONENT_TEMPLATE" => "header-personal",
                                "MAX_LEVEL" => "1",
                                "ROOT_MENU_TYPE" => "header-personal",
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
                    } else { ?>
                        <li class="nav__item">
                            <a href="/auth/" class="nav__link nav__link--user-menu">
                                <svg class="icon icon-user ">
                                    <use xlink:href="#user"></use>
                                </svg>
                                <span>Войти в аккаунт</span>
                            </a>
                        </li>
                    <? } ?>

                    <? include $_SERVER['DOCUMENT_ROOT'] . '/includes/header/favorites.php' ?>
                </ul>

                <div class="header__info">
                    <? if ($phone = SiteInfo::getItem('phone')): ?>
                        <a href="tel:<?= SiteInfo::getClearPhone($phone) ?>" class="header__info-item">
                            <?= $phone ?>
                        </a>
                    <? endif; ?>

                    <? if ($email = SiteInfo::getItem('email')): ?>
                        <a href="mailto:<?= $email ?>" class="header__info-item">
                            <?= $email ?>
                        </a>
                    <? endif; ?>

                    <div class="header__info-item">
                        <img src="/img/icons/box-2.svg"/>
                        <p>Доставка в любой город России</p>
                    </div>
                </div>


            </div>
        </div>

        <div class="container header__container">
            <div class="header__bottom-navigation">
                <a href="/" class="logo header__logo">
                    <img src="/img/logo.png" alt="Бубльгум"/>
                </a>

                <button type="button" class="btn header__btn-catalog js-toggle-header-catalog">
                    <img src="/img/icons/catalogue.svg" class="icon btn__icon-menu"/>
                    <img src="/img/icons/close.svg" class="icon btn__icon-close"/>
                    <span>Каталог</span>
                </button>

                <form action="/search/" method="get" class="form-search header__form-search">
                    <input type="text" name="q" class="input form-search__input js-header-search-input"/>
                    <button type="submit" class="btn form-search__submit"
                            onclick="fbq('track', 'Search', {search_string: $('.js-header-search-input').val(),});">
                        <svg class="icon icon-search ">
                            <use xlink:href="#search"></use>
                        </svg>
                        <span>Найти</span>
                    </button>
                </form>
            </div>

            <ul class="nav">
                <li class="nav__item">
                    <button type="button" class="nav__link nav__link--user-menu js-toggle-header-collections">
                        <svg class="icon icon-copy ">
                            <use xlink:href="#copy"></use>
                        </svg>
                        <span>Подборки</span>
                    </button>
                </li>

                <?
                global $USER;
                if ($USER->IsAuthorized()) {
                    $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "header-personal",
                        array(
                            "COMPONENT_TEMPLATE" => "header-personal",
                            "MAX_LEVEL" => "1",
                            "ROOT_MENU_TYPE" => "header-personal",
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
                } else { ?>
                    <li class="nav__item">
                        <a href="/auth/" class="nav__link nav__link--user-menu">
                            <svg class="icon icon-user ">
                                <use xlink:href="#user"></use>
                            </svg>
                            <span>Войти в аккаунт</span>
                        </a>
                    </li>
                <? } ?>

                <? include $_SERVER['DOCUMENT_ROOT'] . '/includes/header/favorites.php' ?>

                <? include $_SERVER['DOCUMENT_ROOT'] . '/includes/header/small-basket.php' ?>
            </ul>
        </div>
    </div>


</header>
