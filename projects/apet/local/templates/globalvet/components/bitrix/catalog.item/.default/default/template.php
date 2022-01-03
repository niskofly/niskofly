<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var string $imgTitle
 * @var string $productTitle
 * @var CatalogSectionComponent $component
 */

?>

<?
$brandLink = implode(
        array_slice(
            str_split($item["DETAIL_PAGE_URL"]),
            0,
            stripos($item["DETAIL_PAGE_URL"], $item["CODE"])
        )
    )
    . 'filter/brand-is-' . strtolower($item["BRAND_NAME"]) . '/apply/';
?>

<div class="card-product">

    <? if ($item['PREVIEW_PICTURE']['SRC']): ?>
        <a href="<?= $item['DETAIL_PAGE_URL'] ?>"
           class="card-product__preview"
           title="<?= $productTitle ?>">

            <? if ($price['PERCENT']): ?>
                <span class="discount card-product__discount">-<?= $price['PERCENT'] ?>%</span>
            <? endif; ?>

            <img loading="lazy"
                 class="product-big__image lazyload"
                 src="<?= $item['PREVIEW_PICTURE']['SRC'] ? $item['PREVIEW_PICTURE']['SRC'] : '/img/404.png' ?>"
                 alt="<?= $productTitle ?>"/>
        </a>
    <? endif; ?>

    <div class="card-product__main">
        <a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="card-product__title"><?= $item["NAME"]; ?></a>
        <div class="card-product__actions">
            <a href="<?= $brandLink; ?>"
               class="card-product__brand"><?= $item["BRAND_NAME"]; ?></a>

            <div class="user-menu card-product__user-menu">
                <!-- Кнопка добавления в сравнение -->
                <?
                $isActiveCompare = false;
                if (!(array_key_exists($item["ID"], $_SESSION['CATALOG_COMPARE_LIST'][$item["IBLOCK_ID"]]['ITEMS']))) {
                    $methodCompare = 'ADD_TO_COMPARE_LIST';
                } else {
                    $methodCompare = 'DELETE_FROM_COMPARE_LIST';
                    $isActiveCompare = true;
                }
                ?>
                <div class="js-product-compare">
                    <input type="hidden" name="product_id" value="<?= $item["ID"] ?>">
                    <input type="hidden" name="method" value="<?= $methodCompare ?>">
                    <button type="button"
                            class="user-menu__button <?= $isActiveCompare ? 'user-menu__button--active' : '' ?>">
                        <svg class="icon icon-chart ">
                            <use xlink:href="#chart"></use>
                        </svg>
                    </button>
                </div>
                <!-- Кнопка добавления в избранное -->
                <?
                $isActiveFavorite = false;
                try {
                    $isActiveFavorite = (new UserFavoriteProducts())->checkInFavorite($item["ID"]);
                } catch (Exception $e) {
                    $isFavoritesException = true;
                }
                ?>
                <div class="js-product-favourite">
                    <input type="hidden" name="product_id" value="<?= $item["ID"] ?>">
                    <button type="button"
                            class="user-menu__button <?= $isActiveFavorite ? 'user-menu__button--active' : '' ?>">
                        <svg class="icon icon-heart ">
                            <use xlink:href="#heart"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="card-product__footer">
            <div class="card-product__prices">

                <? if ($item['OFFERS'][0]["PRICES"]["ruble"]["PRINT_DISCOUNT_VALUE"] || $arResult['ACTUAL_PRICE']): ?>
                    <div class="card-product__price">
                        <?= $item['OFFERS'][0]["PRICES"]["BASE"]["PRINT_DISCOUNT_VALUE"] ?: $arResult['ACTUAL_PRICE'] ?>
                    </div>
                <? endif; ?>

                <? if ($item['OFFERS'][0]["PRICES"]["ruble"]["DISCOUNT_DIFF"] || $item['PRICES']['ruble']['DISCOUNT_DIFF']): ?>
                    <div class="price-old"> <?= $item['OFFERS'][0]["PRICES"]["BASE"]["PRINT_VALUE"] ?: $arResult['OLD_PRICE']; ?></div>
                <? endif; ?>
            </div>

            <!-- Кнопка добавления товара в корзину -->
            <? if ($item['OFFERS'] || $item["CAN_BUY"] && $item['PRODUCT']['QUANTITY'] > 0): ?>
                <form action="/api/order/add-to-cart.php" class="js-add-to-card product-action__form">
                    <input type="hidden" name="ACTION" value="BUY_PRODUCT">
                    <input type="hidden" name="PRODUCT_ID" value="<?= $item['OFFERS'][0]['ID'] ? $item['OFFERS'][0]['ID'] : $item['ID'] ?>">
                    <input type="hidden" name="QUANTITY" value="1">
                    <input type="hidden" name="PRODUCT_NAME" value="<?= $item['OFFERS'][0]['NAME'] ? $item['OFFERS'][0]['NAME'] : $item['NAME'] ?>">
                    <input type="hidden" name="PRODUCT_BRAND"
                           value="<?= getNameElementById($item['PROPERTIES']['BRAND']['VALUE']) ?>">
                    <input type="hidden" name="PRODUCT_IMG" value="<?= $item['PREVIEW_PICTURE']['SRC'] ?>">
                    <button class="btn btn--medium btn--ice card-product__buy">В корзину</button>
                </form>
            <? else: ?>
                <!-- todo: создание формы уведомления -->
                <button type="button" class="btn btn--medium btn--ice card-product__buy">Уведомить</button>
            <? endif; ?>
        </div>
    </div>
</div>
