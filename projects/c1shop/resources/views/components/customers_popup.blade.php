@php
    $arrCustomersGroupCity = App\Models\Customer::groupCity();
    ksort($arrCustomersGroupCity);

@endphp

@if( count($arrCustomersGroupCity) > 0)
    <div class="clients-popup popup">
        <div class="popup__title">Более 800 клиентов по всей России</div>
        <div class="clients-popup__tabs">

            @foreach($arrCustomersGroupCity as $nameCity => $arrCustomerCity)

                <div class="clients-tab">
                    <div class="clients-tab__header js-toggle-clients-tab">
                        <div class="clients-tab__city">г. {{$nameCity}}</div>
                        <div class="clients-tab__toggle status-tab_close">
                            <div class="wrap-icon">
                                @php(icon(33))
                                @php(icon(34))
                            </div>
                        </div>
                    </div>
                    <div class="clients-tab__content">
                        @foreach($arrCustomerCity as $arrCustomer)
                            <div class="clients-tab__client">{{$arrCustomer['name']}}</div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endif
