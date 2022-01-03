@extends('layout')

@section('bread_crumbs')
    <div class="b-bread-crumbs">
        <a href="/" class="bread-crumbs__item">Главная</a>
        <a href="/zapchasti/{{$city_url}}" class="bread-crumbs__item">Запчасти</a>
        <a href="/zapchasti/{{$city_url}}{{$Category->url}}" class="bread-crumbs__item">{{$Category->name}}</a>
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
                            {{number_format($Product->actual_price, 0, "", " ")}} Р
                        </span>
                        @if($Product->old_price)
                            <span class="product-card__old-price">
                                {{number_format($Product->old_price, 0, "", " ")}} Р
                            </span>
                        @endif
                    </div>
                @else
                    <div class="product-card__price" style="font-size: 16pt;">Цена по запросу</div>
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


                <div class="wrap-product-card__info">

                    @if($Product->mark)
                        @php
                            $mark = $Product->filterMark();
                            $linkBrand = $filter::getLinkBrandCategory($Product->filterMark()->value);
                        @endphp
                        <div class="product-card__info">Производитель:
                            @if($linkBrand)
                                <a href="{{$linkBrand}}" title="{{$mark['name']}}" class="default-link">
                                    {{$mark['name']}}
                                </a>
                            @else
                                <span>{{$mark['name']}}</span>
                            @endif
                        </div>
                    @endif
                    @if($Product->article)
                        <div class="product-card__info">Артикул запчасти:
                            <span>{{$Product->article}}</span>
                        </div>
                    @endif
                        @if(!is_null($ChildCategory))
                            <div class="product-card__info">Вид оборудования:
                                <a href="/zapchasti/{{$city_url}}{{$Product->categoryUrl()->url}}/type-{{$Product->categoryUrl()->url}}" class="default-link">{{ $ChildCategory->name }}</a>
                            </div>
                        @endif

                        @if(!$Product->part_mark->isEmpty())
                            <div class="product-card__info">Подходит к торговым маркам:
                                <?
                                $marks = $Product->part_mark;
                                foreach ($marks as $key => $mack){?>
                                <span>{{ $mack->name }}<?
                                    if ($key < count($marks) - 1){
                                    ?>,<?}?>
                                </span>
                                <?

                                } ?>
                            </div>
                        @endif

                        @if($Product->coming_list)
                        <div class="product-card__info">Оборудование (для которого подходит):
                            <span>{!!$Product->coming_list!!}</span>
                        </div>
                        @endif

                        @if(!$Product->additional_parts->isEmpty())
                            <div class="product-card__info">Сопутствующие товары:
                                <?
                                $additional_parts = $Product->additional_parts;
                                foreach ($additional_parts as $key => $part){?>
                                <a href="/zapchasti/{{$city_url}}{{$part->categoryUrl()->url}}/{{$part->url}}" class="default-link">{{ $part->name }}
                                <?
                                    if ($key < count($additional_parts) - 1){
                                    ?>,<?}?>
                                </a>
                                <?

                                } ?>
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
                    <button class="add-list js-add-list-parts--some btn--gray" data-part-id="{{$Product->id}}">
                        @php(icon(24))
                        <span class="js-btn-added-text">В корзину</span>
                    </button>
                    <button class="send-request js-request-part btn-blue" data-part-name="{{$Product->name}}"
                            data-part-id="{{$Product->id}}">Оставить заявку
                    </button>
                </div>

                @if($Product->load_file || $Product->file_guide || $Product->file_price_list)
                    @include('pages.part.parts.additional-materials')
                @endif

                @if($Product->file_kit_mounting || $Product->file_kit_service || $Product->file_kit_repair)
                    @include('pages.part.parts.product-kits')
                @endif
            </div>
        </div>

        @include('pages.part.parts.consultation-form')

        @if($Product->videos || $Product->certificates || ($Product->params && count(unserialize($Product->params))))
            @include('pages.part.parts.tabs')
        @endif

        @if($Product->description)
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
        @endif
        @if(!$Product->part_product->isEmpty())

                <div class="brands-slider-section">
                    <div class="title_bold">Подходит к: </div>
                    <div class="b-slider b-slider_brands">
                        <div class="b-slider-controll">
                            <button data-slider="fits_parts_slider" class="b-slidercontroll__btn_prev js-prev-banner">
                                @php(icon(31))
                            </button>
                            <button data-slider="fits_parts_slider" class="b-slidercontroll__btn_next js-next-banner">
                                @php(icon(32))
                            </button>
                        </div>
                        <div class="b-slider__content js-b-slider-fits-parts ">
                            @foreach($Product->part_product as $product)
                                <div class="b-slider__item">
                                    <div class="b-slider__item-brand b-slider__item-customers" style="background-image: url(/{{$product->photo}})"></div>
                                    <div class="footer__nav__mail">
                                        <a href="/catalog/{{$city_url}}{{$product->category()->url}}/{{$product->url}}" class="default-link">{{$product->name}}</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

        @endif

        @php($latest = $Product->getLatestParts())
        @if(!$latest->isEmpty())
            {{--недавно просмотренные товары--}}
            @include('pages.part.parts.latest-parts', ['latest' => $latest])
        @endif
        {{--доступные варианты--}}
       {{-- @include('pages.part.parts.available-options', [
            'available_options' => $Product->getAvailableOptions($Product, true),
            'brand' => $mark[0],
            'series' => (!empty($series)) ? $series->name : false
        ])

        --}}{{--доставка--}}{{--
        @include('pages.part.parts.delivery', ['city_code' => $city_code])

        @php($similar = $Product->getSimilar())
        @if(!$similar->isEmpty())
            --}}{{--с этим товаром покупают--}}{{--
            @include('pages.part.parts.buy-with', ['similars' => $similar])
        @endif--}}

        @widget('reviews')
    </div>

    @include('pages.part.parts.schema-org')
    <script>
        window.onload = function(){
            basket.add_part_watched({{$Product->id}})
        }
    </script>
@endsection
