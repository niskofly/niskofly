<p>
    Название товара : {{$data['info_product']->name}}
</p>
<p>
    ID товара : {{$data['info_product']->id}}
</p>
@if($data['name'])
    <p>
        Имя : {{$data['name']}}
    </p>
@endif
@if($data['phone'])
    <p>
        Номер телефона : {{$data['phone']}}
    </p>
@endif
@if($data['email'])
    <p>
        E-mail : {{$data['email']}}
    </p>
@endif
@if($data['comment'])
    <p>
        Комментарий : {{$data['comment']}}
    </p>
@endif