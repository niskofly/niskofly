class Tabs {
  constructor($wrapper) {
    this.$wrapper = $wrapper
    this.$buttons = this.$wrapper.find('.js-tab-action')
    this.$tabs = this.$wrapper.find('.js-tab')
    this.isHashNavigation = false

    this.showTabByLocationHash()
    this.eventHandler()
  }

  showTabByLocationHash() {
    const tabHash = location.hash.replace('#', '')

    if (tabHash && this.isHashNavigation) {
      this.activateTab($("[data-tab='" + tabHash + "']"))
      return
    }

    this.activateTab()
  }

  eventHandler() {
    const self = this

    this.$buttons
      .click(function () {
        self.activateTab($(this))
      })
  }

  activateTab($btn = null) {
    $btn = $btn || this.$wrapper.find('.js-tab-action.active')
    const tabKey = $btn.data('tab')

    if (this.isHashNavigation)
      window.location.hash = tabKey

    this.$buttons.removeClass('active')
    $btn.addClass('active')

    this.$tabs.each(function () {
      const $tab = $(this)
      $tab.removeClass('tab--show')

      if (tabKey === $tab.data('tab-content'))
        $tab.addClass('tab--show')
    })
  }
}

export default Tabs
