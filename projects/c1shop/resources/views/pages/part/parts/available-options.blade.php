@if($available_options->isNotEmpty())
<div class="b-catalog-text">
    <div class="title_light">
        <h2 class="seo-header">
            Доступные варианты
        </h2>
    </div>
</div>

<div class="catalog-products-available">

    @foreach($available_options as $product)
    <div class="product-available">
        <a href="/catalog/{{$city_url}}{{$Category->url}}/{{ $product->url }}" class="product-available__link">
            @if(!empty($product->loading_view))
            <div class="product-available__loading">Загрузка {{ $product->loading_view }} кг</div>
            @endif
            @if(!empty($product->width_area_view))
            <div class="product-available__width-area">Ширина вала {{ $product->width_area_view }} см</div>
            @endif
            <div class="product-available__name">{{ $brand }} {{ $series }}</div>
        </a>
    </div>
    @endforeach

</div>
@endif
