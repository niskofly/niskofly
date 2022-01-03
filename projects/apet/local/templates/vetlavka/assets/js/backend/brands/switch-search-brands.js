const switchSearchBrands = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on("click", ".js-switch-btn-lang", function () {
      self.switchLang($(this))
      return false
    })

    $(document).on("click", ".js-switch-letter", function () {
      self.clickLetter($(this))
      return false
    })
  },

  switchLang($button) {
    const lang = $button.data('switch-btn-lang')
    const $langItemsContainer = $('[data-lang-container="' + lang + '"]')

    $button.toggleClass("letters-switch__btn--active")
    $langItemsContainer.toggle()
  },

  clickLetter($button) {
    const anchor = $button.data("letter-line")
    const $scrollElement = $('[data-letter="' + anchor + '"]')

    if ($scrollElement.length && $scrollElement.offset().top)
      window.scrollToElement('[data-letter="' + anchor + '"]')
  }

}
export default switchSearchBrands
