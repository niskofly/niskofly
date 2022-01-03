@extends('layout')

@section('bread_crumbs')
    <div class="b-bread-crumbs">
        <a href="/" class="bread-crumbs__item">Главная</a>
        <a href="/service" class="bread-crumbs__item">Сервис</a>
        <div class="bread-crumbs__item">Оплата и доставка прачечного оборудования</div>
    </div>
@endsection

@section('content')
    <div class="page-servis-garant page-payment-delivery">
        <div class="title_bold"><h1 class="seo-header">Оплата и доставка прачечного оборудования</h1></div>
        <div class="wrap-text">
            <p class="p-text">
                Товар отгружается в течение 7 рабочих дней при наличие на складе.<br>
                Товар отгружается в течение 60 рабочих дней, если товара нет на складе.
            </p>
        </div>
        <div class="title_blue">Способы оплаты:</div>
        <ul style="padding-left: 20px;">
            <li class="p-text">
                безналичный расчет (по счету, Договору поставки)
            </li>
        </ul>

        <div class="title_blue">Способы доставки:</div>
        <ul class="ul-two-column" style="padding-left: 20px;">
            <li class="p-text margin">
                Самовывоз со склада АО "ВМЗ" (Адрес: 215110, Россия,
                Смоленская обл., г. Вязьма, ул. 25 Октября, д. 37)
            </li>
            <li class="p-text margin">
                Доставка до терминала транспортных компаний г. Москва осуществляется бесплатно.
            </li>
            <li class="p-text">
                Доставка по всей территории РФ до терминала транспортной компании: ПЭК (время с 9.00 до 18.00, по
                звонку), Деловые линии (время с 9.00 до 18.00, по звонку) . Остальные транспортные компании по
                согласованию
            </li>
            <li class="p-text">
                Доставка до Покупателя (условия согласовываются с менеджером)
            </li>
        </ul>

        <div class="title_blue">Реквизиты:</div>
        <p class="p-text" style="line-height: 1.5;">
            ООО "Вектор"<br>
            ИНН/КПП: 3528130155/352801001<br>
            ОГРН: 1073528012040<br>
            БИК: 041909722 Филиал Вологодский Банк ВТБ (ПАО)<br>
            Кор/сч: 30101810000000000722<br>
            Рас/сч: 40702810084070000044
        </p>

    </div>
@endsection