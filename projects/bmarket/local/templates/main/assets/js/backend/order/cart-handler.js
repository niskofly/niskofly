/* eslint-disable no-undef */
/* eslint-disable no-new */
import CounterProductBtn from '../catalog/buy/counter-product-btn'

const cartHandler = {
  init() {
    this.$total = $('.js-cart-total-block')
    this.$products = $('.js-products-in-card')

    this.initCounterProduct()
    this.eventHandler()

    launchWindowPreloader()
    this.updateGiftInfo()

    window.reloadBasketCartItems = () => {
      this.reloadCartItems()
    }
  },

  eventHandler() {
    const self = this

    $(document).on('submit', '.js-update-in-card-form', function () {
      self.updateCountInCart($(this))
      return false
    })

    $(document).on('submit', '.js-remove-product-in-card-form', function () {
      self.removeProductInCart($(this))
      return false
    })

    $(document).on('submit', '.js-recovery-product-in-card-form', function () {
      self.recoveryProductInCart($(this))
      return false
    })
  },

  initCounterProduct() {
    $('.js-product-in-card-counter:not(.--init--)').each(function () {
      new CounterProductBtn($(this), true)
    })
  },

  updateGiftInfo() {
    const formData = new FormData()
    for (var key in window._GIFT_REQUEST_PARAMS)
      formData.append(key, window._GIFT_REQUEST_PARAMS[key])

    axios
      .post('/bitrix/components/bitrix/sale.products.gift.basket/ajax.php?clear_cache=Y', formData)
      .then(response => {

        if (response.data.items) {
          $('.js-basket-gift-container').html(response.data.items)
          window.initSliders()
        } else
          $('.js-basket-gift-container').html('')

        stopWindowPreloader()
      })
      .catch(() => {
        stopWindowPreloader()
      })
  },

  updateCountInCart($form) {
    launchWindowPreloader()

    axios
      .post($form.attr('action'), new FormData($form[0]))
      .then(response => {
        if (response.data.error)
          return messageError({ title: response.data.message })

        this.updateCartContent(response.data)
      })
      .catch(() => {
        messageError({ title: 'Ошибка при обработке запроса.' })
        stopWindowPreloader()
      })
  },

  removeProductInCart($form) {
    launchWindowPreloader()

    axios
      .post($form.attr('action'), new FormData($form[0]))
      .then(response => {
        if (response.data.error)
          return messageError({ title: response.data.message })

        this.renderDeleteItem($form.closest('.js-product-in-card'))
        this.updateCartContent(response.data)
      })
      .catch(() => {
        messageError({ title: 'Ошибка при обработке запроса.' })
        stopWindowPreloader()
      })
  },

  recoveryProductInCart($form) {
    launchWindowPreloader()

    axios
      .post($form.attr('action'), new FormData($form[0]))
      .then(response => {
        if (response.data.error)
          return messageError({ title: response.data.message })

        this.renderOnRecoveryItem($form.closest('.js-product-in-card'))
        this.updateCartContent(response.data)
      })
      .catch(() => {
        messageError({ title: 'Ошибка при обработке запроса.' })
        stopWindowPreloader()
      })
  },

  renderDeleteItem($item) {
    $item.clone()
      .addClass('order-table__tr-removed order-table__tr--recovery')
      .appendTo('.js-products-in-card')

    $item.remove()
  },

  renderOnRecoveryItem($item) {
    $item.clone()
      .removeClass('order-table__tr-removed order-table__tr--recovery')
      .appendTo('.js-products-in-card')
    $item.remove()
  },

  updateCartContent(data) {
    this.updateGiftInfo()

    if (typeof data.total !== 'undefined')
      this.$total.html(data.total)

    if (typeof data.products !== 'undefined') {
      $('.js-product-in-card:not(.order-table__tr--recovery)').remove()
      this.$products.prepend(data.products)
    }

    if (typeof data.countBasketItems !== 'undefined') {
      smallBasketHandler.updateCount(data.countBasketItems)

      if (data.countBasketItems === 0) {
        launchWindowPreloader()
        location.reload()
      }
    }

    this.initCounterProduct()
  },

  reloadCartItems() {
    launchWindowPreloader()
    const formData = new FormData()
    formData.append('IS_AJAX_RELOAD', 'Y')

    axios
      .post('/personal/cart/', formData)
      .then(response => {
        this.updateCartContent(response.data)
        stopWindowPreloader()
      })
      .catch(() => {
        messageError({ title: 'Ошибка при обработке запроса.' })
        stopWindowPreloader()
      })
  }
}

export default cartHandler
