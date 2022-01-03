const subscribe = {
  init() {
    this.subTitle = $(".js-form-subtitle").html('Подпишитесь на рассылку! Узнавайте о новинках продукции и о специальных предложениях.')
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on('submit', '.js-form-subscribe', function () {
      self.sendRequest($(this))
      return false
    })
  },

  sendRequest($form) {
    launchWindowPreloader()

    axios
      .post($form.attr('action'), new FormData($form[0]))
      .then(response => {
        const message = response.data.message ? response.data.message : response.data.error

        this.subTitle.html(message)

        stopWindowPreloader()
      })
  }

}
export default subscribe
