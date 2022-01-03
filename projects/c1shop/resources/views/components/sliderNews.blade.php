@php
    //$arNews = App\Models\Article::active()->news()->get();
    $arNews = App\Models\Article::active()->orderBy('date_view', 'desc')->get();
@endphp

@if (count($arNews) > 0)
    <div class="b-news-slide">
        <div class="title_bold">Статьи и новости</div>
        <div class="b-slider b-slider_news">
            <div class="b-slider-controll">
                <button data-slider="news_slider" class="b-slidercontroll__btn_prev js-prev-banner">
                    @php(icon(31))
                </button>
                <button data-slider="news_slider" class="b-slidercontroll__btn_next js-next-banner">
                    @php(icon(32))
                </button>
            </div>
            <div class="b-slider__content js-b-slider-content_news">

                @foreach($arNews as $news)
                    @if(true)
                        <div class="b-slider__item b-slider__item_news">
                            <div style="background-image: url({{$news->preview_image}})" class="b-news__photo"></div>
                            <a href="/article/{{$news->url}}" class="b-news__title">{{$news->name}}</a>
                            <div class="b-news__description">
                                {{$news->preview_description}}
                            </div>
                            @php
                                $timestamp = strtotime($news->date_view);
                                $published = date('d.m.Y', $timestamp);
                            @endphp
                            <div class="b-news__date">{{$published}}</div>
                        </div>
                    @else
                        <div class="b-slider__item article">
                            <div class="wrap">
                                <div class="card-status">Статья</div>
                                <div style="background-image: url(/{{$news->preview_image}})"
                                     class="card-img"></div>
                                <a href="/article/{{$news->url}}" class="card-name">{{$news->name}}</a>
                                <a href="/article/{{$news->url}}" class="circle-absol-link">
                                    @php(icon(32))
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
