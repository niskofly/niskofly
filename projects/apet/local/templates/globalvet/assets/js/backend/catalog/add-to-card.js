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
  },

  request($form) {
    launchWindowPreloader()

    axios
      .post($form.attr("action"), new FormData($form[0]))
      .then(response => {
        $.magnificPopup.close()

        if (response.data.error)
          console.info(response.data)

        this.renderModalWindow(response.data.product)
        stopWindowPreloader()
      })
  },

  renderModalWindow($data) {
    $(".js-product-buy-name").html($data.name)
    $(".js-product-buy-brand").html($data.brand)
    $(".js-product-buy-img").attr("src", $data.img)
    openModal('#in-cart-modal')
  }

}
export default addToCard
