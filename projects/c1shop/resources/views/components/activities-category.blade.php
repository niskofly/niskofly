@php
    $activities_category = \App\Models\Categorie::whereNotNull('napravlenie_id')->where('active', 1 )->get();

    $activities_category->each(function ($item, $key) {
        $item->url= '/catalog/'.$item->url;
    });

    $city = \App\Models\City::getSelectCity();
    $city_url = '';
    if($city) {
        $city_url = $city->code.'/';
    }
    $is_set_seo_title = isset($is_set_seo_title);
@endphp

@if(!$activities_category->isEmpty())
    <div class="equipment-directions">
        <div class="title_bold">
            @if($is_set_seo_title)
                <h2 class="seo-header">
                    Прачечное оборудование для
                </h2>
            @else
                Прачечное оборудование для
            @endif
        </div>

        <div class="equipment-directions__container">
            @foreach($activities_category as $category)
                <?
                $url = $category->url;
                if ($city) {
                    $url = str_replace('catalog/', 'catalog/' . $city_url, $url);
                }
                ?>
                <div style="background-image: url(/{{$category->img}})" class="equipment-directions__item"
                     onclick="location.href='{{$url}}'">
                    <div class="title_light">
                        @if($is_set_seo_title)
                            <h3 class="seo-header">
                                {{$category->name}}
                            </h3>
                        @else
                            {{$category->name}}
                        @endif
                    </div>
                    <a href="{{$url}}" class="circle-absol-link">
                        @php(icon(32))
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
