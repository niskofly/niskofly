@php
    $arrParams = unserialize($Product->params);
@endphp

@if(count($arrParams) > 0)
    <div class="wrap-specifications-product__table">
        <div class="specifications-product__table">
            @foreach($arrParams as $param)
                <div class="specifications-product__row">
                    <div class="specifications-product__description">{{$param['name']}}</div>
                    <div class="specifications-product__value">{{$param['value']}}</div>
                </div>
            @endforeach
        </div>
    </div>
@endif