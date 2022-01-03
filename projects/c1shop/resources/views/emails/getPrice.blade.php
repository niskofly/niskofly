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
<p>
    Номер телефона : {{$data['phone']}}
</p>
@if($data['comment'])
    <p>
        Комментарий : {{$data['comment']}}
    </p>
@endif