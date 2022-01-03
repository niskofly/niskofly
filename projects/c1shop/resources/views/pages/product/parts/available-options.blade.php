@if($available_options->isNotEmpty())
<div class="b-catalog-text">
    <div class="title_light">
        <h2 class="seo-header">
            Доступные варианты загрузки
        </h2>
    </div>
</div>

    <div class="brands-slider-section">
{{--<div class="catalog-products-available">--}}

    <div class="b-slider b-slider_brands">
        <div class="b-slider-controll">
            <button data-slider="downloading_slider" class="b-slidercontroll__btn_prev js-prev-banner">
                @php(icon(31))
            </button>
            <button data-slider="downloading_slider" class="b-slidercontroll__btn_next js-next-banner">
                @php(icon(32))
            </button>
        </div>
        <div class="b-slider downloading-slider js-popup-gallery--dark">
        <div class="b-slider__content js-b-slider-downloading">
            @foreach($available_options as $product)
                <div class="product-card">
                    <div class="product-card__wraper rubber">
                        <a href="/catalog/{{$city_url}}{{$Category->url}}/{{ $product->url }}" class="product-card__photo"
                           itemscope itemtype="http://schema.org/ImageObject">
                            <img src="/{{$product->photo}}" alt="{{$product->name}}" title="{{$product->name}}" itemprop="contentUrl">
                        </a>

                        @if(!empty($product->loading_view))
                            <div class="product-card__price">
                                {{ $product->loading_view }} кг
                            </div>
                        @endif
                        @if(!empty($product->width_area_view))
                            <div class="product-card__downloading">
                                Ширина вала {{ $product->width_area_view }} см
                            </div>
                        @endif

                        <div class="product-card__downloading">{{ $brand }} {{ $series }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>
    </div>
@endif
