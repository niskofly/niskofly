@php
    $header_phone = \App\Models\FundamentalSetting::GetSetting('header_phone');
@endphp
<div class="product-delivery">
    <div class="product-delivery__info">
        <div class="product-delivery__title">Доставка {{ (!empty($city_code) && $city_selected) ? $city_selected->seo_part : '' }}</div>
        <div class="product-delivery__desc">
            Стоимость доставки и наличие товара {{ (!empty($city_code) && $city_selected) ? 'в городе' : '' }}
            <a href="{{ route('pages-payment') }}">{{ (!empty($city_code) && $city_selected) ? $city_selected->name : '' }}</a><br>
            уточняйте у менеджера по телефону:
        </div>
        <div class="product-delivery__phone"><a href="tel:{{$header_phone->value}}">{{$header_phone->value}}</a></div>
    </div>
</div>
