@if($Product->videos)
    <?
    $videos = explode(',', $Product->videos);
    ?>
    <div class="product-videos">
        @foreach($videos as $src)
            @php
                $id_video = explode('v=', $src);
                if(array_key_exists(1, $id_video))
                    $id_video = $id_video[1];
                else
                    $id_video = false;
            @endphp
            <div class="product-videos__item"
                 <?if($id_video){?>style="background-image: url('https://img.youtube.com/vi/{{$id_video}}/hqdefault.jpg');" <?}?>>
                <button class="video-container__play js-popup-video"
                        data-video-src="{{$src}}">
                    <img src="{{asset('/img/play.png')}}" alt="Play">
                </button>
            </div>
        @endforeach
    </div>
@endif