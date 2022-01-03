@php($version = '1.2')
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    <link rel="stylesheet" media="all" href="/css/app.css?v={{$version}}">

    <meta name='wmail-verification' content='b5f2833ab816a2bcd8f92252c236f930'>
    <meta name="yandex-verification" content="675aec273ce45b5a">
    <meta name="google-site-verification" content="IlJJIhIAJAX5gKYrGFKerZWW5lmVMdLNSwDqD3G1Hyc">
    <meta name="google-site-verification" content="rAO1YhdHfrCllcUMYR00peo0_AOwV-1S0lRTvhSQxrU">

    <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/manifest.json">

    <meta name="theme-color" content="#434E66">
    <meta name="msapplication-TileColor" content="#434E66">
</head>

<body>

{{--wrapper--}}
<div class="layout" id="top">

    {{--content--}}
    <div class="layout-content">
        @include('components.media-menu')
        <div id="SVG_container"></div>

        {{--хедер--}}
        <header class="header">
            <button class="toggle-media-menu js-toggle-menu">
                @php(icon(24))
            </button>
            <div class="header__function">
                <a href="/" class="logo"><img src="/img/logo.png" alt="VECTOR"/></a>

                @include('components.select-city')
                <div class="header-partners-text">
                    Мы являемся официальным<br/>диллером: Вязьма и Unimac
                </div>
                <style>
                    .header-partners-text{
                        padding-left: 15px;
                        margin-right: 15px;
                        position: relative;
                        color: #333333;
                        display: none;
                    }

                    @media (min-width: 1440px){
                        .header-partners-text{
                            display: flex;
                        }
                    }


                </style>
                <div class="wrap-function">

                    @include('components.social-buttons')

                    @php($header_phone = \App\Models\FundamentalSetting::GetSetting('header_phone'))
                    <div class="b-header-tel">
                        <button class="zakaz-zvonok js-zakaz-zvonok">заказать звонок</button>
                        <div class="wrap-header-tel">
                            @php(icon(22))
                            <a href="tel:{{$header_phone->value}}" class="ya-phone">
                                {{$header_phone->value}}
                            </a>
                            <div class="header-tel__free">(бесплатно по России)</div>
                            <div class="header-email">
                                @php(icon(23))
                                <a href="mailto:info@laundrypro.ru">info@laundrypro.ru</a>
                            </div>

                            <button class="zakaz-zvonok js-zakaz-zvonok">заказать звонок</button>
                        </div>
                    </div>

                </div>

            </div>

            {{--главное меню--}}
            <nav class="header-nav">
                <ul class="header-nav__list">
                    <li><a href="/o-kompanii">О компании</a></li>
                    <li><a href="/article">Новости</a></li>
                    <li><a href="/service">Сервис</a></li>
                    <li><a href="/gotovye-proekty">Готовые решения</a></li>
                    <li><a href="/realizovannye-proekty">Реализованные проекты </a></li>
                    <li><a href="/clients">Клиенты</a></li>
                    <li><a href="/contact">Контакты</a></li>
                    <li class="end-punct">
                        <a href="/compare" class="b-small-card js-check-link-basket">
                            @php(icon(24))
                            Сравнение
                            @php
                                $count_compare = 0;
                                if((isset($_COOKIE["js-list-compare"]) && $_COOKIE["js-list-compare"] != ''))
                                {
                                    if((isset($_COOKIE["js-list-compare"]) && $_COOKIE["js-list-compare"] != '')){
                                        $count_compare = count(explode('-', $_COOKIE["js-list-compare"]));
                                    }



                                } else {
                                     $count_compare  = 0;
                                }


                            @endphp
                            (<span class="js-count-compare">{{$count_compare}}</span>)
                        </a>
                    </li>


                    <li class="end-punct">
                        <a href="/basket" class="b-small-card js-check-link-basket">
                            @php(icon(24))
                            Моя корзина
                            @php
                                $countUploadedProducts = 0;
                                $countUploadedParts = 0;

                                if((isset($_COOKIE["js-list-products"]) && $_COOKIE["js-list-products"] != '') ||
                                (isset($_COOKIE["js-list-parts"]) && $_COOKIE["js-list-parts"] != ''))
                                {
                                    if((isset($_COOKIE["js-list-products"]) && $_COOKIE["js-list-products"] != '')){
                                         $countUploadedProducts = count(explode('-', $_COOKIE["js-list-products"]));
                                    }
                                    if((isset($_COOKIE["js-list-parts"]) && $_COOKIE["js-list-parts"] != '')){
                                         $countUploadedParts = count(explode('-', $_COOKIE["js-list-parts"]));
                                    }


                                  $countUploadedProducts =  $countUploadedProducts + $countUploadedParts;
                                } else {
                                    $countUploadedProducts = 0;
                                }


                            @endphp
                            (<span class="js-count-basket">{{$countUploadedProducts}}</span>)
                        </a>
                    </li>
                </ul>
            </nav>
            {{--/главное меню--}}

        </header>
        {{--/хедер--}}

        {{--хлебные крошки--}}
        @yield('bread_crumbs')
        {{--/хлебные крошки--}}

        {{--контент страницы--}}
        @yield('content')
        {{--/контент страницы--}}

        {{--футер--}}
        <footer class="footer">
            <div class="footer-nav">
                <div class="footer-nav__col footer-nav__col--contact">
                    <div class="footer__nav__title">СЛУЖБА ПОДДЕРЖКИ</div>
                    <div class="footer__nav__phone">
                        <div class="phone">
                            @php(icon(22))
                            <a href="tel:{{$header_phone->value}}" class="ya-phone">{{$header_phone->value}}</a>
                        </div>
                        <button class="zakaz-zvonok js-zakaz-zvonok">заказать звонок</button>
                    </div>
                    <div class="footer__nav__mail">
                        @php(icon(23))
                        <a href="mailto:info@laundrypro.ru ">info@laundrypro.ru</a>
                    </div>
                    <div class="footer__nav__socials"><br>МЫ В СОЦСЕТЯХ</div>
                    @include('components.social-buttons')
                </div>
                <nav class="footer-nav__col">
                    <div class="footer__nav__title">О КОМПАНИИ</div>
                    <a href="/o-kompanii" class="footer__nav__link">О компании </a>
                    <a href="/realizovannye-proekty" class="footer__nav__link">Реализованные проекты </a>
                    <a href="/contact" class="footer__nav__link">Контакты</a>
                    <a href="/sitemap" class="footer__nav__link">Карта сайта</a>
                </nav>
                <nav class="footer-nav__col">
                    <div class="footer__nav__title">СЕРВИС</div>
                    <a href="/gotovye-proekty" class="footer__nav__link">Готовые проекты</a>
                    <a href="/zapchasti" class="footer__nav__link">Заявка на запчасти</a>
                    <a href="/servisnoe-garant" class="footer__nav__link">Сервисное обслуживание </a>
                    <a href="/vozvrat-tovara" class="footer__nav__link">Возврат товара </a>
                </nav>
            </div>
            <div class="footer-copy">
                <div class="copy-info">© {{date('Y')}} ООО «Вектор». Все права защищены.</div>
                <div class="b-webest-production">
                    <div class="b-webest-production__text">Разработано</div>
                    <a href="https://wbest.ru/?utm_source=site-client&utm_medium=banner&utm_campaign=wbest&utm_content=laundrypro" class="b-webest-production__logo">
                        @php(icon(38))
                    </a>
                </div>
            </div>
        </footer>
        {{--/футер--}}

    </div>
    {{--/content--}}

    <!-- окно благодарности-->
    <div class="thanks-popup popup">
        <div class="thanks-popup__wrap">
            <div class="thanks-popup__icon">
                @php(icon(19))
            </div>
            <div class="thanks-popup__title">Спасибо за заявку! Мы свяжемся <br/>с вами в ближайшее время.</div>
        </div>
    </div>

    <!-- заказать звонок-->
    <div class="request-callback popup">
        <div class="wrap">
            <div class="popup__icon">
                @php(icon(19))
            </div>
            <div class="popup__title">Заказать обратный звонок</div>
            <form class="request-callback__form js-request-callback__form">
                {{ csrf_field() }}
                <input type="text" placeholder="Имя" name="name" class="input required-input input--border-focus"
                       required/>
                <input type="tel" placeholder="Телефон" name="phone" class="input required-input input--border-focus"
                       required/>
                <button class="submit-popup btn-blue">Заказать звонок</button>
            </form>
            <div class="privacy-policy-prompt">Согласен <a href="/privacy-policy" target="_blank">на обработку
                    персональных данных</a></div>
        </div>
    </div>

    <!-- подбор комплекта-->
    <div class="get-price-from-kit popup popup--narrow">
        <div class="popup__icon">
            @php(icon(19))
        </div>
        <div class="popup__title">Подберем для Вас комплект <br/>оборудования и отправим прайс-лист</div>
        <form class="form-price-from-kit js-send-price">
            {{ csrf_field() }}
            <input type="text" placeholder="Имя" name="name"
                   class="input  full-input required-input input--border-focus" required/>
            <input type="tel" placeholder="Телефон" name="phone"
                   class="input full-input required-input input--border-focus" required/>
            <input type="email" placeholder="E-mail" name="email" style="margin-bottom: 0;"
                   class="input full-input required-input input--border-focus" required/>

            <textarea name="comment" placeholder="Комментарий"
                      class="input textarea_popup input--border-focus"></textarea>
            <button class="submit-popup btn-blue">Получить прайс</button>
            <div class="privacy-policy-prompt">Согласен <a href="/privacy-policy" target="_blank">на обработку
                    персональных данных</a></div>
        </form>
    </div>

    <!-- заявка на акцию -->
    <div class="request-share popup">
        <div class="popup__icon">
            @php(icon(12))
        </div>
        <div class="popup__title">Заявка на акцию <span class="js-name-share">Стирально-отжимная машина UCU020 </span>
        </div>
        <form class=" js-request-share">
            <div class="wrap-inputs_popup">
                {{ csrf_field() }}
                <input type="hidden" name="share-id" class="js-id-share">
                <input type="text" placeholder="Имя" name="name" class="input  required-input input--border-focus"
                       required/>
                <input type="tel" placeholder="Телефон" name="phone" class="input required-input input--border-focus"
                       required/>
            </div>
            <textarea name="comment" placeholder="Комментарий"
                      class="input textarea_popup input--border-focus"></textarea>
            <button class="submit-popup btn-blue">Отправить заявку</button>
            <div class="privacy-policy-prompt">Согласен <a href="/privacy-policy" target="_blank">на обработку
                    персональных данных</a></div>
        </form>
    </div>

    <!-- Заявка на оборудование-->
    <div class="request-from-product popup">
        <div class="popup__icon">
            @php(icon(12))
        </div>
        <div class="popup__title">Заявка на оборудование <span class="js-name-product-popup_request">Стирально-отжимная машина UCU020 </span>
        </div>
        <form class="form-price-from-kit js-request-product-card">
            <div class="wrap-inputs_popup">
                {{ csrf_field() }}
                <input type="hidden" name="product-id" class="js-id-product-popup_request">
            </div>
            <input type="text" placeholder="Имя" name="name" class="input  required-input input--border-focus"
                   style="width: 100%;margin-bottom: 10px;" required/>
            <input type="tel" placeholder="Телефон" name="phone" class="input required-input input--border-focus"
                   style="width: 100%;margin-bottom: 10px;" required/>
            <input type="email" placeholder="E-mail" name="email" class="input required-input" style="width: 100%;"
                   required="">
            <textarea name="comment" placeholder="Комментарий"
                      class="input textarea_popup input--border-focus"></textarea>
            <button class="submit-popup btn-blue">Отправить заявку</button>
            <div class="privacy-policy-prompt">Согласен <a href="/privacy-policy" target="_blank">на обработку
                    персональных данных</a></div>
        </form>
    </div>
    <!-- Заявка на запчасть-->
    <div class="request-from-part popup">
        <div class="popup__icon">
            @php(icon(12))
        </div>
        <div class="popup__title">Заявка на запчасть <span class="js-name-part-popup_request">Стирально-отжимная машина UCU020 </span>
        </div>
        <form class="form-price-from-kit js-request-part-card">
            <div class="wrap-inputs_popup">
                {{ csrf_field() }}
                <input type="hidden" name="part-id" class="js-id-part-popup_request">
            </div>
            <input type="text" placeholder="Имя" name="name" class="input  required-input input--border-focus"
                   style="width: 100%;margin-bottom: 10px;" required/>
            <input type="tel" placeholder="Телефон" name="phone" class="input required-input input--border-focus"
                   style="width: 100%;margin-bottom: 10px;" required/>
            <input type="email" placeholder="E-mail" name="email" class="input required-input" style="width: 100%;"
                   required="">
            <textarea name="comment" placeholder="Комментарий"
                      class="input textarea_popup input--border-focus"></textarea>
            <button class="submit-popup btn-blue">Отправить заявку</button>
            <div class="privacy-policy-prompt">Согласен <a href="/privacy-policy" target="_blank">на обработку
                    персональных данных</a></div>
        </form>
    </div>

    {{--Заявка на комплект--}}
    <div class="request-ready-made-projects popup">
        <div class="popup__icon">
            @php(icon(12))
        </div>
        <div class="popup__title">Заявка на комплект <span class="js-name-ready-made-projects"></span>
        </div>
        <form class="form-ready-made-projects js-request-ready-made-projects">
            <div class="wrap-inputs_popup">
                {{ csrf_field() }}
                <input type="hidden" name="id-projects" class="js-id-projects">
                <input type="text" placeholder="Имя" name="name" class="input  required-input" required/>
                <input type="tel" placeholder="Телефон" name="phone" class="input required-input" required/>
            </div>
            <textarea name="comment" placeholder="Комментарий" class="input textarea_popup"></textarea>
            <button class="submit-popup btn-blue">Отправить заявку</button>
            <div class="privacy-policy-prompt">Согласен <a href="/privacy-policy" target="_blank">на обработку персональных данных</a></div>
        </form>
    </div>

    @include('components.categoryMenu')

    <a href="#top" class="circle-absol-link scroll-to-top">
        @php(icon(32))
    </a>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="/js/libs/jquery/dist/jquery.min.js?v={{$version}}"></script>
    <script src="/js/libs/jquery.malihu.PageScroll2id.js?v={{$version}}"></script>
    <script src="/js/all.js?v={{$version}}"></script>
    <script src="/js/main.js?v={{$version}}"></script>

    @include('seo')

</body>
</html>
