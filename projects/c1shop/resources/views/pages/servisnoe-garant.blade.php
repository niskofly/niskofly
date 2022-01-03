@extends('layout')

@section('bread_crumbs')
        <div class="b-bread-crumbs">
          <a href="/" class="bread-crumbs__item">Главная</a>
          <a href="/service" class="bread-crumbs__item">Сервис</a>
          <div class="bread-crumbs__item">Сервисное обслуживание</div>
        </div>
@endsection

@section('content')
        <div class="page-servis-garant">
          <div class="title_bold"><h1 class="seo-header">Сервисное обслуживание</h1></div>
          <div class="wrap-text">
            <p class="p-text">ООО "Вектор" осуществляет техническое обслуживание и ремонт промышленного
              прачечного оборудования торговых марок Lavamac, Primus, Ipso, Krebe, UniMac, Вязьма.</p>
            <p class="p-text">Целью сервисного обслуживания прачечного оборудования поставляемого Компанией ООО «Вектор» является увеличение
              срока службы.</p>
          </div>
          <div class="title_blue">Можно выделить 5 главных задач сервиса:</div>
          <ol >
            <li class="p-text">
              Снижение износа прачечного оборудования IPSO, Вязьма, KREBE путём проведения плановых регламентных работ.
            </li>
            <li class="p-text">
              Сведение к минимуму времени простоя из-за непредвиденных поломок и неисправностей.
            </li>
            <li class="p-text">
              Увеличить межремонтные сроки работы оборудования для прачечных путём его модернизации и повышения работоспособности.
            </li>
            <li class="p-text">
              Производить плановое техническое обслуживание стирального, сушильного и  гладильного оборудования, по
              возможности, без прерывания основной работы прачечной.
            </li>
            <li class="p-text">
              Создание и поддержание оптимального перечня запасных частей на складе, для нормальной эксплуатации оборудования.
            </li>
          </ol>
          <p class="p-text">Наша компания работает во всех регионах РФ, поставляя и обслуживая оборудование для прачечных и химчисток</p>
          <p class="p-text">
            Заполните форму приведенную ниже для заявки на сервисное обслуживание прачечного оборудования:
          </p>

          {{--<ul class="b-list-servis-garant">--}}
            {{--<li class="p-text"></li>--}}
          {{--</ul>--}}
          <form class="b-application-for-equipment js-send-request-service-and-guarantee">
            {{ csrf_field() }}
            <div class="form-application-for-equipment">
              <div class="wrap-inputs">
                <input type="email" name="email" placeholder="E-mail" class="input">
                <input type="tel" name="phone" placeholder="Телефон" class="input" required>
              </div>
              <div class="wrap-textarea">
                <textarea name="comment" placeholder="Комментарий" class="input textarea"></textarea>
              </div>
              <div class="wrap-submit">
                <button class="submit btn-blue">Отправить</button>
              </div>
            </div>
            <div class="privacy-policy-prompt">Согласен <a href="/privacy-policy" target="_blank">на обработку персональных данных</a></div>
          </form>
        </div>
@endsection