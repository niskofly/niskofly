const comparison = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on("submit", ".js-comparison-form", function () {
      self.request($(this))
      return false
    })

    $(document).on("click", ".js-clear-comparison-list", function () {
      self.clearComparisonList()
      return false
    })

    $(document).ready(function () {
      self.setCountInLoading()
      return false
    })
  },

  setCountInLoading() {
    const formData = new FormData();
    formData.append("ACTION", "GET_COUNT")

    axios
      .post('/api/user/controller-comparison.php', formData)
      .then(response => {
        if (!response.data.error)
          this.updateCount(response.data.count)
      })
  },

  clearComparisonList() {
    launchWindowPreloader()

    const formData = new FormData();
    formData.append("ACTION", "CREAR_LIST")

    axios
      .post('/api/user/controller-comparison.php', formData)
      .then(response => {
        stopWindowPreloader()
      })
  },

  request($form) {
    launchWindowPreloader()

    axios
      .post($form.attr("action"), new FormData($form[0]))
      .then(response => {
        if (response.data.STATUS === 'OK') {
          const $inputAction = $form.find('input[name=action]')
          const $submit = $form.find('button[type=submit]')

          switch ($inputAction.val()) {
            case 'ADD_TO_COMPARE_LIST':
              $inputAction.val("DELETE_FROM_COMPARE_LIST")
              $submit.addClass('active')
              break
            case 'DELETE_FROM_COMPARE_LIST':
              $inputAction.val("ADD_TO_COMPARE_LIST")
              $submit.removeClass('active')
              break
          }

          this.updateCount(response.data.COUNT)
        }

        stopWindowPreloader()
      })
  },

  updateCount(count) {
    const $comparisonCounter = $(".js-comparison-count")
    $comparisonCounter.empty()

    if (count >= 1)
      $comparisonCounter
        .html(count)
        .addClass("header-actions__controls-count--active")
    else
      $comparisonCounter
        .empty()
        .removeClass("header-actions__controls-count--active")
  }
}

export default comparison
