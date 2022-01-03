<?
$domain = 'https://vetlavka.ru/';
$domain_clear = str_replace(['http://', 'https://'], '', $domain);

$APPLICATION->SetPageProperty("og:image", 'img/favicon/apple-icon-180x180.png');
$APPLICATION->SetPageProperty("og:image:type", 'image/png');
?>

<!--open graph-->
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= $domain_clear ?>"/>
<meta property="og:title" content="<? $APPLICATION->ShowTitle() ?>">
<meta property="og:locale" content="ru_RU">
<meta property="og:description" content="<? $APPLICATION->ShowProperty("description") ?>">
<meta property="og:url" content="<?= $domain ?><?= $APPLICATION->GetCurPage(); ?>">
<meta property="og:image:type" content="<?= $APPLICATION->ShowProperty("og:image:type") ?>">
<meta property="og:image" content="<?= $domain ?><?= $APPLICATION->ShowProperty("og:image") ?>">
<!--open graph-->

<!--twitter-->
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:site" content="<?= $domain_clear ?>"/>
<meta name="twitter:title" content="<? $APPLICATION->ShowTitle() ?>">
<meta name="twitter:creator" content="<?= $domain_clear ?>"/>
<meta name="twitter:domain" content="<?= $domain ?>"/>
<meta name="twitter:description" content="<? $APPLICATION->ShowProperty("description") ?>"/>
<meta name="twitter:image:src" content="<?= $domain ?><?= $APPLICATION->ShowProperty("og:image") ?>"/>
<!--twitter-->
