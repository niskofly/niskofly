<?php

class XmlParserHandler
{
    public $PATH_FILE = '/upload/1c_catalog/bublegum0_1.xml';
    protected const COLLECTION_ID = 7;

    public function __construct()
    {
        $this->PATH_FILE = $_SERVER['DOCUMENT_ROOT'] . $this->PATH_FILE;
    }

    /**
     * Обновить данные по картам лоялности
     * @param null $currentUser
     * @return null
     */
    public function updateLoyaltyCards($currentUser = null)
    {
        $content = $this->parseFile('КартыЛояльности');
        if (!$content)
            return null;

        $cards = $this->prepareLoyaltyCardsData($content);
        if (empty($cards))
            return null;

        $users = [];
        /**
         * Обновляем данные для всех пользователей, либо для конкретного пользователя
         */
        if (!$currentUser) {
            $rsUser = CUser::GetList(($by = "id"), ($order = "desc"), ["=PERSONAL_MOBILE" => array_keys($cards)], ["SELECT" => ["ID", "PERSONAL_MOBILE"]]);
            while ($user = $rsUser->Fetch())
                $users[$user['PERSONAL_MOBILE']] = $user['ID'];
        } else
            $users[$currentUser['PERSONAL_MOBILE']] = $currentUser['ID'];

        foreach ($users as $phone => $userId) {
            if (!BonusUser::getAccount($userId))
                BonusUser::createAccount($userId);

            if (!array_key_exists($phone, $cards))
                continue;

            if ($balance = $cards[$phone]['balance'])
                BonusUser::updateAccountBalance($userId, $balance, 'Синхронизация баланса.');
        }
    }

    /**
     * Подготовить данные карт лоялности
     * @param $content
     * @return array
     */
    protected function prepareLoyaltyCardsData($content)
    {
        $cards = [];

        foreach ($content->Карта as $card) {
            $phone = preg_replace('/^8/', '7', (string)$card->Номер);
            $cards[$phone] = [
                'phone' => $phone,
                'balance' => (int)$card->Баллы,
                'ratio' => (float)$card->Коэффициент,
                'paymentPercentage' => (int)$card->ПроцентОплатыБонусами,
            ];
        }

        return $cards;
    }

    /**
     * Обновить данные по подборкам товаров
     */
    public function updateCollections()
    {
        $content = $this->parseFile('КатегорииНоменклатуры');
        if (!$content)
            return null;

        $collections = $this->prepareCollectionsData($content);
        if (empty($collections))
            return null;

        $existsCollections = [];
        $rsCollections = CIBlockElement::GetList([], [
            'IBLOCK_ID' => self::COLLECTION_ID,
            'XML_ID' => array_keys($collections)
        ], false, [], ['ID', 'XML_ID']);
        while ($collection = $rsCollections->Fetch())
            $existsCollections[$collection['XML_ID']] = $collection['ID'];

        foreach ($collections as $xmlId => $collection) {
            if (array_key_exists($xmlId, $existsCollections))
                $this->updateCollectionProducts($existsCollections[$xmlId], $collection);
            else {
                $collectionId = $this->createCollection($collection);
                $existsCollections[$xmlId] = $collectionId;
            }
        }

        $this->saveInformationAboutCollectionOfProduct($collections, $existsCollections);
    }

    /**
     * Сохранить информацию о коллекциях в свойствах товара
     * @param $collections
     * @param $collectionsId
     */
    public function saveInformationAboutCollectionOfProduct($collections, $collectionsId)
    {
        /**
         * Собираем информацию о том к каким коллекциям принадлежит товар
         */
        $productsMitCollections = [];
        foreach ($collections as $collection)
            foreach ($collection['products'] as $productXml)
                if (array_key_exists($collection['xmlId'], $collectionsId))
                    $productsMitCollections[$productXml][] = $collectionsId[$collection['xmlId']];

        /**
         * Очищаем свойство привязка к коллекции у всех товаров
         */
        $rsProducts = CIBlockElement::GetList([],
            ['IBLOCK_ID' => CATALOG_ID, '!PROPERTY_SELECTIONS' => false],
            false, [], ['ID', 'IBLOCK_ID']);
        while ($product = $rsProducts->Fetch())
            CIBlockElement::SetPropertyValuesEx(
                $product['ID'],
                $product['IBLOCK_ID'],
                ['SELECTIONS' => null]
            );

        /**
         * Устанавливаем свойство привязка к коллекции у товаров
         */
        $productsId = $this->getProductsIdFromXmlId(array_keys($productsMitCollections));
        foreach ($productsId as $xmlId => $productId) {
            $collectionsId = $productsMitCollections[$xmlId];
            CIBlockElement::SetPropertyValuesEx($productId, CATALOG_ID, ["SELECTIONS" => $collectionsId]);
        }
    }

    /**
     * Подготовить данные по коллекциям
     * @param $content
     * @return array
     */
    protected function prepareCollectionsData($content)
    {
        $collections = [];

        foreach ($content->КатегорияНоменклатуры as $collection) {
            $collections[(string)$collection->Идентификатор] = [
                'xmlId' => (string)$collection->Идентификатор,
                'name' => (string)$collection->Наименование,
                'products' => (array)$collection->СписокНоменклатуры->Номенклатура
            ];
        }

        return $collections;
    }

    /**
     *  Создать новую коллекцию
     * @param $collection
     * @return null
     */
    protected function createCollection($collection)
    {
        $handler = new AddElementFromBitrix(self::COLLECTION_ID);
        $arData = [
            "NAME" => $collection['name'],
            "XML_ID" => $collection['xmlId'],
            "ACTIVE" => "Y",
            "PROPERTY_VALUES" => [
                "PRODUCTS" => array_values($this->getProductsIdFromXmlId($collection['products']))
            ]
        ];

        $handler->insert($arData);
        return $handler->newElementId;
    }

    protected function updateCollectionProducts($bitrixCollectionId, $collection)
    {
        CIBlockElement::SetPropertyValuesEx($bitrixCollectionId, self::COLLECTION_ID, [
            "PRODUCTS" => array_values($this->getProductsIdFromXmlId($collection['products']))
        ]);
    }

    /**
     * Получить ID товаров по их внешним кодам
     * @param $xmlId
     * @return array
     */
    protected function getProductsIdFromXmlId($xmlId)
    {
        $list = [];

        $rsProducts = CIBlockElement::GetList([], ["IBLOCK_ID" => CATALOG_ID, 'XML_ID' => $xmlId], false, [], ['ID', 'XML_ID']);
        while ($product = $rsProducts->Fetch())
            $list[$product['XML_ID']] = $product['ID'];

        return $list;
    }

    /**
     * Спарсить XML файл
     * @param null $contentType
     * @return SimpleXMLElement|null
     */
    protected function parseFile($contentType = null)
    {
        if (!file_exists($this->PATH_FILE))
            return null;

        $content = new SimpleXMLElement(file_get_contents($this->PATH_FILE));
        return $contentType ? $content->$contentType : $content;
    }
}
