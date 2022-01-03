let storageMap = {
    init() {
        if ($("#js-store-map").length == 0) return;

        this.pickupPoints = JSON.parse(window.__STORE__);
        this.initMap();
    },

    initMap() {
        console.log("initMap");
        ymaps.ready(() => {
            this.pickupPointMap = new ymaps.Map("js-store-map", {
                center: [55.748827, 37.61564],
                zoom: 7,
                behaviors: ["default", "scrollZoom"],
                controls: []
            });
            this.pickupPointMap.controls.add(new ymaps.control.ZoomControl());
            this.pickupPointMap.behaviors.disable("scrollZoom");

            this.setMapMarkers();
        });
    },

    setMapMarkers() {
        let self = this;

        let objectCollection = new ymaps.GeoObjectCollection();

        $.each(this.pickupPoints, function() {
            if (typeof this.COORDINATE != "undefined") {
                let marker = new ymaps.Placemark(
                    this.COORDINATE,
                    {
                        balloonContent: self.getBalloonContent(this)
                    },
                    {
                        preset: "islands#darkBlueClusterIcons"
                    }
                );

                objectCollection.add(marker);
            }
        });

        this.pickupPointMap.geoObjects.add(objectCollection);

        this.pickupPointMap.setBounds(objectCollection.getBounds());

        if (this.pickupPointMap.getZoom() > 19) this.pickupPointMap.setZoom(19);
    },

    getBalloonContent(store) {
        let html = `<b>${store.TITLE}</b><br>`;

        if (store.ADDRESS) html += `Адрес : ${store.ADDRESS}<br>`;

        if (store.DESCRIPTION) html += `Описание : ${store.DESCRIPTION}<br>`;

        if (store.PHONE)
            html += `Телефон : <a href="tel:${store.PHONE}">${store.PHONE}</a><br>`;

        return html;
    }
}

export default storageMap
