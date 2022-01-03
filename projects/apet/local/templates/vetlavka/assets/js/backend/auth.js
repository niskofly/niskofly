const authHandler = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    /* Отправление формы с телефоном при регистрации */
    $(document).on("submit", ".js-auth-form-phone", function () {
      self.sendAutFormPhone($(this))
      return false
    })

    /* Отправление формы с кодом при регистрации */
    $(document).on("submit", ".js-auth-form-code", function () {
      self.sendAutFormCode($(this))
      return false
    });

    /* Отправление формы при авторизации */
    $(document).on("submit", ".js-auth-profile-user", function () {
      self.authUserProfile($(this))
      return false
    })

    /* Отправление формы с телефоном при восстановлении пароля */
    $(document).on("submit", ".js-recovery-profile-user", function () {
      self.recoveryUserProfile($(this))
      return false
    })

    /* Повторная отправка кода при регистрации */
    $(document).on("click", ".js-reg-form-resend-code", function () {
      self.resendReqCode()
      return false
    })

    /* Обработка кнопки повторного отправления кода при восстановлении */
    $(document).on("click", ".js-resend-recovery-code", function () {
      self.resendRecoveryCode()
      return false
    })
  },

  /**
   * Регистрация
   * Отправление данных телефона
   * в api/user/auth.php
   * @param $form
   */
  sendAutFormPhone($form) {
    launchWindowPreloader()

    axios
      .post($form.attr("action"), $form.serialize())
      .then(response => {
        stopWindowPreloader()
        if (response.data.error) {
          $form
            .find('[data-input-group="phone"]')
            .addClass('input-group--error')
            .find('.input-group__error')
            .html(response.data.message)

          $('.js-recovery-password-in-regist').show()
          return;
        }
        $form.css('display', 'none');
        $(".js-auth-form-code")
          .css('display', 'block')
          .find('[name="phone"]')
          .val(
            $form
              .find('.js-auth-form-phone-input')
              .val()
          )
        $(".js-auth-title").text(
          'Мы также отправили вам постоянный пароль для входа на указанный номер телефона'
        )
      })
  },

  /**
   * Регистрация
   * Отправление данных введенного кода
   * в api/user/auth.php
   * @param $form
   */
  sendAutFormCode($form) {
    launchWindowPreloader()

    axios
      .post($form.attr("action"), $form.serialize())
      .then(response => {
        stopWindowPreloader()
        if (response.data.error) {
          $form
            .find('[data-input-group="code"]')
            .addClass('input-group--error')
            .find('.input-group__error')
            .html(response.data.message)
          return
        }
        openModal('#success-authorize-modal')
      })
  },

  /**
   * Авторизация пользователя
   * @param $form
   */
  authUserProfile($form) {
    launchWindowPreloader()

    axios
      .post($form.attr("action"), $form.serialize())
      .then(response => {
        stopWindowPreloader()
        if (response.data.error) {
          $form
            .find('[data-input-group="phone"]')
            .addClass('input-group--error')
          $form
            .find('[data-input-group="password"]')
            .addClass('input-group--error')
            .find('.input-group__error')
            .html(response.data.message)
          return
        }
        openModal('#success-authorize-modal')
      })
  },

  /**
   * Восстановление пароля пользователя
   * @param $form
   */
  recoveryUserProfile($form) {
    launchWindowPreloader()
    const $formInput = $(".js-recovery-form-input");
    const $formInfo = $(".js-form-recovery-info");
    const $userPhone = $form.find('input[name="phone"]').val()

    axios
      .post($form.attr("action"), $form.serialize())
      .then(response => {
        stopWindowPreloader()
        if (response.data.error) {
          $form
            .find('[data-input-group="phone"]')
            .addClass('input-group--error')
            .find('.input-group__error')
            .html(response.data.message)
          return
        }
        $formInfo
          .find('input[name="phone"]')
          .val($userPhone)
        $formInput
          .css('display', 'none')
        $formInfo
          .find('.auth')
          .css('display', 'block')
      });
  },

  /**
   * Повторное отправление кода
   * при восстановлении пароля
   */
  resendRecoveryCode() {
    launchWindowPreloader()
    const $form = $(".js-recovery-profile-user");

    axios
      .post($form.attr("action"), $form.serialize())
      .then(response => {
        stopWindowPreloader()
        if (response.data.error) {
          console.log(response.data.message)
          return
        }
        $('.js-form-recovery-info')
          .find('.auth-header__description')
          .html('Мы повторно отправили новый пароль на ваш номер телефона')
      })
  },

  /**
   * Отправка повторного кода
   * при регистрации
   */
  resendReqCode() {
    launchWindowPreloader();
    const $form = $(".js-auth-form-code");
    const $actionInput = $form.find('[name="ACTION"]');

    $actionInput.val("RESEND_USER_CODE");

    axios
      .post($form.attr("action"), $form.serialize())
      .then(response => {
        stopWindowPreloader()
        $actionInput.val("USER_AUTH")
        $(".js-auth-title").html(
          "На Ваш телефон повторно выслано сообщение с кодом подтверждения."
        )
      })
  }
}

export default authHandler
