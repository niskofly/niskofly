import addToCard from "./catalog/add-to-card";
import alphabet from "./catalog/alphabet";
import catalogFilter from "./catalog/catalog-filter"
import category from "./catalog/category";
import compare from "./catalog/compare";
import favorites from "./catalog/favorites";
import shareSocial from "./catalog/share-social";
import Counter from "./catalog/counter";

import orderHandler from "./order/index"

import profiles from "./personal/profiles";
import subscribe from "./personal/subscriptions";
import updateUserPassword from "./personal/update-user-password";
import updateUserPhoto from "./personal/update-user-photo";

import authHandler from "./auth"
import formSender from "./form-sender"
import LazyLoad from "./lazy-load"
import storageMap from "./storage-map"

function initBackendHandlers() {

  $(".js-counter").each(function () {
    new Counter($(this))
  })

  /**
   * Обработка сортировки по первой букве
   */
  category.init()

  /**
   * Обработка сортировки по первой букве
   */
  alphabet.init()

  /**
   * Изменение пароля пользователя
   */
  updateUserPassword.init()

  /**
   * Профили покупателя
   */
  profiles.init()

  /**
   * Обработка модального окна поделиться
   */
  shareSocial.init()


  /**
   * Избранные товары
   */
  favorites.init()

  /**
   * Добавление товара в корзину
   */
  addToCard.init()


  orderHandler.init()

  /**
   * Управление сравнением
   */
  compare.init()

  /**
   * Авторизация / Регистрация
   */
  authHandler.init()

  /**
   * Обновление фото пользователя в личном кабинете
   */
  updateUserPhoto.init()

  /**
   * Управление подписками пользователя
   */
  subscribe.init()

  /**
   * Управление фильтром каталога товаров
   */
  catalogFilter.init()

  /**
   * Управление отправкой форм
   */
  formSender.init()

  $(document).on("click", ".js-launch-preloader", function () {
    launchWindowPreloader()
  })

  $(".js-simple-pagination-wrapper").each(function () {
    new LazyLoad($(this))
  })

  /**
   * Вывод складов на странице доставка и оплата
   */
  storageMap.init()
}

export default initBackendHandlers
