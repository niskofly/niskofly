class Rating {
  constructor($el) {
    this.$wrapper = $el
    this.$countStars = this.$wrapper.find('.js-count-stars')
    this.$ratingStars = this.$wrapper.find('.js-rating-stars')
    this.$ratingStar = this.$wrapper.find('.js-rating-star')
    this.eventHandlers()
  }

  eventHandlers() {
    const self = this

    this.$ratingStar.on("mouseenter", function () {
      self.toggleRation($(this))
    })
  }

  toggleRation($star) {
    for (let i = 1; i <= 5; i++) {
      if (i <= $star.data('star-id')) {
        this.$countStars.val(i)

        this.$ratingStars
          .find('[data-star-id="' + i + '"]')
          .find('svg')
          .addClass('is--active')
      } else {
        this.$ratingStars
          .find('[data-star-id="' + i + '"]')
          .find('svg')
          .removeClass('is--active')
      }
    }
  }
}

export default Rating
