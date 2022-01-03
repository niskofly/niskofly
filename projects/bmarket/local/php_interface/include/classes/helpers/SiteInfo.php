<?php

use Bitrix\Main\Loader;
use Sotbit\Regions\Internals\RegionsTable;
use Sotbit\Regions\Internals\FieldsTable;

class SiteInfo
{
    public static $phone = '+7 (963) 733-35-55';
    public static $contactPhone = '+7 (963) 733-35-55';
    public static $address = '';

    public static $email = 'shop@печальке.net';
    public static $orderEmail = 'shop@печальке.net';

    public static $instagram = 'https://www.instagram.com/bubblegum_che/';
    public static $vk = 'https://vk.com/bubblegum_che';
    public static $viber = 'viber://chat?number=79637333555';
    public static $wathsap = 'https://api.whatsapp.com/send?phone=79637333555';

    /**
     * Получить значение настройки через свойство или возвращаюшую функцию
     * @param $code
     * @return mixed
     */
    public static function getItem($code)
    {
        if (method_exists(get_called_class(), $code)) {
            return self::$code();
        }

        if (property_exists(get_called_class(), $code)) {
            return self::$$code;
        }
    }

    /**
     * Получить список доступных для выбора годов
     *
     * @return array
     */
    public static function getAvailableYears()
    {
        $arData = [];
        $current_year = (int)date('Y');
        $start_year = 2018;

        for ($year = $start_year; $year <= $current_year; $year++) {
            $arData[] = $year;
        }

        return $arData;
    }

    /**
     * Получить список доступных для выбора дней
     *
     * @return array
     */
    public static function getAvailableDays()
    {
        $arData = [];

        for ($day = 1; $day <= 31; $day++) {
            $arData[] = $day;
        }

        return $arData;
    }

    /**
     * Получить список доступных для выбора месяцев
     *
     * @return array
     */
    public static function getAvailableMonths()
    {
        return [
            [
                'name' => 'Январь',
                'value' => '01'
            ],
            [
                'name' => 'Февраль',
                'value' => '02'
            ],
            [
                'name' => 'Март',
                'value' => '03'
            ],
            [
                'name' => 'Апрель',
                'value' => '04'
            ],
            [
                'name' => 'Май',
                'value' => '05'
            ], [
                'name' => 'Июнь',
                'value' => '06'
            ],
            [
                'name' => 'Июль',
                'value' => '07'
            ],
            [
                'name' => 'Август',
                'value' => '08'
            ],
            [
                'name' => 'Сентябрь',
                'value' => '09'
            ],
            [
                'name' => 'Октябрь',
                'value' => '10'
            ],
            [
                'name' => 'Ноябрь',
                'value' => '11'
            ], [
                'name' => 'Декабрь',
                'value' => '12'
            ],
        ];
    }

    public static function getInfoByGallery($galleryId = null)
    {
        if (!$galleryId)
            return null;

        $query = CIBlockElement::GetByID($galleryId);
        if ($gallery = $query->GetNextElement()) {
            $properties = $gallery->GetProperties();
            $images = [];

            foreach ($properties['MORE_PHOTO']['VALUE'] as $imageId)
                if ($src = CFile::GetPath($imageId))
                    $images[] = $src;

            if (empty($images))
                return null;

            return [
                'TITLE' => $properties['GALLERY_TITLE']['VALUE'],
                'IMAGES' => $images
            ];
        }

        return null;
    }

    public static function getClearPhone($phone)
    {
        return str_replace(['-',' '], '', $phone);
    }

    /**
     * Сборка разделов товара учитывая один вышестоящий раздел,
     * если он есть.
     *
     * @param $product_id
     * @return string
     */
    public static function getECommerceCategories($product_id)
    {
        $productSection = CIBlockElement::GetElementGroups($product_id, false)->Fetch();
        $sectionNames = [$productSection['NAME']];
        if ($productSection['IBLOCK_SECTION_ID']) {
            $parentSection = CIBlockSection::GetByID($productSection['IBLOCK_SECTION_ID'])->GetNext();
            $sectionNames[] = $parentSection['NAME'];
        }
        return htmlspecialcharsbx(implode('/', array_reverse($sectionNames)));
    }
}
