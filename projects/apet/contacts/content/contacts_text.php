<div class="page__title title">
  <h1 class="seo-title">
    Контакты
  </h1>
</div>
<div class="page-sides">
  <div class="page-sides__left">

    <?
    $points = [
      [
        'name' => 'ООО "Ветлавка"',
        'address' => 'г. Москва, ул. Трофимова, 36, корп. 1, Москва (ТЦ Бриз)',
        'phone' => '+7 (495) 777-18-15',
        'COORDINATE' => ['55.703677,37.685701'],
      ],
      [
        'name' => 'ООО "Ветлавка"',
        'address' => 'г. Москва, 2-й Капотнинский проезд, д.1. стр.3',
        'phone' => '8(495) 777-54-90',
        'COORDINATE' => ['55.639827,37.812938'],
      ],
      [
        'name' => 'ООО "Ветлавка"',
        'address' => 'г. Краснодар, ул. Воронежская 47/3',
        'phone' => '8 (861) 205-03-60',
        'COORDINATE' => ['45.000695,39.025331'],
      ],
      [
        'name' => 'ООО "Ветлавка"',
        'address' => 'г. Воронеж, ул. Новгородская, д.126г',
        'phone' => '8(473) 2000-285',
        'COORDINATE' => ['51.700167,39.149541'],
      ],
      [
        'name' => 'ООО "Ветлавка"',
        'address' => 'г. Воронеж, ул. 9 Января, 168',
        'phone' => '8 (473) 200-02-85',
        'COORDINATE' => ['51.674941,39.149029'],
      ],
      [
        'name' => 'ООО "Ветлавка"',
        'address' => 'г. Ростов-на-Дону, Проспект Королева 10/4, 1 этаж. ТРК Орбита',
        'phone' => '8(863)30-90-147',
        'COORDINATE' => ['47.294305,39.704952'],
      ],
      [
        'name' => 'ООО "Ветлавка"',
        'address' => 'г. Ростов-на-Дону, проспект 40-летия Победы, 320А',
        'phone' => '+7 (863) 309-01-87',
        'COORDINATE' => ['47.241395,39.836654'],
      ],
      [
        'name' => 'ООО "Ветлавка"',
        'address' => 'г. Самара, ул. Фрунзе, 96, литер А, ТЦ Европа',
        'phone' => '8 (846) 970-71-44',
        'COORDINATE' => ['53.188643,50.091749'],
      ],
      [
        'name' => 'ООО "Ветлавка"',
        'address' => 'г. Шебекино, Белгородская область, Харьковская 1, ТЦ Галерея',
        'phone' => '+7 (472) 220-59-52',
        'COORDINATE' => ['50.406888,36.89671'],
      ]
    ];
    ?>

    <script>
      window.shops = <?= json_encode($points) ?>
    </script>

    <style>
      .simple-map {
        width: 100%;
        height: 400px;
      }
    </style>

    <div id="js-simple-map" class="simple-map"></div>

    <div class="typography">
      <div class="row page-block-view">
        <p><strong>ООО "Ветлавка"</strong></p>
        <ul>
          <li>г. Москва, ул. Трофимова, 36, корп. 1, Москва (ТЦ Бриз),
            <span style="color: #333333;">+7 (495) 777-18-15</span></li>
          <li>г. Москва, 2-й Капотнинский проезд, д.1. стр.3;&nbsp;тел.&nbsp;8(495) 777-54-90</li>
          <li>г. Краснодар, ул. Воронежская 47/3, тел. 8 (861) 205-03-60 <span style="color: gray;">&nbsp;</span></li>
          <li>г. Воронеж, ул. Новгородская, д.126г; тел.<strong>&nbsp;</strong>8(473) 2000-285</li>
          <li>г. Ростов-на-Дону, Проспект Королева 10/4, 1 этаж. ТРК Орбита,&nbsp;тел. 8(863)30-90-147</li>
          <li>г. Самара, ул. Фрунзе, 96, литер А, ТЦ Европа, тел.: 8 (846) 970-71-44</li>
          <li>г. Ростов-на-Дону,&nbsp;ул. Евдокимова, 102Б 8(863)30-90-187</li>
          <li>г. Воронеж, ул. 9 Января, 168. +7 (473) 200-93-15</li>
          <li>г. Шебекино, Белгородская область, Харьковская 1, ТЦ Галерея, тел +7 (472) 220-59-52</li>
          <li>г. Ростов-на-Дону, <span style="color: #3e2c38;">проспект 40-летия Победы, 320А, +</span>7 (863) 309-01-87
          </li>
        </ul>
        <p><br></p>
        <p><strong>ООО «ВЕТЛАВКА»</strong></p>
        <p>Юридический адрес: 109428, г. Москва, Рязанский проспект, д.8а, стр.14, этаж 8, помещение I, комната 3</p>
        <p>Электронная почта: Moscow@vetlavka.ru</p>
        <p>Телефон: <a href="tel:%20+74957775490">+7 (495) 777-22-91</a></p>
        <p>Генеральный директор, действующий на основании Устава: Сорокина Елена Витальевна</p>
        <p>Идентификационный номер налогоплательщика (ИНН) 5041204500</p>
        <p>Код причины постановки (КПП) 772101001</p>
        <p>ОГРН 1165012052050</p>
        <p><br></p>
      </div>
    </div>
  </div>
  <div class="page-sides__right">
    <div class="help-aside">
      <span class="help-aside__title"><?= SiteInfo::getItem('vetLavka', 'phone') ?></span>
      <div class="help-aside__description">Мы рады помочь вам 24/7</div>
      <div class="help-aside__button">
        <a href="tel: <?= SiteInfo::getItem('vetLavka', 'phone') ?>" class="btn">Связаться с нами</a>
      </div>
    </div>
    <div class="contacts-aside">
      <div class="contacts-aside__title">Центральный офис</div>
      <div class="contacts-aside__element">
        <div class="contacts-aside__element-icon"></div>
        <div class="contacts-aside__element-description"><?= SiteInfo::getItem('vetLavka', 'addressDetailed') ?></div>
      </div>
      <div class="contacts-aside__element">
        <div class="contacts-aside__element-icon"></div>
        <a href="tel: <?= SiteInfo::getItem('vetLavka', 'phone') ?>"
           class="contacts-aside__element-description"><?= SiteInfo::getItem('vetLavka', 'phone') ?></a>
      </div>
      <div class="contacts-aside__element">
        <div class="contacts-aside__element-icon"></div>
        <a href="mailto: <?= SiteInfo::getItem('vetLavka', 'email') ?>"
           class="contacts-aside__element-description"><?= SiteInfo::getItem('vetLavka', 'email') ?></a>
      </div>
    </div>
  </div>
</div>
<br>
