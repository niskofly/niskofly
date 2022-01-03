const filter = {
  init() {
    this.eventHandlers()
  },

  eventHandlers() {
    $(document).on('click', '.js-toggle-catalog-filter', function() {
      $('.js-catalog-filter').toggleClass('active')
    })

    $(document).on('click', '.js-catalog-filter-close', function() {
      $('.js-catalog-filter').removeClass('active')
    })
  },
}

export default filter
