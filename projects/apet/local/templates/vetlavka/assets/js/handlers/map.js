const mapHandler = {
  init() {
    if ($('#js-map-render').length === 0) return

    this.$item = $('.js-map-point')

    if (typeof ymaps === 'undefined')
      this.addScriptYmaps()
    else
      this.initMap()
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
    const self = this

    ymaps.ready(() => {
      this.map = new ymaps.Map('js-map-render', {
        center: [59.13165, 59.1112],
        zoom: 7,
        behaviors: ['default', 'scrollZoom'],
        controls: [],
      })

      if (window.$addresses) {
        const addresses = window.$addresses

        for (const value of addresses) {
          value.COORDINATE = value.COORDINATE[0].split(',').map(e => parseFloat(e))
        }

        this.map.container.fitToViewport()
        this.objectManager = new ymaps.ObjectManager({
          clusterize: true,
          gridSize: 32,
          clusterDisableClickZoom: false
        })

        let objects = []

        for (let i = 0, l = addresses.length; i < l; i++) {
          objects.push({
            type: 'Feature',
            id: i,
            geometry: {
              type: 'Point',
              coordinates: addresses[i].COORDINATE
            },
            properties: {
              balloonContentHeader: '<strong>' + addresses[i].name + '</strong>',
              balloonContentBody:
                `<p><strong>Адресс:</strong> ${addresses[i].address}</p>
                 <p><strong>Телефон:</strong> ${(addresses[i].phone)}</p>
                 <p><strong>Email:</strong> ${(addresses[i].email)}</p>
                `
            }
          })
        }

        this.objectManager.objects.options.set({
          preset: 'islands#darkBlueClusterIcons',
          iconLayout: 'default#image',
          iconImageHref: '/img/icons/map.svg',
          iconImageSize: [39, 51],
        })

        this.objectManager.add(objects)
        this.map.geoObjects.add(this.objectManager)
        this.map.controls.add(new ymaps.control.ZoomControl())
        this.map.behaviors.disable('scrollZoom')

        $('.js-map-point').on('click', function () {
          const coord = $(this).data('coordinates').split(',').map(e => parseFloat(e))
          // const objectId = parseInt($(this).attr('data-coord-id'))

          self.map.panTo(coord, {
            flying: 1
          }).then(function () {
            self.map.setZoom(14)
            // self.objectManager.objects.balloon.open(objectId)
          })
        })
      }
    })
  },
}

class SimpleMap {
  constructor($map) {
    this.$map = $map
    if (this.$map.length === 0) return

    if (typeof ymaps === 'undefined')
      this.addScriptYmaps()
    else
      this.initMap()
  }

  addScriptYmaps() {
    const script = document.createElement('script')
    script.src = '//api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=ddd3730b-6500-4ad2-8af2-36d72cbbca77'
    script.async = true
    script.onload = () => {
      this.initMap()
    }
    document.head.appendChild(script)
  }

  initMap() {
    ymaps.ready(() => {
      this.map = new ymaps.Map('js-simple-map', {
        center: [55.639827, 37.812938],
        zoom: 7,
        behaviors: ['default', 'scrollZoom'],
        controls: [],
      })

      if (window.shops) {
        const addresses = window.shops

        for (const value of addresses) {
          value.COORDINATE = value.COORDINATE[0].split(',').map(e => parseFloat(e))
        }

        this.map.container.fitToViewport()
        this.objectManager = new ymaps.ObjectManager({
          clusterize: true,
          gridSize: 32,
          clusterDisableClickZoom: false
        })

        let objects = []

        for (let i = 0, l = addresses.length; i < l; i++) {
          objects.push({
            type: 'Feature',
            id: i,
            geometry: {
              type: 'Point',
              coordinates: addresses[i].COORDINATE
            },
            properties: {
              balloonContentHeader: '<strong>' + addresses[i].name + '</strong>',
              balloonContentBody:
                `<p><strong>Адресс:</strong> ${addresses[i].address}</p>
                 <p><strong>Телефон:</strong> ${(addresses[i].phone)}</p>
                 <p><strong>Email:</strong> ${(addresses[i].email)}</p>
                `
            }
          })
        }

        this.objectManager.objects.options.set(
          {
            preset: 'islands#darkBlueClusterIcons',
            iconLayout: 'default#image',
            iconImageHref: '/img/icons/map.svg',
            iconImageSize: [39, 51],
          }
        )

        this.objectManager.add(objects)
        this.map.geoObjects.add(this.objectManager)
        this.map.controls.add(new ymaps.control.ZoomControl())
      }
    })
  }
}

function initMapHandlers() {
  mapHandler.init()

  $('.js-simple-map').each(function () {
    new SimpleMap($(this))
  })
}

export default initMapHandlers
