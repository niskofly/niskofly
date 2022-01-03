const favorites = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on("submit", ".js-favorites-form", function () {
      self.request($(this))
      return false
    })

    $(document).ready(function () {
      self.setCountInLoading()
      return false
    })
  },

  setCountInLoading() {
    const formData = new FormData();
    formData.append("action", "get_count")

    axios
      .post('/api/user/controller-favorites.php', formData)
      .then(response => {
        this.updateCount(response.data.count)
      })
  },

  request($form) {
    launchWindowPreloader()

    const $btn = $form.find('[type="submit"]')
    const $productCard = $form.closest('.js-product-card')

    const $formData = new FormData($form[0])
    $formData.append("action", "favorite")

    axios
      .post($form.attr("action"), $formData)
      .then(response => {
        if (response.status === 200) {
          response.data.message.action === "remove"
            ? $btn.removeClass('product-links__group-icon--active')
            : $btn.addClass('product-links__group-icon--active')

          if (window.__IS_PAGE_FAVORITE__ && response.data.message.action === "remove")
            $productCard.remove()

          if (response.data.message.count === 0)
            $('.js-favourite-container').append('<p>Избранные товары отсутствуют</p>')

          this.updateCount(response.data.message.count)
        }
        stopWindowPreloader()
      })
  },

  updateCount(count) {
    const $comparisonCounter = $(".js-favorites-count")
    $comparisonCounter.empty()

    if (count >= 1)
      $comparisonCounter
        .html(count)
        .addClass("header-actions__controls-count--active")
    else
      $comparisonCounter
        .empty()
        .removeClass("header-actions__controls-count--active")
  }
}

export default favorites
