<div class="product-kits">
    <div class="product-kits__title">
        Комплекты:
    </div>
    <div class="product-kits__links">
        @if($Product->file_kit_mounting)
            <div class="product-kit-link">
                <a href="/files/{{ $Product->getFileUrl($Product->file_kit_mounting) }}" target="_blank">
                    Монтажные
                </a>
            </div>
        @endif

        @if($Product->file_kit_service)
            <div class="product-kit-link">
                <a href="/files/{{ $Product->getFileUrl($Product->file_kit_service) }}" target="_blank">
                    Сервисные
                </a>
            </div>
        @endif

        @if($Product->file_kit_repair)
            <div class="product-kit-link">
                <a href="/files/{{ $Product->getFileUrl($Product->file_kit_repair) }}" target="_blank">
                    Ремонтные
                </a>
            </div>
        @endif
    </div>
</div>
