;(function() {
  'use strict'

  var initParent = BX.Sale.OrderAjaxComponent.init,
    getBlockFooterParent = BX.Sale.OrderAjaxComponent.getBlockFooter,
    editOrderParent = BX.Sale.OrderAjaxComponent.editOrder

  BX.namespace('BX.Sale.OrderAjaxComponentExt')
  BX.Sale.OrderAjaxComponentExt = BX.Sale.OrderAjaxComponent

  /**
   * Вызываем родительский init, следом прибиваем ссылки «изменить» у всех блоков.
   * @param parameters
   * @returns {BX.Sale.OrderAjaxComponentExt}
   */
  BX.Sale.OrderAjaxComponentExt.init = function(parameters) {
    initParent.apply(this, arguments)

    var editSteps = this.orderBlockNode.querySelectorAll('.bx-soa-editstep'),
      i
    for (i in editSteps) {
      if (editSteps.hasOwnProperty(i)) {
        BX.remove(editSteps[i])
      }
    }

    var self = this
    document.querySelector('.js-order-submit-btn').addEventListener(
      'click',
      function() {
        self.sendRequest('saveOrderAjax')
      },
      false
    )

    /**
     * Обработка сошласия на обработку персональных данных
     */
    document.querySelector('.js-order-privacy-input').addEventListener(
      'change',
      function(event) {
        document.querySelector('.js-order-submit-btn').disabled = !event.target.checked
      },
      false
    )

    return this
  }

  /**
   * Прибиваем кнопки «Назад» и «Вперед» у блоков.
   * @param node
   */
  BX.Sale.OrderAjaxComponentExt.getBlockFooter = function(node) {
    var parentNodeSection = BX.findParent(node, { className: 'bx-soa-section' })

    getBlockFooterParent.apply(this, arguments)

    if (
      /bx-soa-auth|bx-soa-pickup|bx-soa-total|bx-soa-delivery|bx-soa-paysystem|bx-soa-region|bx-soa-order|bx-soa-properties|bx-soa-basket/.test(
        parentNodeSection.id
      )
    )
      BX.remove(parentNodeSection.querySelector('.bx-soa-more-btn '))
  }

  /**
   * Отменить скрытие секций
   * @param section
   * @param state
   * @returns {null}
   */
  BX.Sale.OrderAjaxComponentExt.changeVisibleSection = function(section, state) {
    return null
  }

  BX.Sale.OrderAjaxComponentExt.showByClick = function(event) {
    return null
  }

  /**
   * COUPONS
   */
  BX.Sale.OrderAjaxComponentExt.editCoupons = function(basketItemsNode) {
    var couponsList = this.getCouponsList(true),
      couponsLabel = this.getCouponsLabel(true),
      couponInput = BX.create('DIV', {
        props: { className: 'bx-soa-coupon-input input-group__wrapper' },
        children: [
          BX.create('LABEL', {
            props: { className: 'input-group__label' },
            text: 'Введите промокод',
          }),
          BX.create('INPUT', {
            props: {
              className: 'form-control bx-ios-fix input js-group-label__input',
              type: 'text',
            },
            events: {
              change: BX.delegate(function(event) {
                var newCoupon = BX.getEventTarget(event)
                if (newCoupon && newCoupon.value) {
                  this.sendRequest('enterCoupon', newCoupon.value)
                  newCoupon.value = ''
                }
              }, this),
            },
          }),
        ],
      }),
      couponInputGroup = BX.create('SPAN', {
        props: { className: 'input-group js-group-label' },
        children: [couponInput],
      }),
      couponsBlock = BX.create('DIV', {
        props: { className: 'bx-soa-coupon-block order-step__promo' },
        children: [
          couponInputGroup,
          BX.create('SPAN', { props: { className: 'bx-soa-coupon-item' }, children: couponsList }),
        ],
      })

    basketItemsNode.appendChild(
      BX.create('DIV', {
        props: { className: 'bx-soa-coupon' },
        children: [couponsLabel, couponsBlock],
      })
    )

    if (window.$ && window.InputLabels) new window.InputLabels($(couponInputGroup))
  }

  BX.Sale.OrderAjaxComponentExt.getCouponsLabel = function(active) {
    return BX.create('DIV', {
      props: { className: 'order-step__promo-title' },
      children: active
        ? [BX.create('LABEL', { html: this.params.MESS_USE_COUPON + ':' })]
        : [this.params.MESS_COUPON + ':'],
    })
  }
  /**
   * END COUPONS
   */

  /**
   * REGION AND USER TYPE
   */
  BX.Sale.OrderAjaxComponentExt.editRegionBlock = function(active) {
    if (!this.regionBlockNode || !this.regionHiddenBlockNode || !this.result.PERSON_TYPE) return

    this.editActiveRegionBlock(true)

    this.initialized.region = true
  }

  BX.Sale.OrderAjaxComponentExt.locationsCompletion = function() {
    var i, locationNode, clearButton, inputStep, inputSearch, arProperty, data, section

    this.locationsInitialized = true
    this.fixLocationsStyle(this.regionBlockNode, this.regionHiddenBlockNode)
    this.fixLocationsStyle(this.propsBlockNode, this.propsHiddenBlockNode)

    for (i in this.locations) {
      if (!this.locations.hasOwnProperty(i)) continue

      locationNode = this.orderBlockNode.querySelector('div[data-property-id-row="' + i + '"]')
      if (!locationNode) continue

      clearButton = locationNode.querySelector('div.bx-ui-sls-clear')
      inputStep = locationNode.querySelector('div.bx-ui-slst-pool')
      inputSearch = locationNode.querySelector('input.bx-ui-sls-fake[type=text]')

      locationNode.removeAttribute('style')
      this.bindValidation(i, locationNode)
      if (clearButton) {
        BX.bind(clearButton, 'click', function(e) {
          var target = e.target || e.srcElement,
            parent = BX.findParent(target, { tagName: 'DIV', className: 'form-group' }),
            locationInput

          if (parent) locationInput = parent.querySelector('input.bx-ui-sls-fake[type=text]')

          if (locationInput) BX.fireEvent(locationInput, 'keyup')
        })
      }

      if (!this.firstLoad && this.options.propertyValidation) {
        if (inputStep) {
          arProperty = this.validation.properties[i]
          data = this.getValidationData(arProperty, locationNode)
          section = BX.findParent(locationNode, { className: 'bx-soa-section' })

          if (section && section.getAttribute('data-visited') == 'true') this.isValidProperty(data)
        }

        if (inputSearch) BX.fireEvent(inputSearch, 'keyup')
      }
    }

    if (
      this.firstLoad &&
      this.result.IS_AUTHORIZED &&
      typeof this.result.LAST_ORDER_DATA.FAIL === 'undefined'
    ) {
      this.showActualBlock()
    } else if (!this.result.SHOW_AUTH) {
      this.changeVisibleContent()
    }

    this.checkNotifications()

    if (this.activeSectionId !== this.regionBlockNode.id && false)
      this.editFadeRegionContent(this.regionBlockNode.querySelector('.bx-soa-section-content'))

    if (this.activeSectionId != this.propsBlockNode.id)
      this.editFadePropsContent(this.propsBlockNode.querySelector('.bx-soa-section-content'))
  }

  BX.Sale.OrderAjaxComponentExt.getPersonTypeControl = function(node) {
    if (!this.result.PERSON_TYPE) return

    this.result.PERSON_TYPE = this.getPersonTypeSortedArray(this.result.PERSON_TYPE)

    var personTypesCount = this.result.PERSON_TYPE.length,
      currentType,
      oldPersonTypeId,
      i,
      input,
      options = [],
      label,
      inputs

    inputs = BX.create('DIV', {
      props: { className: 'input-groups input-groups--order-person-type' },
    })

    for (i in this.result.PERSON_TYPE) {
      if (this.result.PERSON_TYPE.hasOwnProperty(i)) {
        currentType = this.result.PERSON_TYPE[i]
        label = BX.create('LABEL', {
          props: { className: 'radio-round' },
          events: { change: BX.proxy(this.sendRequest, this) },
          children: [
            BX.create('INPUT', {
              props: {
                type: 'radio',
                name: 'PERSON_TYPE',
                value: currentType.ID,
                className: 'radio-round__input',
              },
              attrs: { checked: currentType.CHECKED == 'Y' },
            }),
            BX.create('SPAN', {
              props: { className: 'radio-round__shape' },
              children: [
                BX.create('SPAN', {
                  props: { className: 'radio-round__dot' },
                }),
              ],
            }),
            BX.create('SPAN', {
              props: { className: 'radio-round__label' },
              text: currentType.NAME,
            }),
          ],
        })

        inputs.appendChild(
          BX.create('DIV', { props: { className: 'input-group' }, children: [label] })
        )

        if (currentType.CHECKED == 'Y') oldPersonTypeId = currentType.ID
      }
    }
    this.regionBlockNotEmpty = true

    node.appendChild(inputs)

    if (oldPersonTypeId) {
      node.appendChild(
        BX.create('INPUT', {
          props: {
            type: 'hidden',
            name: 'PERSON_TYPE_OLD',
            value: oldPersonTypeId,
          },
        })
      )
    }
  }

  BX.Sale.OrderAjaxComponentExt.getDeliveryLocationInput = function(node) {
    var currentProperty,
      locationId,
      altId,
      location,
      k,
      altProperty,
      labelHtml,
      currentLocation,
      insertedLoc,
      labelTextHtml,
      label,
      input,
      altNode

    for (k in this.result.ORDER_PROP.properties) {
      if (this.result.ORDER_PROP.properties.hasOwnProperty(k)) {
        currentProperty = this.result.ORDER_PROP.properties[k]
        if (currentProperty.IS_LOCATION == 'Y') {
          locationId = currentProperty.ID
          altId = parseInt(currentProperty.INPUT_FIELD_LOCATION)
          break
        }
      }
    }

    location = this.locations[locationId]
    if (location && location[0] && location[0].output) {
      this.regionBlockNotEmpty = true

      labelHtml =
        '<label class="bx-soa-custom-label" for="soa-property-' +
        parseInt(locationId) +
        '">' +
        (currentProperty.REQUIRED == 'Y'
          ? '<span class="bx-authform-starrequired">*</span> '
          : '') +
        BX.util.htmlspecialchars(currentProperty.NAME) +
        (currentProperty.DESCRIPTION.length
          ? ' <small>(' + BX.util.htmlspecialchars(currentProperty.DESCRIPTION) + ')</small>'
          : '') +
        '</label>'

      currentLocation = location[0].output
      insertedLoc = BX.create('DIV', {
        attrs: { 'data-property-id-row': locationId },
        props: { className: 'form-group input-group  bx-soa-location-input-container' },
        style: { visibility: 'hidden' },
        html: currentLocation.HTML,
      })
      node.appendChild(insertedLoc)
      node.appendChild(
        BX.create('INPUT', {
          props: {
            type: 'hidden',
            name: 'RECENT_DELIVERY_VALUE',
            value: location[0].lastValue,
          },
        })
      )

      for (k in currentLocation.SCRIPT)
        if (currentLocation.SCRIPT.hasOwnProperty(k)) BX.evalGlobal(currentLocation.SCRIPT[k].JS)
    }

    if (location && location[0] && location[0].showAlt && altId > 0) {
      for (k in this.result.ORDER_PROP.properties) {
        if (parseInt(this.result.ORDER_PROP.properties[k].ID) == altId) {
          altProperty = this.result.ORDER_PROP.properties[k]
          break
        }
      }
    }

    if (altProperty) {
      altNode = BX.create('DIV', {
        attrs: { 'data-property-id-row': altProperty.ID },
        props: { className: 'bx-soa-location-input-container input-group__wrapper' },
      })

      labelTextHtml = altProperty.NAME
      labelTextHtml += altProperty.REQUIRED == 'Y' ? '*' : ''

      label = BX.create('LABEL', {
        attrs: { for: 'altProperty' },
        props: { className: 'bx-soa-custom-label input-group__label' },
        html: labelTextHtml,
      })

      input = BX.create('INPUT', {
        props: {
          id: 'altProperty',
          type: 'text',
          placeholder: altProperty.DESCRIPTION,
          autocomplete: 'city',
          className: 'form-control bx-soa-customer-input bx-ios-fix input js-group-label__input',
          name: 'ORDER_PROP_' + altProperty.ID,
          value: altProperty.VALUE,
        },
      })

      altNode.appendChild(label)
      altNode.appendChild(input)
      altNode.appendChild(
        BX.create('DIV', {
          props: { className: 'input-group__error' },
        })
      )

      var propsItemNodeWrapper = BX.create('DIV', {
        props: { className: 'input-group input-group--alter-city js-group-label' },
        children: [altNode],
      })

      node.appendChild(propsItemNodeWrapper)

      this.bindValidation(altProperty.ID, altNode)

      if (window.$ && window.InputLabels)
        setTimeout(function() {
          new window.InputLabels($(propsItemNodeWrapper))
        }, 100)
    }

    this.getZipLocationInput(node)

    if (location && location[0]) {
      node.appendChild(
        BX.create('DIV', {
          props: { className: 'bx-soa-reference order-location-notification' },
          html: this.params.MESS_REGION_REFERENCE,
        })
      )
    }
  }

  BX.Sale.OrderAjaxComponentExt.getZipLocationInput = function(node) {
    var zipProperty, i, propsItemNode, labelTextHtml, label, input

    for (i in this.result.ORDER_PROP.properties) {
      if (
        this.result.ORDER_PROP.properties.hasOwnProperty(i) &&
        this.result.ORDER_PROP.properties[i].IS_ZIP == 'Y'
      ) {
        zipProperty = this.result.ORDER_PROP.properties[i]
        break
      }
    }

    if (zipProperty) {
      this.regionBlockNotEmpty = true

      propsItemNode = BX.create('DIV', {
        props: { className: 'bx-soa-location-input-container input-group__wrapper' },
      })
      propsItemNode.setAttribute('data-property-id-row', zipProperty.ID)

      labelTextHtml = zipProperty.NAME
      labelTextHtml += zipProperty.REQUIRED == 'Y' ? '*' : ''

      label = BX.create('LABEL', {
        attrs: { for: 'zipProperty' },
        props: { className: 'bx-soa-custom-label input-group__label' },
        html: labelTextHtml,
      })
      input = BX.create('INPUT', {
        props: {
          id: 'zipProperty',
          type: 'text',
          placeholder: zipProperty.DESCRIPTION,
          autocomplete: 'zip',
          className: 'form-control bx-soa-customer-input bx-ios-fix input js-group-label__input',
          name: 'ORDER_PROP_' + zipProperty.ID,
          value: zipProperty.VALUE,
        },
      })

      propsItemNode.appendChild(label)
      propsItemNode.appendChild(input)
      propsItemNode.appendChild(
        BX.create('DIV', {
          props: { className: 'input-group__error' },
        })
      )

      var propsItemNodeWrapper = BX.create('DIV', {
        props: { className: 'input-group input-group--order-zip js-group-label' },
        children: [propsItemNode],
      })
      node.appendChild(propsItemNodeWrapper)
      node.appendChild(
        BX.create('input', {
          props: {
            id: 'ZIP_PROPERTY_CHANGED',
            name: 'ZIP_PROPERTY_CHANGED',
            type: 'hidden',
            value: this.result.ZIP_PROPERTY_CHANGED || 'N',
          },
        })
      )

      this.bindValidation(zipProperty.ID, propsItemNode)

      if (window.$ && window.InputLabels) new window.InputLabels($(propsItemNodeWrapper))
    }
  }
  /**
   * END REGION AND USER TYPE
   */

  /**
   * DELIVERY
   */
  BX.Sale.OrderAjaxComponentExt.editDeliveryBlock = function(active) {
    if (!this.deliveryBlockNode || !this.deliveryHiddenBlockNode || !this.result.DELIVERY) return

    this.editActiveDeliveryBlock(true)
    this.checkPickUpShow()
    this.initialized.delivery = true
  }

  BX.Sale.OrderAjaxComponentExt.editActiveDeliveryBlock = function(activeNodeMode) {
    var node = activeNodeMode ? this.deliveryBlockNode : this.deliveryHiddenBlockNode,
      deliveryContent,
      deliveryNode

    deliveryContent = node.querySelector('.bx-soa-section-content')
    if (!deliveryContent) {
      deliveryContent = this.getNewContainer()
      node.appendChild(deliveryContent)
    } else BX.cleanNode(deliveryContent)

    this.getErrorContainer(deliveryContent)

    deliveryNode = BX.create('DIV', { props: { className: 'bx-soa-pp order-step__delivery' } })
    this.editDeliveryItems(deliveryNode)
    deliveryContent.appendChild(deliveryNode)
    this.editDeliveryInfo(deliveryNode)

    this.getBlockFooter(deliveryContent)
  }

  BX.Sale.OrderAjaxComponentExt.editDeliveryItems = function(deliveryNode) {
    if (!this.result.DELIVERY || this.result.DELIVERY.length <= 0) return

    var deliveryItemsContainer = BX.create('DIV', {
        props: { className: 'input-groups bx-soa-pp-item-container order-step__delivery-types' },
      }),
      deliveryItemNode,
      k

    for (k = 0; k < this.deliveryPagination.currentPage.length; k++) {
      deliveryItemNode = this.createDeliveryItem(this.deliveryPagination.currentPage[k])
      deliveryItemsContainer.appendChild(deliveryItemNode)
    }

    if (this.deliveryPagination.show) this.showPagination('delivery', deliveryItemsContainer)

    deliveryNode.appendChild(deliveryItemsContainer)
  }

  BX.Sale.OrderAjaxComponentExt.createDeliveryItem = function(item) {
    var checked = item.CHECKED == 'Y',
      deliveryId = parseInt(item.ID),
      labelNodes,
      deliveryCached = this.deliveryCachedInfo[deliveryId],
      label,
      title,
      itemNode

    labelNodes = [
      BX.create('INPUT', {
        props: {
          id: 'ID_DELIVERY_ID_' + deliveryId,
          name: 'DELIVERY_ID',
          type: 'checkbox',
          className: '',
          value: deliveryId,
          checked: checked,
        },
      }),
      BX.create('SPAN', {
        props: { className: 'radiobutton__view' },
        children: [
          BX.create('SPAN', {
            props: { className: 'icon' },
          }),
        ],
      }),
      BX.create('SPAN', {
        props: { className: 'radiobutton__text' },
        text: this.params.SHOW_DELIVERY_PARENT_NAMES != 'N' ? item.NAME : item.OWN_NAME,
      }),
    ]

    label = BX.create('DIV', {
      props: {
        className:
          'radiobutton' +
          (item.CALCULATE_ERRORS || (deliveryCached && deliveryCached.CALCULATE_ERRORS)
            ? ' bx-bd-waring'
            : ''),
      },
      children: labelNodes,
    })

    itemNode = BX.create('DIV', {
      props: { className: 'bx-soa-pp-company input-group' },
      children: [label, title],
      events: { click: BX.proxy(this.selectDelivery, this) },
    })

    checked && BX.addClass(itemNode, 'bx-selected')

    if (checked && this.result.LAST_ORDER_DATA.PICK_UP) this.lastSelectedDelivery = deliveryId

    return itemNode
  }

  BX.Sale.OrderAjaxComponentExt.selectDelivery = function(event) {
    if (!this.orderBlockNode) return

    var target = event.target || event.srcElement,
      actionSection = BX.hasClass(target, 'bx-soa-pp-company')
        ? target
        : BX.findParent(target, { className: 'bx-soa-pp-company' }),
      selectedSection = this.deliveryBlockNode.querySelector('.bx-soa-pp-company.bx-selected'),
      actionInput,
      selectedInput,
      oldInput = document.querySelector('[name="DELIVERY_ID_OLD"]')

    if (oldInput) oldInput.value = document.querySelector('[name="DELIVERY_ID"]:checked').value

    if (BX.hasClass(actionSection, 'bx-selected')) return BX.PreventDefault(event)

    if (actionSection) {
      actionInput = actionSection.querySelector('input[type=checkbox]')
      BX.addClass(actionSection, 'bx-selected')
      actionInput.checked = true
    }
    if (selectedSection) {
      selectedInput = selectedSection.querySelector('input[type=checkbox]')
      BX.removeClass(selectedSection, 'bx-selected')
      selectedInput.checked = false
    }

    this.sendRequest()
  }

  BX.Sale.OrderAjaxComponentExt.editDeliveryInfo = function(deliveryNode) {
    if (!this.result.DELIVERY) return

    var deliveryInfoContainer,
      currentDelivery,
      name,
      price,
      period,
      clear,
      infoList,
      extraServices,
      extraServicesNode

    BX.cleanNode(deliveryInfoContainer)
    currentDelivery = this.getSelectedDelivery()

    name =
      this.params.SHOW_DELIVERY_PARENT_NAMES != 'N'
        ? currentDelivery.NAME
        : currentDelivery.OWN_NAME

    if (currentDelivery.PRICE >= 0) {
      var priceValue = this.getDeliveryPriceNodes(currentDelivery)
      price = BX.create('div', {
        props: { className: 'order-step__card-price' },
        children: priceValue == '0 &#8381;' ? 'Бесплатно' : priceValue,
      })
    }

    if (currentDelivery.PERIOD_TEXT && currentDelivery.PERIOD_TEXT.length) {
      period = BX.create('DIV', {
        props: { className: 'order-step__card-time' },
        html: currentDelivery.PERIOD_TEXT,
      })
    }

    deliveryInfoContainer = BX.create('DIV', {
      props: { className: 'order-step__card' },
      children: [
        BX.create('DIV', {
          props: { className: 'order-step__card-title' },
          html: currentDelivery.DESCRIPTION,
        }),
        currentDelivery.CALCULATE_DESCRIPTION
          ? BX.create('DIV', {
              props: { className: 'cart-note__text' },
              html: currentDelivery.CALCULATE_DESCRIPTION,
            })
          : null,
        period,
        price,
      ],
    })

    extraServices = this.getDeliveryExtraServices(currentDelivery)

    if (extraServices.length) {
      extraServicesNode = BX.create('DIV', {
        props: { className: 'bx-soa-pp-company-block' },
        children: extraServices,
      })
    }

    deliveryInfoContainer.appendChild(
      BX.create('DIV', {
        props: { className: 'bx-soa-pp-company' },
        children: [extraServicesNode],
      })
    )

    deliveryNode.appendChild(
      BX.create('DIV', {
        props: { className: 'order-step__delivery-cards active ' },
        children: [deliveryInfoContainer],
      })
    )

    if (this.params.DELIVERY_NO_AJAX != 'Y')
      this.deliveryCachedInfo[currentDelivery.ID] = currentDelivery
  }
  /**
   * END DELIVERY
   */

  /**
   * PICK UP
   */
  BX.Sale.OrderAjaxComponentExt.checkPickUpShow = function() {
    var currentDelivery = this.getSelectedDelivery(),
      name,
      stores

    if (currentDelivery && currentDelivery.STORE && currentDelivery.STORE.length)
      stores = this.getPickUpInfoArray(currentDelivery.STORE)

    if (stores && stores.length) {
      name =
        this.params.SHOW_DELIVERY_PARENT_NAMES != 'N'
          ? currentDelivery.NAME
          : currentDelivery.OWN_NAME
      currentDelivery.STORE_MAIN = currentDelivery.STORE
      this.activatePickUp(name)
    } else {
      this.deactivatePickUp()
    }
  }

  BX.Sale.OrderAjaxComponentExt.editPickUpBlock = function(active) {
    if (
      !this.pickUpBlockNode ||
      !this.pickUpHiddenBlockNode ||
      !BX.hasClass(this.pickUpBlockNode, 'bx-active') ||
      !this.result.DELIVERY
    )
      return

    this.initialized.pickup = false

    this.editActivePickUpBlock(true)

    this.initialized.pickup = true
  }

  BX.Sale.OrderAjaxComponentExt.pickUpFinalAction = function() {
    return null

    var selectedDelivery = this.getSelectedDelivery(),
      deliveryChanged

    if (selectedDelivery) {
      deliveryChanged = this.lastSelectedDelivery !== parseInt(selectedDelivery.ID)
      this.lastSelectedDelivery = parseInt(selectedDelivery.ID)
    }

    if (deliveryChanged && this.pickUpBlockNode.id !== this.activeSectionId) {
      if (this.pickUpBlockNode.id !== this.activeSectionId) {
        this.editFadePickUpContent(BX.lastChild(this.pickUpBlockNode))
      }

      BX.removeClass(this.pickUpBlockNode, 'bx-step-completed')
    }

    this.maps && this.maps.pickUpFinalAction()
  }

  BX.Sale.OrderAjaxComponentExt.editPickUpList = function(isNew) {
    if (!this.pickUpPagination.currentPage || !this.pickUpPagination.currentPage.length) return
    BX.remove(BX('pickUpLoader'))

    var pickUpList = BX.create('DIV', {
        props: {
          className: 'input-groups order-step__delivery-cards active bx-soa-pickup-list main',
        },
      }),
      buyerStoreInput = BX('BUYER_STORE'),
      selectedStore,
      container,
      i,
      found = false,
      recommendList,
      selectedDelivery,
      currentStore,
      storeNode

    if (buyerStoreInput) selectedStore = buyerStoreInput.value

    recommendList = this.pickUpBlockNode.querySelector('.bx-soa-pickup-list.recommend')
    if (!recommendList)
      recommendList = this.pickUpHiddenBlockNode.querySelector('.bx-soa-pickup-list.recommend')

    if (!recommendList || !recommendList.querySelector('.bx-soa-pickup-list-item.bx-selected')) {
      selectedDelivery = this.getSelectedDelivery()
      if (selectedDelivery && selectedDelivery.STORE) {
        for (i = 0; i < selectedDelivery.STORE.length; i++)
          if (selectedDelivery.STORE[i] == selectedStore) found = true
      }
    } else found = true

    for (i = 0; i < this.pickUpPagination.currentPage.length; i++) {
      currentStore = this.pickUpPagination.currentPage[i]

      if (currentStore.ID == selectedStore || parseInt(selectedStore) == 0 || !found) {
        selectedStore = buyerStoreInput.value = currentStore.ID
        found = true
      }

      storeNode = BX.create('DIV', {
        props: { className: 'input-group' },
        children: [
          this.createPickUpItem(currentStore, { selected: currentStore.ID == selectedStore }),
        ],
      })

      pickUpList.appendChild(storeNode)
    }

    if (!!isNew) {
      container = this.pickUpHiddenBlockNode.querySelector('.bx_soa_pickup>.col')
      if (!container) container = this.pickUpBlockNode.querySelector('.bx_soa_pickup>.col')

      container.appendChild(pickUpList)
    } else {
      container = this.pickUpBlockNode.querySelector('.bx-soa-pickup-list.main')
      BX.insertAfter(pickUpList, container)
      BX.remove(container)
    }

    this.pickUpPagination.show && this.showPagination('pickUp', pickUpList)
  }

  BX.Sale.OrderAjaxComponentExt.createPickUpItem = function(currentStore, options) {
    options = options || {}

    var html, storeNode

    html = this.getStoreInfoHtml(currentStore)
    storeNode = BX.create('LABEL', {
      props: { className: 'radiobutton bx-soa-pickup-list-item', id: 'store-' + currentStore.ID },
      children: [
        BX.create('SPAN', {
          props: { className: 'radiobutton__card' },
          children: [
            BX.create('SPAN', {
              props: { className: 'radiobutton__view' },
              children: [
                BX.create('SPAN', {
                  props: { className: 'icon' },
                }),
              ],
            }),
            BX.create('SPAN', {
              props: { className: 'radiobutton__text' },
              children: [
                BX.create('SPAN', {
                  props: { className: 'radiobutton__text-label' },
                  children: options.distance
                    ? [
                        BX.util.htmlspecialchars(currentStore.ADDRESS),
                        ' ( ~' + options.distance + ' ' + BX.message('SOA_DISTANCE_KM') + ' ) ',
                      ]
                    : [BX.util.htmlspecialchars(currentStore.ADDRESS)],
                }),
                BX.create('SPAN', {
                  props: { className: 'radiobutton__text-detail' },
                  html: html,
                }),
              ],
            }),
          ],
        }),
      ],
      events: {
        click: BX.delegate(function(event) {
          this.selectStore(event)
          this.clickNextAction(event)
        }, this),
      },
    })

    if (options.selected) BX.addClass(storeNode, 'bx-selected')

    return storeNode
  }
  /**
   * END PICK UP
   */

  /**
   * PAYMENT
   */
  BX.Sale.OrderAjaxComponentExt.editPaySystemBlock = function(active) {
    if (!this.paySystemBlockNode || !this.paySystemHiddenBlockNode || !this.result.PAY_SYSTEM)
      return

    this.editActivePaySystemBlock(true)
    this.initialized.paySystem = true
  }

  BX.Sale.OrderAjaxComponentExt.editActivePaySystemBlock = function(activeNodeMode) {
    var node = activeNodeMode ? this.paySystemBlockNode : this.paySystemHiddenBlockNode,
      paySystemContent,
      paySystemNode

    paySystemContent = node.querySelector('.bx-soa-section-content')
    if (!paySystemContent) {
      paySystemContent = this.getNewContainer()
      node.appendChild(paySystemContent)
    } else BX.cleanNode(paySystemContent)

    this.getErrorContainer(paySystemContent)
    paySystemNode = BX.create('DIV', { props: { className: 'bx-soa-pp form-cart__pay' } })
    this.editPaySystemItems(paySystemNode)
    paySystemContent.appendChild(paySystemNode)
    this.editPaySystemInfo(paySystemNode)

    if (this.params.SHOW_COUPONS_PAY_SYSTEM == 'Y') this.editCoupons(paySystemContent)

    this.getBlockFooter(paySystemContent)
  }

  BX.Sale.OrderAjaxComponentExt.editPaySystemItems = function(paySystemNode) {
    if (!this.result.PAY_SYSTEM || this.result.PAY_SYSTEM.length <= 0) return

    var paySystemItemsContainer = BX.create('DIV', {
        props: { className: 'input-groups bx-soa-pp-item-container order-step__payment' },
      }),
      paySystemItemNode,
      i

    for (i = 0; i < this.paySystemPagination.currentPage.length; i++) {
      paySystemItemNode = this.createPaySystemItem(this.paySystemPagination.currentPage[i])
      paySystemItemsContainer.appendChild(paySystemItemNode)
    }

    if (this.paySystemPagination.show) this.showPagination('paySystem', paySystemItemsContainer)

    paySystemNode.appendChild(paySystemItemsContainer)
  }

  BX.Sale.OrderAjaxComponentExt.createPaySystemItem = function(item) {
    var checked = item.CHECKED == 'Y',
      paySystemId = parseInt(item.ID),
      label,
      itemNode

    label = BX.create('LABEL', {
      props: { className: 'radiobutton' },
      children: [
        BX.create('INPUT', {
          props: {
            id: 'ID_PAY_SYSTEM_ID_' + paySystemId,
            name: 'PAY_SYSTEM_ID',
            type: 'radio',
            value: paySystemId,
            checked: checked,
          },
          events: {
            change: BX.proxy(this.selectPaySystem, this),
          },
        }),
        BX.create('SPAN', {
          props: { className: 'radiobutton__card' },
          children: [
            BX.create('SPAN', {
              props: { className: 'radiobutton__view' },
              children: [
                BX.create('SPAN', {
                  props: { className: 'icon' },
                }),
              ],
            }),
            BX.create('SPAN', {
              props: { className: 'radiobutton__text' },
              children: [
                BX.create('SPAN', {
                  props: { className: 'radiobutton__text-label' },
                  text: item.NAME,
                }),
                BX.create('SPAN', {
                  props: { className: 'radiobutton__text-detail' },
                  text: item.DESCRIPTION,
                }),
              ],
            }),
          ],
        }),
      ],
    })

    itemNode = BX.create('DIV', {
      props: { className: 'input-group' },
      children: [label],
    })

    if (checked) BX.addClass(itemNode, 'bx-selected')

    return itemNode
  }

  BX.Sale.OrderAjaxComponentExt.getInnerPaySystem = function() {
    if (
      !this.result.CURRENT_BUDGET_FORMATED ||
      !this.result.PAY_CURRENT_ACCOUNT ||
      !this.result.INNER_PAY_SYSTEM
    )
      return

    var accountOnly =
        this.params.ONLY_FULL_PAY_FROM_ACCOUNT && this.params.ONLY_FULL_PAY_FROM_ACCOUNT == 'Y',
      isSelected = this.result.PAY_CURRENT_ACCOUNT && this.result.PAY_CURRENT_ACCOUNT == 'Y',
      paySystem = this.result.INNER_PAY_SYSTEM,
      subTitle,
      title,
      input,
      card,
      hiddenInput,
      htmlString,
      innerPsDesc,
      itemNode

    if (this.params.SHOW_PAY_SYSTEM_INFO_NAME == 'Y') {
      subTitle = BX.create('SPAN', {
        props: { className: 'bx-soa-pp-company-subTitle checkbox__text-label' },
        text: paySystem.NAME,
      })
    }

    if (paySystem.DESCRIPTION && paySystem.DESCRIPTION.length) {
      title = BX.create('SPAN', {
        props: { className: 'bx-soa-pp-company-block' },
        children: [
          BX.create('SPAN', {
            props: { className: 'bx-soa-pp-company-desc checkbox__text' },
            html: paySystem.DESCRIPTION,
          }),
        ],
      })
    }

    hiddenInput = BX.create('INPUT', {
      props: {
        type: 'hidden',
        name: 'PAY_CURRENT_ACCOUNT',
        value: 'N',
      },
    })

    input = BX.create('INPUT', {
      props: {
        type: 'checkbox',
        className: 'bx-soa-pp-company-checkbox',
        name: 'PAY_CURRENT_ACCOUNT',
        value: 'Y',
        checked: isSelected,
      },
    })

    htmlString =
      '<span class="checkbox__text-detail">' +
      this.params.MESS_INNER_PS_BALANCE +
      '</span> <span class="user-points">' +
      this.result.CURRENT_BUDGET_FORMATED +
      '</span><br>' +
      (accountOnly ? BX.message('SOA_PAY_ACCOUNT3') : '')
    innerPsDesc = BX.create('SPAN', {
      props: { className: 'bx-soa-pp-company-desc checkbox__text' },
      children: [
        subTitle,
        BX.create('SPAN', {
          html: htmlString,
        }),
      ],
    })

    card = BX.create('SPAN', {
      props: { className: 'checkbox__card' },
      children: [
        BX.create('DIV', {
          props: { className: 'checkbox__view' },
          html: '<svg class="icon icon-check"><use xlink:href="#check"></use></svg>',
        }),
        title,
        innerPsDesc,
      ],
      events: {
        click: BX.proxy(this.selectPaySystem, this),
      },
    })

    itemNode = BX.create('LABEL', {
      props: {
        className:
          'bx-soa-pp-inner-ps checkbox checkbox--bonus' + (isSelected ? ' bx-selected' : ''),
      },
      children: [hiddenInput, input, card],
    })

    return itemNode
  }

  /**
   * END PAYMENT
   */

  /**
   * USER PROPERTIES
   */
  BX.Sale.OrderAjaxComponentExt.editPropsBlock = function(active) {
    if (!this.propsBlockNode || !this.propsHiddenBlockNode || !this.result.ORDER_PROP) return

    this.editActivePropsBlock(true)
    this.initialized.props = true
  }

  BX.Sale.OrderAjaxComponentExt.editFadePropsContent = function(node) {
    return null
  }

  BX.Sale.OrderAjaxComponentExt.editActivePropsBlock = function(activeNodeMode) {
    var node = activeNodeMode ? this.propsBlockNode : this.propsHiddenBlockNode,
      propsContent,
      propsNode,
      selectedDelivery,
      showPropMap = false,
      i,
      validationErrors

    propsContent = node.querySelector('.bx-soa-section-content')
    if (!propsContent) {
      propsContent = this.getNewContainer()
      node.appendChild(propsContent)
    } else BX.cleanNode(propsContent)

    this.getErrorContainer(propsContent)

    propsNode = BX.create('DIV', { props: { className: 'row' } })
    selectedDelivery = this.getSelectedDelivery()

    if (
      selectedDelivery &&
      this.params.SHOW_MAP_IN_PROPS === 'Y' &&
      this.params.SHOW_MAP_FOR_DELIVERIES &&
      this.params.SHOW_MAP_FOR_DELIVERIES.length
    ) {
      for (i = 0; i < this.params.SHOW_MAP_FOR_DELIVERIES.length; i++) {
        if (parseInt(selectedDelivery.ID) === parseInt(this.params.SHOW_MAP_FOR_DELIVERIES[i])) {
          showPropMap = true
          break
        }
      }
    }

    this.editPropsItems(propsNode)
    showPropMap && this.editPropsMap(propsNode)

    if (this.params.HIDE_ORDER_DESCRIPTION !== 'Y') {
      this.editPropsComment(propsNode)
    }

    propsContent.appendChild(propsNode)
    this.getBlockFooter(propsContent)

    if (this.propsBlockNode.getAttribute('data-visited') === 'true') {
      validationErrors = this.isValidPropertiesBlock(true)
      if (validationErrors.length) BX.addClass(this.propsBlockNode, 'bx-step-error')
      else BX.removeClass(this.propsBlockNode, 'bx-step-error')
    }
  }

  BX.Sale.OrderAjaxComponentExt.editPropsItems = function(propsNode) {
    if (!this.result.ORDER_PROP || !this.propertyCollection) return

    var propsItemsContainer = BX.create('DIV', {
        props: { className: 'input-groups order-step__personal' },
      }),
      group,
      property,
      groupIterator = this.propertyCollection.getGroupIterator(),
      propsIterator

    if (!propsItemsContainer)
      propsItemsContainer = this.propsBlockNode.querySelector('.col-sm-12.bx-soa-customer')

    while ((group = groupIterator())) {
      propsIterator = group.getIterator()
      while ((property = propsIterator())) {
        if (
          this.deliveryLocationInfo.loc == property.getId() ||
          this.deliveryLocationInfo.zip == property.getId() ||
          this.deliveryLocationInfo.city == property.getId()
        )
          continue

        this.getPropertyRowNode(property, propsItemsContainer, false)
      }
    }

    propsNode.appendChild(propsItemsContainer)

    if (window.initTimerId) clearInterval(window.initTimerId)
  }

  BX.Sale.OrderAjaxComponentExt.getPropertyRowNode = function(
    property,
    propsItemsContainer,
    disabled
  ) {
    var propsItemNode = BX.create('DIV'),
      textHtml = '',
      propertyType = property.getType() || '',
      propertyDesc = property.getDescription() || '',
      label

    if (disabled) {
      propsItemNode.innerHTML =
        '<strong>' + BX.util.htmlspecialchars(property.getName()) + ':</strong> '
    } else {
      BX.addClass(propsItemNode, 'input-group bx-soa-customer-field')
      if (['EMAIL', 'PHONE'].includes(property.getSettings().CODE))
        BX.addClass(propsItemNode, 'input-group--half')

      /**
       * Если не textarea
       */
      if (!property.getSettings().COLS) BX.addClass(propsItemNode, 'js-group-label')

      propsItemNode.setAttribute('data-property-id-row', property.getId())
    }

    switch (propertyType) {
      case 'LOCATION':
        this.insertLocationProperty(property, propsItemNode, disabled)
        break
      case 'DATE':
        this.insertDateProperty(property, propsItemNode, disabled)
        break
      case 'FILE':
        this.insertFileProperty(property, propsItemNode, disabled)
        break
      case 'STRING':
        this.insertStringProperty(property, propsItemNode, disabled)
        break
      case 'ENUM':
        this.insertEnumProperty(property, propsItemNode, disabled)
        break
      case 'Y/N':
        this.insertYNProperty(property, propsItemNode, disabled)
        break
      case 'NUMBER':
        this.insertNumberProperty(property, propsItemNode, disabled)
    }
    propsItemNode.appendChild(
      BX.create('DIV', {
        props: { className: 'input-group__error' },
      })
    )

    if (window.$ && $(propsItemNode).hasClass('js-group-label') && window.InputLabels)
      new window.InputLabels($(propsItemNode))
    propsItemsContainer.appendChild(propsItemNode)
  }

  BX.Sale.OrderAjaxComponentExt.insertStringProperty = function(property, propsItemNode, disabled) {
    var prop, inputs, values, i, propContainer

    if (disabled) {
      prop = this.propsHiddenBlockNode.querySelector(
        'div[data-property-id-row="' + property.getId() + '"]'
      )
      if (prop) {
        values = []
        inputs = prop.querySelectorAll('input[type=text]')
        if (inputs.length == 0) inputs = prop.querySelectorAll('textarea')

        if (inputs.length) {
          for (i = 0; i < inputs.length; i++) {
            if (inputs[i].value.length) values.push(inputs[i].value)
          }
        }

        propsItemNode.innerHTML += this.valuesToString(values)
      }
    } else {
      var label = BX.create({
        props: { className: 'input-group__label' },
        text: property.getName() + (property.isRequired() ? '*' : ''),
        tag: 'label',
      })

      propContainer = BX.create('DIV', {
        props: { className: 'soa-property-container input-group__wrapper' },
        children: [label],
      })
      property.appendTo(propContainer)
      propsItemNode.appendChild(propContainer)

      this.alterProperty(property.getSettings(), propContainer)
      this.bindValidation(property.getId(), propContainer)
    }
  }

  BX.Sale.OrderAjaxComponentExt.alterProperty = function(settings, propContainer) {
    var divs = BX.findChildren(propContainer, { tagName: 'DIV' }),
      i,
      textNode,
      inputs,
      del,
      add,
      placeholderText = '',
      fileInputs,
      accepts,
      fileTitles

    placeholderText += BX.util.htmlspecialchars(settings.NAME)
    if (settings.REQUIRED == 'Y') placeholderText += '*'

    settings.DESCRIPTION = placeholderText

    textNode = propContainer.querySelector('input[type=text]')
    if (!textNode) textNode = propContainer.querySelector('textarea')

    if (textNode) {
      textNode.id = 'soa-property-' + settings.ID
      if (settings.IS_ADDRESS == 'Y') textNode.setAttribute('autocomplete', 'address')

      if (settings.IS_EMAIL == 'Y') textNode.setAttribute('autocomplete', 'email')

      if (settings.IS_PAYER == 'Y') textNode.setAttribute('autocomplete', 'name')

      if (settings.IS_PHONE == 'Y') {
        textNode.setAttribute('autocomplete', 'tel')
        BX.addClass(textNode, 'js-input-phone')
      }

      if (settings.PATTERN && settings.PATTERN.length) textNode.removeAttribute('pattern')
    }

    inputs = propContainer.querySelectorAll('input[type=text]')
    for (i = 0; i < inputs.length; i++) {
      BX.addClass(inputs[i], 'input js-group-label__input')
    }

    inputs = propContainer.querySelectorAll('select')
    for (i = 0; i < inputs.length; i++) BX.addClass(inputs[i], 'form-control')

    inputs = propContainer.querySelectorAll('textarea')
    for (i = 0; i < inputs.length; i++) {
      inputs[i].placeholder = settings.DESCRIPTION
      BX.addClass(inputs[i], 'input input--textarea')
    }

    if (propContainer.querySelectorAll('textarea').length) {
      del = propContainer.querySelectorAll('label')
      for (i = 0; i < del.length; i++) BX.remove(del[i])
    }

    if (settings.TYPE == 'FILE') {
      if (settings.ACCEPT && settings.ACCEPT.length) {
        fileInputs = propContainer.querySelectorAll('input[type=file]')
        accepts = this.getFileAccepts(settings.ACCEPT)
        for (i = 0; i < fileInputs.length; i++) fileInputs[i].setAttribute('accept', accepts)
      }

      fileTitles = propContainer.querySelectorAll('a')
      for (i = 0; i < fileTitles.length; i++) {
        BX.bind(fileTitles[i], 'click', function(e) {
          var target = e.target || e.srcElement,
            fileInput = target && target.nextSibling && target.nextSibling.nextSibling

          if (fileInput) BX.fireEvent(fileInput, 'change')
        })
      }
    }

    add = propContainer.querySelectorAll('input[type=button]')
    for (i = 0; i < add.length; i++) {
      BX.addClass(add[i], 'btn btn-default btn-sm')

      if (settings.MULTIPLE == 'Y' && i == add.length - 1) continue

      if (settings.TYPE == 'FILE') {
        BX.prepend(add[i], add[i].parentNode)
        add[i].style.marginRight = '10px'
      }
    }

    if (add.length) {
      add = add[add.length - 1]
      BX.bind(
        add,
        'click',
        BX.delegate(function(e) {
          var target = e.target || e.srcElement,
            targetContainer = BX.findParent(target, {
              tagName: 'div',
              className: 'soa-property-container',
            }),
            del = targetContainer.querySelector('label'),
            add = targetContainer.querySelectorAll('input[type=button]'),
            textInputs = targetContainer.querySelectorAll('input[type=text]'),
            textAreas = targetContainer.querySelectorAll('textarea'),
            divs = BX.findChildren(targetContainer, { tagName: 'DIV' })

          var i, fileTitles, fileInputs, accepts

          if (divs && divs.length) {
            for (i = 0; i < divs.length; i++) {
              divs[i].style.margin = '5px 0'
            }
          }

          this.bindValidation(settings.ID, targetContainer)

          if (add.length && add[add.length - 2]) {
            BX.prepend(add[add.length - 2], add[add.length - 2].parentNode)
            add[add.length - 2].style.marginRight = '10px'
            BX.addClass(add[add.length - 2], 'btn btn-default btn-sm')
          }

          del && BX.remove(del)
          if (textInputs.length) {
            textInputs[textInputs.length - 1].placeholder = settings.DESCRIPTION
            BX.addClass(
              textInputs[textInputs.length - 1],
              'form-control bx-soa-customer-input bx-ios-fix'
            )
            if (settings.TYPE == 'DATE')
              this.alterDateProperty(settings, textInputs[textInputs.length - 1])

            if (settings.PATTERN && settings.PATTERN.length)
              textInputs[textInputs.length - 1].removeAttribute('pattern')
          }

          if (textAreas.length) {
            textAreas[textAreas.length - 1].placeholder = settings.DESCRIPTION
            BX.addClass(textAreas[textAreas.length - 1], 'form-control bx-ios-fix')
          }

          if (settings.TYPE == 'FILE') {
            if (settings.ACCEPT && settings.ACCEPT.length) {
              fileInputs = propContainer.querySelectorAll('input[type=file]')
              accepts = this.getFileAccepts(settings.ACCEPT)
              for (i = 0; i < fileInputs.length; i++) fileInputs[i].setAttribute('accept', accepts)
            }

            fileTitles = targetContainer.querySelectorAll('a')
            BX.bind(fileTitles[fileTitles.length - 1], 'click', function(e) {
              var target = e.target || e.srcElement,
                fileInput = target && target.nextSibling && target.nextSibling.nextSibling

              if (fileInput)
                setTimeout(function() {
                  BX.fireEvent(fileInput, 'change')
                }, 10)
            })
          }
        }, this)
      )
    }
  }

  BX.Sale.OrderAjaxComponentExt.editPropsComment = function(propsNode) {
    var propsCommentContainer, input, div

    input = BX.create('TEXTAREA', {
      props: {
        id: 'orderDescription',
        className: 'input input--textarea',
        name: 'ORDER_DESCRIPTION',
        placeholder: this.params.MESS_ORDER_DESC,
      },
      text: this.result.ORDER_DESCRIPTION ? this.result.ORDER_DESCRIPTION : '',
    })
    div = BX.create('DIV', {
      props: { className: 'input-group order-step__order-description' },
      children: [input],
    })
    propsNode.appendChild(div)
  }
  /**
   * END USER PROPERTIES
   */

  /**
   * SHOW ERORRS
   */
  BX.Sale.OrderAjaxComponentExt.showValidationResult = function(inputs, errors) {
    if (!inputs || !inputs.length || !errors) return

    var input0 = BX.type.isElementNode(inputs[0]) ? inputs[0] : inputs[0][0],
      formGroup = BX.findParent(input0, { tagName: 'DIV', className: 'input-group' }),
      inputDiv,
      i,
      errorArea = formGroup.querySelector('.input-group__error')

    errorArea = errorArea ? errorArea : formGroup.querySelector('.bx-ui-sls-error-message')
    for (i = 0; i < inputs.length; i++) {
      inputDiv = BX.findParent(inputs[i], { tagName: 'DIV', className: 'input-group' })
      if (errors[i] && errors[i].length) BX.addClass(inputDiv, 'input-group--error')
      else BX.removeClass(inputDiv, 'input-group--error')
    }

    if (errors.length) errorArea.innerHTML = errors.join('<br>')
    else errorArea.innerHTML = ''
  }

  BX.Sale.OrderAjaxComponentExt.isValidForm = function() {
    if (!this.options.propertyValidation) return true

    var regionErrors = this.isValidRegionBlock(),
      propsErrors = this.isValidPropertiesBlock(),
      navigated = false,
      tooltips,
      i

    if (regionErrors.length) {
      navigated = true
      this.animateScrollTo(this.regionBlockNode, 800, 50)
    }

    if (propsErrors.length && !navigated) {
      if (this.activeSectionId == this.propsBlockNode.id) {
        tooltips = this.propsBlockNode.querySelectorAll('div.tooltip')
        for (i = 0; i < tooltips.length; i++) {
          if (tooltips[i].getAttribute('data-state') == 'opened') {
            this.animateScrollTo(
              BX.findParent(tooltips[i], { className: 'form-group bx-soa-customer-field' }),
              800,
              50
            )
            break
          }
        }
      } else this.animateScrollTo(this.propsBlockNode, 800, 50)
    }

    if (regionErrors.length) {
      this.showError(this.regionBlockNode, regionErrors)
      BX.addClass(this.regionBlockNode, 'bx-step-error')
    }

    return !(regionErrors.length + propsErrors.length)
  }
  /**
   * END SHOW ERORRS
   */

  /**
   * REQUEST AND UPDATE RENDER DATA
   */
  BX.Sale.OrderAjaxComponentExt.sendRequest = function(action, actionData) {
    var form

    this.startLoader()

    this.firstLoad = false

    action = BX.type.isNotEmptyString(action) ? action : 'refreshOrderAjax'

    if (action === 'saveOrderAjax') {
      form = BX('bx-soa-order-form')
      if (form) {
        form.querySelector('input[type=hidden][name=sessid]').value = BX.bitrix_sessid()
      }

      BX.ajax.submitAjax(BX('bx-soa-order-form'), {
        url: this.ajaxUrl,
        method: 'POST',
        dataType: 'json',
        data: {
          via_ajax: 'Y',
          action: 'saveOrderAjax',
          sessid: BX.bitrix_sessid(),
          SITE_ID: this.siteId,
          signedParamsString: this.signedParamsString,
        },
        onsuccess: BX.proxy(this.saveOrderWithJson, this),
        onfailure: BX.proxy(this.handleNotRedirected, this),
      })
    } else {
      BX.ajax({
        method: 'POST',
        dataType: 'json',
        url: this.ajaxUrl,
        data: this.getData(action, actionData),
        onsuccess: BX.delegate(function(result) {
          if (result.redirect && result.redirect.length) document.location.href = result.redirect

          this.saveFiles()
          switch (action) {
            case 'refreshOrderAjax':
              this.refreshOrder(result)
              break
            case 'confirmSmsCode':
            case 'showAuthForm':
              this.firstLoad = true
              this.refreshOrder(result)
              break
            case 'enterCoupon':
              if (result && result.order) {
                this.deliveryCachedInfo = []
                this.refreshOrder(result)
              } else {
                this.addCoupon(result)
              }
              break
            case 'removeCoupon':
              if (result && result.order) {
                this.deliveryCachedInfo = []
                this.refreshOrder(result)
              } else {
                this.removeCoupon(result)
              }

              break
          }
          BX.cleanNode(this.savedFilesBlockNode)

          this.endLoader()
        }, this),
        onfailure: BX.delegate(function() {
          this.endLoader()
        }, this),
      })
    }
  }

  BX.Sale.OrderAjaxComponentExt.editBasketBlock = function(active) {
    this.initialized.basket = true

    for (var id in this.result.GRID.ROWS) {
      var prices = this.result.GRID.ROWS[id].data
      var $priceArea = document.getElementsByClassName('js-product-cart-prices-' + id)[0]

      if (!$priceArea) continue

      prices.PRICE_FORMATED = prices.PRICE_FORMATED.replace('р.', '₽')
      var html = '<div class="product-cart__price">' + prices.PRICE_FORMATED + '</div>'

      if (prices.PRICE != prices.BASE_PRICE)
        html += '<div class="product-cart__price-old">' + prices.BASE_PRICE_FORMATED + '</div>'

      if (prices.DISCOUNT_PRICE_PERCENT > 0)
        html +=
          '<div class="product-cart__discount">-' +
          prices.DISCOUNT_PRICE_PERCENT_FORMATED +
          '</div>'

      $priceArea.innerHTML = html
    }
  }

  BX.Sale.OrderAjaxComponentExt.editTotalBlock = function() {
    var total = this.result.TOTAL
    var totalPrice = total.ORDER_TOTAL_LEFT_TO_PAY_FORMATED
      ? total.ORDER_TOTAL_LEFT_TO_PAY_FORMATED
      : total.ORDER_TOTAL_PRICE_FORMATED

    document.getElementsByClassName('js-order-total-sale')[0].innerHTML =
      total.DISCOUNT_PRICE_FORMATED

    document.getElementsByClassName('js-order-total-delivery')[0].innerHTML =
      total.DELIVERY_PRICE == 0 ? 'Бесплатно' : total.DELIVERY_PRICE_FORMATED
    ;[].forEach.call(document.getElementsByClassName('js-order-total-sum'), function(item) {
      item.innerHTML = totalPrice
    })

    this.renderBasketItems()
  }

  BX.Sale.OrderAjaxComponentExt.renderBasketItems = function() {
    var products = this.result.GRID.ROWS
    var html = ''

    function getProductHtml(product) {
      return (
        '<div class="order-calculate__item">' +
        '<a href="' +
        product.DETAIL_PAGE_URL +
        '" target="_blank" class="order-calculate__item-label">' +
        product.NAME +
        '</a>\n' +
        '<div class="order-calculate__item-value">' +
        product.QUANTITY +
        ' х ' +
        product.PRICE +
        ' <span class="rubl">i</span></div>\n' +
        '</div>'
      )
    }

    for (var key in products) {
      var item = products[key].data
      html += getProductHtml(item)
    }

    document.getElementsByClassName('js-order-basket-products')[0].innerHTML = html
  }
  /**
   * END REQUEST AND UPDATE RENDER DATA
   */

  /**
   * PRELOADER
   */
  BX.Sale.OrderAjaxComponentExt.startLoader = function() {
    launchWindowPreloader()
  }

  BX.Sale.OrderAjaxComponentExt.endLoader = function() {
    stopWindowPreloader()
  }
  /**
   * END PRELOADER
   */
})()
