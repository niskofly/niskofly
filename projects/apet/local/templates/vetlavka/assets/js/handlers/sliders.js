import Swiper from 'swiper'

class AnimalSlider {
  constructor($wrapper) {
    this.$slider = $wrapper.find('.swiper-container')
    this.$wrapper = $wrapper
    this.initSlider()
  }

  initSlider() {
    // eslint-disable-next-line no-new
    new Swiper(this.$slider, {
      direction: 'horizontal',
      loop: false,
      slidesPerView: 6,
      spaceBetween: 20,
      navigation: {
        nextEl: this.$wrapper.find('.swiper-button-next'),
        prevEl: this.$wrapper.find('.swiper-button-prev'),
      },
    })
  }
}

class HeaderSlider {
  constructor($wrapper) {
    this.$slider = $wrapper
    this.initSlider()
  }

  initSlider() {
    // eslint-disable-next-line no-new
    new Swiper(this.$slider, {
      direction: 'horizontal',
      slidesPerView: 6,
      spaceBetween: 40,
      navigation: {
        nextEl: this.$slider.parent().find('.swiper-button-next'),
        prevEl: this.$slider.parent().find('.swiper-button-prev'),
      },
      breakpoints: {
        1280: {
          direction: 'vertical',
        },
      },
    })
  }
}

class NutrionSlider {
  constructor($wrapper) {
    this.$slider = $wrapper.find('.swiper-container')
    this.$wrapper = $wrapper
    this.initSlider()
  }

  initSlider() {
    // eslint-disable-next-line no-new
    new Swiper(this.$slider, {
      direction: 'horizontal',
      loop: false,
      slidesPerView: 4,
      spaceBetween: 20,
      navigation: {
        nextEl: this.$wrapper.find('.swiper-button-next'),
        prevEl: this.$wrapper.find('.swiper-button-prev'),
      },
      observer: true,
      observeParents: true,
    })
  }
}

class OfferSlider {
  constructor($wrapper) {
    this.$slider = $wrapper.find('.swiper-container')
    this.$wrapper = $wrapper
    this.initSlider()
  }

  initSlider() {
    // eslint-disable-next-line no-new
    new Swiper(this.$slider, {
      direction: 'horizontal',
      loop: false,
      slidesPerView: 1,
      spaceBetween: 20,
      navigation: {
        nextEl: this.$wrapper.find('.swiper-button-next'),
        prevEl: this.$wrapper.find('.swiper-button-prev'),
      },
      observer: true,
      observeParents: true,
      breakpoints: {
        1200: {
          slidesPerView: 4,
        },
        1024: {
          slidesPerView: 3,
        },
        768: {
          slidesPerView: 2.5,
        },
      },
    })
  }
}

const catalogSlider = {
  init() {
    this.$slider = $('.js-manufacturers-slider')
    this.initSlider()
  },

  initSlider() {
    // eslint-disable-next-line no-new
    new Swiper(this.$slider, {
      direction: 'horizontal',
      loop: false,
      slidesPerView: 2.5,
      spaceBetween: 25,
      navigation: {
        nextEl: '.swiper-button-next-unique',
        prevEl: '.swiper-button-prev-unique',
      },
      breakpoints: {
        1024: {
          slidesPerView: 7,
        },
        500: {
          slidesPerView: 4,
        },
      },
    })
  },
}

const menuSlider = {
  init() {
    this.$slider = $('.js-menu-slider')
    this.initSlider()
  },

  initSlider() {
    // eslint-disable-next-line no-new
    new Swiper(this.$slider, {
      direction: 'vertical',
      loop: false,
      slidesPerView: 6,
      spaceBetween: 25,
      navigation: {
        nextEl: '.swiper-button-next-unique',
        prevEl: '.swiper-button-prev-unique',
      },
    })
  },
}

const bannerSlider = {
  init() {
    this.$slider = $('.js-animal-banner')
    this.initSlider()
  },

  initSlider() {
    // eslint-disable-next-line no-new
    new Swiper(this.$slider, {
      direction: 'horizontal',
      loop: false,
      slidesPerView: 1,
      autoplay: true,
      pagination: {
        el: '.swiper-pagination',
      },
    })
  },
}

const heroSlider = {
  init() {
    this.$slider = $('.js-hero-slider--promo')
    this.initSlider()
  },

  initSlider() {
    // eslint-disable-next-line no-new
    new Swiper(this.$slider, {
      direction: 'horizontal',
      slidesPerView: 1,
      loop: true,
      autoplay: {
        delay: 1500,
      },
      pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
      },
    })
  },
}

const dailySlider = {
  init() {
    this.$slider = $('.js-hero-slider--daily')
    this.$durationLines = $('.js-daily-card__loader')
    this.sliderDuration = 3000

    this.initSlider()
    this.restartLines(this.$durationLines)
  },

  initSlider() {
    // eslint-disable-next-line no-new
    new Swiper(this.$slider, {
      direction: 'horizontal',
      slidesPerView: 1,
      effect: 'ease',
      autoplay: true,
      autoplaySpeed: this.sliderDuration,
      speed: this.sliderDuration,
      on: {
        init: () => {
          this.restartLines()
        },

        slideChangeTransitionStart: () => {
          this.restartLines(this.sliderDuration)
        },
      },
    })
  },

  restartLines(duration = 0) {
    for (const line of this.$durationLines) {
      const $line = $(line)

      $($line).removeClass('daily-card__loader--active')

      setTimeout(function() {
        $($line).addClass('daily-card__loader--active')
      }, duration)
    }
  },
}

const productSlider = {
  init() {
    this.$slider = $('.js-product-slider')
    this.$thumbs = $('.js-product-thumbs')

    this.initSlider()
  },

  initSlider() {
    const galleryThumbs = new Swiper(this.$thumbs, {
      spaceBetween: 10,
      slidesPerView: 4,
      loop: false,
      freeMode: true,
      loopedSlides: 7, // looped slides should be the same
      watchSlidesVisibility: true,
      watchSlidesProgress: true,
    })

    // eslint-disable-next-line no-new
    new Swiper(this.$slider, {
      spaceBetween: 10,
      loop: true,
      loopedSlides: 7, // looped slides should be the same
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      thumbs: {
        swiper: galleryThumbs,
      },
    })
  },
}

const compareSlider = {
  init() {
    const slide = $('.section-compare__slide').length > 5 ? 5 : $('.section-compare__slide').length

    const sliderCompareInfo = new Swiper('.js-slider-compare-info', {
      spaceBetween: 0,
      slidesPerView: 3,
    })
    const sliderCompare = new Swiper('.js-slider-compare', {
      slidesPerView: slide,
      spaceBetween: 20,
    })

    // if ($(document).find('.js-slider-compare').length) {
    //   sliderCompare.controller.control = sliderCompareInfo
    //   sliderCompareInfo.controller.control = sliderCompare
    // }
  },
}

const initSliders = () => {
  catalogSlider.init()
  bannerSlider.init()
  productSlider.init()
  heroSlider.init()
  dailySlider.init()
  menuSlider.init()
  compareSlider.init()
}

export { initSliders, AnimalSlider, OfferSlider, NutrionSlider, HeaderSlider }
