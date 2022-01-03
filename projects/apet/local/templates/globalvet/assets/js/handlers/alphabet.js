const alphabet = {
  init() {
    this.lang = "ru"
    this.arLetters = {
      ru: [],
      en: [],
    }
    this.eventHandlers()
  },

  eventHandlers() {
    const self = this

    $(document).on("click", ".js-alphabet-btn", function () {
      self.lang = $(this).data("lang")

      $(".js-alphabet-btn").removeClass("active")
      $(this).addClass("active")

      $(".js-alphabet-list").addClass("hide")
      $(".js-alphabet-list[data-lang=" + self.lang + "]").removeClass("hide")
    })

    $(document).on("change", ".js-alphabet-letter", function () {
      if ($(this).prop("checked"))
        self.arLetters[self.lang].push($(this).val())
      else
        self.arLetters[self.lang].splice(
          self.arLetters[self.lang].indexOf($(this).val()),
          1
        )

      self.cardHandler()
    })
  },

  cardHandler() {
    this.arLetters[this.lang].length
      ? $(".js-alphabet-card[data-lang=" + this.lang + "]").addClass("hide")
      : $(".js-alphabet-card[data-lang=" + this.lang + "]").removeClass("hide")

    this.arLetters[this.lang].forEach(letter => $(".js-alphabet-card[data-lang=" + this.lang + "][data-letter=" + letter + "]" ).removeClass("hide"))
  },
}

export default alphabet
