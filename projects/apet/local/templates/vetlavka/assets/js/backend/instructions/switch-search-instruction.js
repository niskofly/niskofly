const switchSearchInstruct = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on("click", ".js-instruction-switch-btn-lang", function () {
      self.switchLangString($(this))
    })

    $(document).on("click", ".js-instruction-letter", function () {
      self.clickLetterSearch($(this))
      return false
    })
  },

  switchLangString($button) {
    const $lang = $button.val()

    switch ($lang) {
      case 'ru':
        this.toggleLang(true)
        break
      case 'en':
        this.toggleLang(false)
        break
    }
  },

  toggleLang($element) {
    if ($element) {
      $(".js-switch-letter-container-en").hide()
      $(".js-switch-letter-container-ru").show()
      $(".js-switch-product-container-ru").show()
      $(".js-switch-product-container-en").hide()
    } else {
      $(".js-switch-letter-container-ru").hide()
      $(".js-switch-letter-container-en").show()
      $(".js-switch-product-container-eu").show()
      $(".js-switch-product-container-ru").hide()
    }
  },

  clickLetterSearch($button) {
    const $clickLetter = $button.data("letter-line")
    const $productsCart = $(".js-instruction-card")

    if (!$button.hasClass("letters-list__item--active")) {
      $.each($productsCart, function () {
        if ($(this).data("instruction-letter") === $clickLetter) {
          $(this).show()
        } else {
          $(this).hide()
        }
      })
    } else {
      $.each($productsCart, function () {
        $(this).show()
        $button.remove('letters-list__item--active')
      })
    }
    $button.toggleClass('letters-list__item--active')
  }

}
export default switchSearchInstruct
