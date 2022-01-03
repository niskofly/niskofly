/* eslint-disable no-eval */
/* eslint-disable no-undef */
import ionRangeSlider from 'ion-rangeslider'

const filter = {
  $form: null,
  $options: null,
  $resetBtn: null,

  resetUrl: null,
  LazyLoad: null,

  init($form, LazyLoad) {
    this.$form = $form
    this.LazyLoad = LazyLoad

    this.$options = $form.find('.js-catalog-filter-option')
    this.$resetBtn = $form.find('.js-catalog-filter-reset')
    this.$sliderPrice = $('.js-range-slider')

    this.$availableInput = $('.js-catalog-filter-available')

    this.initPriceSlider()
    this.eventHandler()
  },

  eventHandler() {
    this.$options.on('change', () => {
      this.loadFilterContent()
    })

    this.$form.on('reset', () => {
      this.resetFilter()
    })

    this.$availableInput.on('change', event => {
      window.setCookie('HIDE_NOT_AVAILABLE', event.target.checked ? 'Y' : 'N')
      this.loadFilterContent()
    })
  },

  initPriceSlider() {
    if (!this.$sliderPrice.length) return

    const settingsRangeSlider = $('.js-range-slider').data('settings')

    const $minPriceResult = $('.js-input-range-from')
    const $maxPriceResult = $('.js-input-range-to')
    const $minPriceInput = $('.js-input-range-from-result')
    const $maxPriceInput = $('.js-input-range-to-result')

    const runPriceFilter = data => {
      if (data.from)
        $minPriceInput.val(settingsRangeSlider.min !== data.from ? data.from : '')

      if (data.to)
        $maxPriceInput.val(settingsRangeSlider.max !== data.to ? data.to : '')

      this.loadFilterContent()
    }

    $minPriceResult.on('change', event => {
      const data = { from: Number(event.target.value.replace('₽', '')) }

      this.$sliderPrice.data('ionRangeSlider').update(data)
      runPriceFilter(data)
    })

    $maxPriceResult.on('change', event => {
      const data = { to: Number(event.target.value.replace('₽', '')) }

      this.$sliderPrice.data('ionRangeSlider').update(data)
      runPriceFilter(data)
    })

    this.$sliderPrice.ionRangeSlider({
      skin: 'round',
      type: 'double',
      min: settingsRangeSlider.min,
      max: settingsRangeSlider.max,
      from: settingsRangeSlider.currentMin,
      to: settingsRangeSlider.currentMax,
      hide_min_max: true,
      hide_from_to: true,
      extra_classes: 'irs--catalog',
      onChange: data => {
        $minPriceResult.val(data.from + ' ₽')
        $maxPriceResult.val(data.to + ' ₽')
      },
      onFinish: data => {
        runPriceFilter(data)
      }
    })
  },

  loadFilterContent() {
    launchWindowPreloader()

    axios
      .post(this.$form.attr('action'), new FormData(this.$form[0]))
      .then(response => {
        /**
         * Парсинг JSON ответа от битрикс
         */
        const result = null
        eval('result = ' + response.data)

        if (!result) {
          stopWindowPreloader()
          messageError({ title: 'Произошла ошибка при фильтрации' })
        }

        this.resetUrl = result.SEF_DEL_FILTER_URL
        this.LazyLoad.loadContentFromFilter(result.FILTER_URL)

        this.toggleResetFilterBtn(result.SEF_DEL_FILTER_URL !== result.SEF_SET_FILTER_URL)
      })
  },

  toggleResetFilterBtn(isShow) {
    isShow ? this.$resetBtn.show() : this.$resetBtn.hide()
  },

  resetFilter() {
    this.$options.each(function () {
      $(this).attr('checked', false)
    })

    if (this.$sliderPrice.length)
      this.$sliderPrice.data('ionRangeSlider').reset()

    launchWindowPreloader()

    this.resetUrl ? this.LazyLoad.loadContentFromFilter(this.resetUrl) : this.loadFilterContent()

    this.toggleResetFilterBtn(false)
  }
}

export default filter
