<div class="product-additional-materials">
    @if($Product->load_file)
        @php($extension = pathinfo($Product->load_file)['extension'])
        <div class="product-additional-material">
            <a href="/files/{{ $Product->getFileUrl($Product->load_file) }}"
                target="_blank"
                class="link--hover-blue"
                {{--download="{{ 'Рекламный проспект ' . $Product->name }}.{{ $extension }}"--}}
            >
                @php(icon(43))
                Скачать рекламный<br>проспект
            </a>
        </div>
    @endif

    @if($Product->file_guide)
        <div class="product-additional-material">
            <a href="/files/{{ $Product->getFileUrl($Product->file_guide) }}"
                target="_blank"
                class="link--hover-blue"
                {{--download="{{ 'Руководство по эксплуатации ' . $Product->name }}.{{ $extension }}"--}}
            >
                @include('pages.product.icons.pdf')
                Руководство <br> по эксплуатации
            </a>
        </div>
    @endif

    @if($Product->file_price_list)
        <div class="product-additional-material product-additional-material--excel">
            <a href="/files/{{ $Product->getFileUrl($Product->file_price_list) }}"
                target="_blank"
                class="link--hover-blue"
                {{--download="{{ 'Прайс ' . $Product->name }}.{{ $extension }}"--}}
            >
                @include('pages.product.icons.excel')
                Скачать прайс
            </a>
        </div>
    @endif
</div>
