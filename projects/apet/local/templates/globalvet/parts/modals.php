<div class="modals">

  <!--
  info: Модальное - обновление пароля в личном кабинете
  -->

  <div id="change-pass-phone" class="modal modal--notify animated">
    <button type="button" class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__header">
      <div class="title title--medium modal__title">Смена пароля</div>
      <div class="modal__header-text js-modal-pass-text">
        Для того, чтобы сменить пароль, необходимо подтвердить номер телефона
      </div>
    </div>
    <div class="modal__main">
      <form action="/api/user/user-update.php" class="form form--product-notify js-form-check-code js-form-sender">
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
          <!-- Ввод кода из смс -->
          <div class="input-group js-group-label">
            <div class="input-group__wrapper">
              <label class="input-group__label">Код из смс</label>
              <input name="code" type="text" placeholder="Код из SMS" class="input js-group-label__input"/>
            </div>
            <div class="input-group__error"></div>
          </div>
        </div>
        <button type="button" class="btn btn--big btn--blue js-resend-code">Отправить еще раз</button>
        <button type="submit" class="btn btn--big btn--blue">Продолжить</button>
      </form>
    </div>
  </div>

  <!--
  info: Модальное - сообщение
  -->
  <div id="message-modal" class="modal modal--message animated">
    <button type="button" class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="title title--medium modal__title js-message-modal-title"></div>
    <div class="modal__text js-message-modal-description"></div>
  </div>

  <!--
  info: Модальное - Спасибо за регистрацию
  -->
  <div id="modal-thanks" class="modal modal--thanks animated">
    <button type="button" class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__header">
      <div class="title title--medium modal__title">Спасибо!</div>
      <div class="modal__header-text">Вы успешно зарегистрированы</div>
    </div>
    <div class="modal__actions">
      <button type="button" class="btn btn--blue btn--big modal__btn-action js-close-modal">Продолжить
        покупки
      </button>
      <a href="/" class="btn btn--white-border btn--big modal__btn-action">Личный
        кабинет</a>
    </div>
  </div>

  <!--
  info: Модальное - Товар добавлен в корзину
  -->
  <div id="modal-product-added" class="modal modal--product-added animated">
    <button type="button" class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__header">
      <div class="title title--medium modal__title">Товар добавлен в корзину</div>
    </div>
    <div class="modal__main">
      <div class="product-order"><a href="/" class="product-order__preview"><img src="/img/card-product-1.png"
                                                                                 alt=""/></a>
        <div class="product-order__content"><a href="/" class="product-order__name">Таблетки для собак весом
            от 2 до 4,5 кг от блох и клещей, 1табл.</a><a href="/"
                                                          class="product-order__brand">Бравекто</a></div>
      </div>
      <div class="modal__actions">
        <button type="button"
                class="btn btn--white-border btn--big modal__btn-action js-close-modal">Продолжить
          покупки
        </button>
        <a href="/" class="btn btn--blue btn--big modal__btn-action">Оформить заказ</a>
      </div>
    </div>
  </div>

  <!--
  info: Модальное - Товар добавлен в корзину
  -->
  <div id="modal-product-notify" class="modal modal--notify animated">
    <button type="button" class="modal__close js-close-modal">
      <svg class="icon icon-close ">
        <use xlink:href="#close"></use>
      </svg>
    </button>
    <div class="modal__header">
      <div class="title title--medium modal__title">Товар добавлен в корзину</div>
      <div class="modal__header-text">
        <p>Оставьте свой email и мы оповестим</p>
        <p>Вас об поступлении данного товара</p>
      </div>
    </div>
    <div class="modal__main">
      <div class="product-order"><a href="/" class="product-order__preview"><img src="/img/card-product-1.png"
                                                                                 alt=""/></a>
        <div class="product-order__content"><a href="/" class="product-order__name">Таблетки для собак весом
            от 2 до 4,5 кг от блох и клещей, 1табл.</a><a href="/"
                                                          class="product-order__brand">Бравекто</a></div>
      </div>
      <form action="" class="form form--product-notify">
        <div class="input-groups">
          <div class="input-group js-group-label">
            <div class="input-group__wrapper">
              <label class="input-group__label">email</label>
              <input name="name" type="email" class="input js-group-label__input"/>
            </div>
            <div class="input-group__error"></div>
          </div>
          <div class="input-group">
            <label class="checkbox">
              <input type="checkbox" name="sms" value="" checked="checked"/>
              <span class="checkbox__view">
                <svg class="icon icon-checkmark ">
                    <use xlink:href="#checkmark"></use>
                </svg>
              </span>
              <span class="checkbox__text">Уведомлять по SMS</span>
            </label>
          </div>
        </div>
        <button type="submit" class="btn btn--big btn--blue">Отправить</button>
      </form>
    </div>
  </div>

  <!--
  info: Модальное - Обратный звонок
  -->
  <div id="modal-feedback" class="modal modal--default animated">
    <div class="modal__header">
      <div class="title title--medium modal__title">Заказать обратный звонок</div>
      <div class="modal__header-text">
        <p>Есть вопросы?</p>
        <p>Мы обязательно Вам поможем</p>
      </div>
      <button type="button" class="modal__close js-close-modal">
        <svg class="icon icon-close ">
          <use xlink:href="#close"></use>
        </svg>
      </button>
    </div>
    <div class="modal__main">
      <form action="" class="form form--modal-default">
        <div class="input-groups">
          <div class="input-group js-group-label">
            <div class="input-group__wrapper">
              <label class="input-group__label">Ваше имя</label>
              <input name="name" type="text" class="input js-group-label__input"/>
            </div>
            <div class="input-group__error"></div>
          </div>
          <div class="input-group js-group-label">
            <div class="input-group__wrapper">
              <label class="input-group__label">Телефон</label>
              <input name="name" type="text" class="input js-group-label__input"/>
            </div>
            <div class="input-group__error"></div>
          </div>
        </div>
        <div class="form__actions">
          <label class="checkbox form__term">
            <input type="checkbox" name="term" value="" checked="checked"/><span
              class="checkbox__view">
                                <svg class="icon icon-checkmark ">
                                    <use xlink:href="#checkmark"></use>
                                </svg></span><span class="checkbox__text">Согласен на обработку <a href="/">персональных
                                    данных</a></span>
          </label>
          <button type="submit" class="btn btn--blue btn--medium form__submit">Отправить</button>
        </div>
      </form>
    </div>
  </div>

  <!--
  info: Модальное - Связались с нами в течение 24/7
  -->
  <div id="modal-contact-us" class="modal modal--default animated">
    <div class="modal__header">
      <div class="title title--medium modal__title">Связаться с нами</div>
      <div class="modal__header-text">Мы рады помочь вам 24/7</div>
      <button type="button" class="modal__close js-close-modal">
        <svg class="icon icon-close ">
          <use xlink:href="#close"></use>
        </svg>
      </button>
    </div>
    <div class="modal__main">
      <form action="" class="form form--modal-default">
        <div class="input-groups">
          <div class="input-group js-group-label">
            <div class="input-group__wrapper">
              <label class="input-group__label">Ваше имя</label>
              <input name="name" type="text" class="input js-group-label__input"/>
            </div>
            <div class="input-group__error"></div>
          </div>
          <div class="input-group js-group-label">
            <div class="input-group__wrapper">
              <label class="input-group__label">Телефон</label>
              <input name="name" type="text" class="input js-group-label__input"/>
            </div>
            <div class="input-group__error"></div>
          </div>
          <div class="input-group">
            <textarea name="name" placeholder="Ваш комментарий" class="input form__textarea"></textarea>
            <div class="input-group__error"></div>
          </div>
        </div>
        <div class="form__actions">
          <label class="checkbox form__term">
            <input type="checkbox" name="term" value="" checked="checked"/><span
              class="checkbox__view">
                                <svg class="icon icon-checkmark ">
                                    <use xlink:href="#checkmark"></use>
                                </svg></span><span class="checkbox__text">Согласен на обработку <a href="/">персональных
                                    данных</a></span>
          </label>
          <button type="submit" class="btn btn--blue btn--medium form__submit">Отправить</button>
        </div>
      </form>
    </div>
  </div>

  <!--
  info: Модальное - авторизуйся! пожалуйста
  -->
  <div id="modal-auth" class="modal modal--default animated">
    <div class="modal__header">
      <div class="title title--medium modal__title">Пожалуйста, авторизуйтесь</div>
      <div class="modal__header-text">Авторизуйтесь, чтобы продолжить оформление заказа</div>
      <button type="button" class="modal__close js-close-modal">
        <svg class="icon icon-close ">
          <use xlink:href="#close"></use>
        </svg>
      </button>
    </div>
    <div class="modal__main"><a href="/" class="btn btn--big btn--blue modal__btn-auth">Авторизоваться</a></div>
  </div>
  <div id="modal-choice" class="modal modal--choice animated">
    <div class="modal__header">
      <button type="button" class="modal__close js-close-modal">
        <svg class="icon icon-close ">
          <use xlink:href="#close"></use>
        </svg>
      </button>
    </div>
    <div class="help-choice help-choice--modal">
      <div class="help-choice__header">
        <div class="title help-choice__title">Поможем вам с выбором для вашего животного</div>
        <div class="help-choice__tabs">
          <button type="button" class="help-choice__tab help-choice__tab--active">препарата</button>
          <button type="button" class="help-choice__tab">корма</button>
        </div>
      </div>
      <div class="help-choice__text">Заполните поля и мы подберем для вас список рекомендуемых товаров</div>
      <form action="" class="form-help-choice">
        <div class="input-groups">
          <div class="input-group input-group--half">
            <div class="custom-select js-custom-select">
              <button class="custom-select__header js-custom-select-toggle"><span
                  class="custom-select__selected js-custom-select-render">Выберите категорию
                                        животного</span><span class="custom-select__arrow">
                                        <svg class="icon icon-down ">
                                            <use xlink:href="#down"></use>
                                        </svg></span></button>
              <div class="custom-select__body js-custom-select-list">
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="1"/><span
                    class="custom-select__label">Выберите категорию животного</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="2"/><span
                    class="custom-select__label">Выберите категорию животного 2</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="3"/><span
                    class="custom-select__label">Выберите категорию животного 3</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="4"/><span
                    class="custom-select__label">Выберите категорию животного 4</span>
                </label>
              </div>
            </div>
          </div>
          <div class="input-group input-group--half">
            <div class="custom-select js-custom-select">
              <button class="custom-select__header js-custom-select-toggle"><span
                  class="custom-select__selected js-custom-select-render">Порода
                                        животного</span><span class="custom-select__arrow">
                                        <svg class="icon icon-down ">
                                            <use xlink:href="#down"></use>
                                        </svg></span></button>
              <div class="custom-select__body js-custom-select-list">
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="1"/><span
                    class="custom-select__label">Порода животного</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="2"/><span
                    class="custom-select__label">Порода животного 2</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="3"/><span
                    class="custom-select__label">Порода животного 3</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="4"/><span
                    class="custom-select__label">Порода животного 4</span>
                </label>
              </div>
            </div>
          </div>
          <div class="input-group input-group--half input-group--container">
            <div class="input-age">
              <div class="input-age__label">Возраст</div>
              <input type="text"/>
            </div>
            <div class="custom-select js-custom-select">
              <button class="custom-select__header js-custom-select-toggle"><span
                  class="custom-select__selected js-custom-select-render">Месяц</span><span
                  class="custom-select__arrow">
                                        <svg class="icon icon-down ">
                                            <use xlink:href="#down"></use>
                                        </svg></span></button>
              <div class="custom-select__body js-custom-select-list">
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="1"/><span
                    class="custom-select__label">Месяц</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="2"/><span
                    class="custom-select__label">Сентябрь</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="3"/><span
                    class="custom-select__label">Февраль</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="4"/><span
                    class="custom-select__label">Декабрь</span>
                </label>
              </div>
            </div>
          </div>
          <div class="input-group input-group--half">
            <div class="custom-select js-custom-select">
              <button class="custom-select__header js-custom-select-toggle"><span
                  class="custom-select__selected js-custom-select-render">Симптомы</span><span
                  class="custom-select__arrow">
                                        <svg class="icon icon-down ">
                                            <use xlink:href="#down"></use>
                                        </svg></span></button>
              <div class="custom-select__body js-custom-select-list">
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="1"/><span
                    class="custom-select__label">Симптомы</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="2"/><span
                    class="custom-select__label">Симптомы 2</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="3"/><span
                    class="custom-select__label">Симптомы 3</span>
                </label>
                <label class="custom-select__option">
                  <input name="test" type="checkbox" value="4"/><span
                    class="custom-select__label">Симптомы 4</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="form-help-choice__actions">
          <button type="submit" class="btn btn--big btn--blue form-help-choice__submit">Подобрать
            варианты
          </button>
        </div>
      </form>
    </div>
  </div>

  <!--
  info: Модальное - карта в модальном
  -->
  <div id="modal-map" class="modal modal--map animated">
    <div class="modal__map">
      <script type="text/javascript" charset="utf-8" async
              src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3AuMiereV5htULfDFcFfcS3mMCWT4fzyDa&amp;width=100%&amp;height=100%&amp;lang=ru_RU&amp;scroll=true"></script>
    </div>
  </div>

  <!--
  info: Модальное - Поделиться
  -->
  <div id="modal-share" class="modal modal--default animated">
    <div class="modal__header">
      <div class="title title--medium modal__title">Поделиться</div>
      <div class="modal__header-text">выберите соцсеть</div>
      <button type="button" class="modal__close js-close-modal">
        <svg class="icon icon-close ">
          <use xlink:href="#close"></use>
        </svg>
      </button>
    </div>
    <div class="modal__main">
      <div class="modal__socials">
        <div class="js-social modal__socials-item" data-share-social="fb">
          <img src="" alt="fb">
        </div>
        <div class="js-social modal__socials-item" data-share-social="vk">
          <img src="" alt="vk">
        </div>
        <div class="js-social modal__socials-item" data-share-social="od">
          <img src="" alt="odn">
        </div>
      </div>
      <div class="input-group js-group-label">
        <div class="input-group__wrapper">
          <label class="input-group__label">ссылка</label>
          <input name="share-link" type="text" class="input js-group-label__input"/>
        </div>
        <div class="input-group__error"></div>
      </div>
    </div>
    <div class="form__actions">
      <div class="btn js-follow-share-link">Перейти</div>
      <div class="btn js-copy-share-link">Скопировать</div>
    </div>
    </form>
  </div>
</div>
</div>
