const profiles = {
  init() {
    this.form = $('.js-profile-form-send')
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on('click', '.js-profile-open', function() {
      self.toggleProfileSection('open', $(this).data('section'))
    })

    $(document).on('click', '.js-profile-close', function() {
      self.toggleProfileSection('close', $(this).data('section'))
    })

    $(document).on('input', '.js-user-file-loading', function () {
      self.loadingUserFile($(this))
    })
  },

  loadingUserFile($button) {
    launchWindowPreloader()

    const $bitrix_sessid = this.form.find('input[name="sessid"]').val()
    const $fileInput = $button.find('[type="file"]')

    const formData = new FormData()
    formData.append("sessid", $bitrix_sessid)
    formData.append("ACTION", "FILE_LOADING")
    formData.append("USER_PROFILE_ID", $button.data('user-profile-id'))
    formData.append("PROPERTY_ID", $button.data('property-id'))
    formData.append("FILE", $fileInput[0].files[0])

    axios
      .post(this.form.attr('action'), formData)
      .then(response => {
        stopWindowPreloader()
      })
  },

  toggleProfileSection(event, section) {
    switch (event) {
      case 'open':
        $('.js-profile-list').hide()
        $(section).fadeIn()
        break
      case 'close':
        $(section).hide()
        $('.js-profile-list').fadeIn()
        break
      default:
        $('.js-profile-list').fadeIn()
        break
    }
  },

}
export default profiles
