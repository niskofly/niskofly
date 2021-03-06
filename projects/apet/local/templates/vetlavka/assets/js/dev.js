function pageWidget(pages) {
  const widgetWrap = $('<div class="widget_wrap"><ul class="widget_list"></ul></div>')

  widgetWrap.prependTo('body')

  for (var i = 0; i < pages.length; i++) {
    $(`<li class="widget_item"><a class="widget_link" href="/${pages[i]}.html">${pages[i]}</a></li>`)
      .appendTo('.widget_list')
  }
  const widgetStyle = $(
    '<style>body {position:relative} .widget_wrap{overflow-y:auto;overflow-x:hidden;max-height:100%;position:fixed;top:0;left:0;z-index:9999;padding:10px 20px;background:#222;border-bottom-right-radius:10px;-webkit-transition:all .3s ease;transition:all .3s ease;-webkit-transform:translate(-100%,0);-ms-transform:translate(-100%,0);transform:translate(-100%,0)}.widget_wrap:after{content:" ";position:absolute;top:0;left:100%;width:24px;height:24px;background:#222 url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAgMAAABinRfyAAAABGdBTUEAALGPC/xhBQAAAAxQTFRF////////AAAA////BQBkwgAAAAN0Uk5TxMMAjAd+zwAAACNJREFUCNdjqP///y/DfyBg+LVq1Xoo8W8/CkFYAmwA0Kg/AFcANT5fe7l4AAAAAElFTkSuQmCC) no-repeat 50% 50%;cursor:pointer}.widget_wrap:hover{-webkit-transform:translate(0,0);-ms-transform:translate(0,0);transform:translate(0,0)}.widget_item{padding:0 0 10px}.widget_link{color:#fff;text-decoration:none;font-size:15px;}.widget_link:hover{text-decoration:underline} </style>'
  )
  widgetStyle.prependTo('.widget_wrap')
}

pageWidget(['index', 'catalog', 'catalog-list', 'catalog-animal', 'product-card', 'cart', 'wishlist', 'lk-orders', 'lk-order', 'lk-order-decline', 'lk-personal', 'lk-wishlist', 'lk-profile', 'lk-profile-ur', 'lk-subscription', 'stocks', 'stock', 'instructions', 'popular-brands', 'text-page', 'help', 'about', 'news-list', 'news', 'blog-list', 'blog', 'login', 'password-recovery', '404', 'search-results', 'selection-results', 'checkout', 'maps', 'ui'])
