<?
/**
 * Выполнение обработки покупки товара в один клик.
 */

use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem;

Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");

class OneClickProductPurchase
{
    protected $siteId;
    protected $currencyCode;
    protected $order;
    protected $orderData;

    public function __construct()
    {
        global $USER;

        $this->siteId = Context::getCurrent()->getSite();
        $this->currencyCode = CurrencyManager::getBaseCurrency();
        $this->order = Order::create($this->siteId, $USER->GetID());
    }

    /**
     * Оформление покупки в один клик
     * @param $data
     * @return string
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\NotSupportedException
     * @throws \Bitrix\Main\ObjectNotFoundException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @throws Exception
     */
    public function buyOneClick($data): string
    {
        if (!$data)
            throw new Exception("Данные не переданы");

        $this->orderData = $data;

        $this->createNewOrder();
        $item = $this->createBasket();
        $this->addingDeliveryInOrder($item);
        $this->addingPaymentInOrder();
        $this->addingPropertyInOrder();

        return $this->saveOrder();
    }

    /**
     * Создание нового заказа
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\NotImplementedException
     */
    protected function createNewOrder()
    {
        $this->order->setPersonTypeId(1);
        $this->order->setField('CURRENCY', $this->currencyCode);
        $this->order->setField('USER_DESCRIPTION', 'One click purchase');
    }

    /**
     * Создание новой корзины
     * @return \Bitrix\Sale\BasketItemBase
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentTypeException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\NotSupportedException
     * @throws \Bitrix\Main\ObjectNotFoundException
     * @throws Exception
     */
    protected function createBasket(): \Bitrix\Sale\BasketItemBase
    {
        if (!$this->orderData['PRODUCT_ID'])
            throw new Exception("Не передан id продукта");

        $basket = Basket::create($this->siteId);
        $item = $basket->createItem('catalog', $this->orderData['PRODUCT_ID']);
        $item->setFields(array(
            'QUANTITY' => $this->orderData['QUANTITY'] ? $this->orderData['QUANTITY'] : 1,
            'CURRENCY' => $this->currencyCode,
            'LID' => $this->siteId,
            'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider',
        ));
        $this->order->setBasket($basket);
        return $item;
    }

    /**
     * Добавление службы доставки
     * @param $item
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ObjectNotFoundException
     * @throws \Bitrix\Main\SystemException
     */
    protected function addingDeliveryInOrder($item)
    {
        $shipmentCollection = $this->order->getShipmentCollection();
        $shipment = $shipmentCollection->createItem();
        $service = Delivery\Services\Manager::getById(Delivery\Services\EmptyDeliveryService::getEmptyDeliveryServiceId());
        $shipment->setFields(array(
            'DELIVERY_ID' => $service['ID'],
            'DELIVERY_NAME' => $service['NAME'],
        ));
        $shipmentItemCollection = $shipment->getShipmentItemCollection();
        $shipmentItem = $shipmentItemCollection->createItem($item);
        $shipmentItem->setQuantity($item->getQuantity());
    }

    /**
     * Добавление метода оплаты
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\NotSupportedException
     */
    protected function addingPaymentInOrder()
    {
        $paymentCollection = $this->order->getPaymentCollection();
        $payment = $paymentCollection->createItem();
        $paySystemService = PaySystem\Manager::getObjectById(1);
        $payment->setFields(array(
            'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
            'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
        ));
    }

    /**
     * Добавление параметров к заказу
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\NotImplementedException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    protected function addingPropertyInOrder()
    {
        $propertyCollection = $this->order->getPropertyCollection();
        $nameProp  = $propertyCollection->getPayerName();
        $nameProp->setValue($this->orderData['NAME']);
        $phoneProp = $propertyCollection->getPhone();
        $phoneProp->setValue($this->orderData['PHONE']);
        $emailProp = $propertyCollection->getUserEmail();
        $emailProp->setValue($this->orderData['EMAIL']);
    }

    /**
     * Сохранение заказа
     * @return string
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ObjectNotFoundException
     * @throws Exception
     */
    protected function saveOrder(): string
    {
        $this->order->doFinalAction(true);
        $this->order->save();
        if ($this->order->getId())
            return "Заказ успешно создан";
        else
            throw new Exception("Произошла ошибка при создании заказа");
    }
}