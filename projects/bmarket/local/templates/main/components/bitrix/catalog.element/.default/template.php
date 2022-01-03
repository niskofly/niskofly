<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>
<script src="/local/templates/main/js/jquery-1.8.3.min.js"></script>
<script src="/local/templates/main/js/jquery.elevateZoom-3.0.8.min.js"></script>

<?
use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$templateData = array(
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => array(
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
        'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
        'JS_OFFERS' => $arResult['JS_OFFERS']
    )
);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId . '_dsc_pict',
    'STICKER_ID' => $mainId . '_sticker',
    'BIG_SLIDER_ID' => $mainId . '_big_slider',
    'BIG_IMG_CONT_ID' => $mainId . '_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId . '_slider_cont',
    'OLD_PRICE_ID' => $mainId . '_old_price',
    'PRICE_ID' => $mainId . '_price',
    'DISCOUNT_PRICE_ID' => $mainId . '_price_discount',
    'PRICE_TOTAL' => $mainId . '_price_total',
    'SLIDER_CONT_OF_ID' => $mainId . '_slider_cont_',
    'QUANTITY_ID' => $mainId . '_quantity',
    'QUANTITY_DOWN_ID' => $mainId . '_quant_down',
    'QUANTITY_UP_ID' => $mainId . '_quant_up',
    'QUANTITY_MEASURE' => $mainId . '_quant_measure',
    'QUANTITY_LIMIT' => $mainId . '_quant_limit',
    'BUY_LINK' => $mainId . '_buy_link',
    'ADD_BASKET_LINK' => $mainId . '_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId . '_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId . '_not_avail',
    'COMPARE_LINK' => $mainId . '_compare_link',
    'TREE_ID' => $mainId . '_skudiv',
    'DISPLAY_PROP_DIV' => $mainId . '_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId . '_main_sku_prop',
    'OFFER_GROUP' => $mainId . '_set_group_',
    'BASKET_PROP_DIV' => $mainId . '_basket_prop',
    'SUBSCRIBE_LINK' => $mainId . '_subscribe',
    'TABS_ID' => $mainId . '_tabs',
    'TAB_CONTAINERS_ID' => $mainId . '_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId . '_small_card_panel',
    'TABS_PANEL_ID' => $mainId . '_tabs_panel'
);

$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

$actualItem = $arResult;
$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;

$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);

$maxQuantity = $actualItem["PRODUCT"]['QUANTITY_TRACE'] == 'Y' && $actualItem["PRODUCT"]['CAN_BUY_ZERO'] == 'N' ?
    $actualItem["PRODUCT"]['QUANTITY'] :
    999;
?>
    <div class="product-detail" itemscope itemtype="http://schema.org/Product">
        <div class="container product-detail__container">
            <? if (!empty($actualItem['MORE_PHOTO'])): ?>
                <div class="product-detail__gallery product-gallery">
                    <div class="product-gallery__thumbs">
                        <div class="swiper-container js-gallery-thumbs">
                            <div class="swiper-wrapper">
                                <? foreach ($actualItem['MORE_PHOTO'] as $src): ?>
                                    <div style="background-image: url(<?= $src ?>)"
                                         class="swiper-slide product-gallery__thumb"></div>
                                <? endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-container product-gallery__preview js-gallery-preview">
                        <div class="swiper-wrapper">
                            <? foreach ($actualItem['MORE_PHOTO'] as $src): ?>
                                <div class="swiper-slide product-gallery__slide">
                                    <a href="<?= $src ?>"
                                       title="<?= $title ?>"
                                       class="product-gallery__image js-modal-photo">
                                        <img id="zoom" src="<?= $src ?>" alt="<?= $alt ?>" data-zoom-image="<?= $src ?>" itemprop="image" >
                                    </a>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                </div>
            <? endif; ?>

            <div class="product-detail__info">
                <div class="product-detail__header">
                    <div class="title product-detail__title">
                        <h1 class="seo-title" itemprop="name"><?= $name ?></h1>
                    </div>

                    <form action="/api/personal/favorites.php" class="js-favorites-form">
                        <input type="hidden" name="PRODUCT_ID" value="<?= $arResult['ID'] ?>">
                        <button type="submit" class="btn btn--purple-text" data-favorite-btn="<?= $arResult['ID'] ?>">
                            <svg class="icon icon-like ">
                                <use xlink:href="#like"></use>
                            </svg>
                            <span>Избранное</span>
                        </button>
                    </form>
                </div>
                <div class="product-detail__order">

                    <?
                    /**
                     * todo: Подумать над округлением цен через отдельный сервис
                     */
                    ?>
                    <div class="prices">
                        <? if ($showDiscount) { ?>
                            <div class="price-old prices__price-old">
                                <?= $price['RATIO_BASE_PRICE'] ?>
                                <span class="rubl">i</span>
                            </div>
                            <div class="price price--discount" itemprop="price">
                                <?= $price['PRICE'] ?>
                                <span class="rubl" itemprop="priceCurrency">i</span>
                            </div>
                            <div class="discount prices__discount"
                                 title="<?= -$price['PERCENT'] ?>%">
                                <?= -$price['PERCENT'] ?>%
                            </div>
                        <? } else { ?>
                            <div class="price" itemprop="price">
                                <?= $price['PRICE'] ?>
                                <span class="rubl" itemprop="priceCurrency">i</span>
                            </div>
                        <? } ?>
                    </div>

                    <? if ($arResult['PRINT_COUNT_BONUSES']): ?>
                        <div class="user-points">
                            + <?= $arResult['PRINT_COUNT_BONUSES'] ?>
                        </div>
                    <? endif; ?>

                    <div class="product-status product-detail__product-status
                        <? echo !$actualItem['CAN_BUY'] ? 'product-status--unavailable' : '' ?>">
                        <div class="product-status__dot"></div>
                        <div class="product-status__text">
                            <? echo $actualItem['CAN_BUY'] ? 'Товар в наличии' : 'Товара нет в наличии' ?>
                        </div>
                    </div>

                    <? if ($actualItem['CAN_BUY']) { ?>
                        <form class="product-detail__controls js-add-to-card" action="/api/catalog/add-to-cart.php">
                            <input type="hidden" name="PRODUCT_ID" value="<?= $arResult['ID'] ?>">
                            <input type="hidden" name="PRODUCT_NAME" value="<?= $name ?>">
                            <input type="hidden" name="PRODUCT_IMAGE" value="<?= $actualItem['MORE_PHOTO'][0] ?>">
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
                            <button type="submit" class="btn product-detail__buy">Добавить в корзину</button>
                        </form>
                    <? } else { ?>
                        <button class="btn product-detail__buy js-product-notify"
                                data-id="<?= $arResult['ID'] ?>"
                                data-image="<?= $actualItem['MORE_PHOTO'][0] ?>"
                                data-name="<?= $name ?>"
                        >
                            Уведомить
                        </button>
                    <? } ?>
                </div>
                <div class="tabs js-tabs">
                    <div class="tabs__buttons">
                        <? if ($showDescription): ?>
                            <button type="button" data-tab="description" class="tabs__button js-tab-action active">
                                Описание
                            </button>
                        <? endif ?>
                        <? if (!empty($arResult['DISPLAY_PROPERTIES'])) : ?>
                            <button type="button" data-tab="characteristic" class="tabs__button js-tab-action">
                                Характеристики
                            </button>
                        <? endif; ?>

                        <?
                        /* todo: Вывести отзывы о товаре на детальной странице
                        ?>
                        <button type="button" data-tab="reviews" class="tabs__button js-tab-action">
                            Отзывы
                        </button>
                        <?*/ ?>
                    </div>

                    <? if ($showDescription): ?>
                        <div data-tab-content="description" class="tabs__tab js-tab" itemprop="description">
                            <?
                            echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ?
                                $arResult['DETAIL_TEXT'] :
                                '<p>' . $arResult['DETAIL_TEXT'] . '</p>'
                            ?>
                        </div>
                    <? endif ?>

                    <? if (!empty($arResult['DISPLAY_PROPERTIES'])) : ?>
                        <div data-tab-content="characteristic" class="tabs__tab js-tab">
                            <div class="product-props">
                                <? foreach ($arResult['DISPLAY_PROPERTIES'] as $property) { ?>
                                    <div class="product-props__prop">
                                        <div class="product-props__prop-name">
                                            <?= $property['NAME'] ?>
                                        </div>
                                        <div class="product-props__prop-space"></div>
                                        <div class="product-props__prop-value">
                                            <?= (
                                            is_array($property['DISPLAY_VALUE'])
                                                ? implode(' / ', $property['DISPLAY_VALUE'])
                                                : $property['DISPLAY_VALUE']
                                            ) ?>
                                        </div>
                                    </div>
                                <? }
                                unset($property);
                                ?>
                            </div>
                        </div>
                    <? endif; ?>

                    <?
                    /* todo: Вывести отзывы о товаре на детальной странице
                    ?>
                    <div data-tab-content="reviews" class="tabs__tab js-tab"></div>
                    <?*/ ?>
                </div>
            </div>
        </div>
    </div>
<script>
    $('#zoom').elevateZoom({
cursor: "crosshair",
scrollZoom : true,
        easing : true
   });
</script>
<?
unset($actualItem, $itemIds, $jsParams);
