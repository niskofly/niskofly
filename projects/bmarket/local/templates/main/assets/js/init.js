/* eslint-disable no-undef */
/* eslint-disable no-new */
import addInputMaskPhone from './handlers/form-elements/phone-mask'
import CustomSelect from './handlers/form-elements/custom-select'
import InputLabels from './handlers/form-elements/input-label'

import formSender from './handlers/form-sender'
import { modalHandler, modalGallery } from './handlers/modals'

import Rating from './handlers/rating'
import Tabs from './handlers/tabs'

import ToggleSlide from './handlers/effects/ToggleSlide'
import FixedSection from './handlers/effects/FixedSection'

import common from './handlers/common'
import catalog from './handlers/catalog'
import filter from './handlers/filter'
import mobileMenu from './handlers/mobile-menu'
import { sliders } from './handlers/sliders'
import SimpleBar from 'simplebar'

import metrics from './handlers/metrics'

function initApp() {
  window.$body = $('.js-body')

  common.init()
  FixedSection.init()

  sliders.init()

  /**
   * Инициализация каталога
   */
  catalog.init()

  /**
   * Инициализация мобильного меню
   */
  mobileMenu.init()

  /**
   * Инициализация фильтра в каталоге(мобильная версия)
   */
  filter.init()

  /**
   *  Добавление масок к номерам телефонов
   */
  addInputMaskPhone()

  /**
   * Инициализация кастомного скролбара
   */
  $('.js-custom-bar').each(function () {
    new SimpleBar($(this)[0])
  })

  /**
   * Кто не скачет тот лэйбл!
   * Лэйбл стартует кверху с центра input-group
   */
  $('.js-group-label').each(function () {
    new InputLabels($(this))
  })

  window.InputLabels = InputLabels

  /**
   * Обработчик поведения лапкового рейтинга
   */
  $('.js-rating').each(function () {
    new Rating($(this))
  })

  /**
   * Обработчик поведение списков выбора
   */
  $('.js-custom-select').each(function () {
    new CustomSelect($(this))
  })

  /**
   * Инициализация для показать/скрыть контент
   */
  $('.js-toggle-slide').each(function () {
    new ToggleSlide($(this))
  })

  /**
   * Обработчик отправки форм
   */
  formSender.init()

  /**
   * Инициализация модальных окон
   */
  modalHandler.init()

  /**
   * Инициализация модальных окон для просмотра фото
   */
  modalGallery.init()

  /**
   * Инициализация табов
   */
  $('.js-tabs').each(function () {
    new Tabs($(this))
  })

  /**
   * Инициализация тоглов
   */
  $('.js-toggle-element').each(function () {
    new ToggleElement($(this))
  })

  /**
   * Запустить обработчик отвечающий
   * за обработку целей метрик (yaCounter, ga)
   */
  window.metrics = metrics.init()
}

export default initApp
