<?php

use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

class FakeGenerator
{
    protected $faker;
    protected $locale = '';

    public function __construct($locale = 'en_EN')
    {
        define("NO_AGENT_CHECK", true);
        require __DIR__ . '/autoload.php';

        $this->faker = Faker\Factory::create($locale);
        $this->locale = $locale == 'en_EN' ? 'en' : 'ru';
        CModule::IncludeModule("iblock");
        CModule::IncludeModule('highloadblock');
    }

    /**
     * @param int $countItems
     */
    public function generateReviews($countItems = 10)
    {
        $iblockId = 5;
        $elements = [];

        for ($i = 0; $i < $countItems; $i++) {
            $name = $this->faker->text(80);
            $date = $this->faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now', $timezone = null);

            $elements[] = [
                'IBLOCK_ID' => $iblockId,
                'ACTIVE_FROM' => $date->format('d.m.Y H:i:s'),
                'ACTIVE' => 'Y',
                'NAME' => $name,
                'CODE' => $this->getElementCode($name),
                'PREVIEW_TEXT' => $this->faker->realText(500, 2)
            ];
        }

        $this->generateElements($elements);
    }

    /**
     * @param int $countItems
     */
    public function generateRepairs($countItems = 10)
    {
        $iblockId = 6;
        $elements = [];

        for ($i = 0; $i < $countItems; $i++) {
            $name = $this->faker->realText(60, 2);
            $elements[] = [
                'IBLOCK_ID' => $iblockId,
                'ACTIVE' => 'Y',
                'NAME' => $name,
                'CODE' => $this->getElementCode($name),
                'PREVIEW_TEXT' => $this->faker->realText(500, 2),
                'DETAIL_TEXT' => $this->faker->realText(4000, 5),
            ];
        }

        $this->generateElements($elements);
    }

    /**
     * Генерация новостей
     * @param int $countItems
     */
    public function generateNews($countItems = 10)
    {
        $iblockId = 4;
        $elements = [];

        for ($i = 0; $i < $countItems; $i++) {
            $name = $this->faker->text(80);
            $date = $this->faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now', $timezone = null);

            $elements[] = [
                'IBLOCK_ID' => $iblockId,
                'ACTIVE_FROM' => $date->format('d.m.Y H:i:s'),
                'ACTIVE' => 'Y',
                'NAME' => $name,
                'CODE' => $this->getElementCode($name),
                'DETAIL_TEXT' => $this->faker->realText(500, 2),
                'PREVIEW_TEXT' => $this->faker->text
            ];
        }

        $this->generateElements($elements);
    }

    /**
     * @param int $countItems
     */
    public function generateServices($countItems = 10) {
        $iblockId = SERVICE_ID;
        $elements = [];

        /**
         * Список разделов
         */
        $sectionsList = $this->getSections(SERVICE_ID);

        for ($i = 0; $i < $countItems; $i++) {
            $name = $this->faker->text(80);

            $elements[] = [
                'IBLOCK_ID' => $iblockId,
                'IBLOCK_SECTION_ID' => $this->faker->randomElement($sectionsList),
                'ACTIVE' => 'Y',
                'NAME' => $name,
                'CODE' => $this->getElementCode($name),
                'DETAIL_TEXT' => $this->faker->realText(4000, 5),
            ];
        }

        $this->generateElements($elements);
    }
    /**
     * Генерация товаров
     */
    public function generateProducts($countItems = 40)
    {
        $elements = [];

        /**
         * Список разделов
         */
        $sectionsList = $this->getSections(CATALOG_ID);

        for ($i = 0; $i < $countItems; $i++) {
            $name = $this->faker->name;

            $elements[] = [
                'IBLOCK_ID' => CATALOG_ID,
                'ACTIVE' => 'Y',
                'NAME' => $this->faker->text(70),
                'CODE' => $this->getElementCode($name),
                'IBLOCK_SECTION_ID' => $this->faker->randomElement($sectionsList),
                'PREVIEW_TEXT' => $this->faker->realText(500, 3),
                'DETAIL_TEXT' => $this->faker->realText(3000, 4),
                'PROPERTY_VALUES' => [
                    'PRICE' => $this->faker->numberBetween(50000, 10000000),
                    'OLD_PRICE' => $this->faker->numberBetween(50000, 10000000),
                    'IS_SALE' => $this->faker->randomElement(['Y', 'N']),
                    'POPULAR_PRODUCT' => $this->faker->randomElement(['Y', 'N']),
                    'SPECIAL_OFFER' => $this->faker->randomElement(['Y', 'N']),
                    'AVAILABLE_STOCK' => $this->faker->randomElement(['Y', 'N']),
                    'SPECIFICATIONS' => $this->faker->realText(500, 3),
                    'EQUIPMENT' => $this->faker->realText(500, 2),
                ]
            ];
        }

        $this->generateElements($elements);
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