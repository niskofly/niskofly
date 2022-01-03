const common = {
  init() {
    this.eventHandlers()
  },

  eventHandlers() {
    $(document).on('click', '.js-anchor', function(e) {
      e.preventDefault()
      scrollToElement($($(this).attr('href')))
    })

    /* Мобильное меню */
    $(document).on('change', '.js-toggle-menu', function() {
      $('.js-header-mobile').toggleClass('active')
      $('.js-body').toggleClass('body--fix')
    })

    $(document).on('click', '.js-header-catalog-link-mobile', function() {
      $(this)
        .siblings('.js-header-menu-subcatalog')
        .addClass('active')
      $('.js-header-mobile').addClass('active-subcatalog')
    })

    $(document).on('click', '.js-subcatalog-back', function() {
      $(this)
        .parent()
        .parent('.js-header-menu-subcatalog')
        .removeClass('active')
      $('.js-header-mobile').removeClass('active-subcatalog')
    })
  },
}

export default common
