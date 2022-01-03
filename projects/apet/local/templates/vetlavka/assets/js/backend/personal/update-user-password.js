const updateUserPassword = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on('submit', '.js-form-send-code', function () {
      self.sendUserCode($(this))
      return false
    })

    $(document).on('change', '.js-form-send-code', function () {
      self.setPasswordModal($(this))
      return false
    })

    $(document).on('click', '.js-resend-code', function () {
      self.clickResendCode()
      return false
    })
  },

  clickResendCode() {
    console.log('click')
    $('.js-btn-save-new-password').trigger('click')
  },

  setPasswordModal($form) {
    const $modalCodeForm = $('.js-form-check-code')
    const $password = $form.find("input[name='PASSWORD']").val()
    $modalCodeForm.find("input[name='USER_NEW_PASSWORD']").val($password)
  },

  sendUserCode($form) {
    launchWindowPreloader()

    axios
      .post($form.attr('action'), new FormData($form[0]))
      .then(response => {

        if (!response.data.error)
          openModal('#change-pass-phone')

        stopWindowPreloader()
      })
  }

}
export default updateUserPassword
