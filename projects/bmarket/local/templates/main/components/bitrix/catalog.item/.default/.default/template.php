<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
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
<div class="product-card js-product-card">
    <a href="<?= $item['DETAIL_PAGE_URL'] ?>"
       title="<?= $productTitle ?>"
       class="product-card__preview">
        <img src="<? echo $item['PREVIEW_PICTURE']['SRC'] ?: NO_IMAGE_SRC ?>"
             alt="<?= $productTitle ?>" itemprop="contentUrl">
    </a>
    <div class="product-card__detail">
        <a href="<?= $item['DETAIL_PAGE_URL'] ?>"
           title="<?= $productTitle ?>"
           class="product-card__title">
            <?= $productTitle ?>
        </a>

        <form action="/api/personal/favorites.php" class="js-favorites-form">
            <input type="hidden" name="PRODUCT_ID" value="<?= $item['ID'] ?>">
            <button type="submit" class="btn btn--purple-text product-card__favourites js-add-to-favorites">
                <svg class="icon icon-like " style="pointer-events: none;">
                    <use xlink:href="#like"></use>
                </svg>
                <span class="product-card__favourites-title" style="pointer-events: none;">Избранное</span>
            </button>
        </form>

        <?
        /**
         * todo: Подумать над округлением цен через отдельный сервис
         */
        $isOldPrice = !($price['RATIO_PRICE'] >= $price['RATIO_BASE_PRICE']);
        ?>
        <div class="prices">
            <? if ($isOldPrice) { ?>
                <div class="price-old prices__price-old">
                    <?= $price['RATIO_BASE_PRICE'] ?>
                    <span class="rubl">i</span>
                </div>
                <div class="price price--discount">
                    <?= $price['PRICE'] ?>
                    <span class="rubl">i</span>
                </div>
                <div class="discount prices__discount">
                    -<?= $price['PERCENT'] ?>%
                </div>
            <? } else { ?>
                <div class="price">
                    <?= $price['PRICE'] ?>
                    <span class="rubl">i</span>
                </div>
            <? } ?>
        </div>
    </div>

    <? if ($item["CAN_BUY"]) {
        $maxQuantity = $item["PRODUCT"]['QUANTITY_TRACE'] == 'Y' && $item["PRODUCT"]['CAN_BUY_ZERO'] == 'N' ?
            $item["PRODUCT"]['QUANTITY'] :
            999;
        ?>
        <form class="product-card__controls js-add-to-card" action="/api/catalog/add-to-cart.php">
            <input type="hidden" name="PRODUCT_ID" value="<?= $item['ID'] ?>">
            <input type="hidden" name="PRODUCT_NAME" value="<?= $productTitle ?>">
            <input type="hidden"
                   name="PRODUCT_IMAGE"
                   value="<? echo $item['PREVIEW_PICTURE']['SRC'] ?: NO_IMAGE_SRC ?>">
            <input type="hidden" name="PRODUCT_PRICE" value="<?= $price['PRICE'] ?>">

            <div class="product-amount js-product-buy-btn" data-max="<?= $maxQuantity ?>">
                <input type="hidden" name="ACTION" value="BUY_PRODUCT">

                <button type="button" name="reduce" class="product-amount__btn">
                    <svg class="icon icon-minus ">
                        <use xlink:href="#minus"></use>
                    </svg>
                </button>
                <input type="text" name="QUANTITY" value="1" readonly class="product-amount__input">
                <button type="button" name="increase" class="product-amount__btn">
                    <svg class="icon icon-plus ">
                        <use xlink:href="#plus"></use>
                    </svg>
                </button>
            </div>
            <button type="submit"
                    class="btn product-card__buy js-btn-to-cart">
                <span class="product-card__buy-title" style="pointer-events: none;">В корзину</span>
                <svg class="icon icon-basket " style="pointer-events: none;">
                    <use xlink:href="#basket"></use>
                </svg>
            </button>
        </form>
    <? } else { ?>
        <div class="product-card__controls">
            <button type="button" class="btn product-card__buy js-product-notify" data-id="<?=$item['ID'];?>" data-name="<?= $productTitle ?>" data-image="<?=$item['PREVIEW_PICTURE']['SRC'];?>">
                <span>Уведомить</span>
            </button>
        </div>
    <? } ?>
</div>
