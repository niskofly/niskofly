<?php

use Bitrix\Main\Loader,
    Bitrix\Main\Context,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Fuser,
    \Bitrix\Main\Data\Cache,
    Bitrix\Currency\CurrencyManager;

CModule::IncludeModule('sale');

class ItemsBitrixCart
{
    const CATALOG_ID = CATALOG_ID;

    /**
     * Обработчик работы с корзиной
     *
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
        if ($settings['quantity'] == 0) {
            self::removeItemInCart($settings);
        } else {
            self::addOrChangeItemInCart($settings);
        }

        return self::getCountBasketItems();
    }

    /**
     * Добавить или изменить количество товаров в корзине
     *
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
     *
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
        $properties = self::getAddCartProductProperties($settings);

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
     *
     * @param $settings
     * @return string
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     */
    public static function getECommerceData($settings)
    {
        switch ($_POST['COUNTER_ACTION']) {
            /**
             * Добавление товара
             */
            case 'BUY' :
                $basket = self::getUserBasket();
                $properties = self::getAddCartProductProperties($settings);
                $basketItem = $basket->getExistsItem('catalog', $settings['product_id'], $properties);
                $response = [
                    'ecommerce' => [
                        'add' => [
                            'products' => [
                                'id' => $basketItem->getProductId(),
                                'name' => $basketItem->getField('NAME'),
                                'price' => $basketItem->getPrice(),
                                'category' => "" . SiteInfo::getECommerceCategories($basketItem->getProductId()) . "",
                                'quantity' => $basketItem->getQuantity()
                            ]
                        ]
                    ]
                ];
                break;
            /**
             * Удаление товара из корзины
             */
            case 'REMOVE' :
                $product = CIBlockElement::GetByID($settings['product_id'])->GetNext();
                $response = [
                    'ecommerce' => [
                        'remove' => [
                            'products' => [
                                'id' => $settings['product_id'],
                                'name' => $product['NAME'],
                                'category' => "" . SiteInfo::getECommerceCategories($settings['product_id']) . "",
                                'quantity' => 1
                            ]
                        ]
                    ]
                ];
                break;
            default:
                return null;
                break;
        }

        return json_encode($response);
    }

    /**
     * Получить свойства добавляемого в корзину товара
     *
     * @param $settings
     * @return array
     */
    public static function getAddCartProductProperties($settings)
    {
        $items = [];

        if ($settings['modifiers'] && !empty($settings['modifiers'])) {
            foreach ($settings['modifiers'] as $key => $product) {
                $dbRes = CIBlockElement::GetByID($product['id']);
                if ($result = $dbRes->GetNextElement()) {
                    $info = $result->GetFields();
                }

                $items[] = [
                    'NAME' => 'Топпинг',
                    'CODE' => "MODIFIER_{$product['id']}__QUANTITY_{$product['quantity']}",
                    'VALUE' => "{$info['NAME']} : {$product['quantity']} шт",
                    'SORT' => $key
                ];
            }
        }

        return $items;
    }

    /**
     * Получить отформатированную цену с добавлением символа - "Р" или "р."
     * @param $price
     * @param bool $isSmall
     * @return string
     */
    public static function getFormattedPrice($price, $isSmall = false)
    {
        return $isSmall ? SaleFormatCurrency($price, CCurrency::GetBaseCurrency()) : self::formattedPrice($price) . ' ₽';
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
     *
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
     *
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
     *
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
     *
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
     *
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