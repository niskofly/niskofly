@extends('layout')

@section('bread_crumbs')
    <div class="b-bread-crumbs">
        <a href="/" class="bread-crumbs__item">Главная</a>
        <div class="bread-crumbs__item">Карта сайта</div>
    </div>
@endsection

@section('content')
    <div class="page-service">
        <div class="title_bold">
            <h1 class="seo-header">Карта сайта</h1>
        </div>
        <ul class="sitemap-nav">
            @foreach($menuCategories as $menuCategorie)
                <li>
                    @if($menuCategorie->name == 'Запчасти')
                        <a href="/{{$menuCategorie->url}}"> {{$menuCategorie->name}} </a>
                    @else
                        <a href="/catalog/{{$menuCategorie->url}}"> {{$menuCategorie->name}} </a>
                    @endif
                </li>

                @if (count($menuCategorie->childCategory) > 0)

                    <ul>
                        @foreach($menuCategorie->childCategory as $childCategory)
                                @if($childCategory->active)
                                <li>
                                    <a href="/catalog/{{$menuCategorie->url}}/type-{{$childCategory->url}}"
                                       class="menu-link">{{$childCategory->name}}</a>
                                </li>
                                @endif
                        @endforeach
                    </ul>

                @endif

            @endforeach
        </ul>
    </div>
    <style>
        .sitemap-nav li {
            margin-bottom: 10px;
        }
    </style>
@endsection
