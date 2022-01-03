const inputRating = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on('mouseenter', '.js-input-rating-item', function () {
      self.toggleRation($(this))
    })
  },

  toggleRation($star) {
    for (let i = 1; i <= 5; i++) {
      if (i <= $star.data('star-id')) {
        $('.js-product-rating')
          .find('.js-count-star')
          .val(i)

        $('.js-rating-stars')
          .find('[data-star-id="' + i + '"]')
          .addClass('rating-stars__icon--marked')
      } else {
        $('.js-rating-stars')
          .find('[data-star-id="' + i + '"]')
          .removeClass('rating-stars__icon--marked')
      }
    }
  }

}
export default inputRating
