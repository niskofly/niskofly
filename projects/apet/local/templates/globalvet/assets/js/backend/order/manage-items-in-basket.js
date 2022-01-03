class ManageItemsInBasket {
    constructor($wrapper, orderHandler) {
        this.$wrapper = $wrapper;
        this.$removeBtn = $wrapper.find(".js-manage-basket-item-remove");
        this.$updateForm = $wrapper.find(".js-manage-basket-item-update-form");

        this.$quantityInput = this.$updateForm.find(
            ".js-manage-basket-item-quantity-input"
        );
        this.$reduceBtn = $wrapper.find(".js-manage-basket-item-reduce");
        this.$increaseBtn = $wrapper.find(".js-manage-basket-item-increase");

        this.orderHandler = orderHandler;

        this.eventHandler();
    }

    eventHandler() {
        this.$removeBtn.click(() => {
            this.remove();
            return false;
        });

        this.$reduceBtn.click(() => {
            let quantity = Number(this.$quantityInput.val());
            this.$quantityInput.val(quantity - 1);
            this.update();
        });

        this.$increaseBtn.click(() => {
            let quantity = Number(this.$quantityInput.val());
            this.$quantityInput.val(quantity + 1);
            this.update();
        });
    }

    remove() {
        let url = this.$removeBtn.attr("href");

        launchWindowPreloader();

        axios.get(url).then(response => {
            let countBasketItems = response.data.countBasketItems;

            if (response.data.error) {
                stopWindowPreloader();
                return messageError({ title: response.data.message });
            }

            smallBasket.updateBasket(countBasketItems);
            $(".js-order-registration-count-basket").text(countBasketItems);
            this.$wrapper.remove();

            if (countBasketItems == 0) return location.reload();

            this.orderHandler.updateOrderInfo();
        });
    }

    update() {
        launchWindowPreloader();

        if (this.$quantityInput.val() == 0) return this.remove();

        axios
            .post(
                this.$updateForm.attr("action"),
                new FormData(this.$updateForm[0])
            )
            .then(response => {
                if (response.data.error) {
                    stopWindowPreloader();
                    return messageError({ title: response.data.message });
                }

                this.orderHandler.updateOrderInfo();
            });
    }
}

export default ManageItemsInBasket
