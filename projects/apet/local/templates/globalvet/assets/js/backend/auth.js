const authHandler = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    /* Отправление формы с телефоном при регистрации */
    $(document).on("submit", ".js-auth", function () {
      self.request($(this))
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

  request($form) {
    launchWindowPreloader()

    axios
      .post($form.attr("action"), new FormData($form[0]))
      .then((response) => {
        stopWindowPreloader()
        if (response.data.error) {
          message({ title: "Ошибка", description: response.data.message })
        } else {
          switch (response.data.handler) {
            case "login":
              message({ title: "Успешная авторизация" })
              setTimeout(() => {
                closeModal()
                location.href = "/personal/"
              }, 1000)
              break
            case 'reg':
              $('.js-form-reg').hide().addClass('form--hide')
              $('.js-form-code').removeClass('form--hide')
              $('.js-form-code-phone').val(response.data.message.PHONE)
              break
            default:
              console.log(response)
              break
          }
        }
      })
  },

  /**
   * Восстановление пароля пользователя
   * @param $form
   */
  recoveryUserProfile($form) {
    launchWindowPreloader()
    const $formInput = $(".js-recovery-form-input")
    const $formInfo = $(".js-form-recovery-info")
    const $userPhone = $form.find('input[name="phone"]').val()

    axios.post($form.attr("action"), $form.serialize()).then((response) => {
      stopWindowPreloader()
      if (response.data.error) {
        $form
          .find('[data-input-group="phone"]')
          .addClass("input-group--error")
          .find(".input-group__error")
          .html(response.data.message)
        return
      }
      $formInfo.find('input[name="phone"]').val($userPhone)
      $formInput.css("display", "none")
      $formInfo.find(".auth").css("display", "block")
    })
  },

  /**
   * Повторное отправление кода
   * при восстановлении пароля
   */
  resendRecoveryCode() {
    launchWindowPreloader()
    const $form = $(".js-recovery-profile-user")

    axios.post($form.attr("action"), $form.serialize()).then((response) => {
      stopWindowPreloader()
      if (response.data.error) {
        console.log(response.data.message)
        return
      }
      $(".js-form-recovery-info")
        .find(".auth-header__description")
        .html("Мы повторно отправили новый пароль на ваш номер телефона")
    })
  },

  /**
   * Отправка повторного кода
   * при регистрации
   */
  resendReqCode() {
    launchWindowPreloader()
    const $form = $(".js-auth-form-code")
    const $actionInput = $form.find('[name="ACTION"]')

    $actionInput.val("RESEND_USER_CODE")

    axios.post($form.attr("action"), $form.serialize()).then((response) => {
      stopWindowPreloader()
      $actionInput.val("USER_AUTH")
      $(".js-auth-title").html(
        "На Ваш телефон повторно выслано сообщение с кодом подтверждения."
      )
    })
  },
}

export default authHandler
