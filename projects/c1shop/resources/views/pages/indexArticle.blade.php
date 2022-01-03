@extends('layout')
@php
    //$arNews = App\Models\Article::active()->news()->get();
    $arNews = App\Models\Article::active()->orderBy('date_view', 'desc')->paginate(6);
@endphp

@section('bread_crumbs')
    <div class="b-bread-crumbs"><a href="/" class="bread-crumbs__item">Главная</a>
        <div class="bread-crumbs__item">Новости и статьи</div>
    </div>
@endsection

@section('content')
    @if (count($arNews) > 0)
        <div class="b-news-slide">
            <div class="title_bold">
                <h1 class="seo-header">Статьи и новости</h1>
            </div>
            <div class="b-slider b-slider_news">
                <div class="b-slider__content b-slider__items_news"> 
                <!-- js-b-slider-content_news -->
                    @foreach($arNews as $news)
                        @if(true)
                            <div class="b-slider__item_news" itemscopeitemtype="http://schema.org/Article">
                                <div style="background-image: url({{$news->preview_image}})" class="b-news__photo"></div>
                                <a href="/article/{{$news->url}}" class="b-news__title" itemprop="name">{{$news->name}}</a>
                                @php($published = date('d.m.Y', strtotime($news->date_view)))
                                <div class="b-news__date" itemprop="datePublished">{{$published}}</div>
                                <div class="b-news__description" itemprop="description">
                                    {{$news->preview_description}}
                                </div>
                            </div>
                        @else
                            <div class="b-slider__item article" itemscopeitemtype="http://schema.org/Article">
                                <div class="wrap">
                                    <div class="card-status" itemprop="articleSection">Статья</div>
                                    <div style="background-image: url(/{{$news->preview_image}})" class="card-img"></div>
                                    <a href="/article/{{$news->url}}" class="card-name" itemprop="name">{{$news->name}}</a>
                                    <a href="/article/{{$news->url}}" class="circle-absol-link">
                                        @php(icon(32))
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    {{ $arNews->links() }}
                </div>
            </div>
        </div>
    @endif
@endsection
