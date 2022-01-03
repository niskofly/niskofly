const common = {
  init() {
    this.eventHandlers()
  },

  eventHandlers() {
    const self = this

    $(document).on('change', '.js-delivery-type', function() {
      const id = $(this).prop('id')
      if (id === 'shop') {
        $('.js-delivery-map').addClass('active')
        $('.js-delivery-personal-input').removeClass('active')
      } else {
        $('.js-delivery-map').removeClass('active')
        $('.js-delivery-personal-input').addClass('active')
      }
      $('.js-delivery-cards').removeClass('active')
      $('.js-delivery-cards-' + id).addClass('active')
    })

    $(document).on('click', '.js-toggle-input-group', function() {
      const $groups = $('.js-input-groups').find('.form__group')
      const $btnText = $(this).find('.js-toggle-input-group-text')

      if ($(this).hasClass('is--show')) {
        $groups.not(':nth-child(-n+6)').slideUp()
        $($btnText).html('Показать все')
      } else {
        $groups.slideDown()
        $($btnText).html('Свернуть')
      }
      $(this).toggleClass('is--show')
    })

    $(document).on('click', '.js-password-eye', function() {
      const $inputGroup = $(this).closest('.js-password-group')
      const $input = $inputGroup.find('.js-password-input')
      const inputType = $input.attr('type')
      if (inputType === 'password') $input.attr('type', 'text')
      else $input.attr('type', 'password')
      $(this).toggleClass('is--open')
    })

    $(document).on('click', function(e) {
      const arrElements = [
        { el: $('.js-window-location'), cls: 'window-location--active' },
        { el: $('.js-window-catalog'), cls: 'window-catalog--active' },
      ]

      arrElements.forEach(item => {
        if (
          !item.el.is(e.target) &&
          item.el.has(e.target).length === 0 &&
          item.el.hasClass(item.cls)
        )
          item.el.removeClass(item.cls)
      })
    })

    $(document).on('click', '.js-open-custom-window, .js-close-custom-window', function() {
      const win = $(this).data('win')
      $('.js-window-' + win).toggleClass('window-' + win + '--active')
      return false
    })
  },
}

export default common
