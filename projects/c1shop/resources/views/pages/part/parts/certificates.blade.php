@if($Product->certificates)
    <?
    $certificates = explode(',', $Product->certificates);
    ?>
    <div class="product-certificates js-popup-gallery--dark">
        @foreach($certificates as $certificate)
            <a href="{{asset($certificate)}}" class="product-certificates__item js-popup-photo"
               style="background-image: url('{{asset($certificate)}}');"
               title="Сертификаты - {{ $Product->name}}"
            >
            </a>
        @endforeach
    </div>
@endif