@if($data['name'])
    <p>
        Имя : {{$data['name']}}
    </p>
@endif
@if($data['email'])
    <p>
        Email : {{$data['email']}}
    </p>
@endif

@if($data['phone'])
    <p>
        Номер телефона : {{$data['phone']}}
    </p>
@endif

<p>Список заказанных запчастей</p>

@if(count($data['naimenovanie-zapchasti']) > 0)


@foreach($data['naimenovanie-zapchasti'] as $key => $value)
    @if($value)
        <p>
            Наименование запчасти : {{$value}}
        </p>
        <ul>
            @if($data['nomer-kataloga'][$key])
                <li>
                    Номер из каталога : {{$data['nomer-kataloga'][$key]}}
                </li>
            @endif

            @if($data['comment-zapchasti'][$key])
                <li>
                    Комментарий : {{$data['comment-zapchasti'][$key]}}
                </li>
            @endif
        </ul>
    @endif
@endforeach

@endif
