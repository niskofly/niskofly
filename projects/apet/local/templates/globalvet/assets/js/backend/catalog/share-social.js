const shareSocial = {
  init() {
    this.sharesContainer = $('.modal__main')
    this.shareInputHref = this.sharesContainer.find("[name='share-link']")
    this.pageUrl = window.__CURRENT_PAGE_URL__
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on('click', '.js-social', function () {
      self.shareSocial($(this))
    })

    $(document).on('click', '.js-copy-share-link', function () {
      self.copyShareSocial()
    })

    $(document).on('click', '.js-follow-share-link', function () {
      self.followShareSocial()
    })
  },

  /**
   * Формирование ссылки "Поделиться"
   * @param $button
   */
  shareSocial($button) {
    let $url = null
    let $shareUrl = null

    switch ($button.data('share-social')) {
      case 'fb':
        $url = 'https://www.facebook.com/sharer.php?'
        $shareUrl = $url += 'u=' + this.pageUrl
        console.log($shareUrl)
        break
      case 'vk':
        $url = 'http://vkontakte.ru/share.php?'
        $shareUrl = $url += 'url=' + this.pageUrl
        break
      case 'od':
        $url = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1'
        $shareUrl = $url += '&st._surl=' + this.pageUrl
        break
    }

    this.shareUrl = $shareUrl
    this.shareInputHref.val($shareUrl)
  },

  /**
   * Переход по сформированной ссылке
   */
  followShareSocial() {
    if (!this.shareUrl)
      return

    window.open(this.shareUrl, '_blank')
  },

  /**
   * Копирование формированной ссылки
   */
  copyShareSocial() {
    if (!this.shareUrl)
      return

    $(this.shareInputHref).select()
    document.execCommand("copy")
  }
}

export default shareSocial
