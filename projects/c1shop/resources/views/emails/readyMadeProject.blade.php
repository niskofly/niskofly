<p>
    Название готового проекта : {{$data['info_project']->name}}
</p>
<p>
    ID готового проекта : {{$data['info_project']->id}}
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