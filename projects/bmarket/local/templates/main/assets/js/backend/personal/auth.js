const authHandler = {
  init() {
    this.$sendCodeForm = $('.js-send-auth-code-form')
    if (!this.$sendCodeForm.length) return

    this.$authForm = $('.js-auth-form')
    this.$authFormCodeInput = $('.js-auth-form-code-input')

    this.timeDefaultValue = 60
    this.$timer = $('.js-auth-resend-timer')
    this.$timerRow = $('.js-auth-resend-timer-row')

    this.$resendCodeBtn = $('.js-auth-resend-code-button')
    this.$resendCodeForm = $('.js-auth-resend-code-form')

    this.eventHandler()
  },

  eventHandler() {
    $(document).on('input', '.js-auth-main-phone', function () {
      $('.js-auth-copy-phone').val($(this).val())
      $('.js-auth-render-phone').text($(this).val())
    })

    this.$sendCodeForm.on('submit', () => {
      this.onSendCodeForm()
      return false
    })

    this.$authFormCodeInput.on('input', () => {
      if (this.$authFormCodeInput.val().length >= 4) {
        this.onSendAuthForm()
        return false
      }
    })

    this.$resendCodeBtn.on('click', () => {
      this.onResendCodeForm()
      return false
    })
  },

  onSendCodeForm() {
    window.launchWindowPreloader()

    window.axios.post(this.$sendCodeForm.attr('action'), this.$sendCodeForm.serialize()).then(response => {
      window.stopWindowPreloader()

      if (response.data.error)
        return window.messageError({ title: response.data.msg })

      if (this.$sendCodeForm.data('goal'))
        window.metrics.reachGoal(this.$sendCodeForm.data('goal'))

      this.showConfirmCodeForm()
    })
  },

  showConfirmCodeForm() {
    this.$sendCodeForm.hide()
    this.$authForm.show()

    this.toggleActiveResendCodeBtn(false)
    this.startResendCodeTimer()
  },

  toggleActiveResendCodeBtn(state) {
    if (state) {
      this.$resendCodeBtn.attr('disabled', false)
      this.$timerRow.hide()
      return
    }

    this.$resendCodeBtn.attr('disabled', true)
    this.$timer.text(this.timeDefaultValue)
    this.$timerRow.show()
  },

  startResendCodeTimer() {
    this.time = this.timeDefaultValue

    const timerId = setInterval(() => {
      --this.time
      const renderTime = this.time >= 10 ? this.time : '0' + this.time
      this.$timer.text(renderTime)

      if (this.time === 0) {
        this.toggleActiveResendCodeBtn(true)
        clearInterval(timerId)
      }
    }, 1000)
  },

  onSendAuthForm() {
    window.launchWindowPreloader()

    window.axios.post(this.$authForm.attr('action'), this.$authForm.serialize()).then(response => {
      if (response.data.error) {
        window.stopWindowPreloader()
        return window.messageError({ title: response.data.msg })
      }

      if (this.$authForm.data('goal'))
        window.metrics.reachGoal(this.$authForm.data('goal'))

      location.reload()
    })
  },

  onResendCodeForm() {
    window.launchWindowPreloader()

    window.axios.post(this.$resendCodeForm.attr('action'), this.$resendCodeForm.serialize()).then(response => {
      window.stopWindowPreloader()

      if (response.data.error) {
        window.stopWindowPreloader()
        return window.messageError({ title: response.data.msg })
      }

      if (this.$authForm.data('goal'))
        window.metrics.reachGoal(this.$resendCodeForm.data('goal'))

      this.toggleActiveResendCodeBtn(false)
      this.startResendCodeTimer()
    })
  }
}

export default authHandler
