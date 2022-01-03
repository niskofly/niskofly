@extends('layout')


@section('bread_crumbs')
    <div class="b-bread-crumbs">
        <a href="/" class="bread-crumbs__item">Главная</a>
        <div class="bread-crumbs__item">Поиск</div>
    </div>
@endsection

@section('content')

    <script>
        window.__STATE_SEARCH__ = {
            query: {!! json_encode($query)!!},
            category: {!!json_encode($selectCategory)!!}
        }
    </script>
    <div class="page-search">
        <form class="search-form js-send-search-form" action="/search/" method="GET">
            {{--{{ csrf_field() }}--}}
            <div class="select-categort">
                <div class="select-categort__current js-action-select-search-category"
                     data-active-select=".js-page-search">
                    <div class="select-categort__current-name js-name-select-category">Все категории</div>
                    <div class="select-categort__current-toggle">
                        @php(icon(33))
                    </div>
                </div>
                <div class="select-category__container js-search-category-container js-page-search">
                    <div class="select-category__item js-current-search-category"
                         data-url-category="">Все категории
                    </div>
                    @foreach($categoris as $category)
                        <div class="select-category__item js-current-search-category"
                             data-url-category="{{$category->url}}">{{$category->name}}</div>
                    @endforeach
                </div>
            </div>
            <input type="text" name="query" placeholder="Поисковая фраза" class="input_search input js-input-search"/>
            <input type="hidden" name="category" value="" class="js-search-category-input">
            <button class="btn-action-search js-btn-action-search">
                @php(icon(25))
            </button>
        </form>
        <div class="catalog-products catalog-products--search">

            @if(count($Products) > 0)

                @foreach($Products as $Product)
                    @if($Product->sale())
                        <div class="product-card sale">
                            @else
                                <div class="product-card">
                                    @endif
                                    <div class="product-card__sale">
                                        @php(icon(26))
                                        <div class="sale-description">
                                            Спецпредложение. Товар по сниженной цене.
                                        </div>
                                    </div>
                                    <div class="product-card__wraper">
                                        <a href="/catalog/{{$Product->category()->url}}/{{$Product->url}}" class="product-card__photo"
                                            itemscope itemtype="http://schema.org/ImageObject">
                                            <img src="/{{$Product->photo}}" alt="{{$Product->name}}" itemprop="contentUrl">
                                        </a>
                                        @if($Product->actual_price)
                                            <div class="product-card__price">{{number_format($Product->actual_price, 0, "", " ")}}
                                                Р
                                            </div>
                                        @else
                                            <div class="product-card__price non-price">Цена по запросу</div>
                                        @endif


                                        <div class="product-card__stok
                                            @if(is_null($Product->in_stock) || $Product->in_stock == 0){{ 'disabled' }}@endif
                                            ">
                                            @if(is_null($Product->in_stock) || $Product->in_stock == 0)
                                                @php(icon(36))
                                            @else
                                                @php(icon(35))
                                            @endif
                                            <span>{{ $Product->getInStockMessage($Product->in_stock) }}</span>
                                        </div>


                                        <a href="/catalog/{{$Product->category()->url}}/{{$Product->url}}"
                                           class="product-card__name">{{$Product->name}} </a>

                                        <div class="wrap-catalog-product-info">
                                            @if($Product->mark)
                                                @php
                                                    $mark = explode(' ', $Product->filterMark()->name);
                                                @endphp
                                                <div class="product-card__info">Производитель
                                                    <span>{{$mark[0]}}</span>
                                                </div>
                                            @endif

                                            @if($Product->loading_view)
                                                <div class="product-card__info">Загрузка
                                                    <span>{{ $Product->loading_view}}
                                                        кг</span>
                                                </div>
                                            @endif

                                            @if($Product->width_area_view)
                                                <div class="product-card__info">Ширина вала
                                                    <span>{{ $Product->width_area_view}}
                                                        мм</span>
                                                </div>
                                            @endif

                                            @if($Product->params)
                                                @php
                                                    $Performance = $Product->getValueParams($Product->params, 'Производительность, кг/час');
                                                    $ShaftDiameter = $Product->getValueParams($Product->params, 'Диаметр вала, мм');
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
                                            @if($Product->description)
                                                <div class="product-card__description">
                                                    {{str_limit(strip_tags($Product->description), 103, '...')}}
                                                </div>
                                            @endif
                                            <button class="product-card__add js-add-list"
                                                    data-product-id="{{$Product->id}}">
                                                В корзину
                                            </button>
                                        </div>

                                    </div>
                                </div>

                                @endforeach

                                @else
                                    <div class="title_light" style="margin-top: 30px;">Совпадения не найдены</div>
                                @endif
                        </div>
        </div>
@endsection
