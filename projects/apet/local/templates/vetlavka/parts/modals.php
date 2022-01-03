<div class="modals">

  <!--
  info: Thanks modal
  -->

  <div id="success-modal" class="modal modal--thanks animated">
    <button class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__body">
      <div class="modal__icon">
        <svg class="icon icon-check ">
          <use xlink:href="#check"></use>
        </svg>
      </div>
      <div class="modal__description js-success-modal-description">
        Спасибо, мы получили Ваш запрос. Наш менеджер
        вскоре свяжется с Вами оформление заказа
      </div>
    </div>
  </div>

  <!--
  info: Thanks modal 2
  -->

  <div id="thanks-modal" class="modal modal--thanks animated">
    <button class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__body">
      <div class="modal__icon">
        <svg class="icon icon-check ">
          <use xlink:href="#check"></use>
        </svg>
      </div>
      <div class="modal__description js-success-modal-description">
        Спасибо, Вы успешно подписаны на рассылку о
        новинках продукции и специальных предложениях
      </div>
    </div>
  </div>

  <!--
  info: Update user password in lk
  -->

  <div id="change-pass-phone" class="modal modal--change-pass animated">
    <button class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__body">
      <div class="modal__header">
        <div class="modal__title">Смена пароля</div>
        <div class="modal__description js-modal-pass-text">
          Для того, чтобы сменить пароль, необходимо подтвердить номер
          телефона
        </div>
      </div>

      <form action="/api/user/controller-editUser.php"
            class="modal__form modal__form--sms form-default js-form-check-code js-form-sender">
        <?= bitrix_sessid_post() ?>
        <input type="hidden"
               name="ACTION"
               value="EDIT_USER_PASSWORD">
        <input type="hidden"
               name="method"
               value="check_code">
        <input type="hidden"
               name="USER_NEW_PASSWORD"
               value="">
        <div class="input-groups">
          <div data-input-group="phone" class="input-group">
            <input
              name="code"
              type="text"
              placeholder="Код из SMS"
              class="input"/>
            <div class="input-group__error"></div>
          </div>
        </div>
        <div class="form-default__actions">
          <button class="link link--gray js-resend-code" type="button">Отправить еще раз</button>
          <button class="btn" type="submit">Продолжить</button>
        </div>
      </form>

    </div>
  </div>

  <!--
  info: Authorize modal
  -->

  <div id="authorize-modal" class="modal modal--authorize animated">
    <button class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__body">
      <div class="modal__title">Пожалуйста, авторизуйтесь</div>
      <div class="modal__description">Авторизуйтесь, чтобы продолжить оформление заказа</div>
      <div class="modal__btn"><a href="#" class="btn">Авторизоваться</a></div>
    </div>
  </div>

  <!--
  info: Success authorize modal
  -->

  <div id="success-authorize-modal" class="modal modal--authorize animated">
    <button class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__body">
      <div class="modal__title">Спасибо!</div>
      <div class="modal__description">Вы успешно зарегистрированы</div>
      <div class="modal__btn"><a href="/catalog/" class="btn">Продолжить покупки</a></div>
      <div class="modal__btn"><a href="/personal/" class="btn btn--outline">Личный кабинет</a></div>
    </div>
  </div>

  <!--
  info: Callback modal
  -->

  <div id="callback-modal" class="modal modal--callback animated">
    <button class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__body">
      <div class="modal__title">Заказать обратный звонок</div>
      <div class="modal__description">Есть вопросы? Мы обязательно Вам поможем</div>
      <form action="/api/catalog/controller-callOrders.php" class="modal__form form-default js-form-sender">
        <?= bitrix_sessid_post() ?>
        <input type="hidden"
               name="ACTION"
               value="ADD_CALL_ORDERS">
        <input type="hidden"
               name="USER_RESPONSE"
               value="Звонок успешно заказан">
        <input type="hidden"
               name="THEME"
               value="Заявка на звонок">
        <div class="modal__input">
          <div data-input-group="name" class="input-group">
            <input name="name"
                   type="text"
                   placeholder="Имя Фамилия"
                   class="input"/>
            <div class="input-group__error"></div>
          </div>
        </div>
        <div class="modal__input">
          <div data-input-group="name" class="input-group">
            <input name="phone"
                   type="text"
                   placeholder="Ваш Телефон"
                   class="input js-input-phone"/>
            <div class="input-group__error"></div>
          </div>
        </div>
        <div class="modal__checkbox">
          <label class="checkbox">
            <input class="js-form-sender-checkbox" name="checkbox" type="checkbox" value="Y" checked/><span
              class="checkbox__indicator">
                  <svg class="icon icon-check ">
                    <use xlink:href="#check"></use>
                  </svg></span><span class="checkbox__description">Согласен на обработку&#8194;<a href="#" class="link">персональных данных</a></span>
          </label>
        </div>
        <div class="modal__submit">
          <button class="btn" type="submit">Отправить</button>
        </div>
      </form>
    </div>
  </div>

  <!--
  info: In cart modal
  -->

  <div id="in-cart-modal" class="modal modal--in-cart animated">
    <button class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__body">
      <div class="modal__title js-product-buy-title">Товар добавлен в корзину</div>
      <div class="modal-product">
        <div class="modal-product__img">
          <img class="js-product-buy-img" src="" alt=""/>
        </div>
        <div class="modal-product__info">
          <div class="modal-product__info-name js-product-buy-name"></div>
          <a href="/brands" class="modal-product__info-dev link js-product-buy-brand"></a>
        </div>
      </div>
      <div class="modal-links">
        <button type="button" class="btn btn--outline js-close-modal">Продолжить покупки</button>
        <a href="/personal/order/make/" title="Оформить заказ" class="btn">Оформить заказ</a>
      </div>
    </div>
  </div>

  <!--
  info: Drug selection modal
  -->

  <div id="drug-selection-modal" class="modal modal--drug-selection animated">
    <button class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__body">
      <form action="#" class="modal__form form-default">
        <div class="drug-selection__title title title--second">Поможем вам с выбором препарата для вашего
          животного
        </div>
        <div class="drug-selection__description">Заполните поля и мы подберем для вас список рекомендуемых
          товаров
        </div>
        <div class="drug-selection__row">
          <div class="drug-selection__column">
            <div class="custom-select js-custom-select">
              <button class="custom-select__header js-custom-select-toggle">
                <span class="custom-select__selected js-custom-select-render">Выберите категорию животного</span>
                <span class="custom-select__arrow">
                  <svg class="icon icon-hesrts-active ">
                    <use xlink:href="#hesrts-active"></use>
                  </svg>
                </span>
              </button>
              <div class="custom-select__body js-custom-select-list">
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="1"/><span
                    class="custom-select__label">Кот</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="2"/><span
                    class="custom-select__label">Пёс</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="3"/><span class="custom-select__label">Котопёс</span>
                </label>
              </div>
            </div>
          </div>
          <div class="drug-selection__column">
            <div class="custom-select js-custom-select">
              <button class="custom-select__header js-custom-select-toggle"><span
                  class="custom-select__selected js-custom-select-render">Порода животного</span><span
                  class="custom-select__arrow">
                      <svg class="icon icon-hesrts-active ">
                        <use xlink:href="#hesrts-active"></use>
                      </svg></span></button>
              <div class="custom-select__body js-custom-select-list">
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="1"/><span class="custom-select__label">Пункт 1</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="2"/><span class="custom-select__label">Пункт 2</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="3"/><span class="custom-select__label">Пункт 3</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="drug-selection__row">
          <div class="drug-selection__column drug-selection__column--double">
            <div class="drug-selection__age">
              <div class="drug-selection__age-span">Возраст</div>
              <input name="search" type="text" class="drug-selection__age-input"/>
            </div>
            <div class="custom-select js-custom-select">
              <button class="custom-select__header js-custom-select-toggle"><span
                  class="custom-select__selected js-custom-select-render">Месяц</span><span
                  class="custom-select__arrow">
                      <svg class="icon icon-hesrts-active ">
                        <use xlink:href="#hesrts-active"></use>
                      </svg></span></button>
              <div class="custom-select__body js-custom-select-list">
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="1"/><span class="custom-select__label">Сентябрь</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="2"/><span class="custom-select__label">Пункт 2</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="3"/><span class="custom-select__label">Пункт 3</span>
                </label>
              </div>
            </div>
          </div>
          <div class="drug-selection__column">
            <div class="custom-select js-custom-select">
              <button class="custom-select__header js-custom-select-toggle"><span
                  class="custom-select__selected js-custom-select-render">Симптомы</span><span
                  class="custom-select__arrow">
                      <svg class="icon icon-hesrts-active ">
                        <use xlink:href="#hesrts-active"></use>
                      </svg></span></button>
              <div class="custom-select__body js-custom-select-list">
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="1"/><span class="custom-select__label">Пункт 1</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="2"/><span class="custom-select__label">Пункт 2</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="3"/><span class="custom-select__label">Пункт 3</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="4"/><span class="custom-select__label">Пункт 4</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="5"/><span class="custom-select__label">Пункт 5 Пункт 5 Пункт 5 Пункт 5 Пункт 5 Пункт 5 Пункт 5</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="6"/><span class="custom-select__label">Пункт 6</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <button class="btn">Подобрать варианты</button>
      </form>
    </div>
  </div>

  <!--
  info: On map modal
  -->

  <div id="on-map-modal" class="modal modal--on-map animated">
    <button class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__body">
      <div class="modal__title">Показать на карте</div>
      <div id="js-simple-map-143" data-coordinates="55.639822, 37.812938" class="modal__map js-simple-map"></div>
    </div>
  </div>

  <!--
  info: Pick points modal
  -->

  <div id="pick-points-modal" class="modal modal--pick-points animated">
    <button class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__body">
      <div class="modal__title">Пункты самовывоза</div>
      <div class="map-sections">
        <div class="map-section map-section--selector">
          <div class="map__title">Населенный пункт</div>
          <div class="map__selector">
            <div class="custom-select custom-select--white js-custom-select">
              <button class="custom-select__header js-custom-select-toggle"><span
                  class="custom-select__selected js-custom-select-render">Москва</span><span
                  class="custom-select__arrow">
                      <svg class="icon icon-hesrts-active ">
                        <use xlink:href="#hesrts-active"></use>
                      </svg></span></button>
              <div class="custom-select__body js-custom-select-list">
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="1"/><span class="custom-select__label">Пункт 1</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="2"/><span class="custom-select__label">Пункт 2</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="3"/><span class="custom-select__label">Пункт 3</span>
                </label>
              </div>
            </div>
          </div>
          <div class="map-points">
            <div class="map-point">
              <div class="map-point__station">
                <div class="map-point__color"></div>
                Павелецкая
              </div>
              <div class="map-point__address">г. Москва, ул. Кожевническая, д. 1 стр. 1</div>
              <div class="map-point__row">
                <div class="map-point__info">Пункт выдачи партнера</div>
                <div class="map-point__dot"></div>
                <div class="map-point__info">Срок хранения заказа 5 дней</div>
              </div>
            </div>
            <div class="map-point">
              <div class="map-point__station">
                <div class="map-point__color"></div>
                Павелецкая
              </div>
              <div class="map-point__address">г. Москва, ул. Кожевническая, д. 1 стр. 1</div>
              <div class="map-point__row">
                <div class="map-point__info">Пункт выдачи партнера</div>
                <div class="map-point__dot"></div>
                <div class="map-point__info">Срок хранения заказа 5 дней</div>
              </div>
            </div>
            <div class="map-point">
              <div class="map-point__station">
                <div class="map-point__color"></div>
                Павелецкая
              </div>
              <div class="map-point__address">г. Москва, ул. Кожевническая, д. 1 стр. 1</div>
              <div class="map-point__row">
                <div class="map-point__info">Пункт выдачи партнера</div>
                <div class="map-point__dot"></div>
                <div class="map-point__info">Срок хранения заказа 5 дней</div>
              </div>
            </div>
            <div class="map-point">
              <div class="map-point__station">
                <div class="map-point__color"></div>
                Павелецкая
              </div>
              <div class="map-point__address">г. Москва, ул. Кожевническая, д. 1 стр. 1</div>
              <div class="map-point__row">
                <div class="map-point__info">Пункт выдачи партнера</div>
                <div class="map-point__dot"></div>
                <div class="map-point__info">Срок хранения заказа 5 дней</div>
              </div>
            </div>
            <div class="map-point">
              <div class="map-point__station">
                <div class="map-point__color"></div>
                Павелецкая
              </div>
              <div class="map-point__address">г. Москва, ул. Кожевническая, д. 1 стр. 1</div>
              <div class="map-point__row">
                <div class="map-point__info">Пункт выдачи партнера</div>
                <div class="map-point__dot"></div>
                <div class="map-point__info">Срок хранения заказа 5 дней</div>
              </div>
            </div>
            <div class="map-point">
              <div class="map-point__station">
                <div class="map-point__color"></div>
                Павелецкая
              </div>
              <div class="map-point__address">г. Москва, ул. Кожевническая, д. 1 стр. 1</div>
              <div class="map-point__row">
                <div class="map-point__info">Пункт выдачи партнера</div>
                <div class="map-point__dot"></div>
                <div class="map-point__info">Срок хранения заказа 5 дней</div>
              </div>
            </div>
            <div class="map-point">
              <div class="map-point__station">
                <div class="map-point__color"></div>
                Павелецкая
              </div>
              <div class="map-point__address">г. Москва, ул. Кожевническая, д. 1 стр. 1</div>
              <div class="map-point__row">
                <div class="map-point__info">Пункт выдачи партнера</div>
                <div class="map-point__dot"></div>
                <div class="map-point__info">Срок хранения заказа 5 дней</div>
              </div>
            </div>
            <div class="map-point">
              <div class="map-point__station">
                <div class="map-point__color"></div>
                Павелецкая
              </div>
              <div class="map-point__address">г. Москва, ул. Кожевническая, д. 1 стр. 1</div>
              <div class="map-point__row">
                <div class="map-point__info">Пункт выдачи партнера</div>
                <div class="map-point__dot"></div>
                <div class="map-point__info">Срок хранения заказа 5 дней</div>
              </div>
            </div>
            <div class="map-point">
              <div class="map-point__station">
                <div class="map-point__color"></div>
                Павелецкая
              </div>
              <div class="map-point__address">г. Москва, ул. Кожевническая, д. 1 стр. 1</div>
              <div class="map-point__row">
                <div class="map-point__info">Пункт выдачи партнера</div>
                <div class="map-point__dot"></div>
                <div class="map-point__info">Срок хранения заказа 5 дней</div>
              </div>
            </div>
            <div class="map-point">
              <div class="map-point__station">
                <div class="map-point__color"></div>
                Павелецкая
              </div>
              <div class="map-point__address">г. Москва, ул. Кожевническая, д. 1 стр. 1</div>
              <div class="map-point__row">
                <div class="map-point__info">Пункт выдачи партнера</div>
                <div class="map-point__dot"></div>
                <div class="map-point__info">Срок хранения заказа 5 дней</div>
              </div>
            </div>
            <div class="map-point">
              <div class="map-point__station">
                <div class="map-point__color"></div>
                Павелецкая
              </div>
              <div class="map-point__address">г. Москва, ул. Кожевническая, д. 1 стр. 1</div>
              <div class="map-point__row">
                <div class="map-point__info">Пункт выдачи партнера</div>
                <div class="map-point__dot"></div>
                <div class="map-point__info">Срок хранения заказа 5 дней</div>
              </div>
            </div>
            <div class="map-point">
              <div class="map-point__station">
                <div class="map-point__color"></div>
                Павелецкая
              </div>
              <div class="map-point__address">г. Москва, ул. Кожевническая, д. 1 стр. 1</div>
              <div class="map-point__row">
                <div class="map-point__info">Пункт выдачи партнера</div>
                <div class="map-point__dot"></div>
                <div class="map-point__info">Срок хранения заказа 5 дней</div>
              </div>
            </div>
          </div>
        </div>
        <div class="map-section map-section--map">
          <div id="js-map-render" class="map-cities"></div>
        </div>
      </div>
    </div>
  </div>
</div>
