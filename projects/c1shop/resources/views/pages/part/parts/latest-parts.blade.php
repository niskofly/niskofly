

<div class="brands-slider-section">
    <div class="b-catalog-text">
        <div class="title_light">
            <h2 class="seo-header">Вы недавно смотрели</h2>
        </div>
    </div>
    <div class="b-slider b-slider_brands">
        <div class="b-slider-controll">
            <button data-slider="fits_latest_products" class="b-slidercontroll__btn_prev js-prev-banner">
                @php(icon(31))
            </button>
            <button data-slider="fits_latest_products" class="b-slidercontroll__btn_next js-next-banner">
                @php(icon(32))
            </button>
        </div>
        <div class="b-slider__content js-b-slider-latest-products">
            @foreach($latest as $part)

                <div class="product-card {{--@if($part->sale()) sale @endif--}}">

                    <div class="product-card__sale">
                        @php(icon(26))
                        <div class="sale-description">Спецпредложение. Товар по сниженной цене.</div>
                    </div>

                    <div class="product-card__wraper">
                        <a href="/zapchasti/{{$city_url}}{{$part->categoryUrl()->url}}/{{$part->url}}" class="product-card__photo"
                           itemscope itemtype="http://schema.org/ImageObject">
                            <img src="/{{$part->photo}}" alt="{{$part->name}}" itemprop="contentUrl">
                        </a>

                        @if($part->actual_price)
                            <div class="product-card__price">{{number_format($part->actual_price, 0, '', ' ')}}
                                Р
                            </div>
                        @else
                            <div class="product-card__price non-price">Цена по запросу</div>
                        @endif


                        <div class="product-card__stok
            @if(is_null($part->in_stock) || $part->in_stock == 0){{ 'disabled' }}@endif
                                ">
                            @if(is_null($part->in_stock) || $part->in_stock == 0)
                                @php(icon(36))
                            @else
                                @php(icon(35))
                            @endif
                            <span>{{ $part->getInStockMessage($part->in_stock) }}</span>
                        </div>


                        <a href="/zapchasti/{{$city_url}}{{$part->categoryUrl()->url}}/{{$part->url}}"
                           class="product-card__name">{{$part->name}} </a>

                        <div class="wrap-catalog-product-info">
                            @if($part->mark)
                                <div class="product-card__info">Производитель
                                    @php
                                        $mark = explode(' ', $part->filterMark()->name);
                                    @endphp
                                    <span>{{$mark[0]}}</span>
                                </div>
                            @endif

                            @if($part->loading_view)
                                <div class="product-card__info">Загрузка
                                    <span>{{ $part->loading_view}}
                            кг</span>
                                </div>
                            @endif

                            @if($part->width_area_view)
                                <div class="product-card__info">Ширина вала
                                    <span>{{ $part->width_area_view}}
                            мм</span>
                                </div>
                            @endif

                            @if($part->params)
                                @php
                                    $Performance = $part->getValueParams($part->params, 'Производительность, кг/час');
                                    $ShaftDiameter = $part->getValueParams($part->params, 'Диаметр вала, мм');
                                @endphp
                                @if($Performance)
                                    <div class="product-card__info">Производительность
                                        <span>{{$Performance}}
                                кг/ч</span>
                                    </div>
                                @endif
                                @if($ShaftDiameter)
                                    <div class="product-card__info">Диаметр вала
                                        <span>{{$ShaftDiameter}}
                                мм</span>
                                    </div>
                                @endif
                            @endif

                        </div>

                        <div class="product-card__hidden">
                            @if($part->description)
                                <div class="product-card__description">
                                    {{str_limit(strip_tags(str_replace('&nbsp;', ' ', $product->description)), 103, '...')}}
                                </div>
                            @endif
                            <button class="product-card__add js-add-list--some"
                                    data-product-id="{{$product->id}}">
                                <span class="js-btn-added-text">В корзину</span>
                            </button>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>

