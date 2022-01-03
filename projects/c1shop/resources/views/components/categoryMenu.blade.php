@php
    $menuCategories = App\Models\Categorie::orderBy('created_at', 'asc')->ShowInNav()->get();
    $city = \App\Models\City::getSelectCity();
    $city_url = '';
    if($city) {
        $city_url = $city->code.'/';
    }
@endphp

<nav class="layout-menu">
    <div class="wrap-menu-lvl">
        <div class="menu-lvl__header">
            <a href="/catalog/{{$city_url}}">
                @php(icon(24))
                КАТАЛОГ
            </a>
        </div>
        <div class="menu-lvl__items">

            @foreach($menuCategories as $menuCategorie)
                @php
                    $category_parts = $menuCategorie->parts()->get();
                @endphp
                @if( $menuCategorie->name == 'Запчасти' && !$category_parts->isNotEmpty())
                    @else
                <ul class="menu-lvl__item {{$menuCategorie->id}}">
                    <li class="menu-lvl__1-lvl menu-lvl__link">
                        {!! $menuCategorie->logotype !!}

                        @if($menuCategorie->name == 'Запчасти')
                            <a href="/{{$menuCategorie->url}}"> {{$menuCategorie->name}} </a>
                        @else
                            <a href="/catalog/{{$city_url}}{{$menuCategorie->url}}"> {{$menuCategorie->name}} </a>
                        @endif


                        @if (count($menuCategorie->childCategory) > 0)
                            @php(icon(30, 'right-arrow'))
                        @endif

                        {{--подкатегория--}}
                        @if (count($menuCategorie->childCategory) > 0)
                        <ul class="menu-lvl__hidden">

                                @foreach($menuCategorie->childCategory as $childCategory)
                                <li class="menu-lvl__link_hidden">
                                    @php
                                        $is_products = false;
                                        $is_parts = false;
                                        if (Cache::has('category_products__'.$menuCategorie->id.'--'.$childCategory->id) && Cache::has('category_additional_products'.$menuCategorie->id.'--'.$childCategory->id)) {
                                            $category_products = Cache::get('category_products__'.$menuCategorie->id.'--'.$childCategory->id);
                                            $category_additional_products =  Cache::get('category_additional_products'.$menuCategorie->id.'--'.$childCategory->id);
                                        } else {
                                            $category_products = $menuCategorie->products()->where('type', $childCategory->url)->get();
                                            $category_additional_products = $menuCategorie->additional_products()->where('type', $childCategory->url)->get();

                                            $expiresAt = \Carbon\Carbon::now()->addMinutes(50);
                                            Cache::put('category_products__'.$menuCategorie->id.'--'.$childCategory->id, $category_products, $expiresAt);
                                            Cache::put('category_additional_products'.$menuCategorie->id.'--'.$childCategory->id, $category_additional_products, $expiresAt);
                                        }
                                        if($category_products->isNotEmpty() || $category_additional_products->isNotEmpty()){
                                            $is_products = true;
                                        }



                                       /* if (Cache::has('category_parts__'.$menuCategorie->id.'--'.$childCategory->id) && Cache::has('category_additional_parts'.$menuCategorie->id.'--'.$childCategory->id)) {
                                            $category_parts = Cache::get('category_parts__'.$menuCategorie->id.'--'.$childCategory->id);
                                            $category_additional_parts =  Cache::get('category_additional_parts'.$menuCategorie->id.'--'.$childCategory->id);
                                        } else {*/



                                            $category_additional_parts = $menuCategorie->additional_parts()->where('type', $childCategory->url)->get();

                                            $expiresAt = \Carbon\Carbon::now()->addMinutes(50);

                                            $category_parts = $menuCategorie->parts()->get();

                                            Cache::put('category_parts__'.$menuCategorie->id.'--'.$childCategory->id, $category_parts, $expiresAt);
                                            Cache::put('category_additional_parts'.$menuCategorie->id.'--'.$childCategory->id, $category_additional_parts, $expiresAt);
                                       /* }*/
                                        if($category_parts->isNotEmpty() || $category_additional_parts->isNotEmpty()){
                                            $is_parts = true;
                                        }
                                    @endphp
                                    @if($childCategory->active && $is_products)
                                        <a href="/catalog/{{$city_url}}{{$menuCategorie->url}}/type-{{$childCategory->url}}"
                                            class="menu-link {{'category_additional_products'.$menuCategorie->id.'--'.$childCategory->id}}">
                                            {{$childCategory->name}}
                                        </a>
                                    @endif
                                    @if($childCategory->active && $is_parts)

                                        <a href="/{{$menuCategorie->url}}/{{$city_url}}{{$childCategory->url}}/type-{{$childCategory->type}}"
                                           class="menu-link {{'category_additional_parts'.$menuCategorie->id.'--'.$childCategory->id}}">
                                            {{$childCategory->name}}
                                        </a>
                                    @endif

                                </li>
                                @endforeach

                        </ul>
                        @endif

                    </li>

                </ul>
                @endif
                @if($menuCategorie->id == 7)
                    <ul class="menu-lvl__item">
                        <li class="menu-lvl__1-lvl menu-lvl__link">
                            @php(icon(45, 'icon-category'))
                            <a href="/catalog/{{$city_url}}oborudovanie-dlya-prachechnykh-samoobsluzhivaniya">
                                Оборудование для мини-прачечной
                            </a>
                        </li>
                    </ul>
                @endif
            @endforeach

            <div class="menu-lvl__item menu-lvl__item-promo">
                <div class="menu-lvl__1-lvl menu-lvl__link">
                    @php(icon('discount', 'icon-category'))
                    <a href="/share">Акции</a>
                </div>
            </div>

        </div>

    </div>

    <button class="button btn btn-blue js-btn-price-list btn-price-list">Получить прайс</button>

    <div class="wrap-function">

        <form class="header-search js-send-search-form" action="/search/" method="GET">
            {{--{{ csrf_field() }}--}}
            @php
                $categoris = \App\Models\Categorie::GetSearchCategory();
            @endphp
            <div class="select-categort">
                <div class="select-categort__current js-action-select-search-category select-categort__current--hide"
                    data-active-select=".js-header-search">
                    <div class="select-categort__current-name js-name-select-category">Все категории</div>
                    <div class="select-categort__current-toggle">
                        @php(icon(33))
                    </div>
                </div>
                <div class="select-category__container js-search-category-container js-header-search">
                    <div class="select-category__item js-current-search-category"
                        data-url-category="">Все категории
                    </div>
                    @foreach($categoris as $category)
                        <div class="select-category__item js-current-search-category"
                            data-url-category="{{$category->url}}">{{$category->name}}</div>
                    @endforeach
                </div>
            </div>
            <input type="text" name="query" placeholder="Поисковая фраза" class="input_search input js-input-search">
            <input type="hidden" name="category" value="" class="js-search-category-input">
            <button class="btn-action-search js-btn-action-search">
                @php(icon(25))
            </button>
        </form>
    </div>

</nav>
