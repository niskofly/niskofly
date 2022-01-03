const choiceWarehouse = {
    init(orderHandler) {
        this.orderHandler = orderHandler;

        this.$mapWrapper = $(".js-pickup-map-wrapper");
        this.$input = orderHandler.$form.find('[name="BUYER_STORE"]');

        this.$addressHiddenInput = orderHandler.$form.find(
            '[name="SELECT_PICKUP_ADDRESS"]'
        );

        this.pickupPointMap = null;
        this.pickupPoints = [];
        this.storeList = [];

        this.eventHandler();

        return this;
    },

    eventHandler() {
        let self = this;

        $(document).on("click", ".js-select-pickup", function() {
            self.selectPickupPoint($(this).data("id"));
        });
    },

    renderStorageArea(result) {
        let selectDelivery = null;
        for (let delivery of result.DELIVERY)
            if (delivery.CHECKED == "Y") selectDelivery = delivery;

        this.prepareStoreList(result.STORE_LIST);
        this.setPickupPoint(selectDelivery);

        if (this.pickupPoints.length == 0) {
            this.$mapWrapper.hide();
            return;
        } else {
            this.$mapWrapper.show();
        }

        if (!this.pickupPointMap) this.initMap();
        else this.setMapMarkers();
    },

    prepareStoreList(stores) {
        this.storeList = [];

        for (let key in stores) {
            let store = stores[key];
            store.COORDINATE = [store.GPS_N, store.GPS_S];
            this.storeList[key] = store;
        }
    },

    setPickupPoint(selectDelivery) {
        this.pickupPoints = [];

        for (let key of selectDelivery.STORE)
            if (typeof this.storeList[key] != "undefined")
                this.pickupPoints.push(this.storeList[key]);
    },

    selectPickupPoint(pointId) {
        launchWindowPreloader();

        this.$input.val(pointId);
        this.$addressHiddenInput.val(this.storeList[pointId].ADDRESS);
        this.orderHandler.updateOrderInfo();
    },

    initMap() {
        ymaps.ready(() => {
            this.pickupPointMap = new ymaps.Map("js-pickup-point-map", {
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
        let selectPickupId = this.$input.val();

        this.pickupPointMap.geoObjects.removeAll();
        let objectCollection = new ymaps.GeoObjectCollection();

        $.each(this.pickupPoints, function() {
            if (typeof this.COORDINATE != "undefined") {
                let pickupPointId = this.ID;
                let isSelectPickup = selectPickupId == this.ID;

                let marker = new ymaps.Placemark(
                    this.COORDINATE,
                    {
                        balloonContent: self.getBalloonContent(this)
                    },
                    {
                        preset: isSelectPickup
                            ? "islands#redShoppingIcon"
                            : "islands#darkBlueClusterIcons"
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

        html += `<button type="button" class="btn js-select-pickup" data-id="${store.ID}">Выбрать</button>`;

        return html;
    }
};

export default choiceWarehouse
