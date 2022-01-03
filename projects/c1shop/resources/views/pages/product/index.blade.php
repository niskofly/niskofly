@extends('layout')

@section('bread_crumbs')
    <div class="b-bread-crumbs">
        <a href="/" class="bread-crumbs__item">Главная</a>
        <a href="/catalog/{{$city_url}}" class="bread-crumbs__item">Каталог</a>
        <a href="/catalog/{{$city_url}}{{$Category->url}}" class="bread-crumbs__item">{{$Category->name}}</a>
        <div class="bread-crumbs__item">{{$Product->name}}</div>
    </div>
@endsection

@section('content')
    <div class="page-product">
        <div class="b-product-page__header">
            <div class="product-page__title product-page__title--mobile">{{$Product->name}} </div>
            <div class="wrap-product-page__photo js-popup-gallery @if($Product->photos || $Product->videos) wrap-product-page__photo--more @endif">
                <a href="/{{$Product->photo}}" class="product-page__photo js-popup-photo"
                    itemscope itemtype="http://schema.org/ImageObject">
                    <img src="/{{$Product->photo}}" alt="{{$Product->name}}" itemprop="contentUrl">
                </a>
                @if($Product->photos || $Product->videos)
                    <div class="product-page__photos ">
                    @if($Product->photos)
                        @php
                            $product_photos = explode(',', $Product->photos );
                        @endphp
                            @foreach($product_photos as $more_photo)
                                <a href="/{{$more_photo}}" class="product-small js-popup-photo">
                                    <img src="/{{$more_photo}}" alt="{{$Product->name}}">
                                </a>
                            @endforeach
                    @elseif($Product->videos)
                        <?
                        $videos = explode(',', $Product->videos);
                        ?>
                        <div class="product-videos">
                            @foreach($videos as $src)
                                @php
                                    $id_video = explode('v=', $src);
                                    if(array_key_exists(1, $id_video))
                                        $id_video = $id_video[1];
                                    else
                                        $id_video = false;
                                @endphp
                                <div class="product-small-videos__item"
                                    <?if($id_video){?>style="background-image: url('https://img.youtube.com/vi/{{$id_video}}/hqdefault.jpg');" <?}?>>
                                    <button class="video-container__play js-popup-video"
                                            data-video-src="{{$src}}">
                                        <img src="{{asset('/img/play.png')}}" alt="Play">
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif                       
                    </div>
                @endif
            </div>
            <div class="product-page__info">
                <div class="product-page__title product-page__title--desktop">
                    <h1 class="seo-header" style="margin-bottom: 0;">
                        {{$Product->name}}
                    </h1>
                </div>
                @if($Product->actual_price)
                    <div class="product-card__price">
                        <span>
                           От {{number_format($Product->actual_price, 0, "", " ")}} Р
                        </span>
                        @if($Product->old_price)
                            <span class="product-card__old-price">
                                {{number_format($Product->old_price, 0, "", " ")}} Р
                            </span>
                            <style>
                                .product-card__old-price{
                                    font-size: 18px;
                                    color: #434e66;
                                    text-decoration: line-through;
                                }
                            </style>
                        @endif
                    </div>
                @else
                    <div class="product-card__price" style="font-size: 16pt;">Цена по запросу</div>
                @endif

                <div class="product-card__info" style="margin-top: 20px">Для клиентов действует система скидок,<span class="js-request-product default-link" data-product-id ="{{$Product->id}}">подробнее уточняйте у менеджера.</span>
                </div>


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


                <div class="wrap-product-card__info">

                    @if($Product->mark)
                        @php
                            $mark = explode(' ', $Product->filterMark()->name);
                            $linkBrand = $filter::getLinkBrandCategory($Product->filterMark()->value);
                        @endphp
                        <div class="product-card__info">Производитель:
                            @if($linkBrand)
                                <a href="{{$linkBrand}}" title="{{$mark[0]}}" class="default-link">
                                    {{$mark[0]}}
                                </a>
                            @else
                                <span>{{$mark[0]}}</span>
                            @endif
                        </div>
                    @endif

                    @if($Product->loading_view)
                        <div class="product-card__info">Загрузка:
                            @if(!empty($Product->loading))
                                <a href="loading-{{$Product->loading}}" class="default-link">
                                    {{ $Product->loading_view}} кг
                                </a>
                            @else
                                <span>{{ $Product->loading_view}} кг</span>
                            @endif
                        </div>
                    @endif

                    @if($Product->width_area_view)
                        <div class="product-card__info">Ширина вала:
                            @if(in_array('width_area', $binding_filters))
                                @php($width_area = $filter->getBindingCategoriesByValue($Product->width_area)->first())
                                <a href="width_area-{{ $width_area->value }}" class="default-link">
                                    {{ $Product->width_area_view }} см
                                </a>
                            @else
                                <span>{{ $Product->width_area_view}} см</span>
                            @endif
                        </div>
                    @endif

                    @if($Product->solvent)
                        <div class="product-card__info">Растворитель:
                            @php($solvent = $filter->getBindingCategoriesByValue($Product->solvent)->first())
                            <a href="solvent-{{ $solvent->value }}" class="default-link">
                                {{ $solvent->name }}
                            </a>
                        </div>
                    @endif

                    @if(!is_null($ChildCategory))
                    <div class="product-card__info">Вид оборудования:
                        <a href="/catalog/{{$city_url}}{{$Category->url}}/type-{{$ChildCategory->url}}#scroll-catalog-filters" class="default-link">{{ $ChildCategory->name }}</a>
                    </div>
                    @endif

                    @php($series = $filter->getBindingCategoriesByValue($Product->series)->first())
                    @if(!empty($series))
                    @php($type = !is_null($ChildCategory) ? '/type-' . $ChildCategory->url : '')
                    <div class="product-card__info">Серия:
                        @if(in_array($series->type_filter, $binding_filters))
                        <a href="/catalog/{{$city_url}}{{$Category->url}}{{ $type }}/series-{{ $series->value }}#scroll-catalog-filters" class="default-link">
                            {{ $series->name }}
                        </a>
                        @else
                            <span>{{ $series->name }}</span>
                        @endif
                    </div>
                    @endif

                    @php($napravlenies = $Product->napravlenie()->get())
                    @if(!$napravlenies->isEmpty())
                    <div class="product-card__info">Отраслевые решения:
                        @foreach($napravlenies as $napravlenie)
                        <a href="/catalog/{{$city_url}}{{ $napravlenie->url }}" class="default-link">{{ $napravlenie->name }}</a>@if (!$loop->last), @endif
                        @endforeach
                    </div>
                    @endif

                </div>

                <div class="product-page__services">
                    <div class="product-page__services-item">
                        <div class="product-page__services-item__image">
                            <img src="/img/product-icon-install.png" alt="Сборка и установка">
                        </div>
                        <div class="product-page__services-item__text">Сборка и установка</div>
                    </div>
                    <div class="product-page__services-item">
                        <div class="product-page__services-item__image">
                            <img src="/img/product-icon-service.png" alt="Сервисное обслуживание">
                        </div>
                        <div class="product-page__services-item__text">Сервисное обслуживание</div>
                    </div>
                </div>

                <div class="product-page__button">
                    <button class="add-list js-add-list--some btn--gray" data-product-id="{{$Product->id}}">
                        @php(icon(24))
                        <span class="js-btn-added-text">В корзину</span>
                    </button>
                    <button class="send-request js-request-product btn-blue" data-product-name="{{$Product->name}}"
                            data-product-id="{{$Product->id}}">Оставить заявку
                    </button>
                </div>

                @if($Product->load_file || $Product->file_guide || $Product->file_price_list)
                    @include('pages.product.parts.additional-materials')
                @endif

                @if($Product->file_kit_mounting || $Product->file_kit_service || $Product->file_kit_repair)
                    @include('pages.product.parts.product-kits')
                @endif
            </div>
        </div>

        @include('pages.product.parts.consultation-form')

        @if($Product->videos || $Product->certificates || ($Product->params && count(unserialize($Product->params))))
            @include('pages.product.parts.tabs')
        @endif

        {{--@if($Product->description)
            <div class="b-catalog-text">
                <div class="title_light">
                    <h2 class="seo-header">
                        {{$Product->name}}
                    </h2>
                </div>
                <div class="wrap-product-text">
                    <div class="product-text-overflow">
                        {!! $Product->description !!}
                    </div>
                </div>
            </div>
        @endif--}}

        {{--доступные варианты--}}
        @include('pages.product.parts.available-options', [
            'available_options' => $Product->getAvailableOptions($Product, true),
            'brand' => $mark[0],
            'series' => (!empty($series)) ? $series->name : false
        ])

        {{--доставка--}}
        @include('pages.product.parts.delivery', ['city_code' => $city_code])

        @php($similar = $Product->getSimilar())
        @if(!$similar->isEmpty())
            {{--с этим товаром покупают--}}
            @include('pages.product.parts.buy-with', ['similars' => $similar])
        @endif
        @php($latest = $Product->getLatestProducts())

        @if(!$latest->isEmpty())
            {{--недавно просмотренные товары--}}
            @include('pages.product.parts.latest-products', ['latest' => $latest])
        @endif
        @widget('reviews')
    </div>

    @include('pages.product.parts.schema-org')

    <script>
        window.onload = function(){
            basket.add_product_watched({{$Product->id}})
        }
    </script>

@endsection
