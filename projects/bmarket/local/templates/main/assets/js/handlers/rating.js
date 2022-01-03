class Rating {
  constructor($el) {
    this.$wrapper = $el
    this.$star = this.$wrapper.find('svg')
    this.inputName = this.$wrapper.data('input-name')
    this.eventHandlers()
  }

  eventHandlers() {
    const self = this
    this.$wrapper.append(`<input type="hidden" name="${this.inputName}" value>`)

    this.$star.hover(function () {
      self.checkStars($(this).index() + 1, 'hover')
    }, function () {
      self.$star.removeClass('is--hover')
    })

    this.$star.click(function () {
      self.checkStars($(this).index() + 1, 'click')
      $('[name=' + self.inputName + ']').val($(this).index() + 1)
    })
  }

  checkStars(index, state) {
    if (state === 'click') this.$star.removeClass('is--active')

    this.$star.each(function (i) {
      if (i < index) {
        if (state === 'click') $(this).addClass('is--active')
        if (state === 'hover') $(this).addClass('is--hover')
      }
    })
  }
}

export default Rating
