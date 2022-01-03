/* eslint-disable no-new */
import Swiper from 'swiper'

const sliders = {
  commonConf: {
    navigation: {
      nextEl: '.js-slider-next',
      prevEl: '.js-slider-prev'
    }
  },

  config: {
    intro: {
      slidesPerView: 1,
      spaceBetween: 0,
      pagination: {
        el: '.slider-pagination',
        type: 'bullets'
      }
    },
    default: {
      slidesPerView: 'auto',
      watchSlidesVisibility: true,
      pagination: {
        el: '.slider-pagination',
        type: 'bullets'
      }
    }
  },

  init() {
    const self = this

    document.addEventListener('DOMContentLoaded', () => {
      this.initSliders()
      this.initGalleryImages()
    })

    window.initSliders = function () {
      self.initSliders()
    }
  },

  initSliders() {
    const mapSliders = new Map()

    $('.js-slider:not(.--slider-initialized--)').each(function (i, e) {
      $(this).addClass('--slider-initialized--')
      const sliderId = $(e).attr('data-slider-id')
      mapSliders.set(sliderId)
    })

    if (!mapSliders.size)
      return

    for (const key of mapSliders.keys())
      new Swiper(`[data-slider-id=${key}`, Object.assign(this.config[key], this.commonConf))
  },

  initGalleryImages() {
    const thumbAmount = $('.js-gallery-thumbs').data('thumbs')
      ? $('.js-gallery-thumbs').data('thumbs')
      : 5

    const galleryThumbs = new Swiper('.js-gallery-thumbs', {
      direction: 'horizontal',
      spaceBetween: 5,
      slidesPerView: thumbAmount,
      freeMode: true,
      watchSlidesVisibility: true,
      watchSlidesProgress: true,
      breakpoints: {
        426: {
          direction: 'vertical',
          spaceBetween: 25
        }
      }
    })

    new Swiper('.js-gallery-preview', {
      spaceBetween: 0,
      navigation: {
        nextEl: '.js-product-gallery-next',
        prevEl: '.js-product-gallery-prev',
      },
      thumbs: {
        swiper: galleryThumbs
      }
    })
  }
}

export { sliders }
