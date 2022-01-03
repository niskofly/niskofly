class FormTotalCheck {
  constructor($wrapper) {
    this.$wrapper = $wrapper
    this.$checkbox = this.$wrapper.find('.cart-total__checkbox')
    this.$button = this.$wrapper.find('.cart-total__order-save-btn')
    this.event()
  }

  event() {
    const self = this
    this.$checkbox.on('change', function() {
      const isDisabled = $(this)
        .children('input')
        .prop('checked')

      if (isDisabled) self.$button.removeAttr('disabled')
      else self.$button.attr('disabled', 'disabled')
    })
  }
}

export default FormTotalCheck
