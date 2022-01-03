const catalogCategory = {
  init() {
    this.elementInputCategory = $(".js-filter-inputs-group")
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on("click", ".js-category-tab", function () {
      self.clickElementCategory($(this))
      return false
    })
  },

  clickElementCategory($category) {
    this.elementInputCategory
      .find('[data-label="' + $category.data('category') + '"]')
      .trigger('click')

    $category.toggleClass('is--active')
  }
}

export default catalogCategory
