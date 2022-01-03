@extends('layout')
<style>
    .shares__item {
        display: flex;
        flex-wrap: wrap;
    }
    .shares__item .articles-widget__item {
        margin: 20px;
        max-width: 300px;
        text-align: center;
    }
</style>
@section('bread_crumbs')
    <div class="b-bread-crumbs">
        <a href="/" class="bread-crumbs__item">Главная</a>
        <div class="bread-crumbs__item">Акции</div>
    </div>
@endsection

@section('content')
    @if (count($shares) > 0)
    <div class="title_bold"><h1 class="seo-header">Акции и скидки</h1></div>
        <div class="shares__item">
            @foreach($shares as $share)
            <div class="articles-widget__item">
                <a href="/share/{{$share->url}}" style="background-image: url(/{{$share->new_design_image or $share->preview_image}}); display: block;" class="articles-widget__photo"></a>
                <a href="/share/{{$share->url}}" class="articles-widget__link">{{$share->name}}</a>
            </div>
            @endforeach
        </div>
    @endif
@endsection