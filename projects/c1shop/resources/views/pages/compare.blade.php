@extends('layout')


@section('bread_crumbs')
    <div class="b-bread-crumbs">
        <a href="/" class="bread-crumbs__item">Главная</a>

        <div class="bread-crumbs__item">Каталог</div>

    </div>
@endsection

@section('content')
    <div class="page-catalog">
        <div id="compare-page">
             <compare_page categories='{!! $Categories !!}'></compare_page>
        </div>
    </div>
    <script src="/js/app_compare.js"></script>
@endsection
