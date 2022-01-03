class Counter {
  constructor($el) {
    this.$wrapper = $el
    this.$counterBtn = this.$wrapper.find('.js-counter-btn')
    this.$counter = this.$wrapper.find('.js-counter-value')
    this.$counterValue = this.$wrapper.find('.js-counter-value').val()
    this.$productQuantity = this.$wrapper.find('.js-product-quantity-available').val()
    this.$productId = this.$wrapper.find('.js-product-id').val()
    this.eventHandler()
  }

  eventHandler() {
    const self = this

    this.$counterBtn.on("click", function () {
      self.counterElements($(this))
    })
  }

  counterElements($button) {
    switch ($button.data('btn-type-counter')) {
      case 'plus':
        if (this.$counterValue < this.$productQuantity)
          this.$counterValue++
        else
          $button.disabled()
        break
      case 'minus':
        if (this.$counterValue > 0)
          this.$counterValue--
        else
          $button.disabled()
        break
    }
    $('.js-buy-card-' + this.$productId + '')
      .find('[name="QUANTITY"]')
      .val(this.$counterValue)
    this.$counter.html(this.$counterValue)
  }
}

export default Counter
