<div class="product-tabs">
    <div class="product-tabs__nav">
        @if($Product->params && count(unserialize($Product->params)))
            <button class="product-tabs__btn">
                Технические характеристики
            </button>
        @endif

        {{--@if($Product->certificates)
            <button class="product-tabs__btn js-product-tabs-nav" data-tab-show="certificates">
                Сертификаты
            </button>
        @endif

        @if($Product->videos)
            <button class="product-tabs__btn js-product-tabs-nav" data-tab-show="video">
                Обзор/Видео
            </button>
        @endif--}}
    </div>

    @if($Product->params && count(unserialize($Product->params)))
        <div class=""
             >
            @include('pages.product.parts.specifications')
        </div>
    @endif

   {{-- @if($Product->certificates)
        <div class="product-tabs__section js-product-tabs-section js-product-tabs-section"
             data-tab-section="certificates">
            @include('pages.product.parts.certificates')
        </div>
    @endif

    @if($Product->videos)
        <div class="product-tabs__section js-product-tabs-section js-product-tabs-section"
             data-tab-section="video">
            @include('pages.product.parts.videos')
        </div>
    @endif--}}
</div>
