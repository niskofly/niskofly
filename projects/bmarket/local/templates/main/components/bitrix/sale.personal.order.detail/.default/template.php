<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

?>
<div class="order container">
    <div class="order-detail order__main">
        <a href="<?= $arParams['PATH_TO_LIST'] ?>" class="lk-control">
            <span class="lk-control__icon">
              <svg class="icon icon-arrow-l ">
                <use xlink:href="#arrow-l"></use>
              </svg>
            </span>
            <span class="lk-control__text">Вернуться к списку</span>
        </a>
        <div class="order-detail__header">
            <div class="title title--small">
                Заказ № <?= $arResult["ACCOUNT_NUMBER"] ?> от <?= $arResult["DATE_INSERT"]->format('d.m.Y') ?>
            </div>
            <a href="<?= $arResult["URL_TO_COPY"] ?>" class="btn order-detail__btn order-detail__btn--repeat">
                Повторить заказ
            </a>
        </div>
        <?
        $colorStatus = 'product-status--proccess';

        if (in_array($arResult['STATUS_ID'], ['F', 'P']))
            $colorStatus = '';

        if ($arResult["CANCELED"] == 'Y')
            $colorStatus = 'product-status--done';
        ?>
        <div class="order-detail__info">
            <div class="order-detail__info-title">Статус заказа:</div>
            <div class="order-detail__info-status">
                <div class="product-status <?= $colorStatus ?>">
                    <div class="product-status__dot"></div>
                    <div class="product-status__text">
                        <?
                        echo $arResult['CANCELED'] !== 'Y'
                            ? htmlspecialcharsbx($arResult["STATUS"]["NAME"])
                            : Loc::getMessage('SPOD_ORDER_CANCELED');
                        ?>
                    </div>
                </div>
                <? if ($arResult['CANCELED'] !== 'Y'): ?>
                    <a href="<?= $arResult["URL_TO_CANCEL"] ?>" class="btn order-detail__btn order-detail__btn--cancel">
                        Отменить заказ
                    </a>
                <? endif; ?>
            </div>
        </div>

        <?
        $renderProps = ['FIO', 'EMAIL', 'PHONE', 'ADDRESS'];
        ?>
        <div class="order-detail__info">
            <div class="order-detail__info-title">Информация о покупателе</div>
            <? foreach ($renderProps as $code):
                $key = array_search($code, array_column($arResult['ORDER_PROPS'], 'CODE'));
                if ($key === false)
                    continue;

                if (!$prop = $arResult['ORDER_PROPS'][$key])
                    continue;

                $value = $prop['VALUE'];
                if (!$value)
                    continue;

                $value = $code == 'PHONE'
                    ? AuthByPhoneSms::getFormattedPhone($value)
                    : $value;
                ?>
                <div class="order-detail__info-text">
                    <?= $prop['NAME'] ?>: <?= $value ?>
                </div>
            <? endforeach; ?>
        </div>

        <? if (!empty($arResult['SHIPMENT'])): ?>
            <div class="order-detail__info">
                <div class="order-detail__info-title">Информация о доставке</div>
                <? foreach ($arResult['SHIPMENT'] as $shipment) {
                    if (empty($shipment))
                        continue;
                    ?>
                    <div class="order-detail__info-text">
                        Доставка: <?= $shipment['DELIVERY_NAME']; ?>
                    </div>
                    <? if (trim($shipment['TRACKING_URL'])) { ?>
                        <div class="order-detail__info-text">
                            Номер отслеживания:
                            <a href="<?= $shipment['TRACKING_URL'] ?>">
                                <?= htmlspecialcharsbx($shipment['TRACKING_NUMBER']) ?>
                            </a>
                        </div>
                    <? } elseif (!empty($shipment['TRACKING_NUMBER'])) { ?>
                        <div class="order-detail__info-text">
                            Номер отслеживания: <?= htmlspecialcharsbx($shipment['TRACKING_NUMBER']) ?>
                        </div>
                    <? } ?>
                <? } ?>
            </div>
        <? endif; ?>

        <? if (!empty($arResult['PAYMENT'])): ?>
            <div class="order-detail__info">
                <div class="order-detail__info-title">Информация об оплате</div>
                <? foreach ($arResult['PAYMENT'] as $payment): ?>
                    <div class="order-detail__payment" style="margin-bottom: 20px">
                        <div class="order-detail__info-text">
                            Способ оплаты: <?= $payment["PAY_SYSTEM_NAME"] ?>
                        </div>
                        <div class="order-detail__info-text">
                            Сумма к оплате: <?= $payment["PRICE_FORMATED"] ?>
                        </div>
                        <div class="order-detail__info-text">
                            Статус оплаты: <? echo $payment["PAID"] == 'Y' ? 'оплачено' : 'не оплачено' ?>
                        </div>
                        <?
                        if ($payment["PAID"] !== "Y"
                            && $payment['PAY_SYSTEM']["IS_CASH"] !== "Y"
                            && $payment['PAY_SYSTEM']['ACTION_FILE'] !== 'cash'
                            && $payment['PAY_SYSTEM']['PSA_NEW_WINDOW'] !== 'Y'
                            && $arResult['CANCELED'] !== 'Y'
                            && $arResult["IS_ALLOW_PAY"] !== "N") {
                            ?>
                            <?= $payment['BUFFERED_OUTPUT'] ?>
                        <? } ?>
                    </div>
                <? endforeach; ?>
            </div>
        <? endif; ?>
    </div>

    <div class="order__sidebar">
        <div class="order__sidebar-section">
            <div class="order__sidebar-header">
                <div class="title title--medium">Ваш заказ</div>
            </div>
            <div class="order-calculate">
                <div class="order-calculate__list">
                    <? foreach ($arResult['BASKET'] as $basketItem) { ?>
                        <div class="order-calculate__item">
                            <a href="<?= $basketItem['DETAIL_PAGE_URL'] ?>"
                               class="order-calculate__item-label">
                                <?= $basketItem["NAME"] ?>
                            </a>
                            <div class="order-calculate__item-value">
                                <?= $basketItem["QUANTITY"] ?>
                                х
                                <?= ItemsBitrixCart::getFormattedPrice($basketItem["PRICE"]) ?>
                            </div>
                        </div>
                    <? } ?>
                </div>
                <div class="order-calculate__total">
                    <div class="order-calculate__total-label">
                        Всего к оплате
                    </div>
                    <div class="order-calculate__total-value">
                        <?= ItemsBitrixCart::getFormattedPrice($arResult['PRICE']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
