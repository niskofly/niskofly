<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;


Loc::loadMessages(__FILE__);
?>

<? if (!empty($arResult['ORDERS'])) { ?>
    <div class="section-orders container">
        <div class="table-orders">
            <table>
                <thead>
                <tr>
                    <td>№ Заказа</td>
                    <td>Статус</td>
                    <td>Товаров в заказе</td>
                    <td>Сумма</td>
                    <td>Способ оплаты и доставки</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <? foreach ($arResult['ORDERS'] as $order):
                    $orderHeaderStatus = $order['ORDER']['STATUS_ID'];
                    $colorStatus = 'product-status--proccess';

                    if (in_array($orderHeaderStatus, ['F', 'P']))
                        $colorStatus = '';

                    if ($order["ORDER"]["CANCELED"] == 'Y')
                        $colorStatus = 'product-status--done';
                    ?>
                    <tr onclick="location.href='/<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"]) ?>'">
                        <td class="table-orders__td-number">
                            № <?= $order['ORDER']['ID'] ?>
                            <br>
                            <?= $order['ORDER']['DATE_INSERT']->format($arParams['ACTIVE_DATE_FORMAT']) ?>
                        </td>
                        <td>
                            <div class="product-status <?= $colorStatus ?>">
                                <div class="product-status__dot"></div>
                                <div class="product-status__text">
                                    <?
                                    echo $order["ORDER"]["CANCELED"] !== 'Y'
                                        ? htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME'])
                                        : Loc::getMessage('SPOL_TPL_ORDER_CANCELED');
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?= count($order['BASKET_ITEMS']); ?>
                            <?
                            $count = count($order['BASKET_ITEMS']) % 10;
                            echo $count == '1'
                                ? Loc::getMessage('SPOL_TPL_GOOD')
                                : (($count >= '2' && $count <= '4')
                                    ? Loc::getMessage('SPOL_TPL_TWO_GOODS')
                                    : Loc::getMessage('SPOL_TPL_GOODS'));
                            ?>
                        </td>
                        <td class="table-orders__td-total">
                            <div>
                                <?= ItemsBitrixCart::getFormattedPrice($order['ORDER']['PRICE']) ?>
                            </div>
                        </td>
                        <td>
                            <? foreach ($order['PAYMENT'] as $payment): ?>
                                <p>
                                    <?= $payment["PAY_SYSTEM_NAME"] ?>
                                </p>
                            <? endforeach; ?>

                            <? foreach ($order['SHIPMENT'] as $shipment) {
                                if (empty($shipment))
                                    continue;
                                ?>
                                <p>
                                    <?= $shipment['DELIVERY_NAME']; ?>
                                </p>
                                <? if (trim($shipment['TRACKING_URL'])) { ?>
                                    <p>
                                        <a href="<?= $shipment['TRACKING_URL'] ?>">
                                            Номер отслеживания: <?= htmlspecialcharsbx($shipment['TRACKING_NUMBER']) ?>
                                        </a>
                                    </p>
                                <? } elseif (!empty($shipment['TRACKING_NUMBER'])) { ?>
                                    <p>
                                        Номер отслеживания: <?= htmlspecialcharsbx($shipment['TRACKING_NUMBER']) ?>
                                    </p>
                                <? } ?>
                            <? } ?>
                        </td>
                        <td>
                            <span class="lk-control">
                                <span class="lk-control__icon">
                                    <svg class="icon icon-arrow-r ">
                                        <use xlink:href="#arrow-r"></use>
                                    </svg>
                                </span>
                            </span>
                        </td>
                    </tr>
                <? endforeach; ?>
                </tbody>
            </table>
        </div>

        <?
        echo trim($arResult["NAV_STRING"]) ? $arResult["NAV_STRING"] : '';
        ?>
    </div>
    <style>
        .catalog__more {
            display: none;
        }
    </style>
<? } else { ?>
    <div class="section-favorites container">
        <div class="section-message container">
            <div class="alert-message">
                <img src="/img/icons/waving-hand.svg" class="alert-message__logo">
                <div class="title title--medium">
                    У вас пока нет ни одного заказа.
                </div>
                <div class="alert-message__text">
                    Перейдите в каталог и добавьте товары в корзину для оформления заказа.
                </div>
                <div class="alert-message__actions">
                    <a href="/catalog/" class="btn">В каталог</a>
                </div>
            </div>
        </div>
    </div>
<? } ?>
