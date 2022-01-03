@php
    $arrParams = unserialize($Product->params);
@endphp



@if($Product->array_depth($arrParams) != 4)
@if(count($arrParams) > 0)
    <div class="wrap-specifications-product-categories__table">
        <div class="specifications-product-categories__table">
            @foreach($arrParams as $param)
                <div class="specifications-product-categories__row">
                    <div class="specifications-product-categories__description">{{$param['name']}}</div>
                    <div class="specifications-product-categories__value">{{$param['value']}}</div>
                </div>
            @endforeach
        </div>
    </div>
@endif
@else
    <div class="wrap-specifications-product-categories__table">

            @foreach($arrParams as $category)
                <div class="specifications-product-categories__title">{{$category['name']}}</div>
                    <div class="specifications-product-categories__table">
            @foreach($category['items'] as $param)

                <div class="specifications-product-categories__row">
                    <div class="specifications-product-categories__description">{{$param['name']}}</div>
                    <div class="specifications-product-categories__value">{{$param['value']}}</div>
                </div>

            @endforeach
                    </div>
            @endforeach

    </div>
@endif