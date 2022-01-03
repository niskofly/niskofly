const favorites = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on('click', '.js-product-favourite', function () {
      self.favoritesHandler($(this))
    })
  },

  favoritesHandler($form) {
    launchWindowPreloader()

    const $productId = $form.find('[name="product_id"]').val()

    const $btn = $form.find('.user-menu__button')
    const $productCard = $form.closest('.card-product')

    const formData = new FormData()
    formData.append("product_id", $productId)

    axios
      .post("/api/catalog/favorites.php", formData)
      .then(response => {
        if (response.statusText === "OK") {
          response.data.message.action === "remove"
            ? $btn.removeClass('user-menu__button--active')
            : $btn.addClass('user-menu__button--active')

          if (window.__IS_PAGE_FAVORITE__ && response.data.message.action === "remove")
            $productCard.remove()

          if (response.data.message.count === 0)
            $('.js-favourite-container').append('<p>Избранные товары отсутствуют</p>');

          $(".js-favorites-counter").html(response.data.message.count ? response.data.message.count : '')
        }
        stopWindowPreloader()
      })
  }
}

export default favorites
