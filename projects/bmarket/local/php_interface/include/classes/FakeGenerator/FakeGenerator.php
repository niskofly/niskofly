<?php

use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

class FakeGenerator
{
    protected $faker;
    protected $locale = '';

    public function __construct($locale = 'ru_RU')
    {
        define("NO_AGENT_CHECK", true);
        require __DIR__ . '/autoload.php';

        $this->faker = Faker\Factory::create($locale);
        $this->locale = $locale == 'en_EN' ? 'en' : 'ru';
        CModule::IncludeModule("iblock");
        CModule::IncludeModule('highloadblock');
    }

    /**
     * Получить и сохранить в базе файковое изображение
     * @param array $sizes
     * @param string $category
     * @return array
     */
    protected function generateImage($sizes = [800, 800], $category = 'abstract')
    {
        if ($image = $this->faker->image(__DIR__ . '/images/', $sizes[0], $sizes[1], $category))
            return CFile::MakeFileArray($image);
    }

    /**
     * Сохранить элементы в структуре битрикс
     * @param array $elements
     */
    protected function generateElements($elements = [])
    {
        $iblock = new CIBlockElement;
        foreach ($elements as $element) {
            $elementId = $iblock->Add($element);
            if (!$elementId)
                dd("Error: " . $iblock->LAST_ERROR);
        }

        dump('Добавлено элементов:' . count($elements));
    }

    /**
     * Сохранить товар в каталог и заполнить поля стоимость и наличие на складе
     * @param array $elements
     */
    protected function generateGoods($elements = [])
    {
        $iblock = new CIBlockElement;
        foreach ($elements as $element) {
            if ($elementId = $iblock->Add($element)) {
                CCatalogProduct::Add([
                    'ID' => $elementId,
                    'VAT_ID' => 1,
                    'VAT_INCLUDED' => 'Y',
                    'QUANTITY' => 100,
                    'TYPE' => \Bitrix\Catalog\ProductTable::TYPE_PRODUCT
                ]);

                CPrice::Add([
                    'PRODUCT_ID' => $elementId,
                    'CATALOG_GROUP_ID' => 1,
                    'CURRENCY' => 'RUB',
                    'PRICE' => $this->faker->numberBetween(300, 2000),
                ]);
            } else
                echo "Error: " . $iblock->LAST_ERROR;
        }

        dump('Добавлено элементов:' . count($elements));
    }

    protected function getEntityDataClass($HlBlockId)
    {
        if (empty($HlBlockId) || $HlBlockId < 1) {
            return false;
        }
        $hlblock = HLBT::getById($HlBlockId)->fetch();
        $entity = HLBT::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        return $entity_data_class;
    }

    protected function getIblockDataClass($lBlockId)
    {
        if (empty($lBlockId) || $lBlockId < 1) {
            return false;
        }
        $hlblock = HLBT::getById($lBlockId)->fetch();
        $entity = HLBT::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();
        return $entity_data_class;
    }

    /**
     * Получить список разделов
     * @param $iblockId
     * @return array
     */
    protected function getSections($iblockId)
    {
        $sectionsList = [];

        $sectionsQuery = CIBlockSection::GetList(['SORT' => 'ASC'], ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'], false, ['ID']);
        while ($section = $sectionsQuery->GetNext())
            $sectionsList[] = $section['ID'];

        return $sectionsList;
    }

    /**
     * Получить список элементов из раздела
     * @param $iblockId
     * @return array
     */
    protected function getElementList($iblockId)
    {
        $list = [];

        $listQuery = CIBlockElement::GetList(['SORT' => 'ASC'], ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'], false, false, ['ID']);
        while ($author = $listQuery->GetNext())
            $list[] = $author['ID'];

        return $list;
    }

    /**
     * Получить список вариантов для списка выбора
     * @param $iblockId
     * @param $code
     * @return array
     */
    protected function getOptionsList($iblockId, $code)
    {
        $list = [];

        $propertyQuery = CIBlockPropertyEnum::GetList([], ['IBLOCK_ID' => $iblockId, 'CODE' => $code]);
        while ($option = $propertyQuery->GetNext())
            $list[] = $option['ID'];

        return $list;
    }

    protected function getElementCode($str)
    {
        return CUtil::translit($str, $this->locale, ['replace_space' => '-', 'replace_other' => '-']);
    }
}
