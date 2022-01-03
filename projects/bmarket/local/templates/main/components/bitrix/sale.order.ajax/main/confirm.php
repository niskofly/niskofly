<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var array $arParams
 * @var array $arResult
 * @var $APPLICATION CMain
 */

if ($arParams["SET_TITLE"] == "Y") {
    $APPLICATION->SetTitle(Loc::getMessage("SOA_ORDER_COMPLETE"));
}
?>
<? if (!empty($arResult["ORDER"])): ?>
    <div class="section-message container">
        <div class="alert-message">
            <img src="/img/icons/ok.svg" class="alert-message__logo">
            <div class="title title--medium">
                Ваш заказ №<?= $arResult["ORDER"]["ACCOUNT_NUMBER"] ?> успешно оформлен
            </div>
            <div class="alert-message__text">
                <?
                if ($arResult["ORDER"]["IS_ALLOW_PAY"] === 'Y') {
                    if (!empty($arResult["PAYMENT"])) {
                        foreach ($arResult["PAYMENT"] as $payment) {
                            if ($payment["PAID"] != 'Y') {
                                if (!empty($arResult['PAY_SYSTEM_LIST'])
                                    && array_key_exists($payment["PAY_SYSTEM_ID"], $arResult['PAY_SYSTEM_LIST'])
                                ) {
                                    $arPaySystem = $arResult['PAY_SYSTEM_LIST_BY_PAYMENT_ID'][$payment["ID"]];
                                    if (empty($arPaySystem["ERROR"])) { ?>
                                        <div class="row mb-2 align-items-center">
                                            <div class="col-auto"><strong><?= $arPaySystem["NAME"] ?></strong></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col">
                                                <? if ($arPaySystem["ACTION_FILE"] <> '' && $arPaySystem["NEW_WINDOW"] == "Y" && $arPaySystem["IS_CASH"] != "Y"): ?>
                                                    <?
                                                    $orderAccountNumber = urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]));
                                                    $paymentAccountNumber = $payment["ACCOUNT_NUMBER"];
                                                    ?>
                                                    <script>
                                                        window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=$orderAccountNumber?>&PAYMENT_ID=<?=$paymentAccountNumber?>');
                                                    </script>
                                                <?= Loc::getMessage("SOA_PAY_LINK", array("#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&PAYMENT_ID=" . $paymentAccountNumber)) ?>
                                                <? if (CSalePdf::isPdfAvailable() && $arPaySystem['IS_AFFORD_PDF']): ?>
                                                <br/>
                                                    <?= Loc::getMessage("SOA_PAY_PDF", array("#LINK#" => $arParams["PATH_TO_PAYMENT"] . "?ORDER_ID=" . $orderAccountNumber . "&pdf=1&DOWNLOAD=Y")) ?>
                                                <? endif ?>
                                                <? else: ?>
                                                    <?= $arPaySystem["BUFFERED_OUTPUT"] ?>
                                                <? endif ?>
                                            </div>
                                        </div>
                                        <?
                                    } else {
                                        ?>
                                        <div class="alert alert-danger"
                                             role="alert"><?= Loc::getMessage("SOA_ORDER_PS_ERROR") ?></div>
                                        <?
                                    }
                                } else {
                                    ?>
                                    <div class="alert alert-danger"
                                         role="alert"><?= Loc::getMessage("SOA_ORDER_PS_ERROR") ?></div>
                                    <?
                                }
                            }
                        }
                    }
                } else {
                    ?>
                    <div class="alert alert-danger" role="alert"><?= $arParams['MESS_PAY_SYSTEM_PAYABLE_ERROR'] ?></div>
                    <?
                }
                ?>
            </div>
            <div class="alert-message__actions">
                <a href="/catalog/" class="btn">
                    Купить ещё что-нибудь
                </a>
                <a href="<?= $arParams['PATH_TO_PERSONAL'] ?>" class="btn btn--transparent">
                    Посмотреть мои заказы
                </a>
            </div>
        </div>
    </div>
<? else: ?>
    <div class="section-favorites container js-favorite-products-empty"
         style="<? echo !empty($favorites) ? 'display:none' : '' ?>">
        <div class="section-message container">
            <div class="alert-message">
                <img src="/img/icons/waving-hand.svg" class="alert-message__logo">
                <div class="title title--medium">
                    <?= Loc::getMessage("SOA_ERROR_ORDER") ?>
                </div>
                <div class="alert-message__text">
                    <?= Loc::getMessage("SOA_ERROR_ORDER_LOST", ["#ORDER_ID#" => htmlspecialcharsbx($arResult["ACCOUNT_NUMBER"])]) ?>
                    <br/>
                    <?= Loc::getMessage("SOA_ERROR_ORDER_LOST1") ?>
                </div>
            </div>
        </div>
    </div>
<? endif ?>

<?
/**
 * Отправка данных для аналитики
 */
if ($_SESSION['ORDER_ANALYTICS_SENDED'] === null)
    $_SESSION['ORDER_ANALYTICS_SENDED'] = [];

if ($arResult['ORDER']['ID'] && !in_array($arResult['ORDER']['ID'], $_SESSION['ORDER_ANALYTICS_SENDED'], true)):
    /**
     * Сохранение обработанного заказа в сессию пользователя
     */
    $_SESSION['ORDER_ANALYTICS_SENDED'][] = $arResult['ORDER']['ID'];

    $dbBasket = \CSaleBasket::GetList(
        ['NAME' => 'ASC', 'ID' => 'ASC'],
        ['ORDER_ID' => $arResult['ORDER']['ID']],
        false,
        false,
        ['ID', 'NAME', 'PRODUCT_ID', 'QUANTITY', 'PRICE', 'IBLOCK_SECTION_ID']
    );
    $basketItems = $dbBasket->arResult;
    ?>
    <script>
        var basketProducts = [
            <?foreach ($basketItems as $item):?>
            {
                id: <?=$item['PRODUCT_ID']?>,
                name: "<?= htmlspecialcharsbx($item['NAME']) ?>",
                price: <?=$item['PRICE']?>,
                category: '<?=SiteInfo::getECommerceCategories($item['PRODUCT_ID'])?>',
                quantity: <?=$item['QUANTITY']?>,
            },
            <?endforeach;?>
        ];

        window.dataLayer.push({
            ecommerce: {
                purchase: {
                    actionField: {
                        id: <?= $arResult['ORDER']['ID'] ?>,
                    },
                    products: basketProducts,
                },
            },
        });

        gtag('event', 'purchase', {
            transaction_id: <?= $arResult['ORDER']['ID'] ?>,
            affiliation: "Печальке.net",
            currency: "RUB",
            value: <?= $arResult['ORDER']['PRICE']?>,
            shipping: <?= $arResult['ORDER']['PRICE_DELIVERY']?>,
            tax: <?= $arResult['ORDER']['TAX_VALUE']?>,
            items: basketProducts
        });


        var basketProductsTarget = [
            <?foreach ($basketItems as $item):?>
            {
                id: <?=$item['PRODUCT_ID']?>,
                price: <?=$item['PRICE']?>,
            },
            <?endforeach;?>
        ];

        VkSendProductEvent(window.vkPriceId, 'purchase', {
            currency_code: 'RUB',
            business_value: '<?= $arResult['ORDER']['PRICE']?>',
            products: basketProductsTarget,
        });

        VkAddRetargeting(40279191)

        document.addEventListener("DOMContentLoaded", function() {
            fbq('track', 'Purchase', {
                value: '<?= $arResult['ORDER']['PRICE']?>',
                currency: 'RUB',
                contents: basketProductsTarget,
                content_type: 'product',
            });

            _tmr.push({
                type: 'itemView',
                productid: [
                    <?foreach ($basketItems as $item):?>
                        <?=$item['PRODUCT_ID']?>,
                    <?endforeach;?>
                ],
                pagetype: 'purchase',
                list: window.listTmrId,
                totalvalue: '<?= $arResult['ORDER']['PRICE']?>'
            })

            window.metrics.reachGoal('buying-success');
        });
    </script>
<? endif; ?>
