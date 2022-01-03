@php
    $menuCategories = App\Models\Categorie::orderBy('created_at', 'asc')->whereNotBetween('id',  [10,10])->ShowInNav()->get();
    $city = \App\Models\City::getSelectCity();
    $city_url = '';
    if($city) {
        $city_url = $city->code.'/';
    }
    $is_set_seo_title = isset($is_set_seo_title);
@endphp

<div class="category-list-home">
    <div class="title_bold">
        @if($is_set_seo_title)
            <h1 class="seo-header">
                Оборудование для прачечных и химчисток
            </h1>
        @else
            Оборудование для прачечных и химчисток
        @endif
    </div>

    <div class="category-list__container">

        @foreach($menuCategories as $menuCategorie)
            
            <div class="category-card">
                <div class="wrap-category-card" onclick="location.href='/catalog/{{$city_url}}{{$menuCategorie->url}}'">
                    <a href="/catalog/{{$city_url}}{{$menuCategorie->url}}" class="category-card__photo">
                        {!! $menuCategorie->longIcon !!}
                    </a>
                    <div class="category-card__section">
                        <span>Раздел</span>
                        <a href="/catalog/{{$city_url}}{{$menuCategorie->url}}">
                            @if($is_set_seo_title)
                                <h3 class="seo-header">
                                    {{$menuCategorie->name}}
                                </h3>
                            @else
                                {{$menuCategorie->name}}
                            @endif
                        </a>
                    </div>

                    {{--отображение скрыто--}}
                    @if (count($menuCategorie->childCategory) > 0 && false)
                        <div class="category-card__menu">

                            <div class="category-card__first-point">
                                @foreach($menuCategorie->childCategory as $menuCategorieChild)
                                    @if ($loop->index != 3)
                                        <a href="/catalog/{{$city_url}}{{$menuCategorie->url}}/type-{{$menuCategorieChild->url}}">
                                            {{$menuCategorieChild->name}}
                                        </a>
                                    @endif
                                @endforeach
                            </div>

                            <div class="category-card__all-point">

                                @foreach($menuCategorie->childCategory as $menuCategorieChild)
                                    @if ($loop->index > 1)
                                        <a href="/catalog/{{$city_url}}{{$menuCategorie->url}}/type-{{$menuCategorieChild->url}}">{{$menuCategorieChild->name}}</a>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    @endif

                </div>
            </div>

        @endforeach
        <div class="category-card">
            <div class="wrap-category-card"
                 onclick="location.href='/catalog/{{$city_url}}oborudovanie-dlya-prachechnykh-samoobsluzhivaniya'">
                <a href="/catalog/{{$city_url}}oborudovanie-dlya-prachechnykh-samoobsluzhivaniya"
                   class="category-card__photo">
                    @php(icon(44))
                </a>
                <div class="category-card__section">
                    <span>Раздел</span>
                    <a href="/catalog/{{$city_url}}oborudovanie-dlya-prachechnykh-samoobsluzhivaniya">
                        @if($is_set_seo_title)
                            <h3 class="seo-header">
                                Мини-прачечная
                            </h3>
                        @else
                            Мини-прачечная
                        @endif
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
