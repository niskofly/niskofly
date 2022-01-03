/* eslint-disable no-new */
/* eslint-disable new-cap */
/* eslint-disable no-undef */
const mapHandler = {
  init() {
    if ($('#js-map-render').length === 0) return

    this.points = null
    this.preparePoints(window.__POINTS__)

    if (!this.points) return

    if (typeof ymaps === 'undefined')
      this.addScriptYmaps()
    else
      this.initMap()
  },

  preparePoints(json) {
    let data = null

    if (typeof json === 'undefined') {
      const lat = $('#js-map-render').data('lat')
      const lon = $('#js-map-render').data('lon')
      if (lat && lon)
        data = { COORDINATE: [lat, lon] }
    } else
      data = JSON.parse(json)

    if (!data)
      return

    if (Array.isArray(data)) {
      this.points = data
      return
    }

    if (typeof data === 'object')
      this.points = [data]
  },

  addScriptYmaps() {
    const script = document.createElement('script')
    script.src = '//api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=ddd3730b-6500-4ad2-8af2-36d72cbbca77'
    script.async = true
    script.onload = () => {
      this.initMap()
    }
    document.head.appendChild(script)
  },

  initMap() {
    ymaps.ready(() => {
      this.map = new ymaps.Map('js-map-render', {
        center: [55.748827, 37.61564],
        zoom: 7,
        behaviors: ['default', 'scrollZoom'],
        controls: []
      })
      this.map.controls.add(new ymaps.control.ZoomControl())
      this.map.behaviors.disable('scrollZoom')

      this.setMarkers()
    })
  },

  setMarkers() {
    const self = this
    const collection = new ymaps.GeoObjectCollection()

    this.points.forEach(element => {
      if (typeof element.COORDINATE !== 'undefined') {
        const marker = new ymaps.Placemark(
          element.COORDINATE,
          { balloonContent: self.getBalloonContent(element) },
          { preset: 'islands#darkBlueClusterIcons' }
        )
        collection.add(marker)
      }
    })

    this.map.geoObjects.add(collection)
    this.map.setBounds(collection.getBounds())

    if (this.map.getZoom() > 19) this.map.setZoom(19)
  },

  getBalloonContent(data) {
    let html = ''

    if (data.ADDRESS) html += `<b>${data.TITLE}</b><br>`
    if (data.ADDRESS) html += `Адрес : ${data.ADDRESS}<br>`
    if (data.DESCRIPTION) html += `Описание : ${data.DESCRIPTION}<br>`
    if (data.PHONE) html += `Телефон : <a href="tel:${data.PHONE}">${data.PHONE}</a><br>`

    return html
  }
}

class SimpleMap {
  constructor($element) {
    this.$element = $element
    this.coordinates = this.prepareCoords()
    this.mapId = this.$element.attr('id')

    if (!this.coordinates || !this.mapId)
      return null

    ymaps.ready(() => {
      this.initMap()
    })
  }

  prepareCoords() {
    const coordinates = this.$element.data('coordinates')
    if (!coordinates)
      return null

    return coordinates.split(',')
  }

  getBalloonContent() {
    return ''
  }

  getIcon() {
    return this.$element.data('icon') ? this.$element.data('icon') : 'islands#redDotIcon'
  }

  initMap() {
    const map = new ymaps.Map(this.mapId, {
      center: this.coordinates,
      zoom: 19,
      behaviors: ['default', 'scrollZoom'],
      controls: []
    })
    map.controls.add(new ymaps.control.ZoomControl())
    map.behaviors.disable('scrollZoom')

    map.geoObjects.add(new ymaps.Placemark(this.coordinates, {
      balloonContent: this.getBalloonContent()
    }, {
      preset: this.getIcon()
    }))

    console.log(map.getZoom())
    if (map.getZoom() > 15) map.setZoom(15)
  }
}

function initMapHandlers() {
  mapHandler.init()

  $('.js-simple-map').each(function () {
    new SimpleMap($(this))
  })
}

export default initMapHandlers
