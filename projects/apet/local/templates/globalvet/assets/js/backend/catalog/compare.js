const compare = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on("click", ".js-product-compare", function () {
      self.toggleCompareElement($(this))
    })

    $(document).on("click", ".js-clear-comparison-list", function () {
      self.clearComparisonList()
    })
  },

  toggleCompareElement($form) {
    launchWindowPreloader()

    const $method = $form.find('[name="method"]').val()
    const $productId = $form.find('[name="product_id"]').val()

    const formData = new FormData()
    formData.append("method", $method)
    formData.append("product_id", $productId)

    axios
      .post('/api/catalog/compare.php', formData)
      .then(response => {
        if (response.data.STATUS === 'OK') {

          switch ($method) {
            case 'ADD_TO_COMPARE_LIST':
              $form.find('.user-menu__button').addClass('user-menu__button--active')
              $form.find('[name="method"]').val('DELETE_FROM_COMPARE_LIST')
              break
            case 'DELETE_FROM_COMPARE_LIST':
              $form.find('.user-menu__button').removeClass('user-menu__button--active')
              $form.find('[name="method"]').val('ADD_TO_COMPARE_LIST')
              break
          }

          $(".js-compare-counter").html(response.data.COUNT ? response.data.COUNT : '')
        }
        stopWindowPreloader()
      })
  },


  clearComparisonList() {
    launchWindowPreloader()

    const formData = new FormData()
    formData.append("method", "CREAR_LIST")

    axios
      .post('/api/catalog/compare.php', formData)
      .then(response => {
        stopWindowPreloader()
      })
  },
}

export default compare
