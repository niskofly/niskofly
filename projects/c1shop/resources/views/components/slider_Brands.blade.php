@php
    $Brands = App\Models\Brand::active()->get();

    $city = \App\Models\City::getSelectCity();
    $city_url = '';
    if($city) {
        $city_url = $city->code.'/';
    }
@endphp

@if(count($Brands))

    <div class="brands-slider-section">
        <div class="title_bold">Производители оборудования для прачечной</div>
        <div class="b-slider b-slider_brands">
            <div class="b-slider-controll">
                <button data-slider="brands_slider" class="b-slidercontroll__btn_prev js-prev-banner">
                    @php(icon(31))
                </button>
                <button data-slider="brands_slider" class="b-slidercontroll__btn_next js-next-banner">
                    @php(icon(32))
                </button>
            </div>
            <div class="b-slider__content js-b-slider-content">
                @foreach($Brands as $brand)
                    <div class="b-slider__item">
                        @if($brand->categories_id)
                            <div class="b-slider__item-brand"
                                 onclick="location.href='/catalog/{{$city_url}}{{$brand->categories->url}}';"
                                 style="background-image: url('/{{$brand->photo}}'); cursor: pointer;"></div>
                        @else
                            <div class="b-slider__item-brand" style="background-image: url({{$brand->photo}})"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endif
