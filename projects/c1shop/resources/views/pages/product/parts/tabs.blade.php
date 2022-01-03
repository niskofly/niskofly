<div class="product-tabs js-product-tabs">
    <div class="product-tabs__nav">

        @if($Product->description)
            <button class="product-tabs__btn js-product-tabs-nav"
                    data-tab-show="description">
                О товаре
            </button>
        @endif
        @if($Product->params && count(unserialize($Product->params)))
            <button class="product-tabs__btn js-product-tabs-nav"
                    data-tab-show="specifications">
                Технические характеристики
            </button>
        @endif
        @if($Product->scheme)
            <button class="product-tabs__btn js-product-tabs-nav" data-tab-show="scheme">
                Чертежи
            </button>
        @endif
        @if($Product->certificates)
            <button class="product-tabs__btn js-product-tabs-nav" data-tab-show="certificates">
                Сертификаты
            </button>
        @endif

        @if($Product->videos)
            <button class="product-tabs__btn js-product-tabs-nav" data-tab-show="video">
                Обзор/Видео
            </button>
        @endif
    </div>
    @if($Product->description)
        <div class="product-tabs__section js-product-tabs-section"
             data-tab-section="description">
            <div class="b-catalog-text">
                <div class="title_light">
                    <h2 class="seo-header">
                        {{$Product->name}}
                    </h2>
                </div>
                <div class="wrap-product-text">
                    <div class="product-text-overflow">
                        {!! $Product->description !!}
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($Product->params && count(unserialize($Product->params)))
        <div class="product-tabs__section js-product-tabs-section"
             data-tab-section="specifications">
            @include('pages.product.parts.specifications')
        </div>
    @endif
    @if($Product->scheme)
        <div class="product-tabs__section js-product-tabs-section js-product-tabs-section"
             data-tab-section="scheme">
            @include('pages.product.parts.scheme')
        </div>
    @endif

    @if($Product->certificates)
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
    @endif
</div>
