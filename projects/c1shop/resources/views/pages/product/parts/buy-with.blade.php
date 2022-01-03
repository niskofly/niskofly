<div class="b-catalog-text">
    <div class="title_light">
        <h2 class="seo-header">С этим товаром покупают</h2>
    </div>
</div>

<div class="catalog-products">

    @foreach($similars as $product)
    <div class="product-card @if($product->sale()) sale @endif">

        <div class="product-card__sale">
            @php(icon(26))
            <div class="sale-description">Спецпредложение. Товар по сниженной цене.</div>
        </div>

        <div class="product-card__wraper">
            <a href="/catalog/{{$city_url}}{{$product->category()->url}}/{{$product->url}}" class="product-card__photo"
                itemscope itemtype="http://schema.org/ImageObject">
                <img src="/{{$product->photo}}" alt="{{$product->name}}" itemprop="contentUrl">
            </a>
            @if($product->actual_price)
                <div class="product-card__price">{{number_format($product->actual_price, 0, '', ' ')}}
                    Р
                </div>
            @else
                <div class="product-card__price non-price">Цена по запросу</div>
            @endif


                <div class="product-card__stok
            @if(is_null($product->in_stock) || $product->in_stock == 0){{ 'disabled' }}@endif
                    ">
                    @if(is_null($product->in_stock) || $product->in_stock == 0)
                        @php(icon(36))
                    @else
                        @php(icon(35))
                    @endif
                    <span>{{ $product->getInStockMessage($product->in_stock) }}</span>
                </div>


            <a href="/catalog/{{$city_url}}{{$product->category()->url}}/{{$product->url}}"
                class="product-card__name">{{$product->name}} </a>

            <div class="wrap-catalog-product-info">
                @if($product->mark)
                    <div class="product-card__info">Производитель
                        @php
                            $mark = explode(' ', $product->filterMark()->name);
                        @endphp
                        <span>{{$mark[0]}}</span>
                    </div>
                @endif

                @if($product->loading_view)
                    <div class="product-card__info">Загрузка
                        <span>{{ $product->loading_view}}
                            кг</span>
                    </div>
                @endif

                @if($product->width_area_view)
                    <div class="product-card__info">Ширина вала
                        <span>{{ $product->width_area_view}}
                            мм</span>
                    </div>
                @endif

                @if($product->params)
                    @php
                        $Performance = $product->getValueParams($product->params, 'Производительность, кг/час');
                        $ShaftDiameter = $product->getValueParams($product->params, 'Диаметр вала, мм');
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
                @if($product->description)
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
