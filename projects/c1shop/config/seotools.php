<?php

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults' => [
            'title' => false, // set false to total remove
            'description' => '«Вектор» поможет Вам приобрести профессиональное стиральное оборудование для прачечной и химчистки. Промышленное стиральное оборудование для прачечных и химчисток от моровых производителей.', // set false to total remove
            'separator' => ' - ',
            'keywords' => [],
            'canonical' => false, // Set null for using Url::current(), set false to total remove
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title' => false,
            'description' => '«Вектор» поможет Вам приобрести профессиональное стиральное оборудование для прачечной и химчистки. Промышленное стиральное оборудование для прачечных и химчисток от моровых производителей.',
            'url' => false,
            'image:type' => 'image/jpg',
            'site_name' => 'Вектор оборудование для прачечной',
            //'image' => 'https://www.laundrypro.ru/img/logo.png',
            'type' => 'website',
            'locale' => 'ru_RU',
            'images' => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card' => 'summary_large_image',
            'site' => 'Вектор оборудование для прачечной',
            'creator' => 'Вектор',
            'domain' => 'https://www.laundrypro.ru/',
            'image:src' => 'https://www.laundrypro.ru/img/logo.png',
            'description' => '«Вектор» поможет Вам приобрести профессиональное стиральное оборудование для прачечной и химчистки. Промышленное стиральное оборудование для прачечных и химчисток от моровых производителей.',

        ],
    ],
];
