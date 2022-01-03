const manageCoupons = {
  init(orderHandler) {
    this.$form = $(".js-manage-coupons-form");
    this.$couponInput = this.$form.find('[name="coupon"]');
    this.$list = $(".js-manage-coupons-list");

    this.orderHandler = orderHandler;

    this.eventHandler();

    if (typeof window.__COUPON_LIST__ != undefined)
      this.renderCouponList(JSON.parse(window.__COUPON_LIST__));

    return this;
  },

  eventHandler() {
    let self = this;

    this.$form.on("submit", () => {
      this.applyCoupon();
      return false;
    });

    $(document).on("click", ".js-manage-coupons-remove", function () {
      self.removeCoupon($(this));
      return false;
    });
  },

  applyCoupon() {
    let coupon = this.$couponInput.val();
    this.orderHandler.addCoupon(coupon);
    this.$form[0].reset();
  },

  removeCoupon($btn) {
    let coupon = $btn.data("coupon");
    this.orderHandler.removeCoupon(coupon);
    $btn.closest(".js-manage-coupons-item").remove();
  },

  renderCouponList(list = []) {
    let html = "";

    list.forEach(coupon => {
      html += this.getCouponTemplate(coupon);
    });

    this.$list.html(html);
  },

  getCouponTemplate(coupon) {
    let applyClass =
      coupon.JS_STATUS == "APPLIED" ? "coupon-item--apply" : "";

    return `<div class="js-manage-coupons-item coupon-item ${applyClass}">
                    <div class="coupon-item__value">${coupon.COUPON} </div>
                    <button class="coupon-item__remove js-manage-coupons-remove"
                        data-coupon="${coupon.COUPON}">
                        <svg class="icon icon-46 ">
                            <use xlink:href="#46"></use>
                        </svg>
                    </button>
                </div>`;
  }
};

export default manageCoupons;
