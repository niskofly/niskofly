const smallBasketHandler = {
  count: 0,

  init() {
    this.count = Number($('.js-small-basket-count').html())

    this.eventHandler()
    return this
  },

  eventHandler() {
    const self = this

    $(document).on('click', '.js-small-basket-link', function () {
      if (self.count > 0)
        location.href = $(this).data('url')

      return false
    })
  },

  updateCount(count) {
    this.count = count
    $('.js-small-basket-count').html(count)
  }
}

export default smallBasketHandler
