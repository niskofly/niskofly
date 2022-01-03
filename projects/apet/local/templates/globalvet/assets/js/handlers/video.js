class Video {
  constructor($wrapper) {
    this.$wrapper = $wrapper
    this.$play = this.$wrapper.find('.js-video-play')
    this.$player = this.$wrapper.find('.js-video-player')[0]
    this.eventHandler()
  }

  eventHandler() {
    const self = this

    $(this.$player).on('ended', () => {
      $(this.$wrapper).removeClass('is--play')
    })

    $(this.$play).on('click', function () {
      if ($(self.$wrapper).hasClass('is--play'))
        self.$player.pause()
      else
        self.$player.play()
      $(self.$wrapper).toggleClass('is--play');
    })
  }
}

export default Video
