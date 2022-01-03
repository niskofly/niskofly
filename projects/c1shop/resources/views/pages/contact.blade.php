@extends('layout')

@section('bread_crumbs')
    <div class="b-bread-crumbs"><a href="/" class="bread-crumbs__item">Главная</a>
        <div class="bread-crumbs__item">Контакты</div>
    </div>
@endsection

@section('content')
    <div class="page-contact">
        <div class="title_bold"><h1 class="seo-header">Контакты</h1></div>
        <div class="title_blue">
            <h2 class="seo-header">Головной офис</h2></div>
        <div class="b-head-office">
            <div class="head-office__col">
                <div class="head-office__title">{{$HeadOffice->city}}</div>
                <div class="head-office__info"><span>{{$HeadOffice->address}}</span>
                    <button class="js-show-map-contacts" data-id-contact="{{$HeadOffice->id}}">Показать на карте</button>
                </div>
                <div class="head-office__info">{{$HeadOffice->time}}</div>
            </div>
            <div class="head-office__col">
                <div class="head-office__info">{!! $HeadOffice->phone_text !!}</div>
                <div class="head-office__info">
                    @if($HeadOffice->email)
                        <span>E-mail: <a href="mailto:{{$HeadOffice->email}}">{{$HeadOffice->email}}</a></span>
                    @endif
                    @if($HeadOffice->skype)
                        <span>Skype: <a href="skype:{{$HeadOffice->skype}}">{{$HeadOffice->skype}}</a></span>
                    @endif
                </div>
            </div>
        </div>

        @if(count($Branches))

            <div class="b-filial">
                <div class="title_blue">
                    <h2 class="seo-header">Филиалы</h2></div>
                <div class="filial__container">

                    @foreach($Branches->slice(0,24) as $Branch)
                        <div class="filial__item">
                            <div class="filial__title">{{$Branch->city}}</div>
                            <div class="filial__map-info">
                                <span>{{$Branch->address}}</span>
                                <button class="js-show-map-contacts" data-id-contact="{{$Branch->id}}">Показать на
                                    карте
                                </button>
                            </div>
                            <div class="filial__contact">
                                {!! $Branch->phone_text  !!}
                                @if($Branch->email)
                                    <span>E-mail: <a href="mailto:{{$Branch->email}}">{{$Branch->email}}</a></span>
                                @endif
                                @if($Branch->skype)
                                    <span>Skype: <a href="skype:{{$Branch->skype}}">{{$Branch->skype}}</a></span>
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif

        @if(count($Pickpoints))

            <div class="b-filial">
                <div class="title_blue">
                    <h2 class="seo-header">Пункты выдачи товара и склады транспортных компаний</h2></div>
                <div class="filial__container">

                    @foreach($Pickpoints->slice(0,24) as $Pickpoint)
                        <div class="filial__item">
                            <div class="filial__title">{{$Pickpoint->city}}</div>
                            <div class="filial__map-info">
                                <span>{{$Pickpoint->address}}</span>
                                <button class="js-show-map-contacts" data-id-contact="{{$Pickpoint->id}}">Показать на
                                    карте
                                </button>
                            </div>
                            <div class="filial__contact">
                                {!! $Pickpoint->phone_text  !!}
                                @if($Pickpoint->email)
                                    <span>E-mail: <a href="mailto:{{$Pickpoint->email}}">{{$Pickpoint->email}}</a></span>
                                @endif
                                @if($Pickpoint->skype)
                                    <span>Skype: <a href="skype:{{$Pickpoint->skype}}">{{$Pickpoint->skype}}</a></span>
                                @endif
                                @if($Pickpoint->transport_company)
                                    <span>Транспортная компания: <strong>{{$Pickpoint->transport_company}}</strong></span>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="filial__readmore">Показать все пункты выдачи</div>

                    @foreach($Pickpoints->slice(24) as $Pickpoint)
                        <div class="filial__item fold folded">
                            <div class="filial__title">{{$Pickpoint->city}}</div>
                            <div class="filial__map-info">
                                <span>{{$Pickpoint->address}}</span>
                                <button class="js-show-map-contacts" data-id-contact="{{$Pickpoint->id}}">Показать на
                                    карте
                                </button>
                            </div>
                            <div class="filial__contact">
                                {!! $Pickpoint->phone_text  !!}
                                @if($Pickpoint->email)
                                    <span>E-mail: <a href="mailto:{{$Pickpoint->email}}">{{$Pickpoint->email}}</a></span>
                                @endif
                                @if($Pickpoint->skype)
                                    <span>Skype: <a href="skype:{{$Pickpoint->skype}}">{{$Pickpoint->skype}}</a></span>
                                @endif
                                @if($Pickpoint->transport_company)
                                    <span>Транспортная компания: <strong>{{$Pickpoint->transport_company}}</strong></span>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div class="filial__hidemore">Свернуть пункты выдачи</div>

                </div>
            </div>
        @endif

        <div id="js-contact-map" class="b-filial-map"></div>
    </div>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
    <script>
        ymaps.ready(function () {

            myMap = new ymaps.Map('js-contact-map', {
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
                    if (infoClient.email) {
                        return {
                            balloonContentHeader: '<font size=3><b>г. ' + infoClient.city + '</b></font>',
                            balloonContentBody: '<div class="span-block">' + infoClient.phone_text + '</div>',
                            balloonContentFooter: '<p>Email: <a href="mailto:' + infoClient.email + '">' + infoClient.email + '</a></p>'
                        };
                    } else {
                        return {
                            balloonContentHeader: '<font size=3><b>г.' + infoClient.city + '</b></font>',
                            balloonContentBody: '<div class="span-block">' + infoClient.phone_text + '</div>',
                            //balloonContentFooter: '<p><a href="mailto:'+infoClient.email+'">'+infoClient.email+'</a></p>'
                        };
                    }
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
                        @foreach($Branches as $Branche)
                    [{{$Branche->coordinates}}],
                        @endforeach
                        @foreach($Pickpoints as $Pickpoint)
                    [{{$Pickpoint->coordinates}}],
                        @endforeach
                    [{{$HeadOffice->coordinates}}]
                ],
                geoObjects = [];
            geoObjects__search = [];
            myMap.behaviors.disable('scrollZoom');

            infoClients = [

                    @foreach($Branches as $Branche)
                {
                    "name": '{{$Branche->name}}',
                    'phone_text': '{!! str_replace(array("\r\n", "\r", "\n"), "", $Branche->phone_text) !!}',
                    'city': '{{$Branche->city}}',
                    'id_city': '{{$Branche->id}}',
                    @if($Branche->email)
                    'email': '{{$Branche->email}}'
                    @endif
                },
                    @endforeach

                    @foreach($Pickpoints as $Pickpoint)
                {
                    "name": '{{$Pickpoint->name}}',
                    'phone_text': '{!! str_replace(array("\r\n", "\r", "\n"), "", $Pickpoint->phone_text) !!}',
                    'city': '{{$Pickpoint->city}}',
                    'id_city': '{{$Pickpoint->id}}',
                    @if($Pickpoint->email)
                    'email': '{{$Pickpoint->email}}'
                    @endif
                },
                    @endforeach

                {
                    "name": '{{$HeadOffice->name}}',
                    'phone_text': '{!! str_replace(array("\r\n", "\r", "\n"), "", $HeadOffice->phone_text) !!}',
                    'city': '{{$HeadOffice->city}}',
                    'email': '{{$HeadOffice->email}}',
                    'id_city': '{{$HeadOffice->id}}',
                },

            ];
            /**
             * Данные передаются вторым параметром в конструктор метки, опции - третьим.
             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/Placemark.xml#constructor-summary
             */
            for (var i = 0, len = points.length; i < len; i++) {
                geoObjects[i] = new ymaps.Placemark(points[i], getPointData(infoClients[i]), getPointOptions());
                geoObjects__search[infoClients[i].id_city] = i;

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
    <style>

    </style>
@endsection
