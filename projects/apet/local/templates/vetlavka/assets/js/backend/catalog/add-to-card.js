const addToCard = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on('submit', '.js-add-to-card', function () {
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
    formData.append("ACTION", "GET_COUNT")

    axios
      .post('/api/catalog/controller-addToCart.php', formData)
      .then(response => {
        if (!response.data.error)
          this.updateCount(response.data.count)
      })
  },

  request($form) {
    launchWindowPreloader()

    axios
      .post($form.attr("action"), new FormData($form[0]))
      .then(response => {
        $.magnificPopup.close()

        if (!response.data.error) {
          $form.find('.btn').html("В корзине")
          this.renderModalWindow(response.data.product)
          this.updateCount(response.data.countBasketItems)
        }

        stopWindowPreloader()
      })
  },

  renderModalWindow($data) {
    $(".js-product-buy-name").html($data.name)
    $(".js-product-buy-brand").html($data.brand)
    $(".js-product-buy-img").attr("src", $data.img)
    openModal('#in-cart-modal')
  },

  updateCount(count) {
    const $comparisonCounter = $(".js-basket-count")
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

export default addToCard
