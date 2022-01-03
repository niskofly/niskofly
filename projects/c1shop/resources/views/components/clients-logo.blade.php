@php
    if(empty($arrCustomers)){
        $arrCustomers = App\Models\Customer::active()->get();
    }

    $CustomersLogo = [];
    foreach ($arrCustomers as $item) {
        if($item->logo){
            $CustomersLogo[] = $item->logo;
        }
    }

@endphp
@if(count($CustomersLogo)>0)

    <div class="brands-slider-section">
        <div class="title_bold" style="display: none;">Логотипы клиентов</div>
        <div class="b-slider b-slider_brands">
            <div class="b-slider-controll">
                <button data-slider="customers_slider" class="b-slidercontroll__btn_prev js-prev-banner">
                    @php(icon(31))
                </button>
                <button data-slider="customers_slider" class="b-slidercontroll__btn_next js-next-banner">
                    @php(icon(32))
                </button>
            </div>
            <div class="b-slider__content js-customers_slider ">
                @foreach($CustomersLogo as $key => $logo)
                    <div class="b-slider__item">
                        <div class="b-slider__item-brand b-slider__item-customers" style="background-image: url({{$logo}})"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endif
