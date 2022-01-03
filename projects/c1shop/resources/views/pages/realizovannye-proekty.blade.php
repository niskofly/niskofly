@extends('layout')

@section('bread_crumbs')
<div class="b-bread-crumbs">
  <a href="/" class="bread-crumbs__item">Главная</a>
  <div class="bread-crumbs__item">Реализованные проекты</div>
</div>
@endsection

@section('content')
<div class="page-realizovannye-proekty">
  <div class="title_bold"><h1 class="seo-header">Реализованные проекты</h1></div>

  @if (count($CompletedProjects) > 0)

  @foreach ($CompletedProjects as $key => $CompletedProject)

  <div class="b-realizovannye-proekty">
    <div class="title_light">{{ $CompletedProject->name}}</div>
    @if($CompletedProject->description)
    <div class="realizovannye-proekty__description">
      {!! $CompletedProject->description  !!}
    </div>
    @endif
    <div class="b-slider realizovannye-proekty__slider">
      <div class="b-slider-controll">
        <button data-slider="realizovannye_proekty_{{$key}}" class="b-slidercontroll__btn_prev js-prev-banner">
            @php(icon(31))
        </button>
        <button data-slider="realizovannye_proekty_{{$key}}" class="b-slidercontroll__btn_next js-next-banner">
            @php(icon(32))
        </button>
      </div>
      <div class="b-slider__content js-b-slider-content_realizovannye-proekty js-popup-gallery--dark">

      @php
        $arCompletedProjectPhotos = explode(',', $CompletedProject->photos)
      @endphp

      @foreach ($arCompletedProjectPhotos as $CompletedProjectPhoto)

        <a href="{{ $CompletedProjectPhoto }}" class="js-popup-photo b-slider__item" title="{{ $CompletedProject->name}}">
          <div style="background-image: url({{ $CompletedProjectPhoto }})" class="realizovannye-proekty__photo"></div>
        </a>

      @endforeach


      </div>
    </div>
  </div>

  @endforeach


  <div class="b-pagination" style="visibility: hidden;">
    <button class="pagination__left">
        @php(icon(31))
    </button>
      <a href="#" class="pagination__link active">1</a>
      <a href="#" class="pagination__link">2</a>
      <a href="#" class="pagination__link">3</a>
    <button class="pagination__right">
        @php(icon(32))
    </button>
  </div>

  @endif
</div>
@endsection
