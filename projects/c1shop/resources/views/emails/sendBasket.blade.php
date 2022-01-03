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


@if(isset($data['products']) && count($data['products']) > 0)
    <p>Список оборудования</p>

    @foreach($data['products'] as $key => $value)
        @if($value)
            <ul>
                <li>
                    Наименование товара : {{$value->name}}
                </li>
                <li>
                    ID товара : {{$value->id}}
                </li>
            </ul>
        @endif
    @endforeach

@endif

@if(isset($data['parts']) && count($data['parts']) > 0)
    <p>Список запчастей</p>

    @foreach($data['parts'] as $key => $value)
        @if($value)
            <ul>
                <li>
                    Наименование товара : {{$value->name}}
                </li>
                <li>
                    ID товара : {{$value->id}}
                </li>
            </ul>
        @endif
    @endforeach

@endif
