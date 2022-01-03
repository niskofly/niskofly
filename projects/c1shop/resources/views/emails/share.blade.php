<p>
    Название акиции : {{$data['info_share']->name}}
</p>
<p>
    ID акции : {{$data['info_share']->id}}
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
@if($data['comment'])
    <p>
        Комментарий : {{$data['comment']}}
    </p>
@endif