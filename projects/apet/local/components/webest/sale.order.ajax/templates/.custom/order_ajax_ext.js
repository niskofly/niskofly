(function () {
    'use strict';

    var initParent = BX.Sale.OrderAjaxComponent.init,
        getBlockFooterParent = BX.Sale.OrderAjaxComponent.getBlockFooter,
        editOrderParent = BX.Sale.OrderAjaxComponent.editOrder;

    BX.namespace('BX.Sale.OrderAjaxComponentExt');
    BX.Sale.OrderAjaxComponentExt = BX.Sale.OrderAjaxComponent;

    /**
     * Вызываем родительский init, следом прибиваем ссылки «изменить» у всех блоков.
     * @param parameters
     * @returns {BX.Sale.OrderAjaxComponentExt}
     */
    BX.Sale.OrderAjaxComponentExt.init = function (parameters) {
        initParent.apply(this, arguments);

        var editSteps = this.orderBlockNode.querySelectorAll('.bx-soa-editstep'), i;
        for (i in editSteps) {
            if (editSteps.hasOwnProperty(i)) {
                BX.remove(editSteps[i]);
            }
        }

        return this;
    };

    /**
     * Прибиваем кнопки «Назад» и «Вперед» у блоков.
     * @param node
     */
    BX.Sale.OrderAjaxComponentExt.getBlockFooter = function (node) {
        var parentNodeSection = BX.findParent(node, {className: 'bx-soa-section'});

        getBlockFooterParent.apply(this, arguments);

        if (/bx-soa-auth|bx-soa-pickup|bx-soa-total|bx-soa-delivery|bx-soa-paysystem|bx-soa-region|bx-soa-order|bx-soa-properties|bx-soa-basket/.test(parentNodeSection.id)) {
            BX.remove(parentNodeSection.querySelector('.pull-left'));
            BX.remove(parentNodeSection.querySelector('.pull-right'));
        }
    };

    /**
     * Отменить скрытие секций
     * @param section
     * @param state
     * @returns {null}
     */
    BX.Sale.OrderAjaxComponentExt.changeVisibleSection = function (section, state) {
        return null;
    };

    /**
     * Отмена рендера блока с купонами
     * @param basketItemsNode
     * @returns {null}
     */
    BX.Sale.OrderAjaxComponentExt.editCoupons = function (basketItemsNode) {
        return null;
    };


    /**
     * REGION AND USER TYPE
     */
    BX.Sale.OrderAjaxComponentExt.editRegionBlock = function (active) {
        if (!this.regionBlockNode || !this.regionHiddenBlockNode || !this.result.PERSON_TYPE)
            return;

        this.editActiveRegionBlock(true);
        this.initialized.region = true;
    };

    BX.Sale.OrderAjaxComponentExt.editFadeRegionContent = function (node) {
        return null;
    };

    BX.Sale.OrderAjaxComponentExt.editActiveRegionBlock = function (activeNodeMode) {
        var node = activeNodeMode ? this.regionBlockNode : this.regionHiddenBlockNode,
            regionContent, regionNode, regionNodeCol;

        regionContent = node.querySelector('.bx-soa-section-content');
        if (!regionContent) {
            regionContent = this.getNewContainer();
            node.appendChild(regionContent);
        } else
            BX.cleanNode(regionContent);

        this.getErrorContainer(regionContent);

        regionNode = BX.create('DIV', {props: {className: 'bx_soa_location row'}});
        regionNodeCol = BX.create('DIV', {props: {className: 'form-cart__payer'}});

        this.getPersonTypeControl(regionNodeCol);

        this.getProfilesControl(regionNodeCol);

        this.getDeliveryLocationInput(regionNodeCol);

        if (!this.result.SHOW_AUTH) {
            if (this.regionBlockNotEmpty) {
                BX.addClass(this.regionBlockNode, 'bx-active');
                this.regionBlockNode.style.display = '';
            } else {
                BX.removeClass(this.regionBlockNode, 'bx-active');
                this.regionBlockNode.style.display = 'none';

                if (!this.result.IS_AUTHORIZED || typeof this.result.LAST_ORDER_DATA.FAIL !== 'undefined')
                    this.initFirstSection();
            }
        }

        regionNode.appendChild(regionNodeCol);
        regionContent.appendChild(regionNode);
        this.getBlockFooter(regionContent);
    };

    BX.Sale.OrderAjaxComponentExt.getPersonTypeControl = function (node) {
        if (!this.result.PERSON_TYPE)
            return;

        this.result.PERSON_TYPE = this.getPersonTypeSortedArray(this.result.PERSON_TYPE);

        var personTypesCount = this.result.PERSON_TYPE.length,
            currentType, oldPersonTypeId, i,
            input, options = [], label, inputs;

        node.appendChild(BX.create('DIV', {
            props: {className: 'form-cart__label'},
            text: 'Тип плательщика'
        }));

        inputs = BX.create('DIV', {props: {className: 'input-groups'}});

        for (i in this.result.PERSON_TYPE) {
            if (this.result.PERSON_TYPE.hasOwnProperty(i)) {
                currentType = this.result.PERSON_TYPE[i];
                label = BX.create('LABEL', {
                    props: {className: 'radio'},
                    events: {change: BX.proxy(this.sendRequest, this)},
                    children: [
                        BX.create('INPUT', {
                            props: {
                                type: 'radio',
                                name: 'PERSON_TYPE',
                                value: currentType.ID,
                                className: 'radio-round__input'
                            },
                            attrs: {checked: currentType.CHECKED == 'Y'},
                        }),
                        BX.create('SPAN', {
                            props: {className: 'radio__indicator'},
                        }),
                        BX.create('SPAN', {
                            props: {className: 'radio__description'},
                            text: currentType.NAME
                        })
                    ]
                });

                inputs.appendChild(BX.create('DIV', {props: {className: ''}, children: [label]}));

                if (currentType.CHECKED == 'Y')
                    oldPersonTypeId = currentType.ID;
            }
        }
        this.regionBlockNotEmpty = true;

        node.appendChild(inputs);

        if (oldPersonTypeId) {
            node.appendChild(
                BX.create('INPUT', {
                    props: {
                        type: 'hidden',
                        name: 'PERSON_TYPE_OLD',
                        value: oldPersonTypeId
                    }
                })
            );
        }
    };

    BX.Sale.OrderAjaxComponentExt.getDeliveryLocationInput = function (node) {
        var currentProperty, locationId, altId, location, k, altProperty,
            labelHtml, currentLocation, insertedLoc,
            locationWrapper, labelTextHtml, label, input, altNode;

        for (k in this.result.ORDER_PROP.properties) {
            if (this.result.ORDER_PROP.properties.hasOwnProperty(k)) {
                currentProperty = this.result.ORDER_PROP.properties[k];
                if (currentProperty.IS_LOCATION == 'Y') {
                    locationId = currentProperty.ID;
                    altId = parseInt(currentProperty.INPUT_FIELD_LOCATION);
                    break;
                }
            }
        }

        location = this.locations[locationId];
        if (location && location[0] && location[0].output) {
            this.regionBlockNotEmpty = true;

            labelHtml = '<div class="form-cart__label">'
                + BX.util.htmlspecialchars(currentProperty.NAME)
                + (currentProperty.REQUIRED == 'Y' ? '*' : '')
                + (currentProperty.DESCRIPTION.length ? ' <small>(' + BX.util.htmlspecialchars(currentProperty.DESCRIPTION) + ')</small>' : '')
                + '</div>';

            currentLocation = location[0].output;
            insertedLoc = BX.create('DIV', {
                attrs: {'data-property-id-row': locationId},
                props: {className: 'form-group bx-soa-location-input-container'},
                style: {visibility: 'hidden'},
                html: labelHtml + currentLocation.HTML + '<div class="input-group__error"></div>',
            });

            locationWrapper = BX.create('DIV', {
                props: {className: 'form-cart__location'},
                children: [insertedLoc]
            });

            node.appendChild(locationWrapper);
            node.appendChild(BX.create('INPUT', {
                props: {
                    type: 'hidden',
                    name: 'RECENT_DELIVERY_VALUE',
                    value: location[0].lastValue
                }
            }));

            for (k in currentLocation.SCRIPT)
                if (currentLocation.SCRIPT.hasOwnProperty(k))
                    BX.evalGlobal(currentLocation.SCRIPT[k].JS);
        }

        if (location && location[0] && location[0].showAlt && altId > 0) {
            for (k in this.result.ORDER_PROP.properties) {
                if (parseInt(this.result.ORDER_PROP.properties[k].ID) == altId) {
                    altProperty = this.result.ORDER_PROP.properties[k];
                    break;
                }
            }
        }

        if (altProperty) {
            altNode = BX.create('DIV', {
                attrs: {'data-property-id-row': altProperty.ID},
                props: {className: "form-group bx-soa-location-input-container"}
            });

            labelTextHtml = altProperty.REQUIRED == 'Y' ? '<span class="bx-authform-starrequired">*</span> ' : '';
            labelTextHtml += BX.util.htmlspecialchars(altProperty.NAME);

            label = BX.create('LABEL', {
                attrs: {for: 'altProperty'},
                props: {className: 'bx-soa-custom-label'},
                html: labelTextHtml
            });

            input = BX.create('INPUT', {
                props: {
                    id: 'altProperty',
                    type: 'text',
                    placeholder: altProperty.DESCRIPTION,
                    autocomplete: 'city',
                    className: 'form-control bx-soa-customer-input bx-ios-fix',
                    name: 'ORDER_PROP_' + altProperty.ID,
                    value: altProperty.VALUE
                }
            });

            altNode.appendChild(label);
            altNode.appendChild(input);
            node.appendChild(altNode);

            this.bindValidation(altProperty.ID, altNode);
        }

        this.getZipLocationInput(node);

        if (location && location[0]) {
            node.appendChild(
                BX.create('DIV', {
                    props: {className: 'bx-soa-reference'},
                    html: this.params.MESS_REGION_REFERENCE
                })
            );
        }
    };
    /**
     * END REGION AND USER TYPE
     */


    /**
     * DELIVERY
     */
    BX.Sale.OrderAjaxComponentExt.editDeliveryBlock = function (active) {
        if (!this.deliveryBlockNode || !this.deliveryHiddenBlockNode || !this.result.DELIVERY)
            return;

        this.editActiveDeliveryBlock(true);
        this.checkPickUpShow();
        this.initialized.delivery = true;
    };

    BX.Sale.OrderAjaxComponentExt.editActiveDeliveryBlock = function (activeNodeMode) {
        var node = activeNodeMode ? this.deliveryBlockNode : this.deliveryHiddenBlockNode,
            deliveryContent, deliveryNode;

        deliveryContent = node.querySelector('.bx-soa-section-content');
        if (!deliveryContent) {
            deliveryContent = this.getNewContainer();
            node.appendChild(deliveryContent);
        } else
            BX.cleanNode(deliveryContent);

        this.getErrorContainer(deliveryContent);

        deliveryNode = BX.create('DIV', {props: {className: 'bx-soa-pp form-cart__delivery'}});
        this.editDeliveryItems(deliveryNode);
        deliveryContent.appendChild(deliveryNode);
        this.editDeliveryInfo(deliveryNode);

        this.getBlockFooter(deliveryContent);
    };

    BX.Sale.OrderAjaxComponentExt.editDeliveryItems = function (deliveryNode) {
        if (!this.result.DELIVERY || this.result.DELIVERY.length <= 0)
            return;

        var deliveryItemsContainer = BX.create('DIV', {props: {className: 'input-groups bx-soa-pp-item-container'}}),
            deliveryItemNode, k;

        for (k = 0; k < this.deliveryPagination.currentPage.length; k++) {
            deliveryItemNode = this.createDeliveryItem(this.deliveryPagination.currentPage[k]);
            deliveryItemsContainer.appendChild(deliveryItemNode);
        }

        if (this.deliveryPagination.show)
            this.showPagination('delivery', deliveryItemsContainer);

        deliveryNode.appendChild(deliveryItemsContainer);
    };

    BX.Sale.OrderAjaxComponentExt.createDeliveryItem = function (item) {
        var checked = item.CHECKED == 'Y',
            deliveryId = parseInt(item.ID),
            labelNodes,
            deliveryCached = this.deliveryCachedInfo[deliveryId],
            label, title, itemNode;

        labelNodes = [
            BX.create('INPUT', {
                props: {
                    id: 'ID_DELIVERY_ID_' + deliveryId,
                    name: 'DELIVERY_ID',
                    type: 'checkbox',
                    className: 'bx-soa-pp-company-checkbox',
                    value: deliveryId,
                    checked: checked
                }
            }),
            BX.create('SPAN', {
                props: {className: 'radio__indicator'},
            }),
            BX.create('SPAN', {
                props: {className: 'radio__description'},
                text: this.params.SHOW_DELIVERY_PARENT_NAMES != 'N' ? item.NAME : item.OWN_NAME
            })
        ];

        label = BX.create('DIV', {
            props: {
                className: 'radio'
                    + (item.CALCULATE_ERRORS || deliveryCached && deliveryCached.CALCULATE_ERRORS ? ' bx-bd-waring' : '')
            },
            children: labelNodes
        });

        itemNode = BX.create('DIV', {
            props: {className: 'bx-soa-pp-company'},
            children: [label, title],
            events: {click: BX.proxy(this.selectDelivery, this)}
        });

        checked && BX.addClass(itemNode, 'bx-selected');

        if (checked && this.result.LAST_ORDER_DATA.PICK_UP)
            this.lastSelectedDelivery = deliveryId;

        return itemNode;
    };

    BX.Sale.OrderAjaxComponentExt.selectDelivery = function (event) {
        if (!this.orderBlockNode)
            return;

        var target = event.target || event.srcElement,
            actionSection = BX.hasClass(target, 'bx-soa-pp-company') ? target : BX.findParent(target, {className: 'bx-soa-pp-company'}),
            selectedSection = this.deliveryBlockNode.querySelector('.bx-soa-pp-company.bx-selected'),
            actionInput, selectedInput, oldInput = document.querySelector('[name="DELIVERY_ID_OLD"]');

        if (oldInput)
            oldInput.value = document.querySelector('[name="DELIVERY_ID"]:checked').value;

        if (BX.hasClass(actionSection, 'bx-selected'))
            return BX.PreventDefault(event);

        if (actionSection) {
            actionInput = actionSection.querySelector('input[type=checkbox]');
            BX.addClass(actionSection, 'bx-selected');
            actionInput.checked = true;
        }
        if (selectedSection) {
            selectedInput = selectedSection.querySelector('input[type=checkbox]');
            BX.removeClass(selectedSection, 'bx-selected');
            selectedInput.checked = false;
        }
        console.log(selectedInput.value);

        this.sendRequest();
    };

    BX.Sale.OrderAjaxComponentExt.editDeliveryInfo = function (deliveryNode) {
        if (!this.result.DELIVERY)
            return;

        var deliveryInfoContainer,
            currentDelivery, name,
            price, period,
            clear, infoList, extraServices, extraServicesNode;

        BX.cleanNode(deliveryInfoContainer);
        currentDelivery = this.getSelectedDelivery();

        name = this.params.SHOW_DELIVERY_PARENT_NAMES != 'N' ? currentDelivery.NAME : currentDelivery.OWN_NAME;

        deliveryInfoContainer =
            BX.create('DIV',
                {
                    props: {className: 'cart-note'},
                    children: [
                        BX.create('DIV', {props: {className: 'cart-note__text'}, html: currentDelivery.DESCRIPTION}),
                        currentDelivery.CALCULATE_DESCRIPTION
                            ? BX.create('DIV', {
                                props: {className: 'cart-note__text'},
                                html: currentDelivery.CALCULATE_DESCRIPTION
                            })
                            : null
                    ]
                });

        if (currentDelivery.PRICE >= 0) {
            price = BX.create('LI', {
                props: {className: 'cart-note__detail-item'},
                children: [
                    BX.create('P', {
                        props: {className: 'cart-note__detail-label'},
                        html: this.params.MESS_PRICE + ':'
                    }),
                    BX.create('P', {
                        props: {className: 'cart-note__detail-value'},
                        children: this.getDeliveryPriceNodes(currentDelivery)
                    })
                ]
            });
        }

        if (currentDelivery.PERIOD_TEXT && currentDelivery.PERIOD_TEXT.length) {
            period = BX.create('LI', {
                props: {className: 'cart-note__detail-item'},
                children: [
                    BX.create('DIV', {
                        props: {className: 'cart-note__detail-label'},
                        html: this.params.MESS_PERIOD + ':'
                    }),
                    BX.create('DIV', {
                        props: {className: 'cart-note__detail-value'},
                        html: currentDelivery.PERIOD_TEXT
                    })
                ]
            });
        }

        infoList = BX.create('UL', {props: {className: 'cart-note__detail'}, children: [price, period]});
        extraServices = this.getDeliveryExtraServices(currentDelivery);

        if (extraServices.length) {
            extraServicesNode = BX.create('DIV', {
                props: {className: 'bx-soa-pp-company-block'},
                children: extraServices
            });
        }

        deliveryInfoContainer.appendChild(
            BX.create('DIV', {
                props: {className: 'bx-soa-pp-company'},
                children: [extraServicesNode, infoList]
            })
        );
        deliveryNode.appendChild(deliveryInfoContainer);

        if (this.params.DELIVERY_NO_AJAX != 'Y')
            this.deliveryCachedInfo[currentDelivery.ID] = currentDelivery;
    };

    /*BX.Sale.OrderAjaxComponentExt.checkPickUpShow = function () {
        var currentDelivery = this.getSelectedDelivery(), name, stores;

        if (currentDelivery && currentDelivery.STORE && currentDelivery.STORE.length)
            stores = this.getPickUpInfoArray(currentDelivery.STORE);

        if (stores && stores.length) {
            name = this.params.SHOW_DELIVERY_PARENT_NAMES != 'N' ? currentDelivery.NAME : currentDelivery.OWN_NAME;
            currentDelivery.STORE_MAIN = currentDelivery.STORE;
            this.activatePickUp(name);
        } else {
            this.deactivatePickUp();
        }
    };*/

    /*BX.Sale.OrderAjaxComponentExt.activatePickUp = function (deliveryName) {
        return;
    };*/
    /**
     * END DELIVERY
     */


    /**
     * PAYMENT
     */
    BX.Sale.OrderAjaxComponentExt.editPaySystemBlock = function (active) {
        if (!this.paySystemBlockNode || !this.paySystemHiddenBlockNode || !this.result.PAY_SYSTEM)
            return;

        this.editActivePaySystemBlock(true);
        this.initialized.paySystem = true;
    };

    BX.Sale.OrderAjaxComponentExt.editActivePaySystemBlock = function (activeNodeMode) {
        var node = activeNodeMode ? this.paySystemBlockNode : this.paySystemHiddenBlockNode,
            paySystemContent, paySystemNode;

        paySystemContent = node.querySelector('.bx-soa-section-content');
        if (!paySystemContent) {
            paySystemContent = this.getNewContainer();
            node.appendChild(paySystemContent);
        } else
            BX.cleanNode(paySystemContent);

        this.getErrorContainer(paySystemContent);
        paySystemNode = BX.create('DIV', {props: {className: 'bx-soa-pp form-cart__pay'}});
        this.editPaySystemItems(paySystemNode);
        paySystemContent.appendChild(paySystemNode);
        this.editPaySystemInfo(paySystemNode);

        if (this.params.SHOW_COUPONS_PAY_SYSTEM == 'Y')
            this.editCoupons(paySystemContent);

        this.getBlockFooter(paySystemContent);
    };

    BX.Sale.OrderAjaxComponentExt.editPaySystemItems = function (paySystemNode) {
        if (!this.result.PAY_SYSTEM || this.result.PAY_SYSTEM.length <= 0)
            return;

        var paySystemItemsContainer = BX.create('DIV', {props: {className: 'input-groups bx-soa-pp-item-container'}}),
            paySystemItemNode, i;

        for (i = 0; i < this.paySystemPagination.currentPage.length; i++) {
            paySystemItemNode = this.createPaySystemItem(this.paySystemPagination.currentPage[i]);
            paySystemItemsContainer.appendChild(paySystemItemNode);
        }

        if (this.paySystemPagination.show)
            this.showPagination('paySystem', paySystemItemsContainer);

        paySystemNode.appendChild(paySystemItemsContainer);
    };

    BX.Sale.OrderAjaxComponentExt.createPaySystemItem = function (item) {
        var checked = item.CHECKED == 'Y',
            paySystemId = parseInt(item.ID),
            label, itemNode;

        label = BX.create('LABEL', {
            props: {className: 'radio'},
            children: [
                BX.create('INPUT', {
                    props: {
                        id: 'ID_PAY_SYSTEM_ID_' + paySystemId,
                        name: 'PAY_SYSTEM_ID',
                        type: 'radio',
                        className: 'radio-round__input',
                        value: paySystemId,
                        checked: checked
                    }
                }),
                BX.create('SPAN', {
                    props: {className: 'radio__indicator'},
                }),
                BX.create('SPAN', {
                    props: {className: 'radio__description'},
                    text: item.NAME
                })
            ]
        });

        itemNode = BX.create('DIV', {
            props: {className: ''},
            children: [label],
            events: {
                click: BX.proxy(this.selectPaySystem, this)
            }
        });

        if (checked)
            BX.addClass(itemNode, 'bx-selected');

        return itemNode;
    };

    BX.Sale.OrderAjaxComponentExt.getInnerPaySystem = function () {
        return;
    }
    /**
     * END PAYMENT
     */


    /**
     * USER PROPERTIES
     */
    BX.Sale.OrderAjaxComponentExt.editPropsBlock = function (active) {
        if (!this.propsBlockNode || !this.propsHiddenBlockNode || !this.result.ORDER_PROP)
            return;

        this.editActivePropsBlock(true);
        this.initialized.props = true;
    };

    BX.Sale.OrderAjaxComponentExt.editFadePropsContent = function (node) {
        return null;
    };

    BX.Sale.OrderAjaxComponentExt.editActivePropsBlock = function (activeNodeMode) {
        var node = activeNodeMode ? this.propsBlockNode : this.propsHiddenBlockNode,
            propsContent, propsNode, selectedDelivery, showPropMap = false, i, validationErrors;

        propsContent = node.querySelector('.bx-soa-section-content');
        if (!propsContent) {
            propsContent = this.getNewContainer();
            node.appendChild(propsContent);
        } else
            BX.cleanNode(propsContent);

        this.getErrorContainer(propsContent);

        propsNode = BX.create('DIV', {props: {className: 'row'}});
        selectedDelivery = this.getSelectedDelivery();

        if (
            selectedDelivery && this.params.SHOW_MAP_IN_PROPS === 'Y'
            && this.params.SHOW_MAP_FOR_DELIVERIES && this.params.SHOW_MAP_FOR_DELIVERIES.length
        ) {
            for (i = 0; i < this.params.SHOW_MAP_FOR_DELIVERIES.length; i++) {
                if (parseInt(selectedDelivery.ID) === parseInt(this.params.SHOW_MAP_FOR_DELIVERIES[i])) {
                    showPropMap = true;
                    break;
                }
            }
        }

        this.editPropsItems(propsNode);
        showPropMap && this.editPropsMap(propsNode);

        if (this.params.HIDE_ORDER_DESCRIPTION !== 'Y') {
            this.editPropsComment(propsNode);
        }

        propsContent.appendChild(propsNode);
        this.getBlockFooter(propsContent);

        if (this.propsBlockNode.getAttribute('data-visited') === 'true') {
            validationErrors = this.isValidPropertiesBlock(true);
            if (validationErrors.length)
                BX.addClass(this.propsBlockNode, 'bx-step-error');
            else
                BX.removeClass(this.propsBlockNode, 'bx-step-error');
        }
    };

    BX.Sale.OrderAjaxComponentExt.editPropsItems = function (propsNode) {
        if (!this.result.ORDER_PROP || !this.propertyCollection)
            return;

        var propsItemsContainer = BX.create('DIV', {props: {className: 'input-groups'}}),
            group, property, groupIterator = this.propertyCollection.getGroupIterator(), propsIterator;

        if (!propsItemsContainer)
            propsItemsContainer = this.propsBlockNode.querySelector('.col-sm-12.bx-soa-customer');

        while (group = groupIterator()) {
            propsIterator = group.getIterator();
            while (property = propsIterator()) {
                if (
                    this.deliveryLocationInfo.loc == property.getId()
                    || this.deliveryLocationInfo.zip == property.getId()
                    || this.deliveryLocationInfo.city == property.getId()
                )
                    continue;

                this.getPropertyRowNode(property, propsItemsContainer, false);
            }
        }

        propsNode.appendChild(propsItemsContainer);
    };

    BX.Sale.OrderAjaxComponentExt.getPropertyRowNode = function (property, propsItemsContainer, disabled) {
        var propsItemNode = BX.create('DIV'),
            textHtml = '',
            propertyType = property.getType() || '',
            propertyDesc = property.getDescription() || '',
            label;

        if (disabled) {
            propsItemNode.innerHTML = '<strong>' + BX.util.htmlspecialchars(property.getName()) + ':</strong> ';
        } else {
            BX.addClass(propsItemNode, "input-group--one-third form-group bx-soa-customer-field");
            propsItemNode.setAttribute('data-property-id-row', property.getId());
        }

        switch (propertyType) {
            case 'LOCATION':
                this.insertLocationProperty(property, propsItemNode, disabled);
                break;
            case 'DATE':
                this.insertDateProperty(property, propsItemNode, disabled);
                break;
            case 'FILE':
                this.insertFileProperty(property, propsItemNode, disabled);
                break;
            case 'STRING':
                this.insertStringProperty(property, propsItemNode, disabled);
                break;
            case 'ENUM':
                this.insertEnumProperty(property, propsItemNode, disabled);
                break;
            case 'Y/N':
                this.insertYNProperty(property, propsItemNode, disabled);
                break;
            case 'NUMBER':
                this.insertNumberProperty(property, propsItemNode, disabled);
        }
        propsItemNode.appendChild(
            BX.create('DIV',
                {
                    props: {className: 'input-group__error'}
                })
        );

        propsItemsContainer.appendChild(propsItemNode);
    };

    BX.Sale.OrderAjaxComponentExt.insertStringProperty = function (property, propsItemNode, disabled) {
        var prop, inputs, values, i, propContainer;

        if (disabled) {
            prop = this.propsHiddenBlockNode.querySelector('div[data-property-id-row="' + property.getId() + '"]');
            if (prop) {
                values = [];
                inputs = prop.querySelectorAll('input[type=text]');
                if (inputs.length == 0)
                    inputs = prop.querySelectorAll('textarea');

                if (inputs.length) {
                    for (i = 0; i < inputs.length; i++) {
                        if (inputs[i].value.length)
                            values.push(inputs[i].value);
                    }
                }

                propsItemNode.innerHTML += this.valuesToString(values);
            }
        } else {
            propContainer = BX.create('DIV', {props: {className: 'soa-property-container'}});
            property.appendTo(propContainer);
            propsItemNode.appendChild(propContainer);
            this.alterProperty(property.getSettings(), propContainer);
            this.bindValidation(property.getId(), propContainer);
        }
    };

    BX.Sale.OrderAjaxComponentExt.alterProperty = function (settings, propContainer) {
        var divs = BX.findChildren(propContainer, {tagName: 'DIV'}),
            i, textNode, inputs, del, add, placeholderText = '',
            fileInputs, accepts, fileTitles;

        placeholderText += BX.util.htmlspecialchars(settings.NAME);
        if (settings.REQUIRED == 'Y')
            placeholderText += '*';

        settings.DESCRIPTION = placeholderText;

        textNode = propContainer.querySelector('input[type=text]');
        if (!textNode)
            textNode = propContainer.querySelector('textarea');

        if (textNode) {
            textNode.id = 'soa-property-' + settings.ID;
            if (settings.IS_ADDRESS == 'Y')
                textNode.setAttribute('autocomplete', 'address');

            if (settings.IS_EMAIL == 'Y')
                textNode.setAttribute('autocomplete', 'email');

            if (settings.IS_PAYER == 'Y')
                textNode.setAttribute('autocomplete', 'name');

            if (settings.IS_PHONE == 'Y')
                textNode.setAttribute('autocomplete', 'tel');

            if (settings.PATTERN && settings.PATTERN.length)
                textNode.removeAttribute('pattern');
        }

        inputs = propContainer.querySelectorAll('input[type=text]');
        for (i = 0; i < inputs.length; i++) {
            inputs[i].placeholder = settings.DESCRIPTION;
            BX.addClass(inputs[i], 'input-base');
        }

        inputs = propContainer.querySelectorAll('select');
        for (i = 0; i < inputs.length; i++)
            BX.addClass(inputs[i], 'form-control');

        inputs = propContainer.querySelectorAll('textarea');
        for (i = 0; i < inputs.length; i++) {
            inputs[i].placeholder = settings.DESCRIPTION;
            BX.addClass(inputs[i], 'textarea');
        }

        del = propContainer.querySelectorAll('label');
        for (i = 0; i < del.length; i++)
            BX.remove(del[i]);

        if (settings.TYPE == 'FILE') {
            if (settings.ACCEPT && settings.ACCEPT.length) {
                fileInputs = propContainer.querySelectorAll('input[type=file]');
                accepts = this.getFileAccepts(settings.ACCEPT);
                for (i = 0; i < fileInputs.length; i++)
                    fileInputs[i].setAttribute('accept', accepts);
            }

            fileTitles = propContainer.querySelectorAll('a');
            for (i = 0; i < fileTitles.length; i++) {
                BX.bind(fileTitles[i], 'click', function (e) {
                    var target = e.target || e.srcElement,
                        fileInput = target && target.nextSibling && target.nextSibling.nextSibling;

                    if (fileInput)
                        BX.fireEvent(fileInput, 'change');
                });
            }
        }

        add = propContainer.querySelectorAll('input[type=button]');
        for (i = 0; i < add.length; i++) {
            BX.addClass(add[i], 'btn btn-default btn-sm');

            if (settings.MULTIPLE == 'Y' && i == add.length - 1)
                continue;

            if (settings.TYPE == 'FILE') {
                BX.prepend(add[i], add[i].parentNode);
                add[i].style.marginRight = '10px';
            }
        }

        if (add.length) {
            add = add[add.length - 1];
            BX.bind(add, 'click', BX.delegate(function (e) {
                var target = e.target || e.srcElement,
                    targetContainer = BX.findParent(target, {tagName: 'div', className: 'soa-property-container'}),
                    del = targetContainer.querySelector('label'),
                    add = targetContainer.querySelectorAll('input[type=button]'),
                    textInputs = targetContainer.querySelectorAll('input[type=text]'),
                    textAreas = targetContainer.querySelectorAll('textarea'),
                    divs = BX.findChildren(targetContainer, {tagName: 'DIV'});

                var i, fileTitles, fileInputs, accepts;

                if (divs && divs.length) {
                    for (i = 0; i < divs.length; i++) {
                        divs[i].style.margin = '5px 0';
                    }
                }

                this.bindValidation(settings.ID, targetContainer);

                if (add.length && add[add.length - 2]) {
                    BX.prepend(add[add.length - 2], add[add.length - 2].parentNode);
                    add[add.length - 2].style.marginRight = '10px';
                    BX.addClass(add[add.length - 2], 'btn btn-default btn-sm');
                }

                del && BX.remove(del);
                if (textInputs.length) {
                    textInputs[textInputs.length - 1].placeholder = settings.DESCRIPTION;
                    BX.addClass(textInputs[textInputs.length - 1], 'form-control bx-soa-customer-input bx-ios-fix');
                    if (settings.TYPE == 'DATE')
                        this.alterDateProperty(settings, textInputs[textInputs.length - 1]);

                    if (settings.PATTERN && settings.PATTERN.length)
                        textInputs[textInputs.length - 1].removeAttribute('pattern');
                }

                if (textAreas.length) {
                    textAreas[textAreas.length - 1].placeholder = settings.DESCRIPTION;
                    BX.addClass(textAreas[textAreas.length - 1], 'form-control bx-ios-fix');
                }

                if (settings.TYPE == 'FILE') {
                    if (settings.ACCEPT && settings.ACCEPT.length) {
                        fileInputs = propContainer.querySelectorAll('input[type=file]');
                        accepts = this.getFileAccepts(settings.ACCEPT);
                        for (i = 0; i < fileInputs.length; i++)
                            fileInputs[i].setAttribute('accept', accepts);
                    }

                    fileTitles = targetContainer.querySelectorAll('a');
                    BX.bind(fileTitles[fileTitles.length - 1], 'click', function (e) {
                        var target = e.target || e.srcElement,
                            fileInput = target && target.nextSibling && target.nextSibling.nextSibling;

                        if (fileInput)
                            setTimeout(function () {
                                BX.fireEvent(fileInput, 'change');
                            }, 10);
                    });
                }
            }, this));
        }
    };

    BX.Sale.OrderAjaxComponentExt.editPropsComment = function (propsNode) {
        var propsCommentContainer, input, div;

        propsCommentContainer = BX.create('DIV', {props: {className: 'input-groups input-groups--order-comment'}});


        input = BX.create('TEXTAREA', {
            props: {
                id: 'orderDescription',
                className: 'textarea',
                name: 'ORDER_DESCRIPTION',
                placeholder: this.params.MESS_ORDER_DESC
            },
            text: this.result.ORDER_DESCRIPTION ? this.result.ORDER_DESCRIPTION : ''
        });
        div = BX.create('DIV', {
            props: {className: 'form-group'},
            children: [input]
        });

        propsCommentContainer.appendChild(div);
        propsNode.appendChild(propsCommentContainer);
    };
    /**
     * END USER PROPERTIES
     */

    /**
     * SHOW ERORRS
     */
    BX.Sale.OrderAjaxComponentExt.showValidationResult = function (inputs, errors) {
        if (!inputs || !inputs.length || !errors)
            return;

        var input0 = BX.type.isElementNode(inputs[0]) ? inputs[0] : inputs[0][0],
            formGroup = BX.findParent(input0, {tagName: 'DIV', className: 'form-group'}),
            inputDiv, i,
            errorArea = formGroup.querySelector('.input-group__error');

        for (i = 0; i < inputs.length; i++) {
            inputDiv = BX.findParent(inputs[i], {tagName: 'DIV', className: 'form-group'});
            if (errors[i] && errors[i].length)
                BX.addClass(inputDiv, 'input-group--error');
            else
                BX.removeClass(inputDiv, 'input-group--error');
        }

        if (errors.length)
            errorArea.innerHTML = errors.join('<br>');
        else
            errorArea.innerHTML = "";
    };

    BX.Sale.OrderAjaxComponentExt.isValidForm = function () {
        if (!this.options.propertyValidation)
            return true;

        var regionErrors = this.isValidRegionBlock(),
            propsErrors = this.isValidPropertiesBlock(),
            navigated = false, tooltips, i;

        if (regionErrors.length) {
            navigated = true;
            this.animateScrollTo(this.regionBlockNode, 800, 50);
        }

        if (propsErrors.length && !navigated) {
            if (this.activeSectionId == this.propsBlockNode.id) {
                tooltips = this.propsBlockNode.querySelectorAll('div.tooltip');
                for (i = 0; i < tooltips.length; i++) {
                    if (tooltips[i].getAttribute('data-state') == 'opened') {
                        this.animateScrollTo(BX.findParent(tooltips[i], {className: 'form-group bx-soa-customer-field'}), 800, 50);
                        break;
                    }
                }
            } else
                this.animateScrollTo(this.propsBlockNode, 800, 50);
        }

        if (regionErrors.length) {
            this.showError(this.regionBlockNode, regionErrors);
            BX.addClass(this.regionBlockNode, 'bx-step-error');
        }

        return !(regionErrors.length + propsErrors.length);
    };
    /**
     * END SHOW ERORRS
     */


    /**
     * REQUEST AND UPDATE RENDER DATA
     */
    BX.Sale.OrderAjaxComponentExt.sendRequest = function (action, actionData) {
        var form;

        this.startLoader();

        this.firstLoad = false;

        action = BX.type.isNotEmptyString(action) ? action : 'refreshOrderAjax';

        if (action === 'saveOrderAjax') {
            form = BX('bx-soa-order-form');
            if (form) {
                form.querySelector('input[type=hidden][name=sessid]').value = BX.bitrix_sessid();
            }

            BX.ajax.submitAjax(
                BX('bx-soa-order-form'),
                {
                    url: this.ajaxUrl,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        via_ajax: 'Y',
                        action: 'saveOrderAjax',
                        sessid: BX.bitrix_sessid(),
                        SITE_ID: this.siteId,
                        signedParamsString: this.signedParamsString
                    },
                    onsuccess: BX.proxy(this.saveOrderWithJson, this),
                    onfailure: BX.proxy(this.handleNotRedirected, this)
                }
            );
        } else {
            BX.ajax({
                method: 'POST',
                dataType: 'json',
                url: this.ajaxUrl,
                data: this.getData(action, actionData),
                onsuccess: BX.delegate(function (result) {
                    if (result.redirect && result.redirect.length)
                        document.location.href = result.redirect;

                    this.saveFiles();
                    switch (action) {
                        case 'refreshOrderAjax':
                            this.refreshOrder(result);
                            break;
                        case 'confirmSmsCode':
                        case 'showAuthForm':
                            this.firstLoad = true;
                            this.refreshOrder(result);
                            break;
                        case 'enterCoupon':
                            if (result && result.order) {
                                this.deliveryCachedInfo = [];
                                this.refreshOrder(result);
                            } else {
                                this.addCoupon(result);
                            }
                            break;
                        case 'removeCoupon':
                            if (result && result.order) {
                                this.deliveryCachedInfo = [];
                                this.refreshOrder(result);
                            } else {
                                this.removeCoupon(result);
                            }

                            break;
                    }
                    BX.cleanNode(this.savedFilesBlockNode);

                    window.orderHandler.updateRelatedInformation(result);
                    this.endLoader();
                }, this),
                onfailure: BX.delegate(function () {
                    this.endLoader();
                }, this)
            });
        }
    };

    BX.Sale.OrderAjaxComponentExt.editBasketBlock = function (active) {
        this.initialized.basket = true;

        for (var id in this.result.GRID.ROWS) {
            var prices = this.result.GRID.ROWS[id].data
            var $priceArea = document.getElementsByClassName('js-product-cart-prices-' + id)[0];

            if (!$priceArea)
                continue;

            prices.PRICE_FORMATED = prices.PRICE_FORMATED.replace('р.', '₽');
            var html = '<div class="order-card__price">' + prices.PRICE_FORMATED + '</div>';

            if (prices.PRICE != prices.BASE_PRICE)
                html += '<div class="order-card__old-price">' + prices.BASE_PRICE_FORMATED + '</div>';

            /* if (prices.DISCOUNT_PRICE_PERCENT > 0)
                            html += '<div class="order-card__old-price">-' + prices.DISCOUNT_PRICE_PERCENT_FORMATED + '</div>'; */

            $priceArea.innerHTML = html;
        }
    };

    BX.Sale.OrderAjaxComponentExt.editTotalBlock = function () {
        var total = this.result.TOTAL;
        var totalPrice = total.ORDER_TOTAL_LEFT_TO_PAY_FORMATED ? total.ORDER_TOTAL_LEFT_TO_PAY_FORMATED : total.ORDER_TOTAL_PRICE_FORMATED;
        document.getElementsByClassName('js-order-total-sum')[0].innerHTML = totalPrice;
        document.getElementsByClassName('js-order-footer-total-sum')[0].innerHTML = totalPrice;
        document.getElementsByClassName('js-order-total-basket')[0].innerHTML = total.PRICE_WITHOUT_DISCOUNT;
        document.getElementsByClassName('js-order-total-sale')[0].innerHTML = total.DISCOUNT_PRICE_FORMATED;
        document.getElementsByClassName('js-order-total-delivery')[0].innerHTML = total.DELIVERY_PRICE_FORMATED;
    };
    /**
     * END REQUEST AND UPDATE RENDER DATA
     */


    /**
     * PRELOADER
     */
    BX.Sale.OrderAjaxComponentExt.startLoader = function () {
        if (this.BXFormPosting === true)
            return false;

        launchWindowPreloader();
    };

    BX.Sale.OrderAjaxComponentExt.endLoader = function () {
        this.BXFormPosting = false;
        stopWindowPreloader();
    };
    /**
     * END PRELOADER
     */


    /* Пункт выдачи */
    BX.Sale.OrderAjaxComponentExt.editFadePickUpContent = function (
      pickUpContainer
    ) 		{
			var selectedPickUp = this.getSelectedPickUp(), html = '', logotype, imgSrc;

			if (selectedPickUp)
			{
        html += '<div class="cart-wrapper">';
				if (this.params.SHOW_STORES_IMAGES == 'Y')
				{
					logotype = this.getImageSources(selectedPickUp, 'IMAGE_ID');
					imgSrc = logotype.src_1x || this.defaultStoreLogo;

					html += '<img src="' + imgSrc + '" class="bx-soa-pickup-preview-img">';
				}

				html += '<div>' + BX.util.htmlspecialchars(selectedPickUp.TITLE) + '</div>';
				if (selectedPickUp.ADDRESS)
					html += '<br><div>' + BX.message('SOA_PICKUP_ADDRESS') + ':</div> ' + BX.util.htmlspecialchars(selectedPickUp.ADDRESS);

				if (selectedPickUp.PHONE)
					html += '<br><div>' + BX.message('SOA_PICKUP_PHONE') + ':</div> ' + BX.util.htmlspecialchars(selectedPickUp.PHONE);

				if (selectedPickUp.SCHEDULE)
					html += '<br><div>' + BX.message('SOA_PICKUP_WORK') + ':</div> ' + BX.util.htmlspecialchars(selectedPickUp.SCHEDULE);

				if (selectedPickUp.DESCRIPTION)
					html += '<br><div>' + BX.message('SOA_PICKUP_DESC') + ':</div> ' + BX.util.htmlspecialchars(selectedPickUp.DESCRIPTION);

				pickUpContainer.innerHTML = html;

				if (this.params.SHOW_STORES_IMAGES == 'Y')
				{
					BX.bind(pickUpContainer.querySelector('.bx-soa-pickup-preview-img'), 'click', BX.delegate(function(e){
						this.popupShow(e, logotype && logotype.src_orig || imgSrc);
					}, this));
				}
        html += '</div>';
			}
		}

})();
