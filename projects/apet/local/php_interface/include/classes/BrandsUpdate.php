<?php

class BrandsUpdate
{
    protected $mainIBlock = 29;
    protected $brandIBlock = 12;

    /**
     * Создание элемента в bitrix
     * @param $code
     * @return array
     */
    public function createBitrixElement($code): array
    {
        $response = [];

        $elements = self::getPropertiesValues($code);

        foreach ($elements as $elementID => $elementValue) {
            $elementHandler = new CIBlockElement;

            $elementProperties = [
                "PROPERTY_LIST_ID" => $elementID
            ];
            $loadElementData = [
                "IBLOCK_ID" => $this->brandIBlock,
                "IBLOCK_SECTION_ID" => false,
                "NAME" => $elementValue['NAME'],
                "ACTIVE" => "Y",
                "PROPERTY_VALUES" => $elementProperties
            ];

            $createElementID = $elementHandler->Add($loadElementData);
            $response[] = $createElementID ?: $elementHandler->LAST_ERROR;
        }

        return $response ?: [];
    }

    /**
     * Получение элементов из свойства
     * @param $code
     * @return array
     */
    protected function getPropertiesValues($code): array
    {
        $brandProperties = CIBlockPropertyEnum::GetList(
            ['ID' => 'ASC'],
            [
                'ACTIVE' => 'Y',
                'IBLOCK_ID' => $this->mainIBlock,
                'CODE' => $code,
            ]
        );

        $response = [];

        while ($brandProperty = $brandProperties->GetNext()) {
            $response[$brandProperty['ID']] = [
                'NAME' => $brandProperty['VALUE']
            ];
        }

        return $response ?: [];
    }


    /**
     * Заполнение первой буквы
     */
    public function setProductFirstLetter()
    {

    }


    /**
     * Установка свойства в элемент
     */
    public function setProductBrand()
    {
        $elements = self::getProductsValues();

        foreach ($elements as $elementID => $elementValue) {
            CIBlockElement::SetPropertyValuesEx(
                $elementID,
                false,
                ['BRAND' => $this->getProductIdByListId($elementValue['MARK_ID'])]
            );
        }
    }

    /**
     * Изменение бренда у товара
     * @return array
     */
    protected function getProductsValues(): array
    {
        $response = [];
        $fields = ['ID', 'NAME', 'IBLOCK_ID', 'PROPERTY_MARKA'];

        $query = CIBlockElement::GetList(
            ['ID' => 'ASC'],
            ['IBLOCK_ID' => $this->mainIBlock],
            false,
            false,
            $fields
        );

        while ($element = $query->GetNext())
            $response[$element['ID']] = [
                'NAME' => $element['NAME'],
                'MARK_ID' => $element['PROPERTY_MARKA_ENUM_ID'],
            ];

        return $response ?: [];
    }

    /**
     * Получение id element по list id
     * @param $brandPropertyID
     * @return false|mixed
     */
    protected function getProductIdByListId($brandPropertyID)
    {
        $fields = ['ID', 'NAME', 'IBLOCK_ID', 'PROPERTY_MARKA'];

        $query = CIBlockElement::GetList(
            ['ID' => 'ASC'],
            ['IBLOCK_ID' => $this->brandIBlock, 'PROPERTY_LIST_ID' => $brandPropertyID],
            false,
            false,
            $fields
        );

        if ($element = $query->GetNext())
            return $element['ID'];

        return false;
    }
}