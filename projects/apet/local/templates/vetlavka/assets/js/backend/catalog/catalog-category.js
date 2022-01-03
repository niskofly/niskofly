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

  /**
   * Осуществление клика
   * на категорию в меню,
   * установка класса на
   * кнопку категории.
   * @param $category
   */
  clickElementCategory($category) {
    this.elementInputCategory
      .find('[data-label="' + $category.data('category') + '"]')
      .trigger('click')

    $category.toggleClass('catalog-tabs__item--active')
  }

}
export default catalogCategory
