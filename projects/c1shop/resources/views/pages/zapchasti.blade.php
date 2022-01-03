@extends('layout')

@section('bread_crumbs')
        <div class="b-bread-crumbs">
          <a href="/" class="bread-crumbs__item">Главная</a>
          <a href="/service" class="bread-crumbs__item">Сервис</a>
          <div class="bread-crumbs__item">Запчасти</div>
        </div>
@endsection

@section('content')
    <div class="page-zapchasti">
      <div class="title_bold">
          <h1 class="seo-header">Запчасти</h1>
      </div>

      @if(!empty($category->top_description))
      <div class="zapchasti--description-filter">{!! html_entity_decode($category->top_description) !!}</div>
      @endif

      <form class="b-request-zapchasti js-request-zapchasti">
        <div class="request-zapchasti__header">
          <div class="title title_bold">Заявка на запчасти</div>
          <div class="wrap-inputs">
            <input type="text" name="name" placeholder="Имя" class="input">
            <input type="tel" name="phone" placeholder="Телефон" class="input" required>
            <input type="email" name="email" placeholder="E-mail" class="input">
            {{ csrf_field() }}
          </div>
        </div>

        <div class="request-zapchasti__container js-zapchasti__container">

          <div class="request-zapchasti__item zapchasti-item-0">
            <div class="wrap-inputs">
              <input type="text" name="naimenovanie-zapchasti[]" placeholder="Наименование запчасти" class="input request-zapchasti__naimenovanie input--border-focus">
              <input type="text" name="nomer-kataloga[]" placeholder="Номер из каталога" class="input request-zapchasti__nomer input--border-focus">
            </div>
            <input type="text" name="comment-zapchasti[]" placeholder="Комментарий" class="input request-zapchasti__comment input--border-focus">
            <div class="request-zapchasti__item-buttons">
              <button type="button" class="request-zapchasti__add js-zapchasti-item_add ">
                <div class="wrap-icon">
                    @php(icon(37))
                </div>Добавить запчасть
              </button>
            </div>
          </div>

        </div>

        <button class="submit btn-blue">Отправить</button>
        <div class="privacy-policy-prompt">Согласен <a href="/privacy-policy" target="_blank">на обработку персональных данных</a></div>
      </form>

      <div class="wrap-js-copy-container" style="display: none;">
        <div class="request-zapchasti__item zapchasti-item-#id#">
          <div class="wrap-inputs">
            <input type="text" name="naimenovanie-zapchasti[]" placeholder="Наименование запчасти" class="input request-zapchasti__naimenovanie input--border-focus">
            <input type="text" name="nomer-kataloga[]" placeholder="Номер из каталога" class="input request-zapchasti__nomer input--border-focus">
          </div>
          <input type="text" name="comment-zapchasti[]" placeholder="Комментарий" class="input request-zapchasti__comment input--border-focus">
          <div class="request-zapchasti__item-buttons">
            <button type="button" class="request-zapchasti__delete js-zapchasti-item_delete" data-id-zapchasti="#id#">
              <div class="wrap-icon">
                  @php(icon(36))
              </div>Удалить запчасть
            </button>
            <button type="button" class="request-zapchasti__add js-zapchasti-item_add">
              <div class="wrap-icon">
                  @php(icon(37))
              </div>Добавить запчасть
            </button>
          </div>
        </div>
      </div>

      @if(!empty($category->description))
      <div class="zapchasti--description">{!! html_entity_decode($category->description) !!}</div>
      @endif

    </div>
@endsection
