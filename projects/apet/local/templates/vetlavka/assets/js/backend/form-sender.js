const formSender = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on('submit', '.js-form-sender', function () {
      self.sendRequest($(this))
      return false
    });

    $(document).on('change', '.js-form-sender-checkbox', function () {
      self.checkCheckbox($(this))
    })
  },

  sendRequest($form) {
    launchWindowPreloader()

    axios
      .post($form.attr('action'), new FormData($form[0]))
      .then(response => {
        const message = response.data.message
        const isError = response.data.error

        $.magnificPopup.close()

        setTimeout(() => {
          stopWindowPreloader()

          const goal = $form.data('goal')
          if (goal) metrics.reachGoal(goal)

          if (message){
            $('.js-success-modal-description').html(message)
            return openModal('#thanks-modal')
          }

          if (isError)
            return openModal('#authorize-modal')

        }, 500)
      })
  },

  checkCheckbox($form) {
    const isDisabled = !$form.prop('checked')
    const $submit = $form.closest('form').find('[type="submit"]')

    if (isDisabled)
      $submit.attr('disabled', 'disabled')
    else
      $submit.removeAttr('disabled')
  }

}
export default formSender
