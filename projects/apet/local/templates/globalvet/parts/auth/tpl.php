<div class="section-main container">
  <div class="section-main__wrapper">

    <div class="auth-section">

      <div class="auth-section__header">
        <div class="title auth-section__title"><? $APPLICATION->ShowTitle(false); ?></div>
      </div>

      <form
        action="/api/user/auth.php"
        class="form form--<?=$AUTH_PAGE?> js-auth<? if ($AUTH_PAGE == 'reg'): ?> js-form-reg<? endif; ?>">
        <?= bitrix_sessid_post() ?>
      <?
        switch ($AUTH_PAGE):
          case 'enter':
      ?>
            <input type="hidden" name="ACTION" value="USER_AUTH">
            <div class="input-groups">
              <div class="input-group js-group-label">
                <div class="input-group__wrapper">
                  <label class="input-group__label">Телефон *</label>
                  <input
                    name="PHONE"
                    type="tel"
                    class="input js-group-label__input"
                    placeholder="+7 (000) 000-00-00">
                </div>
                <div class="input-group__error"></div>
              </div>
              <div class="input-group js-group-label">
                <div class="input-group__wrapper">
                  <label class="input-group__label">Пароль</label>
                  <input
                    name="CODE"
                    type="password"
                    class="input js-group-label__input">
                </div>
                <div class="input-group__error"></div>
              </div>
            </div>
            <div class="form__actions">
              <label class="checkbox">
                <input
                  type="checkbox"
                  name="REMEMBER"
                  value=""
                  checked>
                <span class="checkbox__view">
                  <svg class="icon icon-checkmark ">
                    <use xlink:href="#checkmark"></use>
                  </svg>
                </span>
                <span class="checkbox__text">Запомнить меня</span>
              </label>
              <button type="submit" class="btn btn--blue btn--big">Отправить</button>
            </div>
      <?
            include_once 'socials.php';
            break;
          case 'reg':
      ?>
            <input
              type="hidden"
              name="ACTION"
              value="USER_CREATE">
            <div class="input-groups">
              <div class="input-group js-group-label">
                <div class="input-group__wrapper">
                  <label class="input-group__label">Телефон *</label>
                  <input
                    name="PHONE"
                    type="tel"
                    class="input js-group-label__input">
                </div>
                <div class="input-group__error"></div>
              </div>
              <div class="input-group">
                <label class="checkbox">
                  <input
                    type="checkbox"
                    name="private"
                    value=""
                    checked>
                  <span class="checkbox__view">
                    <svg class="icon icon-checkmark ">
                      <use xlink:href="#checkmark"></use>
                    </svg>
                  </span>
                  <span class="checkbox__text">Я частное лицо</span>
                </label>
                <div class="input-group__error"></div>
              </div>
            </div>
            <div class="form__actions">
              <button
                type="submit"
                class="btn btn--blue btn--big">Зарегистрироваться</button>
            </div>
      <?
            include_once 'socials.php';
            break;
        endswitch;
      ?>
      </form>
      <? if ($AUTH_PAGE == 'reg'): ?>
        <form
          action="/api/user/auth.php"
          class="form form--code form--hide form--<?=$AUTH_PAGE;?> js-auth js-form-code">
          <?= bitrix_sessid_post() ?>
          <input type="hidden" name="PHONE" value="" class="js-form-code-phone">
          <input type="hidden" name="ACTION" value="USER_AUTH">

          <div class="input-groups">
            <div class="input-group js-group-label">
              <div class="input-group__wrapper">
                <label class="input-group__label">Код из SMS</label>
                <input
                  name="CODE"
                  type="text"
                  class="input js-group-label__input">
              </div>
              <div class="input-group__error"></div>
            </div>
            <div class="input-group">
              <button type="button" class="form__code-repeat">Отправить код еще раз</button>
            </div>
          </div>

          <div class="form__actions">
            <button type="submit" class="btn btn--blue btn--big">Зарегистрироваться</button>
          </div>
        </form>
      <? endif; ?>
    </div>

    <?
      switch ($AUTH_PAGE):
        case 'enter':
    ?>
          <div class="section-main__links">
            <a href="/" class="section-main__link">Забыли пароль?</a>
            <a href="/auth/reg/" class="section-main__link">Зарегистрироваться</a>
          </div>
    <?
          break;
        case 'reg':
    ?>
          <div class="section-main__links section-main__links--center">
            <a
              href="/auth/"
              class="section-main__link section-main__link--blue">Уже есть аккаунт?</a>
          </div>
    <?
          break;
      endswitch;
    ?>

  </div>

</div>
