const filter = {
  init() {
    this.eventHandlers()
  },

  eventHandlers() {
    $(document).on('click', '.js-toggle-filter', function() {
      $('.js-filter-close').toggleClass('active')
      $('.js-filter').toggleClass('active')
      $('.js-body').toggleClass('body--fix')
    })

    $(document).on('click', '.js-filter-close', function() {
      $('.js-filter-close').toggleClass('active')
      $('.js-filter').toggleClass('active')
      $('.js-body').toggleClass('body--fix')
    })
  },
}

export default filter
