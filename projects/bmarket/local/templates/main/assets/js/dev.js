function pageWidget(pages) {
  const widgetWrap = $('<div class="widget_wrap"><ul class="widget_list"></ul></div>')

  widgetWrap.prependTo('body')

  for (var i = 0; i < pages.length; i++) {
    $(`<li class="widget_item"><a class="widget_link" href="/${pages[i]}.html">${pages[i]}</a></li>`)
      .appendTo('.widget_list')
  }
}

pageWidget(['ui', 'index', 'catalog-products', 'product-detail', 'basket', 'order', 'no-product', 'basket-empty', 'order-success', 'lk-personal', 'lk-favorites', 'lk-orders', 'lk-orders-detail', 'contacts', '404', 'stocks', 'standart-page', 'auth'])
