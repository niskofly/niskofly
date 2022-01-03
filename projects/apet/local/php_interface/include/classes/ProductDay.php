<?php


class ProductDay
{
    protected $IBLOCK_CATALOG_ID;
    protected $IBLOCK_PRODUCTS_DAY_ID;

    public function __construct($iblockCatalogId, $iblockProductsDayId)
    {
        $this->IBLOCK_CATALOG_ID = $iblockCatalogId;
        $this->IBLOCK_PRODUCTS_DAY_ID = $iblockProductsDayId;
    }

    /**
     * Получение информации о товаре дня
     * @return array
     * @throws Exception
     */
    public function getProductsDayList(): array
    {
        $products = [];

        $obProducts = CIBlockElement::GetList(
            ['SORT' => 'ASC'],
            ['IBLOCK_ID' => $this->IBLOCK_PRODUCTS_DAY_ID, 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'],
            false,
            false,
            ['*']
        );

        while ($obProduct = $obProducts->GetNextElement()) {
            $fields = $obProduct->GetFields();
            $properties = $obProduct->GetProperties();

            $products[$properties['BIND_PRODUCT']['VALUE']] = [
                'NAME' => $fields['NAME'],
                'DATA_ACTIVE_FROM' => $fields['DATE_ACTIVE_FROM'],
                'DATA_ACTIVE_TO' => $fields['DATE_ACTIVE_TO'],
            ];
        }

        if (empty($products))
            return [];

        /**
         * Заполняем данные о реальном товаре
         */
        $productCatalog = $this->getProductsCatalog(array_keys($products));
        foreach ($products as $id => $data) {
            if (!array_key_exists($id, $productCatalog))
                unset($products[$id]);
            $products[$id]['PRODUCT_DATA'] = $productCatalog[$id];
        }

        return $products;
    }

    /**
     * Получение продуктов из основного каталога
     * @param $IDs
     * @return array
     * @throws Exception
     */
    public function getProductsCatalog($IDs): array
    {
        $products = [];

        $obProducts = CIBlockElement::GetList(
            ['SORT' => 'ASC'],
            ['IBLOCK_ID' => $this->IBLOCK_CATALOG_ID, 'ACTIVE' => 'Y', '=ID' => $IDs],
            false,
            false,
            ['*']
        );

        while ($obProduct = $obProducts->GetNextElement()) {
            $fields = $obProduct->GetFields();
            $properties = $obProduct->GetProperties();
            $products[$fields['ID']] = [
                'NAME' => $fields['NAME'],
                'PREVIEW_TEXT' => $fields['PREVIEW_TEXT'],
                'BRAND' => getNameElementById($properties['BRAND']['VALUE']),
                'IMG' => $fields['PREVIEW_PICTURE']
                  ? CFile::GetPath($fields['PREVIEW_PICTURE'])
                  : CFile::GetPath($fields['DETAIL_PICTURE']),
                'DETAIL_URL' => $fields['DETAIL_PAGE_URL'],
                'PRICE_DATA' => $this->getProductsPrice($fields['ID']),
            ];
        }

        return $products;
    }

    /**
     * Получение информации о цене продукта по его id
     * @param $productId
     * @return array|false
     */
    protected function getProductsPrice($productId)
    {
        global $USER;

        if (!$priceData = CCatalogProduct::GetOptimalPrice($productId, 1, $USER->GetUserGroupArray(), 'N'))
            return false;

        return [
            'PRICE' => $priceData['PRICE']['PRICE'],
            'DISCOUNT_PRICE' => $priceData['RESULT_PRICE']['DISCOUNT_PRICE'],
            'DISCOUNT' => $priceData['RESULT_PRICE']['DISCOUNT'],
            'DISCOUNT_PERCENT' => $priceData['RESULT_PRICE']['PERCENT']
        ];
    }
}