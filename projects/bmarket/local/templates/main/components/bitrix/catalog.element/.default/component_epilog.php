<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Catalog\CatalogViewedProductTable as CatalogViewedProductTable;

/**
 * Добавление товара в список просмотренных
 */
CatalogViewedProductTable::refresh($arResult['ID'], CSaleBasket::GetBasketUserID());

if (UserFavoriteProducts::checkInFavorite($arResult["ID"])) { ?>
    <script>
        document.querySelector('[data-favorite-btn="<?=$arResult["ID"]?>"]')
            .classList
            .add('product-in-favorite')
    </script>
    <?
}

if ($arResult['OPENGRAF_IMAGE']) {
    $fileName = end(explode('/', $arResult['OPENGRAF_IMAGE']));
    $extension = (new SplFileInfo($fileName))->getExtension();
    $extension = $extension ? "image/{$extension}" : 'image/png';

    $APPLICATION->SetPageProperty("og:image", $arResult['OPENGRAF_IMAGE']);
    $APPLICATION->SetPageProperty("og:image:type", $extension);
}
?>
<script>
    var productEcommerce = {
        id: <?=$arResult["ID"]?>,
        name: '<?=$arResult["NAME"]?>',
        price: '<?=$arResult["PRICE"]?>',
        category: '<?=SiteInfo::getECommerceCategories($arResult["ID"])?>',
    }

    window.dataLayer.push({ecommerce: {detail: {products: [productEcommerce]}}})
    window.gtag('event', 'view_item', {items: [productEcommerce]})

    VkSendProductEvent(window.vkPriceId, 'view_product', {
        currency_code: 'RUB',
        business_value: productEcommerce.price,
        products: [{id: productEcommerce.id, price: productEcommerce.price}],
    })

    document.addEventListener("DOMContentLoaded", function () {
        fbq('track', 'ViewContent', {
            value: productEcommerce.price,
            currency: 'RUB',
            content_ids: productEcommerce.id,
            content_type: 'product',
            content_name: productEcommerce.name,
        });

        _tmr.push({
            type: 'itemView',
            productid: productEcommerce.id,
            pagetype: 'product',
            list: window.listTmrId,
            totalvalue: productEcommerce.price
        });
    });
</script>
