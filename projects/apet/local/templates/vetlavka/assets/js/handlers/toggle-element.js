class ToggleElement {
  constructor($wrapper) {
    this.$wrapper = $wrapper
    this.$toggle = this.$wrapper.find('.js-toggle-element-action')
    this.$body = this.$wrapper.find('.js-toggle-element-body')

    this.eventHandler()
    this.addGlobalInstance()

    if (this.$wrapper.hasClass('toggle-element--open')) this.$body.slideToggle()
  }

  eventHandler() {
    this.$toggle.click(() => {
      this.toggleContent()
      return false
    })
  }

  toggleContent() {
    window.TOGGLE_ELEMENTS.forEach(element => {
      if (element !== this) element.close()
    })

    this.$wrapper.toggleClass('toggle-element--open')
    this.$body.slideToggle()
  }

  close() {
    this.$wrapper.removeClass('toggle-element--open')
    this.$body.slideUp()
  }

  addGlobalInstance() {
    if (typeof window.TOGGLE_ELEMENTS === 'undefined') window.TOGGLE_ELEMENTS = []

    window.TOGGLE_ELEMENTS.push(this)
  }
}

export default ToggleElement
