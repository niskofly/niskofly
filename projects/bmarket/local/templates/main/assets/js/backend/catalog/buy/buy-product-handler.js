/* eslint-disable no-undef */
const buyProductHandler = {
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
      .post($form.attr('action'), new FormData($form[0]))
      .then(response => {
        stopWindowPreloader()
        $.magnificPopup.close()

        if (response.data.error)
          return messageError({ title: response.data.message })

        const goal = $form.data('goal')
        if (goal) metrics.reachGoal(goal)

        if (window.__BASKET_CART_PAGE__)
          window.reloadBasketCartItems()
        else
          this.renderModalSuccess(response.data.product)

        if (typeof response.data.countBasketItems !== 'undefined')
          smallBasketHandler.updateCount(response.data.countBasketItems)

        if (
          typeof response.data.eCommerceProduct !== 'undefined' &&
          response.data.eCommerceProduct
        ) {
          const eCommerceProduct = response.data.eCommerceProduct
          window.dataLayer.push({ ecommerce: { add: { products: [eCommerceProduct] } } })
          window.gtag('event', 'add_to_cart', { items: [eCommerceProduct] })

          VkSendProductEvent(window.vkPriceId, 'add_to_cart', {
            currency_code: 'RUB',
            business_value: eCommerceProduct.price,
            products: [{ id: eCommerceProduct.id, price: eCommerceProduct.price }]
          })

          VkAddRetargeting(40149899)

          fbq('track', 'AddToCart', {
            value: eCommerceProduct.price,
            currency: 'RUB',
            contents: [
              {
                id: eCommerceProduct.id,
                quantity: eCommerceProduct.quantity,
              }],
            content_type: 'product',
            content_name: eCommerceProduct.name
          })

          _tmr.push({
            type: 'itemView',
            productid: eCommerceProduct.id,
            pagetype: 'cart',
            list: window.listTmrId,
            totalvalue: eCommerceProduct.price
          })

          window.metrics.reachGoal('dobavitKorzina')
        }
      })
  },

  renderModalSuccess(data) {
    $('.js-product-buy-image').attr('src', data.image)
    $('.js-product-buy-name').html(data.name)
    $('.js-product-buy-price').html(`${data.quantity} х ${data.price} <span class="rubl">i</span>`)

    $('.js-product-buy-basket-price').html(data.basketPrice)
    const renderCountBasket = `${data.countBasketItems} товар` + getEncoding(data.countBasketItems)
    $('.js-product-buy-count-basket-items').html(renderCountBasket)

    $('.js-product-buy-favorite-input').val(data.id)

    data.isFavorite
      ? $('.js-product-buy-favorite-btn').addClass('product-in-favorite')
      : $('.js-product-buy-favorite-btn').removeClass('product-in-favorite')

    openModal('#product-added')
  }
}

export default buyProductHandler
