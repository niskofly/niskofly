/* eslint-disable no-undef */
const productNotifyHandler = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on('click', '.js-product-notify', function () {
      self.renderModal($(this))
    })
  },

  renderModal($btn) {
    $('.js-product-notify-id').val($btn.data('id'))
    $('.js-product-notify-image').attr('src', $btn.data('image'))
    $('.js-product-notify-name').html($btn.data('name'))

    openModal('#product-notify')
  }
}

export default productNotifyHandler
