import Swiper from 'swiper'

const sliders = {
  config: {
    'catalog-window-brands': {
      direction: 'vertical',
      slidesPerView: 3,
      spaceBetween: 50
    },
    'home-intro': {
      slidesPerView: 1,
      spaceBetween: 0,
      pagination: {
        el: '.swiper-pagination',
        type: 'bullets'
      }
    },
    'catalog-brands': {
      slidesPerView: 8,
      spaceBetween: 30
    },
    'brands': {
      slidesPerView: 6,
      spaceBetween: 90,
      on: {
        init: function () {
          $(this.el)
            .find('.swiper-slide img')
            .css('transform', 'scale(1)')
        }
      }
    },
    'catalog-sections': {
      slidesPerView: 6,
      spaceBetween: 20
    },
    'compare': {
      slidesPerView: 3,
      spaceBetween: 20
    },
    'news': {
      slidesPerView: 3,
      spaceBetween: 20
    },
    'popular': {
      slidesPerView: 4,
      spaceBetween: 20,
      observer: true,
      observeParents: true
    },
    'best': {
      slidesPerView: 4,
      spaceBetween: 20,
      observer: true,
      observeParents: true
    },
    'food': {
      slidesPerView: 4,
      spaceBetween: 20,
      observer: true,
      observeParents: true
    },
    'recommend': {
      slidesPerView: 4,
      spaceBetween: 20,
      observer: true,
      observeParents: true
    }
  },

  init() {
    this.eventHandlers()
  },

  eventHandlers() {
    const self = this

    $('.js-slider').each(function (i, e) {
      const sliderId = $(e).attr('data-slider-id')
      const slider = new Swiper(`[data-slider-id=${sliderId}]`, self.config[sliderId])

      $(document).on('click', '.js-' + sliderId + '-prev', function () {
        slider.slidePrev()
      })

      $(document).on('click', '.js-' + sliderId + '-next', function () {
        slider.slideNext()
      })
    })

    const thumbAmount = ($('.js-gallery-thumbs').data('thumbs')) ? $('.js-gallery-thumbs').data('thumbs') : 4
    const galleryThumbs = new Swiper('.js-gallery-thumbs', {
      spaceBetween: 9,
      slidesPerView: thumbAmount,
      freeMode: true,
      watchSlidesVisibility: true,
      watchSlidesProgress: true
    })

    const galleryPreview = new Swiper('.js-gallery-preview', {
      spaceBetween: 0,
      navigation: {
        nextEl: '.js-product-gallery-next',
        prevEl: '.js-product-gallery-prev'
      },
      thumbs: {
        swiper: galleryThumbs
      }
    })

    const sliderCompareInfo = new Swiper('.js-slider-compare-info', {
      spaceBetween: 0,
      slidesPerView: 3
    })
    const sliderCompare = new Swiper('.js-slider-compare', {
      slidesPerView: 3,
      spaceBetween: 20
    })

    if ($(document).find('.js-slider-compare').length) {
      sliderCompare.controller.control = sliderCompareInfo
      sliderCompareInfo.controller.control = sliderCompare
    }
  }
}

export default sliders
