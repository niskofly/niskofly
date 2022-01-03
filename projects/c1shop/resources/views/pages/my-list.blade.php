@extends('layout')

@section('bread_crumbs')
        <div class="b-bread-crumbs">
          <a href="/" class="bread-crumbs__item">Главная</a>
          <div class="bread-crumbs__item">Моя корзина</div>
        </div>
@endsection

@section('content')
        <div class="page-my-list">
          <div class="title_bold">Моя корзина</div>
          @if((count($Products) > 0 && $Products[0] !== null) || (count($Parts) > 0 && $Parts[0] !== null) )
          <div class="table-my-list">
            <div class="table-my-list__row table-my-list__header">
              <div class="table-cell table-my-list__photo"> </div>
              <div class="table-cell table-my-list__name">Наименованое</div>
              <div class="table-cell table-my-list__price">Цена</div>
              <div class="table-cell table-my-list__creator">Произв-ль</div>
              <div class="table-cell table-my-list__stok">Наличие</div>
              <div class="table-cell table-my-list__delete">Удалить</div>
            </div>
          </div>
            @if(count($Products) > 0 && $Products[0] !== null)
          @foreach($Products as $key => $product)
          <div class="table-my-list__row" data-uploaded-row="{{$product->id}}-{{$key}}">
            <div class="table-cell table-my-list__photo">
              <div style="background-image: url(/{{$product->photo}})" class="photo-container"></div>
            </div>
            <a href="/catalog/{{$product->category()->url}}/{{$product->url}}" class="table-cell table-my-list__name">
              {{$product->name}}
            </a>
            @if($product->actual_price)
              <div class="table-cell table-my-list__price">{{number_format($product->actual_price, 0, "", " ")}} Р</div>
            @else
              <div class="table-cell table-my-list__price">Цена уточняется после оформления заявки</div>
            @endif

            @php
              $mark = explode(' ', $product->filterMark()->name);
            @endphp
            <div class="table-cell table-my-list__creator">{{$mark[0]}}</div>


          <div class="table-cell table-my-list__stok product-card__stok
                @if(is_null($product->in_stock) || $product->in_stock == 0){{ 'disabled' }}@endif
              ">
              @if(is_null($product->in_stock) || $product->in_stock == 0)
                  @php(icon(36))
              @else
                  @php(icon(35))
              @endif
              <span>{{ $product->getInStockMessage($product->in_stock) }}</span>
          </div>


            <div class="table-cell table-my-list__delete">
              <button class="table-my-list__delete-btn js-delete-list--some" data-product-id="{{$product->id}}"  data-delete-row="{{$product->id}}-{{$key}}">
                  @php(icon(36))
              </button>
            </div>
          </div>

          @endforeach
                @endif

                @if(count($Parts) > 0 && $Parts[0] !== null)
            @foreach($Parts as $key => $product)
              <div class="table-my-list__row" data-uploaded-row="{{$product->id}}-{{$key}}">
                <div class="table-cell table-my-list__photo">
                  <div style="background-image: url(/{{$product->photo}})" class="photo-container"></div>
                </div>
                <a href="/zapchasti/{{$product->categoryUrl()->url}}/{{$product->url}}" class="table-cell table-my-list__name">
                  {{$product->name}}
                </a>
                @if($product->actual_price)
                  <div class="table-cell table-my-list__price">{{number_format($product->actual_price, 0, "", " ")}} Р</div>
                @else
                  <div class="table-cell table-my-list__price">Цена уточняется после оформления заявки</div>
                @endif

                @php
                  $mark = explode(' ', $product->filterMark()->name);
                @endphp
                <div class="table-cell table-my-list__creator">{{$mark[0]}}</div>


                  <div class="table-cell table-my-list__stok product-card__stok
                @if(is_null($product->in_stock) || $product->in_stock == 0){{ 'disabled' }}@endif
                          ">
                    @if(is_null($product->in_stock) || $product->in_stock == 0)
                      @php(icon(36))
                    @else
                      @php(icon(35))
                    @endif
                    <span>{{ $product->getInStockMessage($product->in_stock) }}</span>
                  </div>


                <div class="table-cell table-my-list__delete">
                  <button class="table-my-list__delete-btn js-delete-list-parts--some" data-product-id="{{$product->id}}"  data-delete-row="{{$product->id}}-{{$key}}">
                    @php(icon(36))
                  </button>
                </div>
              </div>

            @endforeach
                @endif


          <div class="table-my-list__footer">
            <button class="print-this">
                @php(icon(27))
                Распечатать
            </button>
          </div>
          <form class="b-application-for-equipment js-send-basket">
            {{ csrf_field() }}
            <div class="title_bold">Заявка на оборудование</div>
            <div class="form-application-for-equipment">
              <div class="wrap-inputs">
                <input type="email" name="email" placeholder="E-mail" class="input required">
                <input type="tel" name="phone" placeholder="Телефон" class="input required" required>
              </div>
              <div class="wrap-textarea">
                <textarea name="comment" placeholder="Комментарий" class="input textarea"></textarea>
              </div>
              <div class="wrap-submit">
                <button class="submit btn-blue">Отправить</button>
              </div>
            </div>
            <div class="privacy-policy-prompt">Согласен <a href="/privacy-policy" target="_blank">на обработку персональных данных</a></div>
          </form>
          @else
            <div class="table-my-list">Список пуст...</div>
          @endif
        </div>
@endsection
