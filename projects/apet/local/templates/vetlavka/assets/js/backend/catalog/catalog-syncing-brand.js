const catalogSyncingBrand = {
  init() {
    this.elementInputCategory = $(".js-filter-inputs-group")
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on('click', '.js-syncing-brand', function () {
      self.clickBrandFilter($(this))
    })
  },

  clickBrandFilter($button) {
    this.elementInputCategory
      .find('[data-label="' + $button.attr('data-brand-name') + '"]')
      .trigger('click')
  },
}

export default catalogSyncingBrand
