/* eslint-disable no-new */
import './handlers/custom'
import common from './handlers/common'

import addInputMaskPhone from './handlers/form-elements/phone-mask'
import CustomSelect from './handlers/form-elements/custom-select'
import MultipleCustomSelect from './handlers/form-elements/multiple-custom-select'
import InputFiles from './handlers/form-elements/input-files'

import formSender from './handlers/form-sender'
import { modalHandler, modalGallery } from './handlers/modals'

import Tabs from './handlers/tabs'
import Timer from './handlers/Timer'
import ToggleElement from './handlers/toggle-element'

import FixedSection from './handlers/effects/FixedSection'
import FormTotalCheck from './handlers/form-elements/form-total'

import {
  initSliders,
  AnimalSlider,
  OfferSlider,
  NutrionSlider,
  HeaderSlider,
} from './handlers/sliders'

import initMapHandlers from './handlers/map'
import filter from './handlers/filter'

function initApp() {
  window.$body = $('.js-body')

  common.init()

  $('.cart-total').each(function () {
    new FormTotalCheck($(this))
  })

  /**
   *  Добавление масок к номерам телефонов
   */
  addInputMaskPhone()

  FixedSection.init()

  /**
   * Обработчик для таймера
   */
  $('.js-timer').each(function() {
    new Timer($(this))
  })

  /**
   * Обработчик поведение кастомных списков выбора файлов
   */
  $('.js-input-files').each(function() {
    new InputFiles($(this))
  })

  /**
   * Обработчик поведение списков выбора
   */
  $('.js-custom-select').each(function() {
    new CustomSelect($(this))
  })

  /**
   * Обработчик поведение множественных списков выбора
   */
  $('.js-custom-multiple-select').each(function() {
    new MultipleCustomSelect($(this))
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
  $('.js-tabs').each(function() {
    new Tabs($(this))
  })

  /**
   * Инициализация тоглов
   */
  $('.js-toggle-element').each(function() {
    new ToggleElement($(this))
  })

  initSliders()

  $('.js-animal-category__slider').each(function() {
    new AnimalSlider($(this))
  })

  $('.js-offer-slider').each(function() {
    new OfferSlider($(this))
  })

  $('.js-nutrion__slider').each(function() {
    new NutrionSlider($(this))
  })

  $('.js-header-brand-slider').each(function() {
    new HeaderSlider($(this))
  })

  /**
   * Инициализация карт
   * todo: Требует исправлений
   */
  initMapHandlers()

  /**
   * Инициализация фильтра
   */
  filter.init()
}

export default initApp
