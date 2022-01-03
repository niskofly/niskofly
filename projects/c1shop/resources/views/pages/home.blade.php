@extends('layout')


@section('content')
<div class="b-banner-get-price">
  <div class="wrap">
    <div class="title_light">Подберем для Вас комплект прачечного <br> оборудования и отправим прайс-лист</div>
    <form class="form-get-price js-send-price" style="display: none;">
      {{ csrf_field() }}
      <div class="wrap-padding">
        <input type="email" name="email" placeholder="E-mail" class="input required-input" required>
        <input type="tel" name="phone" placeholder="Телефон" class="input required-input" required>
      </div>
      <button>Получить прайс</button>
    </form>
    <button class="button btn btn-blue show-form-price js-btn-price-list">Оставить заявку</button>
    <div class="get-price-advantages">
      <div class="get-price-advantages__item">
        - Доставка по России
      </div>
      <div class="get-price-advantages__item">
        - Широкий ассортимент, низкие цены
      </div>
    </div>
  </div>
</div>
{{--фиксирование отступа блока акций, из-за изменения положения блока--}}
<div style="margin-top: 20px;"></div>
{{--Слайдер статей и акций--}}
@include('components.sliderArticleShares')

{{--Cлайдер брендов--}}
@include('components.slider_Brands')

@include('components.categoryListHome', ['is_set_seo_title' => 'true'])

@include('components.activities-category', ['is_set_seo_title' => 'true'])

<div style="background-image: url(/img/homepage-banner-2.png)" class="b-text-mit-btn">
  <div class="title_light">
    <h4 class="seo-header">
      Готовые проекты <br>для прачечных и химчисток
    </h4>
  </div>
  <p>Специалисты нашей компании подготовят технологический проект работы прачечной и химической чистки, произведут компьютерную расстановку оборудования на плане помещений Вашего предприятия. Предоставят информацию по необходимым коммуникациям.</p>
  <a href="/gotovye-proekty" class="submit-application btn btn-dark-blue" >Смотреть проекты</a>
</div>

{{--блок наши клиенты с ссылкой на страницу клиентов--}}
@include('components.our_customers')

{{--блок логотипов клиентов--}}
@include('components.clients-logo')

{{--Слайдер новостей--}}
@include('components.sliderNews')

@widget('reviews')

  <div style="background-image: url(/img/homepage-banner-3.png)" class="b-text-mit-btn">
    <div class="title_light">
      <h4 class="seo-header">
        Склад запасных частей<br>и комплектующих
      </h4>
    </div>
    <p>Наличие запасных частей и комплектующих на складе позволяет значительно сокращать  сроки сервисных ремонтов оборудования  и оперативно реагировать на потребности клиентов в запасных частях. На складе находятся только оригинальные запасные части фирм производителей по оптимальным ценам.</p>
    <a href="/zapchasti" class="submit-application btn btn-dark-blue">Оставить заявку</a>
  </div>
  @endsection
