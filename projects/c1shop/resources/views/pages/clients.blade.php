@php
    $arrCustomers = App\Models\Customer::active()->get();


    foreach ($arrCustomers as $item) {
        $CustomersCity[] = $item->city;
    }


    $countHalf = count($CustomersCity)/2 ;
    $CustomersCity = array_unique($CustomersCity);
    asort($CustomersCity);

    //$i = 0;
    //foreach ($CustomersCity as $key => $city){
    //    if($i%2){
    //        $arrCustomersCity[0][] = $city;
    //    } else {
    //        $arrCustomersCity[1][] = $city;
    //    }
    //    $i++;
    //}
    $showCity = [];
    $showCity[] = 'Москва';
    $showCity[] = 'Санкт-Петербург';
    $showCity[] = 'Казань';
    $showCity[] = 'Красноярск';
    $showCity[] = 'Сочи';
    $showCity[] = 'Крым';
    $showCity[] = 'Омск';
    $showCity[] = 'Воронеж';
    $showCity[] = 'Архангельск';
    $showCity[] = 'Ярославль';
    $showCity[] = 'Махачкала';
    $showCity[] = 'Ростов-на-Дону';
    $showCity[] = 'Тюмень';
    $showCity[] = 'Магнитогорск';
    $showCity[] = 'Южно-Сахалинск';
    $showCity[] = 'Самара';
    $showCity[] = 'Барнаул';
    $showCity[] = 'Чебоксары';
    $showCity[] = 'Якутск';
    $showCity[] = 'Ухта';
    $showCity[] = 'Владимир';
    $showCity[] = 'Вологда';
    asort($showCity);
    $CustomersCity = array_chunk($showCity, 11);
    $arrCustomersCity[0] = $CustomersCity[0];
    $arrCustomersCity[1] = $CustomersCity[1];
@endphp

@extends('layout')

@section('bread_crumbs')
    <div class="b-bread-crumbs"><a href="/" class="bread-crumbs__item">Главная</a>
        <div class="bread-crumbs__item">Клиенты</div>
    </div>
@endsection

@section('content')
    <div class="page-clients">
        <div class="title_bold"><h1 class="seo-header">Клиенты</h1></div>
        <div class="b-our-clients">
            <div class="title">Нашими клиентами стали<span>более 800 компаний</span>по всей России</div>
            <div class="b-our-clients__list">
                <ul>
                    @foreach($arrCustomersCity[0] as $CustomerCity)

                        @if($loop->index < 11)
                            <li>{{$CustomerCity}}</li>
                        @else
                            @break
                        @endif

                    @endforeach
                </ul>
                <ul>
                    @if(count($arrCustomersCity) > 1)
                        @foreach($arrCustomersCity[1] as $CustomerCity)

                            @if($loop->index < 10)
                                <li>{{$CustomerCity}}</li>
                            @else
                                @break
                            @endif

                        @endforeach
                    @endif
                    <li>Ижевск и другие</li>
                </ul>
                <div class="lint-to-map-page">
                    <a href="#" class="link--hover-dark-blue" style="outline: none!important;"
                       onclick="open_magnific_popup('.clients-popup'); return false;" >Смотреть всех клиентов
                        @php(icon(32))
                    </a>
                </div>
            </div>
        </div>
        <div id="js-clients-map" class="b-clients-map"></div>

        {{--блок логотипов клиентов--}}
        @include('components.clients-logo')

        @widget('reviews')

    </div>

    {{--Клиенты по всей России--}}
    @include('components.customers_popup')

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
    <script>
        ymaps.ready(function () {

            var myMap = new ymaps.Map('js-clients-map', {
                    center: [55.751574, 37.573856],
                    zoom: 9,
                    behaviors: ['default', 'scrollZoom']
                }, {
                    searchControlProvider: 'yandex#search'
                }),
                /**
                 * Создадим кластеризатор, вызвав функцию-конструктор.
                 * Список всех опций доступен в документации.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Clusterer.xml#constructor-summary
                 */
                clusterer = new ymaps.Clusterer({
                    /**
                     * Через кластеризатор можно указать только стили кластеров,
                     * стили для меток нужно назначать каждой метке отдельно.
                     * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/option.presetStorage.xml
                     */
                    preset: 'islands#blueClusterIcons',
                    clusterIcons: [
                        {
                            href: '/img/map-claster.png',
                            size: [40, 40],
                            offset: [-20, -20]
                        }],
                    //clusterIconContentLayout: null,
                    /**
                     * Ставим true, если хотим кластеризовать только точки с одинаковыми координатами.
                     */
                    groupByCoordinates: false,
                    /**
                     * Опции кластеров указываем в кластеризаторе с префиксом "cluster".
                     * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/ClusterPlacemark.xml
                     */
                    clusterDisableClickZoom: true,
                    clusterHideIconOnBalloonOpen: false,
                    geoObjectHideIconOnBalloonOpen: false
                }),
                /**
                 * Функция возвращает объект, содержащий данные метки.
                 * Поле данных clusterCaption будет отображено в списке геообъектов в балуне кластера.
                 * Поле balloonContentBody - источник данных для контента балуна.
                 * Оба поля поддерживают HTML-разметку.
                 * Список полей данных, которые используют стандартные макеты содержимого иконки метки
                 * и балуна геообъектов, можно посмотреть в документации.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/GeoObject.xml
                 */
                getPointData = function (infoClient) {
                    return {
                        balloonContentHeader: '<font size=3><b>' + infoClient.city + '</b></font>',
                        balloonContentBody: '<p>' + infoClient.name + '</p>',
                        balloonContentFooter: '<p>' + infoClient.address + '</p>'
                    };
                },
                /**
                 * Функция возвращает объект, содержащий опции метки.
                 * Все опции, которые поддерживают геообъекты, можно посмотреть в документации.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/GeoObject.xml
                 */
                getPointOptions = function () {
                    return {
                        preset: 'islands#darkBlueClusterIcons',
                        iconLayout: 'default#image',
                        iconImageHref: '/img/placemark-icon.png',
                        iconImageSize: [23, 31]
                    };
                },
                points = [
                        @foreach($arrCustomers as $Customer)
                    [{{$Customer->coordinates}}],
                    @endforeach
                ],
                geoObjects = [];
            myMap.behaviors.disable('scrollZoom');

            infoClients = [
                    @foreach($arrCustomers as $Customer)
                {
                    "name": '{{$Customer->name}}',
                    'address': '{{$Customer->address}}',
                    'city': '{{$Customer->city}}'
                },
                @endforeach
            ];
            /**
             * Данные передаются вторым параметром в конструктор метки, опции - третьим.
             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Placemark.xml#constructor-summary
             */
            for (var i = 0, len = points.length; i < len; i++) {
                geoObjects[i] = new ymaps.Placemark(points[i], getPointData(infoClients[i]), getPointOptions());
            }

            /**
             * Можно менять опции кластеризатора после создания.
             */
            clusterer.options.set({
                gridSize: 80,
                clusterDisableClickZoom: false
            });

            /**
             * В кластеризатор можно добавить javascript-массив меток (не геоколлекцию) или одну метку.
             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Clusterer.xml#add
             */
            clusterer.add(geoObjects);
            myMap.geoObjects.add(clusterer);

            /**
             * Спозиционируем карту так, чтобы на ней были видны все объекты.
             */

            myMap.setBounds(clusterer.getBounds(), {
                checkZoomRange: true
            });
        });
    </script>
@endsection
