class InputLabels {
  constructor($group, callback) {
    this.$group = $group
    this.$input = this.$group.find('.js-group-label__input')
    this.not_empty_class = 'input-group--not-empty'

    this.eventHandler()

    if (callback)
      callback(this)

    this.checkEmpty()

    return this
  }

  eventHandler() {
    this.$input.on('focus', () => {
      this.$group.addClass(this.not_empty_class)
    })

    this.$input.on('blur', () => {
      this.checkEmpty()
    })
  }

  checkEmpty() {
    const isEmpty = this.$input.val().trim() === ''

    if (isEmpty)
      this.$group.removeClass(this.not_empty_class)
    else
      this.$group.addClass(this.not_empty_class)
  }
}

window.resetLabelInput = function ($form) {
  $form.find('.js-group-label').each(function () {
    $(this).removeClass(this.not_empty_class)
    $(this)
      .find('.js-group-label__input')
      .val('')
  })
}

export default InputLabels
