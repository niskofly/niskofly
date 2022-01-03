@extends('layout')

@section('bread_crumbs')
    <div class="b-bread-crumbs"><a href="/" class="bread-crumbs__item">Главная</a>
        <a href="/service" class="bread-crumbs__item">Сервис</a>
        <div class="bread-crumbs__item">Готовые варианты прачечной/химчистки</div>
    </div>
@endsection

@section('content')
    <style>
        .project-kit__description p {
            margin: 0 0 3px;
        }
    </style>
    <div class="page-gotovye-proekty">
        <div class="title_bold"><h1 class="seo-header">Готовые варианты прачечной/химчистки </h1></div>

        @include('components.form-get-pricelist')

        <p class="gotovye-proekty__text">
            Специалисты фирмы работают с прачечным оборудованием с 2000 года, имеют опыт
            его поставки в различные регионы России. Они помогут Вам подобрать прачечное оборудование для использования
            в гостинице, больнице, детских садах, предприятиях общественного питания или для обработки спецодежды на
            предприятии, а так же готовы предоставить необходимые консультации по организации работы прачечной или
            химчистки.
            Ниже приведены примеры готовых решений прачечных.
        </p>
        <p class="gotovye-proekty__text" style="text-align: justify;">
        Внимание! Стирка махрового белья имеет свои особенности: загрузка стиральной машины производится на 80% от
        паспортных данных машины. Цикл сушки белья в сушильной машине составляет 45-50 мин. Не требует глажки
        (гладильный каток исключается).
        </p>
        @if(count($rusProjects) > 0)
            <div class="title_light title_blue">Оборудование производства Вязьма</div>
            <div class="b-project-kits css-padding-bottom">

                @foreach($rusProjects as $rusProject)

                    <div class="project-kit__item">
                        <div class="project-kit__title"><span>Комплект №{{$loop->index + 1}}
                                . </span>{{$rusProject->name}}</div>
                        <div class="project-kit__description">
                            {!! $rusProject->description !!}
                        </div>
                        <div class="project-kit__table">

                            @php
                                $arrParams = unserialize($rusProject->params);
                            @endphp

                            @foreach($arrParams as $parameter)
                                <div class="project-kit__row">
                                    <div class="project-kit__parameter">{{$parameter['name']}}</div>
                                    <div class="project-kit__value">{{$parameter['value']}}</div>
                                </div>
                            @endforeach
                        </div>
                        <button class="project-kit__button js-add-request-kit"
                                data-id-project="{{$rusProject->id}}"
                                data-name-project="{{$rusProject->name}}"
                        >Оставить заявку
                        </button>
                    </div>

                @endforeach

            </div>
        @endif

        @if(count($importProjects) > 0)
            <div class="title_light title_blue">Импортные (Смена 8 часов, количество циклов 5, белье хлопок, прямое)
            </div>
            <div class="b-project-kits">

                @foreach($importProjects as $importProject)

                    <div class="project-kit__item">
                        <div class="project-kit__title"><span>Комплект №{{$loop->index + 1}}
                                . </span>{{$importProject->name}}</div>
                        <div class="project-kit__description">
                            {!! $importProject->description !!}
                        </div>
                        <div class="project-kit__table">

                            @php
                                $arrParams = unserialize($importProject->params);
                            @endphp

                            @foreach($arrParams as $parameter)
                                <div class="project-kit__row">
                                    <div class="project-kit__parameter">{{$parameter['name']}}</div>
                                    <div class="project-kit__value">{{$parameter['value']}}</div>
                                </div>
                            @endforeach
                        </div>
                        <button class="project-kit__button js-add-request-kit"
                                data-id-project="{{$importProject->id}}"
                                data-name-project="{{$importProject->name}}"
                        >Оставить заявку
                        </button>
                    </div>

                @endforeach

            </div>
        @endif
    </div>
@endsection