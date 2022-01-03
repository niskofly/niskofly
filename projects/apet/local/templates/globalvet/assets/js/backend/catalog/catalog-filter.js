import LazyLoad from "./../lazy-load"
import ionRangeSlider from 'ion-rangeslider'

const catalogFilter = {
  init() {
    this.$form = $(".js-catalog-filter-form")
    this.countInputs = []
    if (this.$form.length == 0) return

    this.LazyLoad = new LazyLoad($(".js-lazy-load-catalog"))
    this.$elementCounter = $(".js-filter-count-elements")
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    let priceRange = $('.js-range-price').ionRangeSlider({
      skin: 'round',
      type: 'double',
      hide_min_max: true,
      hide_from_to: true,
      extra_classes: 'irs--prices',
      onFinish: function (data) {
        $('.js-price-to').val(data.to)
        $('.js-price-from').val(data.from)
        launchWindowPreloader()
        self.request()
      }
    }).data("ionRangeSlider")


    $(document).on("change", ".js-filter-option", function() {
      if ($(this).hasClass('js-price-to') || $(this).hasClass('js-price-from')) {
        priceRange.update({
          from: $('.js-price-from').val(),
          to: $('.js-price-to').val()
        })
      }

      launchWindowPreloader()
      self.request()
    })


    $(document).on("click", ".js-filter-reset", () => {
      launchWindowPreloader()
      this.reset()
    })


    $(document).on("change", ".js-quantity-filter-control", function () {
      let value = $(this).prop("checked") ? "Y" : "N"
      self.filterQuantity(value)
    })

    $(document).on("change", ".js-catalog-sorting", function () {
      let value = $(this).prop("checked") ? $(this).val() : ""
      self.catalogSort(value)
    });

    $(document).on("click", ".js-catalog-filter-show", function () {
      $(".js-catalog-sidebar").addClass("catalog__sidebar--show")
      $("body")
        .css("overflow", "hidden")
        .append(
          '<div class="modal-background js-modal-background js-catalog-filter-hide"></div>'
        )
    })

    $(document).on("click", ".js-catalog-filter-hide", function () {
      $(".js-modal-background").remove()
      $(".js-catalog-sidebar").removeClass("catalog__sidebar--show")
      $("body").css("overflow", "initial")
    })
  },

  request() {
    axios
      .post(this.$form.attr("action"), new FormData(this.$form[0]))
      .then(response => {
        /**
         * Парсинг JSON ответа от битрикс
         */
        let result = null;
        eval("result=" + response.data)

        if (!result) {
          stopWindowPreloader()
          messageError({title: "Произошла ошибка при фильтрации"})
        }

        this.LazyLoad.loadByFilter(result.FILTER_URL.replaceAll('amp;', ''))
        this.updateElementCount(result.ELEMENT_COUNT);
      })
  },

  reset() {
    let $inputs = this.$form.find(".js-filter-option")
    $inputs.each(function () {
      switch ($(this).attr("type")) {
        case "checkbox":
          $(this).prop("checked", false)
          break
        default:
          $(this).val("")
      }
    })

    setTimeout(() => {
      this.request()
    }, 0 )
  },

  updateElementCount(count) {
    if (this.$elementCounter.length == 0 || !count) return;
    this.$elementCounter.html(count);
  },

  filterQuantity(value) {
    launchWindowPreloader()

    setCookie("HIDE_NOT_AVAILABLE", value)
    this.request()
  },

  catalogSort(value) {
    launchWindowPreloader()

    setCookie("SORT_SETTING", value)
    this.request()
  }
};

export default catalogFilter
