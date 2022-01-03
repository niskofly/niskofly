/* eslint-disable no-undef */
class LazyLoadHandler {
  constructor($wrapper) {
    this.$wrapper = $wrapper
    this.$contentWrapper = $wrapper.find('.js-lazy-load-content')
    this.$paginationWrapper = $wrapper.find('.js-lazy-load-more-pagination')

    this.eventHandler()

    this.loadContentFromFilter = href => {
      this.request(href, this.filterRender)
    }

    this.ajaxReloadPage = () => {
      window.launchWindowPreloader()
      this.request(location.protocol + '//' + location.host + location.pathname, this.paginateRender)
    }

    return this
  }

  eventHandler() {
    const self = this

    this.$wrapper.find('.js-lazy-load-more-link').on('click', function () {
      window.launchWindowPreloader()
      self.request($(this).attr('href'), self.lazyRender)
      return false
    })

    this.$wrapper.find('.js-lazy-load-paginate').on('click', function () {
      window.launchWindowPreloader()
      self.request($(this).attr('href'), self.paginateRender)
      return false
    })
  }

  request(href, render) {
    const resultUrl =
      href.indexOf('?') !== -1
        ? href + '&ACTION=AJAX_LAZY'
        : href + '?ACTION=AJAX_LAZY'

    axios
      .get(resultUrl)
      .then(response => {
        render.call(this, response.data)

        this.eventHandler()

        history.pushState(null, null, href)
        $(document).trigger('SuccessLazyLoadRequest')

        stopWindowPreloader()
      })
      .catch(() => {
        messageError({ title: 'Ошибка при загрузке данных' })
        stopWindowPreloader()
      })
  }

  lazyRender(data) {
    if (typeof data.content !== 'undefined')
      this.$contentWrapper.append(data.content)

    if (typeof data.more !== 'undefined')
      this.$moreWrapper.html(data.more)

    if (typeof data.pagination !== 'undefined')
      this.$paginationWrapper.html(data.pagination)
  }

  paginateRender(data) {
    if (typeof data.content !== 'undefined')
      this.$contentWrapper.html(data.content)

    if (typeof data.more !== 'undefined')
      this.$moreWrapper.html(data.more)

    if (typeof data.pagination !== 'undefined')
      this.$paginationWrapper.html(data.pagination)

    $('html, body').animate(
      { scrollTop: this.$contentWrapper.offset().top - 20 },
      500
    )
  }

  filterRender(data) {
    if (typeof data.content !== 'undefined')
      this.$contentWrapper.html(data.content)

    if (typeof data.more !== 'undefined')
      this.$moreWrapper.html(data.more)

    if (typeof data.pagination !== 'undefined')
      this.$paginationWrapper.html(data.pagination)
  }
}

export default LazyLoadHandler
