@if(array_key_exists('phone', $data))
    <p>
        Контакты (Email/Телефон) : {{$data['phone']}}
    </p>
@endif

@if(array_key_exists('product', $data))
    <p>
        Название товара : {{$data['product']}}
    </p>
@endif