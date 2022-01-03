@extends('layout')

@section('bread_crumbs')
    <div class="b-bread-crumbs"><a href="/" class="bread-crumbs__item">Главная</a>
        <a href="/article" class="bread-crumbs__item">Новости и статьи</a>
        <div class="bread-crumbs__item">{{$article->name}}</div>
    </div>
@endsection

@section('content')

    <div class="page-article" itemscopeitemtype="http://schema.org/Article">
        <div class="title_bold"><h1 class="seo-header" itemprop="name">{{$article->name}}</h1></div>
        @php($published = date('d.m.Y', strtotime($article->date_view)))
        <div class="article__date" itemprop="datePublished">{{$published}}</div>
        <div class="wrap-block-article">
            <div class="b-article">
                <img src="/{{$article->preview_image}}"
                     alt="{{$article->name}}"
                     class="article__photo">
                <div class="article__content" itemprop="description">
                    {!! $article->full_content !!}
                </div>
            </div>

            @if($articles)
                <div class="b-articles-widget">

                    @foreach($articles as $item)
                        <div class="articles-widget__item" itemscopeitemtype="http://schema.org/Article">
                            <a href="/article/{{$item->url}}" style="background-image: url(/{{$item->preview_image}})" class="articles-widget__photo"></a>
                            <a href="/article/{{$item->url}}" class="articles-widget__link" itemprop="name">{{$item->name}}</a>
                            @php($published = date('d.m.Y', strtotime($item->date_view)))
                            <div class="articles-widget__date" itemprop="datePublished">{{$published}}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
