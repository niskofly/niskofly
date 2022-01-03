const updateUserPhoto = {
  init() {
    this.$form = $(".js-update-photo-form")
    if (this.$form.length == 0) return
    this.$input = this.$form.find('[type="file"]')
    this.$image = this.$form.find(".js-update-photo-image")
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    this.$input.on("change", () => {
      this.request()
    })
  },

  request() {
    launchWindowPreloader()

    axios
      .post(this.$form.attr("action"), new FormData(this.$form[0]))
      .then(response => {
        stopWindowPreloader()

        if (response.data.error)
          return messageError({title: response.data.message})

        const newPhotoSrc = response.data.newPhotoSrc
        if (newPhotoSrc) return this.$image.attr("src", newPhotoSrc)
      })
  }

}
export default updateUserPhoto
