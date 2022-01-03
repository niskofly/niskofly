const alphabet = {
  init() {
    this.elementInputCategory = $(".js-filter-inputs-group")
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on("click", ".js-filter-btn-switch", function () {
      self.switchLangString($(this))
    })

    $(document).on("click", ".js-filter-letter", function () {
      self.clickLetterFilter($(this))
      return false
    })
  },

  switchLangString($button) {
    const $lang = $button.val()

    switch ($lang) {
      case 'ru':
        this.toggleLetterString(true)
        break
      case 'en':
        this.toggleLetterString(false)
        break
    }
  },

  toggleLetterString($element) {
    if ($element) {
      $(".js-filter-letter-container-en").hide()
      $(".js-filter-letter-container-ru").show()
    } else {
      $(".js-filter-letter-container-ru").hide()
      $(".js-filter-letter-container-en").show()
    }
  },

  clickLetterFilter($button) {
    this.elementInputCategory
      .find('[data-label="' + $button.data("filter-letter") + '"]')
      .trigger('click')

    $button.toggleClass('letters-list__item--active')
  },

}
export default alphabet
