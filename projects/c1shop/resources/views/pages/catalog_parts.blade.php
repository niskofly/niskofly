@extends('layout')

@php
    // Добавление параметров фильтра в ссылки пагинатора
    if (!empty($categories_by_type_active)) $Products->appends(['type' => implode(',', $categories_by_type_active)]);
@endphp

@section('bread_crumbs')
    <div class="b-bread-crumbs">
        <a href="/" class="bread-crumbs__item">Главная</a>
        @if($Category->id != 18)
            <a href="/catalog/{{$city_url}}" class="bread-crumbs__item">Каталог</a>
            <div class="bread-crumbs__item">{{ $Category->seo_h1 or $Category->name }}</div>
        @else
            <div class="bread-crumbs__item">Каталог</div>
        @endif
    </div>
@endsection

@section('content')
    <div class="page-catalog">
        <div class="page-catalog__header">
            <div class="title_bold">
                <h1 class="seo-header">{{ $Category->seo_h1 ? $Category->seo_h1 : $Category->name }}</h1>
            </div>
            <div class="catalog-header__link">
                <a href="/gotovye-proekty" class="catalog-header__link-item link--hover-blue">
                    @php(icon(40))
                    Готовые проекты <br>под ключ</a>
                <a href="/raschjot-komplektacii" class="catalog-header__link-item link--hover-blue">
                    @php(icon(39))
                    Расчет комплектации<br>оборудования
                </a>
            </div>
        </div>

        @include('components.form-get-pricelist')

        @if($Category->id == 18)
            @include('components.brochures')
        @endif

        @if($Category->id == 18)
            @include('components.categoryListHome')
        @endif

        @if($Category->top_description )
            <div class="b-catalog-text">
                {!! $Category->top_description !!}
            </div>
        @endif
        <span id="scroll-catalog-filters"></span>
        <div class="wrap-vue" id="part-filter">

                <part_filter
                        existent-filter='{!! $JsonExistentFilter !!}'
                        all-parameter-filter='{!! $JsonAllParameterFilter!!}'
                        active-filter='{!! $JsonActiveFilter!!}'
                        category='{!! json_encode($jsonCategory)!!}'
                        is_no_add_url_category= {!! $is_no_add_url_category !!}
                ></part_filter>


            @if(count($categories_by_type) > 0)
                <div class="b-catalog-filter">
                    <div class="catalog-filter__item catalog-filter__item--full">
                        <div class="filter-item__title">Категории оборудования</div>
                        <form class="filter-item__selects" id="categories-by-type">
                            @foreach($categories_by_type as $key => $category)
                                <div class="wrap-checkbox filter-item__option">
                                    <input name="type-{{ $category->id }}"
                                        form="categories-by-type"
                                        type="checkbox"
                                        id="type-{{ $category->id }}"
                                        class="checkbox"
                                        @if(in_array($category->url, $categories_by_type_active)) {{ 'checked' }} @endif
                                    >
                                    <label class="checkbox-label js-set-category-by-type"
                                        data-url="{{ $category->url }}"
                                        data-id="{{ $category->id }}"
                                        for="type-{{ $category->id }}">
                                        <span class="icon-wrap">
                                            @php(icon(35))
                                        </span>
                                        {{ $category->name }}
                                    </label>

                                </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            @endif

        </div>


        @if(count($categories_by_type) > 0)
            @php
                /**
                 * Bug fix
                 * Сохранение выбраных категорий в фильтре на странице "Оборудование на складе"
                 */
                $selectedCategories = [];
                foreach ($categories_by_type as $key => $category) {
                    if(in_array($category->url, $categories_by_type_active)){
                        $selectedCategories[] = $category->url;
                    }
                }
                $categoryGetQuery = $selectedCategories ? "?type=" .implode(",", $selectedCategories) : "";
            @endphp
            <script>
                window.FILTER_CATEGORY_QUERY = "{!! $categoryGetQuery !!}";
            </script>
        @endif

        @if(count($categories_by_brand) > 0)
            <div class="b-catalog-filter">
                <div class="catalog-filter__item catalog-filter__item--full">
                    <div class="filter-item__title">Категории оборудования</div>
                    <div class="filter-item__selects">

                        @foreach($categories_by_brand as $key => $category)
                            <div class="wrap-checkbox filter-item__option">
                                <input name="mark"
                                       type="radio"
                                       id="{{$key}}"
                                       class="checkbox">
                                <label class="checkbox-label js-set-category-by-brand"
                                       data-set-url="/catalog/{{$city_url}}{{$category->url}}/mark-{{$Category->brands->filter_mark}}"
                                       for="{{$key}}">
                                    <span class="icon-wrap">
                                        @php(icon(35))
                                    </span>
                                    {{$category->name}}
                                </label>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @endif

        <div class="b-additional-function-catalog">
            <div class="b-sorting-content"><span>Сортировать:</span>
                <div class="select-sorting-container">
                    <div class="current-sorting js-current-sorting">
                        <div class="js-current-sorting__value">По популярности</div>
                        <button class="toggle-current-sorting status-off">
                            @php(icon(33, 'hidden-sorting'))
                            @php(icon(34, 'visible-sorting'))
                        </button>
                    </div>
                    <div class="sorting-options">

                        <div class="sorting-option js-sorting-option js-popular"
                             data-sort-name="popular">
                            По популярности
                        </div>

                        <div class="sorting-option js-sorting-option js-price-asc"
                             data-sort-name="actual_price"
                             data-sort-type="asc">
                            По цене (возрастание)
                        </div>

                        <div class="sorting-option js-sorting-option js-price-desc"
                             data-sort-name="actual_price"
                             data-sort-type="desc">
                            По цене (убывание)
                        </div>
                    </div>
                </div>
            </div>
            <div class="b-show-stock">
                <div class="wrap-checkbox filter-item__option">
                    <input name="show-stock" value="show-stock" type="checkbox" id="show-stock"
                           class="checkbox js-show-in-stock">
                    <label for="show-stock" class="checkbox-label">
                        <span class="icon-wrap">
                            @php(icon(35))
                        </span>
                        Показать только на складе
                    </label>
                </div>
            </div>
        </div>

        <div class="catalog-products--wrapper">
            <div class="catalog-products" id="catalog-products">

            @if(count($Products) > 0)

                @foreach($Products as $Product)
                    {{--@if($Product->sale())
                        <div class="product-card sale">
                            @else
                                <div class="product-card">
                                    @endif--}}
                        <div class="product-card">
                                    <div class="product-card__sale">
                                        @php(icon(26))
                                        <div class="sale-description">
                                            Спецпредложение. Товар по сниженной цене.
                                        </div>
                                    </div>
                                    <div class="product-card__wraper">
                                        <a href="/zapchasti/{{$city_url}}{{$Product->categoryUrl()->url}}/{{$Product->url}}" class="product-card__photo"
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


                                        <a href="{{--/catalog/{{$city_url}}{{$Product->category()->url}}/{{$Product->url}}--}}"
                                           class="product-card__name">{{$Product->name}} </a>

                                        <div class="wrap-catalog-product-info">
                                            @if($Product->mark)
                                                <div class="product-card__info">Производитель
                                                    @php($mark = explode(' ', $Product->filterMark()->name))
                                                    <span>{{$mark[0]}}</span>
                                                </div>
                                            @endif
                                            {{--@if($Product->loading_view)
                                                <div class="product-card__info">Загрузка
                                                    <span>{{ $Product->loading_view}} кг</span>
                                                </div>
                                            @endif

                                            @if($Product->width_area_view)
                                                <div class="product-card__info">Ширина вала
                                                    <span>{{ $Product->width_area_view }} мм</span>
                                                </div>
                                            @endif

                                            @if($Product->solvent)
                                                <div class="product-card__info">Растворитель
                                                    @php($solvent = $filter->getBindingCategoriesByValue($Product->solvent)->first())
                                                    <span>{{ $solvent->name }}</span>
                                                </div>
                                            @endif--}}

                                           {{-- @if($Product->params)
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
                                            @endif--}}

                                        </div>

                                        <div class="product-card__hidden">
                                            @if($Product->description)
                                                <div class="product-card__description">
                                                    {{str_limit(strip_tags(str_replace("&nbsp;", " ", $Product->description)), 103, '...')}}
                                                </div>
                                            @endif
                                            <button class="product-card__add js-add-list-parts--some"
                                                    data-product-id="{{$Product->id}}">
                                                <span class="js-btn-added-text">В корзину</span>
                                            </button>
                                        </div>

                                    </div>
                                </div>

                                @endforeach

                                @else
                                    <div class="title_light"> Товары отсутствуют</div>
                                @endif
                        </div>

                        <div class="wrap-pagination">
                            {{$Products->links()}}
                        </div>
                        @if($Category->description )
                            <div class="b-catalog-text">
                                <div class="title_light">
                                    <h2 class="seo-header"> {{ $Category->seo_h2 ? $Category->seo_h2 : $Category->name }}</h2>
                                </div>
                                {!! $Category->description !!}
                            </div>
                        @endif
                        <script src="/js/app.js"></script>

                        @if($Products->count() < 16)
                            <div class="wrap-share-catalog-not-pagination">
                                @include('components.sliderArticleShares')
                            </div>
                        @else
                            @include('components.sliderArticleShares')
                        @endif

        </div>
        </div>

@endsection
