const profiles = {
  init() {
    this.addingProfileForm = $('.js-form-create-profile')
    this.profileForm = $('.js-profile-form-send')
    this.bitrixToken = this.profileForm.find('input[name="sessid"]').val()

    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on('click', '.js-profile-open', function () {
      self.toggleProfile('open', $(this))
    })

    $(document).on('click', '.js-profile-close', function () {
      self.toggleProfile('close', $(this))
    })

    $(document).on('click', '.js-profile-delete', function () {
      self.profileDelete($(this))
    })

    $(document).on('input', '.js-loading-files', function () {
      self.loadingFileInProfile($(this))
    })
  },

  profileDelete($button) {
    launchWindowPreloader()

    const formData = new FormData()
    formData.append("sessid", this.bitrixToken)
    formData.append("ACTION", "DELETE")
    formData.append("PROFILE_ID", $button.data('profile-id'))

    axios
      .post(this.profileForm.attr("action"), formData)
      .then(response => {
        stopWindowPreloader()
        $button.closest('.lk-section--profile').remove()
      })
  },

  loadingFileInProfile($button) {
    //launchWindowPreloader()
    const $fileInput = $button.find('[type="file"]')
    const $progress = $button.find('.js-upload-progress'),
          $progressPercent = $progress.find('.js-upload-progress-percent'),
          $progressLine = $progress.find('.js-upload-progress-line'),
          $progressText = $progress.find('.js-upload-progress-text');

    const formData = new FormData()
    formData.append("sessid", this.bitrixToken)
    formData.append("ACTION", "FILE_LOADING")
    formData.append("USER_PROFILE_ID", $button.data('user-profile-id'))
    formData.append("PROPERTY_ID", $button.data('property-id'))
    formData.append("FILE", $fileInput[0].files[0])

    axios
      .post(this.profileForm.attr('action'), formData, {
        onUploadProgress: function (progressEvent) {
          let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total) + "%"

          $progress.addClass('progress--active')
          $progressPercent.html(percentCompleted)
          $progressLine.css('width', percentCompleted)
          $progressText.html('Загружается...')
          console.log(progressEvent)
        }
      })
      .catch(function (error) {
        console.log(error)
      })
      .then(response => {
        //stopWindowPreloader()
        $progressText.html('Готово!')
        setTimeout(() => $progress.removeClass('progress--active'), 1000)
      })
  },

  toggleProfile(event, $button) {
    switch (event) {
      case 'open':
        this.addingProfileForm.fadeIn()
        $button.removeClass('js-profile-open')
        $button.addClass('js-profile-close')
        $button.find('.js-profile-btn-text').html('Закрыть профиль')
        $button.find('.js-profile-btn-icon').css('transform', 'rotate(45deg)')
        break
      case 'close':
        this.addingProfileForm.hide()
        $button.removeClass('js-profile-close')
        $button.addClass('js-profile-open')
        $button.find('.js-profile-btn-text').html('Создать профиль')
        $button.find('.js-profile-btn-icon').css('transform', 'rotate(0deg)')
    }
  }
}

export default profiles
