@php
    //$arrCustomers = App\Models\Customer::active()->get();

    //foreach ($arrCustomers as $item) {
        //$CustomersCity[] = $item->city;
   // }


    //$countHalf = count($CustomersCity)/2 ;
    //$CustomersCity = array_unique($CustomersCity);
    //asort($CustomersCity);
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
            <a href="/clients" class="link--hover-dark-blue">Смотреть на карте
                @php(icon(32))
            </a>
        </div>
    </div>
</div>
