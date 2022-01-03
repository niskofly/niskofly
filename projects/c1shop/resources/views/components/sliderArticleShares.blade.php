@php
    $arShares = \App\Models\Share::active()->orderBy('sort', 'asc')->get();
    $pinned = $arShares->first(function ($share) {
        return $share->is_pinned;
    });

    if(!$pinned) {
        $pinned = $arShares->shift();
    } else {
        $arShares = $arShares->filter(function ($share) {
            return !$share->is_pinned;
        });
    }
@endphp

@if (count($arShares) > 0)
    <div class="promotions-slider-section" id="promo">

        <div class="wrap-slider-promotions">
            <div class="b-slider b-slider_promotions b-slider_promotions--desktop">
                <div class="b-slider-controll">
                    <button data-slider="promotions_slider" class="b-slidercontroll__btn_prev js-prev-banner">
                        @php(icon(31))
                    </button>
                    <button data-slider="promotions_slider" class="b-slidercontroll__btn_next js-next-banner">
                        @php(icon(32))
                    </button>
                </div>

                <div class="b-slider__content js-b-slider-content_promotions">
                    @foreach($arShares as $share)
                        <div class="slide-promotion js-slide-promotion"
                             style="background-image: url(/{{$share->new_design_image or $share->preview_image}});"
                             onclick="location.href='/share/{{$share->url}}'">
                            <div class="slide-promotion__wrapper">
                                <div class="slide-promotion__content" style="display: none;">
                                    <img src="/img/promotion-img.png" alt="{{$share->name}}"
                                         class="slide-promotion__icon">
                                    <a href="/share/{{$share->url}}" class="slide-promotion__name">{{$share->name}}</a>
                                </div>
                            </div>
                            <a href="/share/{{$share->url}}" class="circle-absol-link">
                                @php(icon(32))
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="b-slider b-slider_promotions b-slider_promotions--mobile">
                <div class="b-slider-controll">
                    <button data-slider="promotions_slider_mobile" class="b-slidercontroll__btn_prev js-prev-banner">
                        @php(icon(31))
                    </button>
                    <button data-slider="promotions_slider_mobile" class="b-slidercontroll__btn_next js-next-banner">
                        @php(icon(32))
                    </button>
                </div>

                <div class="b-slider__content js-b-slider-content_promotions_mobile">
                    @foreach($arShares as $share)
                        <div class="b-slider__item b-slider__item--fixed" style="margin: 0 !important; ">
                            <div class="wrap">
                                <div style="background-image: url('/{{$share->preview_image}}'); cursor: pointer;"
                                     class="card-img"
                                     onclick="location.href='/share/{{$share->url}}'"></div>
                                <a href="/share/{{$share->url}}" class="card-name">
                                    {{$share->name}}
                                </a>
                                <a href="/share/{{$share->url}}" class="circle-absol-link">
                                    @php(icon(32))
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="promotion-static promotion-static--mobile">
                <div class="b-slider__item b-slider__item--fixed">
                    <div class="wrap">
                        <div style="background-image: url('/{{$pinned->preview_image}}'); cursor: pointer;"
                             class="card-img"
                             onclick="location.href='/share/{{$pinned->url}}'"></div>
                        <a href="/share/{{$pinned->url}}" class="card-name">
                            {{$pinned->name}}
                        </a>
                        <a href="/share/{{$pinned->url}}" class="circle-absol-link">
                            @php(icon(32))
                        </a>
                    </div>
                </div>
            </div>

            <div class="promotion-static promotion-static--desktop">
                <div class="slide-promotion js-slide-promotion"
                     style="background-image: url('/{{$pinned->preview_image or $pinned->new_design_image}}');"
                     onclick="location.href='/share/{{$pinned->url}}'">
                    <div class="slide-promotion__wrapper">
                    </div>
                    <a href="/share/{{$pinned->url}}" class="circle-absol-link">
                        @php(icon(32))
                    </a>
                </div>
            </div>
        </div>

    </div>
@endif
