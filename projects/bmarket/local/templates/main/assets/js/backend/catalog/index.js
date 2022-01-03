/* eslint-disable no-new */
import LazyLoadHandler from '../lazy-load-handler'
import filter from './filter'
import buyProductHandler from './buy/buy-product-handler'
import CounterProductBtn from './buy/counter-product-btn'
import smallBasketHandler from './small-basket-handler'
import productNotifyHandler from './product-notify-handler'

const catalogHandler = {
  init() {
    this.eventHandler()
    this.initBuyProductHandlers()

    productNotifyHandler.init()
    window.smallBasketHandler = smallBasketHandler.init()
    window.globalCatalogHandler = this
  },

  eventHandler() {
    let LazyLoad = null

    if ($('.js-lazy-load-catalog').length)
      LazyLoad = new LazyLoadHandler($('.js-lazy-load-catalog'))

    if ($('.js-catalog-filter').length)
      filter.init($('.js-catalog-filter'), LazyLoad)

    $(document).on('change', '.js-catalog-sorting', function () {
      window.setCookie('CATALOG_SORTING', $(this).val())
      LazyLoad.ajaxReloadPage()
    })

    $(document).on('SuccessLazyLoadRequest', () => {
      $('.js-product-buy-btn:not(.--init--)').each(function () {
        new CounterProductBtn($(this))
      })
    })

    $(document).on('reInitProductCounters', () => {
      $('.js-product-buy-btn:not(.--init--)').each(function () {
        new CounterProductBtn($(this))
      })
    })
  },

  initBuyProductHandlers() {
    $('.js-product-buy-btn:not(.--init--)').each(function () {
      new CounterProductBtn($(this))
    })

    buyProductHandler.init()
  }
}

export default catalogHandler
