<?php

use Bitrix\Main\Loader;
use Sotbit\Regions\Internals\RegionsTable;
use Sotbit\Regions\Internals\FieldsTable;

class SiteInfo
{
  public static $vetLavka = [
    'workTime' => 'Пн-Пт с 8:00 до 18:00',
    'phone' => '+7 (495) 777-54-90',
    'address' => 'Москва',
    'addressDetailed' => 'г. Москва, 2-й Капотнинский проезд, д.1, стр.2',
    'instagram' => 'https://www.instagram.com/vet.lavka/',
    'vk' => 'https://vk.com/vetlavka',
    'fb' => 'https://www.facebook.com/vetlavka.global',
    'email' => 'zakaz@vetlavka.ru'
  ];

  public static $globalVet = [
    'workTime' => 'Пн-Вт с 8:00 до 18:00',
    'phone' => '+7 (495) 777-54-90',
    'address' => 'Москва',
    'addressDetailed' => 'г. Москва, 2-й Капотнинский проезд, д.1, стр.2',
    'warehouse' => 'Склад: 109429, г. Москва, 2-й Капотнинский пр-д, д.2, стр. 2',
    'instagram' => 'https://www.instagram.com/globalVet',
    'vk' => 'https://vk.com/globalVet',
    'twitter' => 'https://www.twitter.com/globalVet',
    'fb' => 'https://www.facebook.com/globalVet',
    'youTube' => 'https://www.youtube.com/channel/globalVet',
    'email' => 'shop@globalVet.ru'
  ];

  /**
   * Получить значение настройки через свойство или возвращающую функцию
   * @param $site
   * @param $code
   * @return mixed
   */
  public static function getItem($site, $code)
  {
    if (method_exists(get_called_class(), $site)) {
      return self::$site()[$code];
    }

    if (property_exists(get_called_class(), $site)) {
      return self::$$site[$code];
    }
  }

  /**
   * Получить список ссылок на соц. сети
   * @param $site
   * @return array
   */
  public static function getSocialLinks($site): array
  {
    $socials = ['instagram', 'vk', 'fb', 'youtube'];
    $result = [];

    foreach ($socials as $social) {
      if ($link = self::getItem($site, $social))
        $result[$social] = $link;
    }

    return $result;
  }

  /**
   * Получить список доступных для выбора годов
   * @return array
   */
  public static function getAvailableYears(): array
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
   * @return array
   */
  public static function getAvailableDays(): array
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
  public static function getAvailableMonths(): array
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

  public static function getInfoByGallery($galleryId = null): ?array
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
}
