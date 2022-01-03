class CounterProductBtn {
  constructor($wrapper, isSubmitWhenChange = false) {
    this.$wrapper = $wrapper
    if (this.$wrapper.hasClass('--init--'))
      return

    this.maxQuantity = $wrapper.data('max')

    this.$btn = $wrapper.find('[type="submit"]')
    this.$reduceBtn = $wrapper.find('[name="reduce"]')
    this.$increaseBtn = $wrapper.find('[name="increase"]')
    this.$quantityInput = $wrapper.find('[name="QUANTITY"]')
    this.$actionInput = $wrapper.find('[name="ACTION"]')
    this.$form = $wrapper.closest('form').get(0)

    this.SUBMIT_FORM_WHEN_CHANGE = isSubmitWhenChange

    this.$wrapper.addClass('--init--')

    this.eventHandler()
    return this
  }

  eventHandler() {
    this.$reduceBtn.click(() => {
      this.reduceValue()
    })

    this.$increaseBtn.click(() => {
      this.increaseValue()
    })
  }

  reduceValue() {
    const quantity = this.$quantityInput.val() - 1
    if (quantity <= 0) return

    this.$quantityInput.val(quantity)

    if (this.SUBMIT_FORM_WHEN_CHANGE)
      this.sendForm('UPDATE_BASKET_ITEM')
  }

  increaseValue() {
    const quantity = Number(this.$quantityInput.val()) + 1
    if (this.maxQuantity && quantity > this.maxQuantity)
      return

    this.$quantityInput.val(quantity)

    if (this.SUBMIT_FORM_WHEN_CHANGE)
      this.sendForm('UPDATE_BASKET_ITEM')
  }

  sendForm(action = 'BUY_PRODUCT') {
    this.$actionInput.val(action)

    if (this.$form)
      this.$form.dispatchEvent(new Event('submit', { bubbles: true }))
  }
}

export default CounterProductBtn
