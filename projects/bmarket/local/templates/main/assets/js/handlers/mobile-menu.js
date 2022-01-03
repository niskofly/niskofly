const mobileMenu = {
  init() {
    this.eventHandlers()
  },

  eventHandlers() {
    let id = null

    $(document).on('click', '.js-toggle-burger-menu', function() {
      $(this).toggleClass('active')
      $('.js-header').toggleClass('active')
      $('.js-header-menu').toggleClass('active')
      $('.js-body').toggleClass('body--fix')

      if ($('.js-header-collections').hasClass('active')) {
        $('.js-header-collections').removeClass('active')
        $('.js-header-menu').removeClass('active')
      }
    })

    // ПОДКАТЕГОРИИ:

    $(document).on('click', '.js-header-catalog-link-mobile', function() {
      id = $(this).data('id')
      $('.js-header-menu-subcatalog').toggleClass('active')
      $('.js-header-subcatalog-mobile-' + id).addClass('active')
    })

    $(document).on('click', '.js-subcatalog-back', function() {
      $('.js-header-menu-subcatalog').toggleClass('active')
      $('.js-header-subcatalog-mobile').removeClass('active')
    })
  },
}

export default mobileMenu
