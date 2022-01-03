@extends('layout')

@section('bread_crumbs')
    <div class="b-bread-crumbs">
        <a href="/" class="bread-crumbs__item">Главная</a>
        <div class="bread-crumbs__item">Сервис</div>
    </div>
@endsection

@section('content')
    <div class="page-service">
        <div class="title_bold"><h1 class="seo-header">Сервис</h1></div>
        <div class="b-service-list">
            <div class="service-item" onclick="location.href='/raschjot-komplektacii'">
                <div class="service-item__icon">
                    @php(icon(39))
                </div>
                <a href="/raschjot-komplektacii" class="service-item__name">Расчет комплектации оборудования</a>
                <div class="service-item__description">Специалисты компании "Вектор" произведут индивидуальный расчёт
                    нескольких вариантов комплектации прачечного оборудования с учетом индивидуальных особенностей и
                    потребности Вашего предприятия в обработке белья.
                </div>
                <a href="/raschjot-komplektacii" class="circle-absol-link">
                    @php(icon(32))
                </a>
            </div>
            <div class="service-item" onclick="location.href='/gotovye-proekty'">
                <div class="service-item__icon">
                    @php(icon(40))
                </div>
                <a href="/gotovye-proekty" class="service-item__name">Готовые варианты прачечной</a>
                <div class="service-item__description">Специалисты нашей компании подготовят вариант прачечной и
                    химческой чистки, произведут компьютерную расстановку оборудования на плане
                    помещений Вашего предприятия. Предоставят информацию по необходимым коммуникациям.
                </div>
                <a href="/gotovye-proekty" class="circle-absol-link">
                    @php(icon(32))
                </a>
            </div>
            <div class="service-item" onclick="location.href='/servisnoe-garant'">
                <div class="service-item__icon">
                    @php(icon(41))
                </div>
                <a href="/servisnoe-garant" class="service-item__name">Сервисное обслуживание</a>
                <div class="service-item__description">ООО "Вектор" осуществляет техническое обслуживание и ремонт
                    промышленного прачечного оборудования торговых марок Lavamac, Primus, Ipso, Krebe, UniMac, Вязьма.
                </div>
                <a href="/servisnoe-garant" class="circle-absol-link">
                    @php(icon(32))
                </a>
            </div>
            <div class="service-item" onclick="location.href='/zapchasti'">
                <div class="service-item__icon">
                    @php(icon(42))
                </div>
                <a href="/zapchasti" class="service-item__name">Склад запасных частей</a>
                <div class="service-item__description">ООО "Вектор" осуществляет техническое обслуживание и ремонт
                    промышленного прачечного оборудования торговых марок Lavamac, Primus, Ipso, Krebe, UniMac, Вязьма.
                </div>
                <a href="/zapchasti" class="circle-absol-link">
                    @php(icon(32))
                </a>
            </div>
            <div class="service-item" onclick="location.href='/payment-delivery'">
                <div class="service-item__icon">
                    <img src="/img/payment-delivery.svg" alt="Оплата и доставка прачечного оборудования">
                </div>
                <a href="/payment-delivery" class="service-item__name">
                    Оплата и доставка прачечного оборудования
                </a>
                <div class="service-item__description">
                    Товар отгружается в течение 7 рабочих дней при наличие на складе. Товар отгружается в течение 60
                    рабочих дней, если товара нет на складе.
                </div>
                <a href="/payment-delivery" class="circle-absol-link">
                    @php(icon(32))
                </a>
            </div>
        </div>

        {{--блок сертификатов--}}
        @include('components.sertificates')

        @widget('reviews')
    </div>
@endsection
