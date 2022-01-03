@php
    $countUploadedProducts = '';
    if(isset($_COOKIE["js-list-products"]) && $_COOKIE["js-list-products"] != '')
    {
      $countUploadedProducts = count(explode('-', $_COOKIE["js-list-products"]));
    } else {
        $countUploadedProducts = 0;
    }

    $menuCategories = App\Models\Categorie::orderBy('created_at', 'asc')->ShowInNav()->get();
    $current_city = \App\Models\City::getSelectCityFromFromUI();

    $city = \App\Models\City::getSelectCity();
    $city_url = '';
    if($city) {
        $city_url = $city->code.'/';
    }
@endphp

<aside class="media-menu js-media-menu">
    <div class="media-menu__header">
        <button class="media-menu__toggle js-toggle-menu">
            @php(icon(24))
            <span>МЕНЮ</span>
        </button>
        @if($current_city)
            <div class="city-select-media__menu">
                <button class="city-select-media__btn js-show-city-list "><span
                            class="js-current-city">{{$current_city->name}}</span></button>
            </div>
        @endif
    </div>

    <!--noindex-->
    <nav class="media-menu__nav-wrapper">
        <button class="media-menu__nav-item js-show-categories">
            Каталог продукции
            @php(icon(32))
        </button>
        <a class="media-menu__nav-item" href="/catalog/oborudovanie-na-sklade">Оборудование на складе
            @php(icon(32))
        </a>
        <a class="media-menu__nav-item" href="/o-kompanii">О компании
            @php(icon(32))
        </a>
        <a class="media-menu__nav-item" href="/service">Сервис
            @php(icon(32))
        </a>
        <a class="media-menu__nav-item" href="/payment-delivery">Доставка и оплата
            @php(icon(32))
        </a>
        <a class="media-menu__nav-item" href="/realizovannye-proekty">Реализованные проекты
            @php(icon(32))
        </a>
        <a class="media-menu__nav-item" href="/clients">Клиенты
            @php(icon(32))
        </a>
        <a class="media-menu__nav-item" href="/contact">Контакты
            @php(icon(32))
        </a>
        @php
            $countUploadedProducts = (isset($_COOKIE["js-list-products"]) && $_COOKIE["js-list-products"] != '')
                ? count(explode('-', $_COOKIE["js-list-products"]))
                : 0;
        @endphp
        <a class="media-menu__nav-item js-check-link-basket" href="/basket">
            <span>Моя корзина &nbsp;(<span class="js-count-basket">{{$countUploadedProducts}}</span>)</span>
            @php(icon(32))
        </a>
    </nav>

    <div class="media-menu-social">
        <div class="media-menu-social__title">
            МЫ В СОЦСЕТЯХ
        </div>
        <div class="media-menu-social__list">
            @include('components.social-buttons')
        </div>
    </div>

    <!--/noindex-->
    <div class="media-menu__btn-wrapper">
        <button class="button btn btn-blue js-btn-price-list btn-price-list">Получить прайс</button>
    </div>
    <!--noindex-->
    <div class="media-menu__search">
        <form class="header-search js-send-search-form" action="/search/" method="GET">
            <input type="text" name="query" placeholder="Поисковая фраза" class="input_search input js-input-search">
            <input type="hidden" name="category" value="" class="js-search-category-input">
            <button class="btn-action-search js-btn-action-search">
                @php(icon(25))
            </button>
        </form>
    </div>
    <!--/noindex-->

    <!--noindex-->
    <nav class="media-menu__categories">
        <button class="media-menu__back-full js-show-categories">
            @php(icon(31, 'right-arrow'))
            Каталог продукции
        </button>
        @foreach($menuCategories as $menuCategorie)
            @if ($menuCategorie->id == 11)
                @continue
            @endif
            @if (count($menuCategorie->childCategory) > 0)
                <div class="media-menu__category">
                    @if($menuCategorie->name == 'Запчасти')
                        <a href="/{{$menuCategorie->url}}/"> {{$menuCategorie->name}} </a>
                    @else
                        <a href="/catalog/{{$city_url}}{{$menuCategorie->url}}/"> {{$menuCategorie->name}} </a>
                    @endif
                    <span class="show-media-menu__sub-category js-show-sub-category" data-id-sub-categories="{{$menuCategorie->url}}">
                        @php(icon(30, 'right-arrow'))
                    </span>
                </div>
            @else
                @php
                    $url = '';
                    if($menuCategorie->name == 'Запчасти'){
                        $url = '/'.$menuCategorie->url;
                    } else {
                        $url = '/catalog/'.$city_url.$menuCategorie->url;
                    }
                @endphp
                <a href="{{$url}}" class="media-menu__category">
                    {{$menuCategorie->name}}
                </a>
            @endif
            @if($menuCategorie->id == 7)
                <a href="/catalog/oborudovanie-dlya-prachechnykh-samoobsluzhivaniya" class="media-menu__category">
                    Оборудование для мини-прачечной
                </a>
            @endif
        @endforeach
        <a class="media-menu__nav-item" href="/#promo"><strong>АКЦИИ</strong></a>
    </nav>
    <!--/noindex-->

    @foreach($menuCategories as $menuCategorie)
        @if (count($menuCategorie->childCategory) > 0)
            <!--noindex-->
            <nav class="media-menu__sub-categories" id="{{$menuCategorie->url}}">
                <button class="media-menu__back-full js-hide-sub_categories">
                    @php(icon(31, 'right-arrow'))
                    {{$menuCategorie->name}}
                </button>
                @foreach($menuCategorie->childCategory as $sub_category)
                    @php
                        $is_products = false;
                        if (Cache::has('category_products__'.$menuCategorie->id.'--'.$sub_category->id) && Cache::has('category_additional_products'.$menuCategorie->id.'--'.$sub_category->id)) {
                            $category_products = Cache::get('category_products__'.$menuCategorie->id.'--'.$sub_category->id);
                            $category_additional_products =  Cache::get('category_additional_products'.$menuCategorie->id.'--'.$sub_category->id);
                        } else {
                            $category_products = $menuCategorie->products()->where('type', $sub_category->url)->get();
                            $category_additional_products = $menuCategorie->additional_products()->where('type', $sub_category->url)->get();

                            $expiresAt = \Carbon\Carbon::now()->addMinutes(50);
                            Cache::put('category_products__'.$menuCategorie->id.'--'.$sub_category->id, $category_products, $expiresAt);
                            Cache::put('category_additional_products'.$menuCategorie->id.'--'.$sub_category->id, $category_additional_products, $expiresAt);
                        }

                        if($category_products->isNotEmpty() || $category_additional_products->isNotEmpty()){
                            $is_products = true;
                        }
                    @endphp
                    @if($sub_category->active && $is_products )
                        <a href="/catalog/{{$city_url}}{{$menuCategorie->url}}/type-{{$sub_category->url}}"
                           class="media-menu__category">{{$sub_category->name}}</a>
                    @endif
                @endforeach
            </nav>
            <!--/noindex-->
        @endif
    @endforeach
</aside>
