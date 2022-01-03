@extends('layout')

@section('bread_crumbs')
    <div class="b-bread-crumbs"><a href="/" class="bread-crumbs__item">Главная</a>
        <div class="bread-crumbs__item">{{$share->name}}</div>
    </div>
@endsection

@section('content')

    <div class="page-article">
        <div class="title_bold"><h1 class="seo-header">{{$share->name}}</h1></div>
        <div class="article__date">{{$share->created_at->format('d.m.Y')}}</div>
        <div class="wrap-block-article">
            <div class="b-article">
                <img src="/{{$share->new_design_image or $share->preview_image}}"
                     alt="{{$share->name}}"
                     class="article__photo article__photo--desktop">

                <img src="/{{$share->preview_image}}"
                     alt="{{$share->name}}"
                     class="article__photo article__photo--mobile">

                <div class="wrap-article-content">
                    <div class="article__content">
                        {!! $share->full_content !!}
                    </div>
                </div>
                <button class="request-share-btn btn js-open-form-share"
                        data-id-share="{{$share->id}}"
                        data-name-share="{{$share->name}}"
                        style="box-shadow: none">
                    Оставить заявку
                </button>
            </div>

            @if($shares)
                <div class="b-articles-widget">

                    @foreach($shares as $item)
                        <div class="articles-widget__item">
                            <a href="/share/{{$item->url}}" style="background-image: url(/{{$item->new_design_image or $item->preview_image}})"
                               class="articles-widget__photo"></a>
                            <a href="/share/{{$item->url}}" class="articles-widget__link">{{$item->name}}</a>
                            <div class="articles-widget__date">{{$item->created_at->format('d.m.Y')}}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection