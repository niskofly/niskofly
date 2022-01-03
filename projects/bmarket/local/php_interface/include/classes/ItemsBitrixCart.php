<?php

use Bitrix\Main\Context,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Fuser,
    Bitrix\Currency\CurrencyManager;

CModule::IncludeModule('sale');

class ItemsBitrixCart
{
    const CATALOG_ID = CATALOG_ID;

    /**
     * Обработчик работы с корзиной
     * @param $settings
     * @return bool|CDBResult Колличество товаров в корзине
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\NotSupportedException
     * @throws \Bitrix\Main\ObjectNotFoundException
     */
    public static function handlerBuy($settings)
    {
        if ($settings['quantity'] == 0)
            self::removeItemInCart($settings);
        else
            self::addOrChangeItemInCart($settings);

        return self::getCountBasketItems();
    }

    /**
     * Добавить или изменить количество товаров в корзине
     * @param $settings
     * @return int|null|string
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\NotSupportedException
     * @throws \Bitrix\Main\ObjectNotFoundException
     */
    public static function addOrChangeItemInCart($settings)
    {
        $basket = self::getUserBasket();
        $productId = $settings['product_id'];
        $quantity = $settings['quantity'];

        if ($basketItem = $basket->getExistsItem('catalog', $productId)) {
            $oldQuantity = $basketItem->getField('QUANTITY');
            $basketItem->setField('QUANTITY', $oldQuantity + $quantity);
            $basketItem->save();
        } else {
            $basketItem = $basket->createItem('catalog', $productId);
            $basketItem->setFields([
                'QUANTITY' => $quantity,
                'CURRENCY' => CurrencyManager::getBaseCurrency(),
                'LID' => Context::getCurrent()->getSite(),
                'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider'
            ]);
            $basketItem->save();
        }

        $basket->save();
    }

    /**
     * Удалить товар из корзины
     * @param $settings
     * @return int|null|string
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\ObjectNotFoundException
     */
    public static function removeItemInCart($settings)
    {
        $basket = self::getUserBasket();
        $properties = [];

        if ($basketItem = $basket->getExistsItem('catalog', $settings['product_id'], $properties)) {
            $result = $basketItem->delete();
            if ($result->isSuccess()) {
                $basket->save();
                return $basketItem->getId();
            }
        }
    }

    /**
     * Получить JSON для Yandex e-commerce описывающий управление товаром
     * @param $settings
     * @return array|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     */
    public static function getECommerceData($settings)
    {
        $productId = $settings['product_id'];

        switch ($_POST['ACTION']) {
            /**
             * Добавление товара
             */
            case 'BUY_PRODUCT' :
                $basket = self::getUserBasket();
                $properties = [];
                $basketItem = $basket->getExistsItem('catalog', $productId, $properties);
                $response = [
                    'id' => $basketItem->getProductId(),
                    'name' => urldecode($basketItem->getField('NAME')),
                    'price' => $basketItem->getPrice(),
                    'category' => SiteInfo::getECommerceCategories($basketItem->getProductId()),
                    'quantity' => $basketItem->getQuantity()
                ];
                break;
            default:
                $product = CIBlockElement::GetByID($productId)->GetNext();
                $response = [
                    'id' => $productId,
                    'name' => urldecode($product['NAME']),
                    'category' => SiteInfo::getECommerceCategories($productId),
                    'price' => self::getOptimalPrice($productId, true),
                    'quantity' => 1
                ];
                break;
        }

        return $response;
    }

    /**
     * Получить отформатированную цену
     * @param $price
     * @param bool $isSmall
     * @return string
     */
    public static function getFormattedPrice($price, $isSmall = false)
    {
        $price = str_replace([' ', '&nbsp;'], '', $price);
        $price = floatval($price);
        return $isSmall ? SaleFormatCurrency($price, CCurrency::GetBaseCurrency()) : self::formattedPrice($price) . '<span class="rubl">i</span>';
    }

    /**
     * Форматирование чисел по общему правилу
     * @param $price
     * @return string
     */
    public static function formattedPrice($price)
    {
        return number_format($price, 0, '.', ' ');
    }

    /**
     * Получить корзину текущего пользователя
     * @return \Bitrix\Sale\BasketBase
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     */
    public static function getUserBasket()
    {
        return Basket::loadItemsForFUser(
            Fuser::getId(),
            Context::getCurrent()->getSite()
        );
    }

    /**
     * Получить наименьшую цену или массив описывающий цену товара по его ID
     * @param $productId
     * @param bool $is_short
     * @return array|bool
     */
    public static function getOptimalPrice($productId, $is_short = false)
    {
        global $USER;
        CCatalogProduct::setUseDiscount(true);
        $arPrice = CCatalogProduct::GetOptimalPrice($productId, 1, $USER->GetUserGroupArray());

        if ($is_short) {
            return $arPrice['RESULT_PRICE']['DISCOUNT_PRICE'];
        } else {
            return $arPrice;
        }
    }


    /**
     * ORDER PRODUCT HANDLER
     */

    /**
     * Удалить товар из заказа, до его оформления
     * @param $basketItemId
     * @return bool|CDBResult
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\ObjectNotFoundException
     */
    public static function removeBasketItem($basketItemId)
    {
        $basket = self::getUserBasket();
        $basket->getItemById($basketItemId)->delete();
        $basket->save();

        return self::getCountBasketItems();
    }

    /**
     * Изменение количества товара в заказе, до его оформления
     * @param $basketItemId
     * @param $quantity
     * @return bool|CDBResult
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     */
    public static function updateBasketItem($basketItemId, $quantity)
    {
        $basket = self::getUserBasket();

        $basketItem = $basket->getItemById($basketItemId);
        $basketItem->setField('QUANTITY', $quantity);
        $basketItem->save();

        return self::getCountBasketItems();
    }


    /**
     * HELPERS CATALOG
     */

    /**
     * Получить количество товарных позиций в корзине
     * @return bool|CDBResult
     */
    public static function getCountBasketItems()
    {
        return CSaleBasket::GetList(
            array(),
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL"
            ),
            array()
        );
    }

    /**
     * Получить обшую стоимость товаров в корзине
     * @return mixed
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     */
    public static function getBasketPrice()
    {
        global $USER;
        $basketStorage = \Bitrix\Sale\Basket\Storage::getInstance(\Bitrix\Sale\Fuser::getId(), \Bitrix\Main\Context::getCurrent()->getSite());
        $basket = $basketStorage->getOrderableBasket();
        $registryOrder = \Bitrix\Sale\Registry::getInstance(\Bitrix\Sale\Registry::REGISTRY_TYPE_ORDER);
        $orderClassName = $registryOrder->getOrderClassName();
        $order = $orderClassName::create(\Bitrix\Main\Context::getCurrent()->getSite(), $USER->GetID());
        $order->appendBasket($basket);
        return $order->getField('PRICE');
    }

    /**
     * Получить количество активных заказов пользователя
     * @return null|integer
     */
    public static function getOrdersCount()
    {
        global $USER;
        if (!$userId = $USER->GetID())
            return null;

        $count = CSaleOrder::GetList([], ['USER_ID' => $userId, 'CANCELED' => 'N'], ['COUNT'])
            ->SelectedRowsCount();

        return $count ?: null;
    }
}
