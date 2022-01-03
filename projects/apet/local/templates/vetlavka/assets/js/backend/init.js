import authHandler from './auth'
import metrics from './metrics'
import LazyLoad from "./lazy-load";
import inputRating from "./catalog/input-rating";
import catalogFilter from "./catalog/catalog-filter";
import catalogCategory from "./catalog/catalog-category";
import formSender from "./form-sender";
import updateUserPhoto from "./personal/update-user-photo";
import favorites from "./personal/favorites";
import subscribe from "./personal/subscribe";
import profiles from "./personal/profiles";
import addToCard from "./catalog/add-to-card";
import orderHandler from "./order/index";
import comparison from "./personal/comparison";
import switchSearchBrands from "./brands/switch-search-brands";
import timer from "./home/timer";
import alphabet from "./catalog/catalog-alphabet";
import switchSearchInstruct from "./instructions/switch-search-instruction";
import shareSocial from "./catalog/share-social";
import Counter from "./catalog/catalog-counter";
import updateUserPassword from "./personal/update-user-password";
import catalogAutoLoad from "./catalog/catalog-auto-load";
import catalogSyncingBrand from "./catalog/catalog-syncing-brand";

function initBackendHandlers() {
  /**
   * Синхронизация брендов с фильтром
   */
  catalogSyncingBrand.init();

  /**
   * Плагинация на скролл
   */
  catalogAutoLoad.init();

  /**
   * Авторизация / Регистрация
   */
  authHandler.init();

  /**
   * Обработка метрик
   */
  metrics.init();

  /**
   * Управление процессом оформления заказа
   */
  window.orderHandler = orderHandler.init();

  $(document).on("click", ".js-launch-preloader", function () {
    launchWindowPreloader();
  });

  $(".js-simple-pagination-wrapper").each(function () {
    new LazyLoad($(this));
  });

  /**
   * Рейтинг продукта
   */
  inputRating.init();

  /**
   * Фильтрация каталога
   */
  catalogFilter.init();

  /**
   * Фильтрация по категориям
   */
  catalogCategory.init();

  /**
   * Отзывы о товаре
   */
  formSender.init();

  /**
   * Изменение фото у пользователя
   */
  updateUserPhoto.init();

  /**
   * Добавление/Удаление избранного
   */
  favorites.init();

  /**
   * Подписка на рассылку
   */
  subscribe.init();

  /**
   * Профили пользователя
   */
  profiles.init();

  /**
   * Добавление в корзину
   */
  addToCard.init();

  /**
   * Добавление в сравнение
   */
  comparison.init();

  /**
   * Бреды
   */
  switchSearchBrands.init();

  /**
   * Таймер
   */
  timer.init();

  /**
   * Сортировка по букве
   */
  alphabet.init();

  /**
   * Обработка поиска элементов
   */
  switchSearchInstruct.init();

  /**
   * Поделиться по букве
   */

  shareSocial.init();

  /**
   * Обработка кол-во покупаемых продуктов
   */
  $(".js-counter").each(function () {
    new Counter($(this))
  })

  /**
   * Изменение пароля в личном кабинете
   */
  updateUserPassword.init()
}

export default initBackendHandlers
