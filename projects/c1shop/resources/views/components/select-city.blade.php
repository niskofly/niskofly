<?
$cities = \App\Models\City::published()->get();
$fast_sities = \App\Models\City::Fast()->get();

$current_city = \App\Models\City::getSelectCityFromFromUI();
?>
@if(count($cities) > 0)
    <script src="https://api-maps.yandex.ru/2.1/?apikey=b71483d2-ce0e-4683-af88-d30f7a4a3cb7&lang=ru_RU"></script>
    <script>
        __CITY_LIST__ = {
            @foreach($cities as $city)
            '{{$city->name}}': {
                'NAME': '{{$city->name}}',
                "ID": '{{$city->id}}'
            },
            @endforeach
        };
    </script>

    <div class="city-select">
        <div class="city-select__current">
            Ваш город:
            <span class="js-current-city">
                @if($current_city)
                    {{ $current_city->name }}
                @else
                    {{ 'не выбран' }}
                @endif
            </span>
        </div>
        <button class="city-select__toggle js-show-city-list">другой город</button>

        <div class="city-select__auto js-api-city-container">
            <div class="city-select__auto-name">Ваш город <span class="js-api-city">не выбран</span>?</div>
            <div class="city-select__auto-btn">
                <button class="js-api-city__good btn-blue">Верно</button>
                <button class="js-api-city__bad btn-gray">Другой город</button>
            </div>
        </div>
    </div>

    <div class="city-select__auto--media popup">
        <div class="city-select__auto js-api-city-container">
            <div class="city-select__auto-name">Ваш город <span class="js-api-city">не выбран</span>?</div>
            <div class="city-select__auto-btn">
                <button class="js-api-city__good btn-blue">Верно</button>
                <button class="js-api-city__bad btn-gray">Другой город</button>
            </div>
        </div>
    </div>

    <div class="city-select__popup popup">
        <div class="popup__title">Выберите город</div>
        <div class="city-select__fast">
            @if(count($fast_sities) > 0)
                @foreach($fast_sities as $city)
                    <div class="city-select__fast-wrap">
                        <button class="city-select__fast-item js-fast-select-city"
                                data-city-id="{{$city->id}}"
                                data-city-name="{{$city->name}}">
                            {{$city->name}}
                        </button>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="city-select__form">
            <div class="city-select__find-wrap">
                <input type="text" placeholder="Город" name="city-find" autocomplete="off"
                       class="input city-select__input js-search-city-input">
                <div class="city-select__find js-city-variants">
                </div>
            </div>
            <button class="submit-popup btn-blue js-city-find-set">Выбрать</button>
        </div>
    </div>
@endif