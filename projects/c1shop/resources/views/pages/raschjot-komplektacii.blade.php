@extends('layout')

@section('bread_crumbs')
        <div class="b-bread-crumbs">
          <a href="/" class="bread-crumbs__item">Главная</a>
          <a href="/service" class="bread-crumbs__item">Сервис</a>
          <div class="bread-crumbs__item">Расчёт комплектации оборудования</div>
        </div>
@endsection

@section('content')
        <div class="page-raschjot-komplektacii">
          <div class="title_bold"><h1 class="seo-header">Расчёт комплектации оборудования для прачечной</h1></div>

          <form class="form-raschjot-komplektacii js-send-raschjot-komplektacii">
            {{ csrf_field() }}
            <div class="raschjot-komplektacii__block">
              <div class="raschjot-komplektacii__row">
                <div class="raschjot-komplektacii__name">Вес белья обрабатываемого за определенный период (год, месяц, день, смена) в кг или тоннах:</div>
                <div class="raschjot-komplektacii__value">
                  <input type="text" name="ves-belja-opredelennyj-period" class="input input--border-focus">
                </div>
              </div>
            </div>
            <div class="raschjot-komplektacii__block color-gray">
              <div class="raschjot-komplektacii__title">Вид белья в кг или % от общего количества:</div>
              <div class="raschjot-komplektacii__row">
                <div class="raschjot-komplektacii__name">Прямое (простыни, пододеяльники, наволочки):</div>
                <div class="raschjot-komplektacii__value">
                  <input type="text" name="ves-belja-prjamoe" class="input input--border-focus">
                </div>
              </div>
              <div class="raschjot-komplektacii__row">
                <div class="raschjot-komplektacii__name">Фасонное (спецодежда, халаты, рубашки и т.д.):	</div>
                <div class="raschjot-komplektacii__value">
                  <input type="text" name="ves-belja-fasonnoe" class="input input--border-focus">
                </div>
              </div>
              <div class="raschjot-komplektacii__row">
                <div class="raschjot-komplektacii__name">Махровое (полотенца, халаты):</div>
                <div class="raschjot-komplektacii__value">
                  <input type="text" name="ves-belja-mахровое" class="input input--border-focus">
                </div>
              </div>
              <div class="raschjot-komplektacii__row">
                <div class="raschjot-komplektacii__name">Утепленная спецодежда:</div>
                <div class="raschjot-komplektacii__value">
                  <input type="text" name="ves-belja-uteplennaja-specodezhda" class="input input--border-focus">
                </div>
              </div>
              <div class="raschjot-komplektacii__row">
                <div class="raschjot-komplektacii__name">Другое:</div>
                <div class="raschjot-komplektacii__value">
                  <input type="text" name="ves-belja-drugoe" class="input input--border-focus">
                </div>
              </div>
            </div>
            <div class="raschjot-komplektacii__block reset-margin">
              <div class="raschjot-komplektacii__row">
                <div class="raschjot-komplektacii__name">Максимальные размеры прямого белья (ширина, длина):</div>
                <div class="raschjot-komplektacii__value">
                  <input type="text" name="maksimalnye-razmery-prjamogo" class="input input--border-focus">
                </div>
              </div>
            </div>
            <div class="raschjot-komplektacii__block reset-margin">
              <div class="raschjot-komplektacii__row">
                <div class="raschjot-komplektacii__name">Вид загрязнения:</div>
                <div class="raschjot-komplektacii__value">
                  <input type="text" name="vid-zagrjaznenija" class="input input--border-focus">
                </div>
              </div>
            </div>
            {{--<div class="raschjot-komplektacii__block margin-b-45">--}}
              {{--<div class="raschjot-komplektacii__row">--}}
                {{--<div class="raschjot-komplektacii__name">Периодичность смены белья (каждый день, 1 раз/2 дня, 1 раз/неделя):</div>--}}
                {{--<div class="raschjot-komplektacii__value">--}}
                  {{--<input type="text" name="periodichnost-smeny-belja" class="input">--}}
                {{--</div>--}}
              {{--</div>--}}
            {{--</div>--}}

            <div class="raschjot-komplektacii__block reset-margin">
              <div class="raschjot-komplektacii__row">
                <div class="raschjot-komplektacii__name">Планируемый режим работы прачечной:</div>
                <div class="raschjot-komplektacii__value">
                  <input type="text" name="planiruemyj-rezhim-raboty" class="input input--border-focus">
                </div>
              </div>
            </div>

            <div class="raschjot-komplektacii__block reset-margin">
              <div class="raschjot-komplektacii__row">
                <div class="raschjot-komplektacii__name">Количество рабочих дней в месяце:</div>
                <div class="raschjot-komplektacii__value">
                  <input type="text" name="kolichestvo-rabochih-dnej" class="input input--border-focus">
                </div>
              </div>
            </div>

            <div class="raschjot-komplektacii__block reset-margin">
              <div class="raschjot-komplektacii__row">
                <div class="raschjot-komplektacii__name">Вид нагрева:</div>
                <div class="raschjot-komplektacii__value">
                  <select name="vid-nagreva" class="select input input--border-focus">
                    <option value="Электрический">Электрический</option>
                    <option value="Паровой">Паровой</option>
                    <option value="Газовый">Газовый</option>
                    <option value="Комбинированный">Комбинированный</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="raschjot-komplektacii__block margin-b-58">
              <div class="raschjot-komplektacii__row">
                <div class="raschjot-komplektacii__name">Площадь в прачечной, кв.м:</div>
                <div class="raschjot-komplektacii__value">
                  <input type="text" name="square-laundry" class="input input--border-focus">
                </div>
              </div>
            </div>
            {{--<div class="raschjot-komplektacii__block reset-margin">--}}
              {{--<div class="raschjot-komplektacii__row">--}}
                {{--<div class="raschjot-komplektacii__name">Основание в помещении прачечной (пол):</div>--}}
                {{--<div class="raschjot-komplektacii__value">--}}
                  {{--<input type="text" name="osnovanie-pomeshhenii" class="input">--}}
                {{--</div>--}}
              {{--</div>--}}
            {{--</div>--}}
            <div class="raschjot-komplektacii__block reset-margin">
              <div class="raschjot-komplektacii__row textarea-block">
                <div class="raschjot-komplektacii__name">Дополнительные сведения или пожелания :</div>
                <div class="raschjot-komplektacii__value">
                  <textarea type="text" name="dopolnitelnye-svedenija" class="input textarea input--border-focus"></textarea>
                </div>
              </div>
            </div>
            <div class="b-application-for-equipment">
              <div class="form-application-for-equipment">
                <div class="wrap-inputs">
                  <input type="email" name="email" placeholder="E-mail" class="input">
                  <input type="tel" name="phone" placeholder="Телефон" class="input" required>
                </div>
                <div class="wrap-textarea">
                  <textarea name="comment" placeholder="Комментарий" class="input textarea"></textarea>
                </div>
                <div class="wrap-submit">
                  <button class="submit btn-blue">Рассчитать</button>
                </div>
              </div>
              <div class="privacy-policy-prompt">Согласен <a href="/privacy-policy" target="_blank">на обработку персональных данных</a></div>
            </div>
          </form>

        </div>
@endsection