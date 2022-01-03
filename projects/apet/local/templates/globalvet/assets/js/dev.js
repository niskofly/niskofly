function pageWidget(pages) {
  const widgetWrap = $('<div class="widget_wrap"><ul class="widget_list"></ul></div>')

  widgetWrap.prependTo('body')

  for (var i = 0; i < pages.length; i++) {
    $(`<li class="widget_item"><a class="widget_link" href="/${pages[i]}.html">${pages[i]}</a></li>`)
      .appendTo('.widget_list')
  }
}

pageWidget(['ui', 'index', 'catalog-home', 'catalog-products', 'catalog-section', 'product-detail', 'order', 'order-detail', 'wishlist', 'info-privacy', 'info-how-order', 'info-delivery', 'info-client', 'info-work', 'info-collab', 'info-help', 'pickup-points', 'company', 'news', 'news-detail', 'blog', 'blog-detail', 'conference', 'conference-detail', 'materials', 'materials-detail', 'stocks', 'stocks-detail', 'instructions', 'brands', 'compare', 'lk-orders', 'lk-orders-list', 'lk-order-detail', 'lk-order-cancel', 'lk-favourites', 'lk-personal', 'lk-profiles', 'lk-subscribe', 'auth-enter', 'auth-reg', 'auth-reg-code', 'auth-reg-restore', 'auth-restore-enter', '404', 'search-result', 'choice-result'])
