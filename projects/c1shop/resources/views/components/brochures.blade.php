{{--рекламные буклеты--}}

@php($brochures = App\Models\Brochure::booklets())

@if(!$brochures->isEmpty())
    <div class="brochures">
        <div class="title_bold">Каталоги оборудования</div>
        <div class="brochures__list">
            @foreach($brochures as $brochure)
                <a href="/{{$brochure->file}}" target="_blank" class="brochures__item">
                    <img src="/{{$brochure->img}}" class="brochures__photo" alt="{{$brochure->name}}">
                    <span class="brochures__name">
                        @php(icon(43))
                        {{$brochure->name}}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
@endif

{{--прайс-листы--}}

@php($prices = App\Models\Brochure::prices())

@if(!$prices->isEmpty())
    <div class="brochures">
        <div class="title_bold">Прайс-листы</div>
        <div class="brochures__list">
            @foreach($prices as $price)
                <a href="/{{$price->file}}" target="_blank" class="brochures__item">
                    <img src="/{{$price->img}}" class="brochures__photo" alt="{{$price->name}}">
                    <span class="brochures__name">
                        @php(icon('file-xls'))
                        {{$price->name}}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
@endif
