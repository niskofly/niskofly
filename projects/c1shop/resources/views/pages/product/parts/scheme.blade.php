@if($Product->scheme)
    <?
    $scheme = explode(',', $Product->scheme);
    ?>
    <div class="product-certificates js-popup-gallery--dark">
        @foreach($scheme as $scheme_item)
            <a href="{{asset($scheme_item)}}" class="product-certificates__item js-popup-photo"
               style="background-image: url('{{asset($scheme_item)}}');"
               title="Чертежи - {{ $Product->name}}"
            >
            </a>
        @endforeach
    </div>
@endif