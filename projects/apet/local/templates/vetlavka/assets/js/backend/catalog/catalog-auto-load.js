const catalogAutoLoad = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    if (window.__IS_PAGE_CATALOG__) {
      $(window).scroll(function () {
        self.checkScrollPosition($(this))
      })
    }
  },

  checkScrollPosition($data) {
    const linkLoad = $('.js-lazy-load-more-link')

    const status = Boolean(linkLoad.attr('data-status-load'))
    const triggerElement = $('.js-trigger-load')
    const scrollPagePosition = $data.scrollTop()
    const scrollTriggerElement = triggerElement.offset().top - 900

    if (scrollPagePosition > scrollTriggerElement)
      if (!status)
        linkLoad
          .trigger('click')
          .attr('data-status-load', 'true')
  }
}

export default catalogAutoLoad
