const payBonuses = {
  init(orderHandler) {
    this.orderHandler = orderHandler;
    this.$payInput = this.orderHandler.$form.find(
      '[name="PAY_CURRENT_ACCOUNT"]'
    );
    this.$payBtn = $(".js-pay-bonus");

    this.eventHandler();
  },

  eventHandler() {
    this.$payBtn.on("click", () => {
      launchWindowPreloader();
      this.toggleApplyBonusPay();
    });
  },

  toggleApplyBonusPay() {
    this.$payInput.val(this.isPay() ? "N" : "Y");
    this.updatePayBtn();

    this.orderHandler.updateOrderInfo();
  },

  updatePayBtn() {
    if (this.isPay())
      this.$payBtn
        .addClass("btn-colorless")
        .removeClass("btn-orange")
        .text("Отменить");
    else
      this.$payBtn
        .addClass("btn-orange")
        .removeClass("btn-colorless")
        .text("Использовать");
  },

  isPay() {
    return this.$payInput.val() == "Y";
  }
};

export default payBonuses;
