<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @var string $templateName
 * @var CMain $APPLICATION
 * @var CBitrixBasketComponent $component
 * @var CBitrixComponentTemplate $this
 * @var array $giftParameters
 */

$arResult["BASKET_ITEM_RENDER_DATA"];

$arBasketItems = array();

$dbBasketItems = CSaleBasket::GetList(
    array(
        "NAME" => "ASC",
        "ID" => "ASC"
    ),
    array(
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
    ),
    false,
    false,
    array("ID", "NAME", "PRICE",
        "QUANTITY", "PRICE")
);
$amount = 0;
while ($arItems = $dbBasketItems->Fetch()) {
    $arBasketItems[] = $arItems;
    $amount += $arItems['PRICE'];
}
foreach($arResult['ITEMS'] as $item1){
    foreach ($item1 as $item2){
        if ($item2['LABEL_ARRAY_VALUE']['VOZRASTNYE_OGRANICHENIYA_PO_PRODAZHE']){
    $buy18='y';
    }
    }
};
?>
<? if (empty($arResult["BASKET_ITEM_RENDER_DATA"])) {
    include(Main\Application::getDocumentRoot() . $templateFolder . '/empty.php');
} else { ?>
    <div class="basket-order container">
        <div class="basket-order__main">
            <div class="order-table">

                <div class="order-table__head">
                    <div class="order-table__td-first">Ваш заказ</div>
                    <!-- <div class="order-table__td-name"></div> -->
                    <div class="order-table__td-prices">Цена</div>
                    <div>Кол-во</div>
                    <div class="order-table__td-prices">Сумма</div>
                </div>

                <div class="js-products-in-card">
                    <!-- items-container -->
                    <? foreach ($arResult["BASKET_ITEM_RENDER_DATA"] as $arItem) : ?>
                        <div
                            class="<? echo !$arItem["NOT_AVAILABLE"] ? '' : 'order-table__tr-removed' ?>order-table__body js-product-in-card">
                            <div>
                                <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="order-table__image">
                                    <img src="<?= $arItem['IMAGE_URL'] ?: NO_IMAGE_SRC ?>"
                                         alt="<?= htmlspecialchars($arItem['NAME']) ?>">
                                </a>
                            </div>
                            <div class="order-table__td-name">
                                <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="order-table__title">
                                    <?= $arItem['NAME'] ?>
                                </a>
                                <? if (!$arItem["NOT_AVAILABLE"]) { ?>
                                    <br>
                                    <?
                                    $isInFavorite = UserFavoriteProducts::checkInFavorite($arItem['PRODUCT_ID']);
                                    ?>
                                    <form action="/api/personal/favorites.php" class="js-favorites-form">
                                        <input type="hidden" name="PRODUCT_ID" value="<?= $arItem['PRODUCT_ID'] ?>">
                                        <button type="submit"
                                                class="btn btn--purple-text <? echo $isInFavorite ? 'product-in-favorite' : '' ?>"
                                                data-favorite-btn="<?= $arItem['PRODUCT_ID'] ?>">
                                            <svg class="icon icon-like ">
                                                <use xlink:href="#like"></use>
                                            </svg>
                                            <span>Избранное</span>
                                        </button>
                                    </form>

                                <? } else { ?>
                                    <div class="order-table__label">Товар закончился</div>
                                <? } ?>
                            </div>

                            <div class="order-table__td-name-media">
                                <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="order-table__title">
                                    <?= $arItem['NAME'] ?>
                                </a>
                            </div>

                            <div class="order-table__td-prices order-table__td-prices--main">
                                <? if ($arItem['DISCOUNT_PRICE_PERCENT']) { ?>
                                    <div class="prices">
                                        <div class="price price--discount">
                                            <?= ItemsBitrixCart::getFormattedPrice($arItem["PRICE"]) ?>
                                        </div>
                                        <div class="price-old prices__price-old">
                                            <?= ItemsBitrixCart::getFormattedPrice($arItem["FULL_PRICE"]) ?>
                                        </div>
                                        <? if ($arItem['DISCOUNT_PRICE_PERCENT']): ?>
                                            <div class="discount prices__discount">
                                                -<?= $arItem['DISCOUNT_PRICE_PERCENT'] ?>%
                                            </div>
                                        <? endif; ?>
                                    </div>
                                <? } else { ?>
                                    <div class="price">
                                        <?= ItemsBitrixCart::getFormattedPrice($arItem["PRICE"]) ?>
                                    </div>
                                <? } ?>
                            </div>
                            <div class="order-table__td-counter">
                                <form class="product-card__controls js-update-in-card-form"
                                      action="/personal/cart/">
                                    <input type="hidden" name="BASKET_ITEM_ID" value="<?= $arItem['ID'] ?>">

                                    <div class="product-amount js-product-in-card-counter"
                                         data-max="<? echo $arItem["CHECK_MAX_QUANTITY"] == 'Y' ? $arItem["AVAILABLE_QUANTITY"] : 999 ?>">
                                        <input type="hidden" name="ACTION" value="BUY_PRODUCT">
                                        <input type="hidden" name="IS_AJAX_RELOAD" value="Y">

                                        <button type="button" name="reduce" class="product-amount__btn">
                                            <svg class="icon icon-minus ">
                                                <use xlink:href="#minus"></use>
                                            </svg>
                                        </button>

                                        <input type="text"
                                               name="QUANTITY"
                                               readonly
                                               value="<?= $arItem['QUANTITY'] ?>"
                                               class="product-amount__input">

                                        <button type="button" name="increase" class="product-amount__btn">
                                            <svg class="icon icon-plus ">
                                                <use xlink:href="#plus"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="order-table__td-prices order-table__td-prices--sum">
                                <div class="prices">
                                    <div class="price">
                                        <?= ItemsBitrixCart::getFormattedPrice($arItem["SUM_PRICE"]) ?>
                                    </div>
                                </div>
                            </div>
                            <? if (!$arItem["NOT_AVAILABLE"]): ?>
                                <div class="order-table__td-action">
                                    <form
                                        class="js-remove-product-in-card-form cart-product-form cart-product-form--remove"
                                        action="/personal/cart/">
                                        <input type="hidden" name="BASKET_ITEM_ID" value="<?= $arItem['ID'] ?>">
                                        <input type="hidden" name="ACTION" value="REMOVE_BASKET_ITEM">
                                        <input type="hidden" name="IS_AJAX_RELOAD" value="Y">

                                        <button type="submit" class="order-table__action" data-tooltip="Удалить">
                                            <img src="/img/icons/delite.svg" class="icon">
                                        </button>
                                    </form>

                                    <form
                                        class="js-recovery-product-in-card-form cart-product-form cart-product-form--recovery"
                                        action="/personal/cart/">
                                        <input type="hidden" name="PRODUCT_ID" value="<?= $arItem['PRODUCT_ID'] ?>">
                                        <input type="hidden" name="ACTION" value="BUY_PRODUCT">
                                        <input type="hidden" name="QUANTITY" value="<?= $arItem['QUANTITY'] ?>">
                                        <input type="hidden" name="IS_AJAX_RELOAD" value="Y">

                                        <button type="submit" class="order-table__action" data-tooltip="Восстановить">
                                            <img src="/img/icons/recovery.svg" class="icon">
                                        </button>
                                    </form>
                                </div>
                            <? endif; ?>
                        </div>
                    <? endforeach; ?>
                    <!-- items-container -->
                </div>

            </div>
        </div>

        <div class="basket-order__sidebar">
            <div class="basket-order__sidebar-section">
                <div class="basket-order__sidebar-header">
                    <div class="title title--medium">Ваш заказ</div>
                </div>
                <div class="order-calculate js-cart-total-block">
                    <!-- total-container -->
                    <div class="order-calculate__list">
                        <div class="order-calculate__item">
                            <div class="order-calculate__item-label">
                                Товары (<span><?= $arResult['BASKET_ITEMS_COUNT'] ?></span>)
                            </div>
                            <div class="order-calculate__item-value">
                                <?= ItemsBitrixCart::getFormattedPrice($arResult["TOTAL_RENDER_DATA"]['PRICE_WITHOUT_DISCOUNT_FORMATED']) ?>
                            </div>
                        </div>

                        <? if ($userBonuses = CSaleUserAccount::GetByUserID($USER->GetID(), "RUB")) { ?>
                            <div class="order-calculate__item">
                                <div class="order-calculate__item-label">
                                    Бонусов на счету
                                </div>
                                <div class="order-calculate__item-value">
                                    <?= SaleFormatCurrency($userBonuses["CURRENT_BUDGET"], $userBonuses["CURRENCY"]); ?>
                                </div>
                            </div>
                        <? } ?>

                        <? if ($arResult["TOTAL_RENDER_DATA"]['DISCOUNT_PRICE_FORMATED']): ?>
                            <div class="order-calculate__item">
                                <div class="order-calculate__item-label">Скидка на товары</div>
                                <div class="order-calculate__item-value order-calculate__item-value--discount">
                                    <?= ItemsBitrixCart::getFormattedPrice($arResult["TOTAL_RENDER_DATA"]['DISCOUNT_PRICE_FORMATED']) ?>
                                </div>
                            </div>
                        <? endif; ?>
                    </div>
                    <div class="order-calculate__total">
                        <div class="order-calculate__total-label">Итого</div>
                        <div class="order-calculate__total-value">
                            <?= ItemsBitrixCart::getFormattedPrice($arResult["TOTAL_RENDER_DATA"]['PRICE']) ?>
                        </div>

                    </div>
                    <? if ($arResult["TOTAL_RENDER_DATA"]['PRICE'] < 500) {
                        ?>
                        <div class="order-calculate__total-label">Минимальная сумма заказа 500 рублей.
                            <a href="/catalog/">Вернутсья к покупкам</a>
                        </div>
                        <?
                    }elseif ($buy18=='y'){ ?>
                        <a href="<?= $arParams['PATH_TO_ORDER'] ?>" class="btn llm">Подтверждаю что мне 18 лет,<br> продолжить оформление</a>
                   <? }else { ?>
                        <a href="<?= $arParams['PATH_TO_ORDER'] ?>" class="btn">Перейти к оформлению</a>
                    <? } ?>
                    <!-- total-container -->
                </div>
            </div>
        </div>
    </div>

    <div class="js-basket-gift-container"></div>

    <?
    CBitrixComponent::includeComponentClass('bitrix:sale.products.gift.basket');
    $giftParameters = array(
        'SHOW_PRICE_COUNT' => 1,
        'PRODUCT_SUBSCRIPTION' => 'N',
        'PRODUCT_ID_VARIABLE' => 'id',
        'USE_PRODUCT_QUANTITY' => 'N',
        'ACTION_VARIABLE' => 'actionGift',
        'ADD_PROPERTIES_TO_BASKET' => 'Y',
        'PARTIAL_PRODUCT_PROPERTIES' => 'Y',

        'BASKET_URL' => $APPLICATION->GetCurPage(),
        'APPLIED_DISCOUNT_LIST' => $arResult['APPLIED_DISCOUNT_LIST'],
        'FULL_DISCOUNT_LIST' => $arResult['FULL_DISCOUNT_LIST'],

        'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
        'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_SHOW_VALUE'],
        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],

        'BLOCK_TITLE' => $arParams['GIFTS_BLOCK_TITLE'],
        'HIDE_BLOCK_TITLE' => $arParams['GIFTS_HIDE_BLOCK_TITLE'],
        'TEXT_LABEL_GIFT' => $arParams['GIFTS_TEXT_LABEL_GIFT'],

        'DETAIL_URL' => isset($arParams['GIFTS_DETAIL_URL']) ? $arParams['GIFTS_DETAIL_URL'] : null,
        'PRODUCT_QUANTITY_VARIABLE' => $arParams['GIFTS_PRODUCT_QUANTITY_VARIABLE'],
        'PRODUCT_PROPS_VARIABLE' => $arParams['GIFTS_PRODUCT_PROPS_VARIABLE'],
        'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
        'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
        'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
        'MESS_BTN_BUY' => $arParams['GIFTS_MESS_BTN_BUY'],
        'MESS_BTN_DETAIL' => $arParams['GIFTS_MESS_BTN_DETAIL'],
        'CONVERT_CURRENCY' => $arParams['GIFTS_CONVERT_CURRENCY'],
        'HIDE_NOT_AVAILABLE' => $arParams['GIFTS_HIDE_NOT_AVAILABLE'],

        'PRODUCT_ROW_VARIANTS' => '',
        'PAGE_ELEMENT_COUNT' => 0,
        'DEFERRED_PRODUCT_ROW_VARIANTS' => \Bitrix\Main\Web\Json::encode(
            SaleProductsGiftBasketComponent::predictRowVariants(
                $arParams['GIFTS_PAGE_ELEMENT_COUNT'],
                $arParams['GIFTS_PAGE_ELEMENT_COUNT']
            )
        ),
        'DEFERRED_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],

        'ADD_TO_BASKET_ACTION' => 'BUY',
        'PRODUCT_DISPLAY_MODE' => 'Y',
        'PRODUCT_BLOCKS_ORDER' => isset($arParams['GIFTS_PRODUCT_BLOCKS_ORDER']) ? $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'] : '',
        'SHOW_SLIDER' => isset($arParams['GIFTS_SHOW_SLIDER']) ? $arParams['GIFTS_SHOW_SLIDER'] : '',
        'SLIDER_INTERVAL' => isset($arParams['GIFTS_SLIDER_INTERVAL']) ? $arParams['GIFTS_SLIDER_INTERVAL'] : '',
        'SLIDER_PROGRESS' => isset($arParams['GIFTS_SLIDER_PROGRESS']) ? $arParams['GIFTS_SLIDER_PROGRESS'] : '',
        'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],

        'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
        'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
        'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
    );

    $APPLICATION->IncludeComponent(
        'bitrix:sale.products.gift.basket',
        '.default',
        $giftParameters,
        $component
    );
    ?>
<? } ?>
