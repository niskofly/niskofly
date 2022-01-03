class ToggleSlide {
  constructor($wrapper) {
    this.$wrapper = $wrapper
    this.$btn = this.$wrapper.find('.js-toggle-slide-btn')
    this.$btnText = this.$btn.find('.js-toggle-slide-btn-text')
    this.$content = this.$wrapper.find('.js-toggle-slide-content')
    this.eventHandler()
  }

  eventHandler() {
    const self = this

    this.$btn.on('click', function () {
      $(self.$content).slideToggle()
      $(this).toggleClass('active');

      ($(this).hasClass('active')) ? $(self.$btnText).html('Свернуть') : $(self.$btnText).html('Развернуть')
    })

    if (!$(this.$btn).hasClass('active')) $(this.$content).hide()
  }
}

export default ToggleSlide
