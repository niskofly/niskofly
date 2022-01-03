/* eslint-disable no-new */
import catalogHandler from './catalog/index'
import favoriteHandler from './personal/favorites'
import cartHandler from './order/cart-handler'
import initMapHandlers from './map-handler'
import LazyLoadHandler from './lazy-load-handler'
import authHandler from './personal/auth'

const initBackend = () => {
  catalogHandler.init()

  favoriteHandler.init()

  cartHandler.init()

  initMapHandlers()

  $('.js-simple-pagination-wrapper').each(function () {
    new LazyLoadHandler($(this))
  })

  authHandler.init()

  $(document).on('click', '.js-catalog-links-toggle', function () {
    const $links = $(this).siblings('.js-catalog-links')
    const isOpen = $links.hasClass('visible')

    isOpen
      ? $links
        .children()
        .slice(3)
        .hide(300)
      : $links.children().show(300)

    $(this).text(isOpen ? 'Показать все категории' : 'Скрыть')
    $links.toggleClass('visible')
  })
}

export default initBackend
