class ManageItemsInBasket {
  constructor($wrapper, orderHandler) {
    this.$wrapper = $wrapper;
    this.$removeForm = $wrapper.find(".js-manage-basket-item-remove");

    this.$updateForm = $wrapper.find(".js-manage-basket-item-update-form");

    this.$quantityInput = this.$updateForm.find("[name=QUANTITY]");
    this.$countElementInput = this.$updateForm.find("[name=COUNT_ELEMENT]");

    this.$quantityDisplay = this.$updateForm.find(".js-manage-basket-item-quantity-display");

    this.$reduceBtn = $wrapper.find(".js-manage-basket-item-reduce");
    this.$increaseBtn = $wrapper.find(".js-manage-basket-item-increase");

    this.orderHandler = orderHandler;

    this.eventHandler();
  }

  eventHandler() {
    this.updateDisabledReduceBtn()
    this.updateDisabledIncreaseBtn()

    this.$removeForm.click(() => {
      this.remove();
      return false;
    });

    this.$reduceBtn.click(() => {
      const quantity = Number(this.$quantityInput.val());
      this.$quantityInput.val(quantity - 1);
      this.$quantityDisplay.text(quantity - 1);
      this.update();
      this.updateDisabledReduceBtn()
      this.updateDisabledIncreaseBtn()
    });

    this.$increaseBtn.click(() => {
      const quantity = Number(this.$quantityInput.val());
      this.$quantityInput.val(quantity + 1);
      this.$quantityDisplay.text(quantity + 1);
      this.update();
      this.updateDisabledReduceBtn()
      this.updateDisabledIncreaseBtn()
    });
  }

  updateDisabledReduceBtn() {
    if (Number(this.$quantityInput.val()) < 2) this.$reduceBtn.prop('disabled', true)
    else this.$reduceBtn.prop('disabled', false)
  }

  updateDisabledIncreaseBtn() {
    if (Number(this.$quantityInput.val()) >= Number(this.$countElementInput.val())) this.$increaseBtn.prop('disabled', true)
    else this.$increaseBtn.prop('disabled', false)
  }

  remove() {
    const url = this.$removeForm.attr("href");

    axios
      .post(this.$removeForm.attr("action"), new FormData(this.$removeForm[0]))
      .then(response => {
        let countBasketItems = response.data.countBasketItems;

        if (response.data.error) {
          stopWindowPreloader();
          return messageError({title: response.data.message});
        }

        $(".js-order-registration-count-basket").text(countBasketItems);
        this.$wrapper.remove();

        if (countBasketItems == 0)
          return location.reload();

        this.orderHandler.updateOrderInfo();
      });
  }

  update() {
    launchWindowPreloader();

    if (this.$quantityInput.val() == 0)
      return this.remove();

    axios
      .post(
        this.$updateForm.attr("action"),
        new FormData(this.$updateForm[0])
      )
      .then(response => {
        if (response.data.error) {
          stopWindowPreloader();
          return messageError({title: response.data.message});
        }

        this.orderHandler.updateOrderInfo();
      });
  }
}

export default ManageItemsInBasket;
