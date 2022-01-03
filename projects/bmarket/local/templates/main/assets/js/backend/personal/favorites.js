/* eslint-disable no-undef */
const favoriteHandler = {
  favoriteCssClass: 'product-in-favorite',
  emptyClass: 'nav__link--favorite-empty',
  count: 0,

  init() {
    this.$counter = $('.js-favorites-counter')
    this.$counterPage = $('.js-favorites-counter-page')
    this.$link = $('.js-favorites-link')

    this.isPageFavorite = !!window.__IS_PAGE_FAVORITE__
    if (this.isPageFavorite) {
      const self = this
      $('.js-product-card').each(function () {
        self.renderRemoveBtn($(this))
      })
    }
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on('submit', '.js-favorites-form', function () {
      self.request($(this))
      return false
    })

    $(document).on('click', '.js-remove-favorite', function () {
      const $form = $(this).closest('.js-product-card').find('.js-favorites-form')
      $form.trigger('submit')
    })
  },

  request($form) {
    launchWindowPreloader()
    const $btn = $form.find('[type="submit"]')

    axios
      .post($form.attr('action'), new FormData($form[0]))
      .then(response => {
        stopWindowPreloader()

        if (response.data.error)
          return messageError({ title: response.data.title, description: response.data.message })

        this.updateCounter(response.data.count)

        switch (response.data.action) {
          case 'add':
            $btn.addClass(this.favoriteCssClass)
            // eslint-disable-next-line no-case-declarations
            const eCommerceProduct = response.data.eCommerceProduct

            VkSendProductEvent(window.vkPriceId, 'add_to_wishlist', {
              currency_code: 'RUB',
              business_value: eCommerceProduct.price,
              products: [{ id: eCommerceProduct.id, price: eCommerceProduct.price }]
            })

            fbq('track', 'AddToWishlist', {
              value: eCommerceProduct.price,
              currency: 'RUB',
              content_ids: eCommerceProduct.id,
              content_type: 'product',
              content_name: eCommerceProduct.name
            })

            window.metrics.reachGoal('clickFavorit')

            break
          case 'remove':
            $btn.removeClass(this.favoriteCssClass)

            if (this.isPageFavorite)
              $btn.closest('.js-product-card').remove()
            break
        }
      })
  },

  updateCounter(count) {
    count = count || null
    const isEmpty = !count

    if (isEmpty) {
      this.$link.addClass(this.emptyClass)
      this.$counter.text('')

      if (this.$counterPage) {
        this.$counterPage.text('')
        $('.js-favorite-products-empty').show()
        $('.js-favorite-products').hide()
      }

      return
    }

    this.$link.removeClass(this.emptyClass)
    this.$counter.text(count)

    if (this.$counterPage) {
      this.$counterPage.text(`(${count})`)
      $('.js-favorite-products-empty').hide()
      $('.js-favorite-products').show()
    }
  },

  renderRemoveBtn($card) {
    const template = `<button type="button" class="product-card__remove-favorite js-remove-favorite"">
              <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
              </svg>
            </button>`
    $card.append(template)
  }
}

export default favoriteHandler
