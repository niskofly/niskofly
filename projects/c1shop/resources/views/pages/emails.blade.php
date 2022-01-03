@extends('layout')

@section('bread_crumbs')
    <div class="b-bread-crumbs"><a href="/" class="bread-crumbs__item">Главная</a>
        <div class="bread-crumbs__item">Список заявок</div>
    </div>
@endsection

@section('content')
    <div class="page-emails">
        <a href="/export/all" class="export-email--all" target="_blank">Выгрузить заявки</a>
        {{--TABS EMAILS --}}
        <div class="wrap-tabs-emails">
            @foreach($types as $code => $type)
                <button class="b-tab-emails js-show-type-emails" data-show-type-emails="{{$code}}">
                    {{$type}}
                </button>
            @endforeach

        </div>
        {{--TABS EMAILS --}}

        @foreach($emails as $code => $emailByType)
            <div class="b-container-type-emails js-container-emails" data-type-emails="{{$code}}">

                @foreach($emailByType as $email)

                    <div class="b-email-info">
                        <div class="emails-title b-email-info__id">
                            #{{$email['id']}} --- {{$email['theme']}}
                        </div>
                        <table class="table-email-info">
                            <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Имя</th>
                                <th>Телефон</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            <tr>
                                @php
                                    $date = strtotime($email['created_at']);
                                @endphp
                                <th>{{Date('m.d.Y',$date)}}</th>
                                <th>{{$email['name']}}</th>
                                <th><a href="tel:{{$email['phone']}}"> {{$email['phone']}} </a></th>
                                <th><a href="mailto:{{$email['email']}}">{{$email['email']}}</a></th>
                            </tr>
                        </table>

                        @if($email['comment'])
                            <div class="b-email-info__comment">
                                <div class="emails-title">
                                    Комментарий
                                </div>
                                <p>
                                    {{$email['comment']}}
                                </p>
                            </div>
                        @endif


                        @if($code == 'product')
                            <div class="b-email-info_additional">
                                <div class="emails-title">
                                    Список товаров
                                </div>
                                @if(!empty($email['id_product']))
                                    {!! \App\Models\Product::getInfoEmails($email['id_product']) !!}
                                @endif

                                @if(!empty($email['id_product_list']))
                                    {!! \App\Models\Product::getInfoEmails($email['id_product_list']) !!}
                                @endif
                            </div>
                        @endif

                        @if($code == 'share')
                            <div class="b-email-info_additional">
                                <div class="emails-title">
                                    Инофрмация о акции
                                </div>
                                @if(!empty($email['id_share']))
                                    {!! \App\Models\Share::getInfoEmails($email['id_share']) !!}
                                @endif
                            </div>
                        @endif


                        @if($code == 'calculateKit')
                            <div class="b-email-info_additional">
                                <div class="emails-title">
                                    Параметры комплекта
                                </div>
                                @if(!empty($email['calculate_kit_params']))
                                    {!! \App\Models\Email::GetEmailInfoCalculateKit($email['calculate_kit_params']) !!}
                                @endif
                            </div>
                        @endif


                        @if($code == 'zapchasti')
                            <div class="b-email-info_additional">
                                <div class="emails-title">
                                    Список запчастей
                                </div>
                                @if(!empty($email['spare_part_list']))
                                    {!! \App\Models\Email::GetEmailSparePartList($email['spare_part_list']) !!}
                                @endif
                            </div>
                        @endif

                        @if($code == 'project')
                            <div class="b-email-info_additional">
                                <div class="emails-title">
                                    Название проекта
                                </div>
                                @if(!empty($email['id_finished_project']))
                                    {!! \App\Models\Email::GetEmailFinishProject($email['id_finished_project']) !!}
                                @endif
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        @endforeach

    </div>
@endsection