import choiceWarehouse  from "./choice-warehouse";
import ManageItemsInBasket  from "./manage-items-in-basket";

let orderHandler = {
    init() {
        if ($(".js-order-registration").length == 0) return;

        this.$form = $(document).find('[name="ORDER_FORM"]');
        this.eventHandler();

        return this;
    },

    eventHandler() {
        let self = this;

        $(document).on("click", ".js-order-auth-alert-close", () => {
            $(".js-order-auth-alert").slideUp(300);
        });

        $(document).on("click", ".js-order-save", event => {
            this.saveOrder();
        });

        $(".js-manage-basket-item").each(function() {
            new ManageItemsInBasket($(this), self);
        });

        //this.manageCoupons = manageCoupons.init(this);

        //payBonuses.init(this);

        this.choiceWarehouse = choiceWarehouse.init(this);
        this.choiceWarehouse.renderStorageArea(window.OrderAjax.result);
    },

    saveOrder(event) {
        window.OrderAjax.clickOrderSaveAction(event);
    },

    updateOrderInfo() {
        window.OrderAjax.BXFormPosting = true;
        window.OrderAjax.sendRequest();
    },

    addCoupon(coupon) {
        window.OrderAjax.sendRequest("enterCoupon", coupon);
    },

    removeCoupon(coupon) {
        window.OrderAjax.sendRequest("removeCoupon", coupon);
    },

    updateRelatedInformation(result) {
        if (typeof result == "string")
            return window.OrderAjax.sendRequest("refreshOrderAjax");

        //this.manageCoupons.renderCouponList(result.order.COUPON_LIST);
        this.choiceWarehouse.renderStorageArea(result.order);
    }
};

export default orderHandler
