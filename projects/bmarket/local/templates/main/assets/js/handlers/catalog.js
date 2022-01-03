const catalog = {
  init() {
    this.eventHandlers()
  },

  eventHandlers() {
    const links = $('.js-header-catalog-link')
    let id = null
    if (links.length) firstCatalogItem()

    $(document).on('click', '.js-toggle-header-catalog', function() {
      // если открыты подборки, то каталог закрыть:
      if ($('.js-header-collections').hasClass('active')) {
        $('.js-header-collections').removeClass('active')
        $('.js-toggle-header-collections').removeClass('active')
      }

      $(this).toggleClass('active')
      $('.js-header-catalog').toggleClass('active')
      firstCatalogItem()
    })

    $(document).on('click', '.js-header-catalog-link', function() {
      id = $(this).data('id')
      $('.js-header-subcatalog, .js-header-catalog-link').removeClass('active')
      $(this).addClass('active')
      $('.js-header-subcatalog-' + id).addClass('active')
    })

    /*ПОДБОРКИ*/

    $(document).on('click', '.js-toggle-header-collections', function() {
      // если открыт каталог, то подборки закрыть:
      if ($('.js-header-catalog').hasClass('active')) {
        $('.js-header-catalog').removeClass('active')
        $('.js-toggle-header-catalog').removeClass('active')
      }

      $(this).toggleClass('active')
      $('.js-header-menu').toggleClass('active')
      $('.js-header-collections').toggleClass('active')
    })

    function firstCatalogItem() {
      $(links[0]).addClass('active')
      id = $(links[0]).data('id')
      $('.js-header-subcatalog-' + id).addClass('active')
    }
  },
}

export default catalog
