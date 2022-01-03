/* eslint-disable no-new */
import addInputMaskPhone from './handlers/form-elements/phone-mask'
import CustomSelect from './handlers/form-elements/custom-select'
import InputLabels from './handlers/form-elements/input-label'

import { modalHandler, modalGallery } from './handlers/modals'

import Rating from './handlers/rating'
import Tabs from './handlers/tabs'
import Video from './handlers/video'
import alphabet from './handlers/alphabet'

import ToggleSlide from './handlers/effects/ToggleSlide'
import FixedSection from './handlers/effects/FixedSection'

import common from './handlers/common'
import sliders  from './handlers/sliders'
import SimpleBar from 'simplebar'

function initApp() {
  window.$body = $('.js-body')

  common.init()
  alphabet.init()
  FixedSection.init()

  sliders.init()

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
   * Инициализация video
   */
  $('.js-video').each(function () {
    new Video($(this))
  })

  /**
   * Кто не скачет тот лэйбл!
   * Лэйбл стартует кверху с центра input-group
   */
  $('.js-group-label').each(function () {
    new InputLabels($(this))
  })

  /**
   * Обработчик поведения лапкового рейтинга
   */
  $('.js-product-rating').each(function () {
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
}

export default initApp
