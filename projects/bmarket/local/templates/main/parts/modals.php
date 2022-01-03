<div class="modals">
    <div id="message-modal" class="modal modal--message animated">
        <button type="button" class="modal__close js-close-modal">
            <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
            </svg>
        </button>
        <div class="title title--medium modal__title js-message-modal-title"></div>
        <div class="modal__text js-message-modal-description"></div>
    </div>

    <div id="error-modal" class="modal modal--message modal--error animated">
        <button type="button" class="modal__close js-close-modal">
            <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
            </svg>
        </button>
        <div class="title title--medium modal__title js-error-modal-title"></div>
        <div class="modal__text js-error-modal-description"></div>
    </div>

    <div id="success-modal" class="modal modal--message modal--success animated">
        <button type="button" class="modal__close js-close-modal">
            <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
            </svg>
        </button>
        <div class="title title--medium modal__title js-success-modal-title"></div>
        <div class="modal__text js-success-modal-description"></div>
    </div>

    <div id="modal-thanks" class="modal modal--thanks animated">
        <button type="button" class="modal__close js-close-modal">
            <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
            </svg>
        </button>
        <div class="modal__header">
            <div class="title title--medium modal__title">Спасибо!</div>
            <div class="modal__header-text">Вы успешно зарегистрированы</div>
        </div>
        <div class="modal__actions">
            <button type="button" class="btn btn--blue btn--big modal__btn-action js-close-modal">Продолжить покупки
            </button>
            <a href="/" class="btn btn--transparent-border btn--big modal__btn-action">Личный кабинет</a>
        </div>
    </div>

    <div id="product-added" class="modal modal--product-added animated">
        <button type="button" class="modal__close js-close-modal">
            <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
            </svg>
        </button>
        <div class="modal__main">
            <div class="title title--small modal__title">
                Товар добавлен в корзину
            </div>
            <div class="order-table order-table--modal">
                <table>
                    <tbody>
                    <tr>
                        <td class="order-table__td-first">
                            <div class="order-table__image">
                                <img src="<?= NO_IMAGE_SRC ?>"
                                     class="js-product-buy-image"/>
                            </div>
                        </td>
                        <td class="order-table__td-name">
                            <div class="order-table__title js-product-buy-name">
                            </div>
                            <br>
                            <form action="/api/personal/favorites.php" class="js-favorites-form">
                                <input type="hidden" name="PRODUCT_ID" class="js-product-buy-favorite-input">
                                <button type="submit" class="btn btn--purple-text js-product-buy-favorite-btn">
                                    <svg class="icon icon-like ">
                                        <use xlink:href="#like"></use>
                                    </svg>
                                    <span>Избранное</span>
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="prices">
                                <div class="price js-product-buy-price"></div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal__footer">
            <div class="modal__basket-info">
                <a href="/personal/cart/">
                    В корзине <span class="js-product-buy-count-basket-items"></span>
                </a>
                на сумму <span class="js-product-buy-basket-price"></span> <span class="rubl">i</span>
            </div>
            <div class="modal__actions">
                <button type="button" class="btn btn--transparent modal__btn-action js-close-modal">
                    Продолжить покупки
                </button>
                <a href="/personal/cart/" class="btn modal__btn-action">
                    Перейти в корзину
                </a>
            </div>
        </div>
    </div>

    <div id="product-notify" class="modal modal--product-notify animated">
        <button type="button" class="modal__close js-close-modal">
            <svg class="icon icon-close ">
                <use xlink:href="#close"></use>
            </svg>
        </button>
        <div class="modal__main">
            <div class="title title--small modal__title">
                Уведомить о поступлении товара
            </div>
            <div class="order-table order-table--modal">
                <table>
                    <tbody>
                    <tr>
                        <td class="order-table__td-first">
                            <div class="order-table__image">
                                <img src="<?= NO_IMAGE_SRC ?>"
                                     class="js-product-notify-image"/>
                            </div>
                        </td>
                        <td class="order-table__td-name">
                            <div class="order-table__title js-product-notify-name"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal__footer">
            <? global $USER; ?>
            <form action="/api/catalog/product-notify.php" class="js-form-send" data-reset-form="Y">
                <input type="hidden" name="PRODUCT_ID" value="" class="js-product-notify-id">
                <div class="input-group js-group-label">
                    <div class="input-group__wrapper">
                        <label class="input-group__label">Эл. почта</label>
                        <input name="EMAIL"
                               required
                               type="email"
                               value="<?= $USER->GetEmail() ?>"
                               class="input js-group-label__input">
                    </div>
                    <div class="input-group__error"></div>
                </div>
                <button type="submit" class="btn btn--transparent">
                    Уведомить о поступлении
                </button>
            </form>
        </div>
    </div>
</div>
