<div class="social-buttons">
    @foreach($socials as $name => $link)
        @if(!empty($link))
        <div class="social-button social-button-{{ $name }}">
            <a href="{{ $link }}" rel="nofollow" target="_blank" title="{{ ucfirst($name) }}">
                @php
                    $icon_name = 'wb-' . $name;
                    icon($icon_name);
                @endphp
            </a>
        </div>
        @endif
    @endforeach
</div>
