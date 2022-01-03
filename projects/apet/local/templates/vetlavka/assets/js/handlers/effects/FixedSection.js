const FixedSection = {
  sectionClass: '.js-fixed-section',
  offsetTop: null,
  height: null,
  isDataSection: false,

  init() {
    if($(this.sectionClass).length) {
      this.getParams()
      this.eventHandlers()
    }
  },

  eventHandlers(){
    const self = this
    let extraHeight = (this.isDataSection) ? this.height : 0

    if (this.offsetTop)
      $(window).on('scroll', function(){
        if (self.offsetTop + extraHeight < $(this).scrollTop()) {
          if (!$(self.sectionClass).hasClass('is--fixed'))
            $(self.sectionClass)
              .wrap(`<div class="fixed-wrapper" style="height: ${self.height}px"></div>`)
              .wrap(`<div class="fixed-section"></div>`)
              .wrap(`<div class="container fixed-section__container"></div>`)
              .addClass('is--fixed')
        }
        else {
          if ($(self.sectionClass).hasClass('is--fixed'))
            $(self.sectionClass)
              .removeClass('is--fixed')
              .unwrap()
              .unwrap()
              .unwrap()
        }
      })
  },

  getParams(){
    this.offsetTop = $(this.sectionClass).offset().top
    this.height = $(this.sectionClass).outerHeight()
    this.isDataSection = $(this.sectionClass)[0].hasAttribute('data-extra-height')
  },
}

export default FixedSection
