const common = {

  init() {
    this.eventHandlers()
  },

  eventHandlers() {
    const self = this

    $(document).on('click', '.js-toggle-filter-group', function () {
      const $groups = $(this).parent().find('div')

      if ($(this).hasClass('is--show')) {
        $groups.not(':nth-child(-n+6)').fadeOut()
        $(this).html('Развернуть')
      } else {
        $groups.fadeIn()
        $(this).html('Свернуть')
      }
      $(this).toggleClass('is--show')
    })

    $(document).on('click', '.js-password-eye', function () {
      const $inputGroup = $(this).closest('.js-password-group')
      const $input = $inputGroup.find('.js-password-input')
      const inputType = $input.attr('type')
      if (inputType === 'password')
        $input.attr('type', 'text')
      else
        $input.attr('type', 'password')
      $(this).toggleClass('is--open')
    })

    $(document).on('click', function (e) {
      const arrElements = [{ el: $('.js-window-location'), cls: 'window-location--active' }, { el: $('.js-window-catalog'), cls: 'window-catalog--active' }]

      arrElements.forEach(item => {
        if (
          !item.el.is(e.target) &&
          item.el.has(e.target).length === 0 &&
          item.el.hasClass(item.cls)
        )
          item.el.removeClass(item.cls)
      })
    })

    $(document).on('click', '.js-open-custom-window, .js-close-custom-window', function () {
      const win = $(this).data('win')
      $('.js-window-' + win).toggleClass('window-' + win + '--active')
      return false
    })
  }
}

export default common
