!function () {
    var r = {}, a = function (e) {
        e = e.currentTarget;
        e.removeEventListener("mousedown", a), e.value = e.getAttribute("placeholder"), e.setAttribute("placeholder", r[e.getAttribute("name")] || ""), e.removeAttribute("data-send-placeholder")
    }, s = {text: "name", tel: "phone", email: "email"}, c = new function (e) {
        var t = this;
        void 0 === e && (e = {}), this.session_uid = null, this.gso_origin = null, this.propertiesHandler = e.propertiesHandler || function () {
            return !0
        }, this.getSessionUid = function () {
            return t.session_uid ? t.session_uid.split("_")[1] : t.session_uid
        }, this.sendInternalMetadata = function () {
            try {
                t.iframe.contentWindow.postMessage({method: "send_internal_meta", payload: {}}, t.gso_origin)
            } catch (e) {
                console.log(e)
            }
        }, this.tryUpdateProperties = function (e) {
            void 0 === e && (e = null);
            try {
                e && (t.propertiesHandler = e), t.iframe.contentWindow.postMessage({
                    method: "try_update_properties",
                    payload: {}
                }, t.gso_origin)
            } catch (e) {
                console.log(e)
            }
        }, this.handlers = {
            send_meta: function (e, t) {
                try {
                    this.iframe.contentWindow.postMessage({method: "send_meta", payload: t}, this.gso_origin)
                } catch (e) {
                    console.log(e)
                }
            }.bind(this), onload_iframe: function (e, t) {
                var o = this, n = "ru" === t.form.locale ? "ru" : "com", r = t.form.protocol,
                    a = r + "://gso.amocrm." + n;
                this.gso_origin = r + "://gso.amocrm." + n, this.iframe = document.createElement("iframe"), this.iframe.setAttribute("id", "forms_pixel_" + t.form.id), this.iframe.setAttribute("name", "forms_pixel_" + t.form.id), this.iframe.setAttribute("style", "display: none;"), this.iframe.src = a + "/pixel/html/forms.html?uB0tnu1ySULvBf7FHh3NF", this.iframe.addEventListener("load", function () {
                    try {
                        o.iframe.contentWindow.postMessage({method: "onload_iframe", payload: t}, o.gso_origin)
                    } catch (e) {
                        console.log(e)
                    }
                }), document.body.appendChild(this.iframe)
            }.bind(this), set_session: function (e, t) {
                this.session_uid = t.session_uid
            }.bind(this), handle_properties: function (e, t) {
                "function" == typeof this.propertiesHandler && this.propertiesHandler(t.properties)
            }.bind(this)
        }, window.addEventListener("message", function (e) {
            e.data && e.data.method && "function" == typeof t.handlers[e.data.method] && t.handlers[e.data.method](e, e.data.payload)
        })
    }({
        propertiesHandler: fillFields = function (e) {
            var t, o, n = document.querySelectorAll(".amoforms_placeholder");
            for (i = 0; i < n.length; i++) {
                n[i].removeAttribute("data-send-placeholder"), function (e) {
                    e = e.getAttribute("name").split("]")[0].split("_")[1];
                    return "1" === String(e)
                }(n[i]) && (t = n[i].getAttribute("type"), o = e[s[t]], "text" === t && "fields[name_1]" !== n[i].getAttribute("name") || !n[i].value && o && (r[n[i].getAttribute("name")] || (r[n[i].getAttribute("name")] = n[i].getAttribute("placeholder")), n[i].setAttribute("placeholder", o), n[i].setAttribute("data-send-placeholder", "Y"), n[i].addEventListener("mousedown", a), n[i].value = ""))
            }
        }
    }), l = new function (t) {
        function o(e) {
            return "" + t.prefix + e.getAttribute("name")
        }

        var n = document.querySelectorAll(t.inputs_class_dot);
        try {
            if (window.localStorage) {
                document.addEventListener("input", function (e) {
                    e.target.classList.contains(t.inputs_class) && window.localStorage.setItem(o(e.target), e.target.value)
                });
                for (var e = 0; e < n.length; ++e) {
                    var r = window.localStorage.getItem(o(n[e]));
                    r && (n[e].value = r)
                }
            }
        } catch (e) {
        }
        this.clear = function () {
            try {
                if (window.localStorage) for (var e = 0; e < n.length; ++e) window.localStorage.removeItem(o(n[e]))
            } catch (e) {
            }
        }
    }({prefix: "forms_input_saver", inputs_class_dot: ".amoforms_placeholder", inputs_class: "amoforms_placeholder"});
    Element.prototype.matches || (Element.prototype.matches = Element.prototype.matchesSelector || Element.prototype.webkitMatchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector), Element.prototype.closest || (Element.prototype.closest = function (e) {
        for (var t = this; t;) {
            if (t.matches(e)) return t;
            t = t.parentElement
        }
        return null
    }), Object.assign || Object.defineProperty(Object, "assign", {
        enumerable: !1,
        configurable: !0,
        writable: !0,
        value: function (e, t) {
            var o = arguments;
            if (null == e) throw new TypeError("Cannot convert first argument to object");
            for (var n = Object(e), r = 1; r < arguments.length; r++) {
                var a = o[r];
                if (null != a) for (var i = Object.keys(Object(a)), s = 0, l = i.length; s < l; s++) {
                    var d = i[s], c = Object.getOwnPropertyDescriptor(a, d);
                    void 0 !== c && c.enumerable && (n[d] = a[d])
                }
            }
            return n
        }
    });

    function d(e) {
        if (null != e) for (; e = e.parentNode;) if (e === document) return 1
    }

    var u, m, f, e, p, h, g = document.forms[0], v = "", y = !1,
        o = document.querySelectorAll(".text-input, .amoforms-input-select"), n = o.length,
        b = document.querySelectorAll('input[type="checkbox"], input[type="radio"]'), w = new function () {
            var o = {};
            this.setPrevValue = function (e, t) {
                o[e] = t
            }, this.getPrevValue = function (e) {
                return o[e]
            }
        };
    try {
        e = decodeURI(location.hash.substring(1)), f = JSON.parse(e.replace(/\n/g, "<br>").replace(/\r/g, ""))
    } catch (e) {
        throw new Error("Error parsing iframe parameters:", e.message)
    }
    try {
        var t = document.getElementById("user_origin"), S = document.getElementById("ga");
        t && (t.value = JSON.stringify(f.user_origin || {})), S && (S.value = JSON.stringify({
            ga: f.ga || {},
            utm: f.utm || {},
            data_source: "form"
        }));
        f.utm = f.utm || {}, ["utm_source", "utm_medium", "utm_campaign", "utm_term"].forEach(function (e) {
            var t = document.getElementById(e), e = e.substring(4);
            t && f.utm.hasOwnProperty(e) && (t.value = f.utm[e] || "")
        })
    } catch (e) {
    }
    !function () {
        try {
            window.AMOPIXEL_IDENTIFIER_PARAMS = window.AMOPIXEL_IDENTIFIER_PARAMS || {}, window.AMOPIXEL_IDENTIFIER_PARAMS.onload = function (e) {
                var t = e.getVisitorUid();
                t && ((e = document.createElement("input")).id = "visitor_uid", e.type = "hidden", e.name = "visitor_uid", e.value = t, g.appendChild(e))
            };
            var e = location.origin.replace(/forms\./, "piper."), t = document.createElement("script"),
                o = document.getElementsByTagName("script")[0];
            t.id = "amo_pixel_identifier_js", t.type = "text/javascript", t.async = !0, t.src = e + "/pixel/js/identifier/pixel_identifier.js", o.parentNode.insertBefore(t, o)
        } catch (e) {
        }
    }();
    var E, A;
    (A = f.dp.hash) && ((E = document.createElement("input")).id = "dp_hash", E.type = "hidden", E.name = "dp_hash", E.value = A, g.appendChild(E));

    function M() {
        var e, t = document.querySelectorAll(".amoforms-validate_required"),
            o = document.querySelectorAll(".amoforms-validate_email"),
            n = document.querySelectorAll(".amoforms-validate_phone"),
            r = document.querySelectorAll(".amoforms-validate_number"), a = !0, i = {
                email: /^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[\da-z](?:[\da-z-_]*[\da-z])?\.)+[a-z]{2,}$/i,
                phone: /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){5,14}(\s*)?$/,
                number: /^\d*\.?\d*$/
            };
        for (m = t.length, u = 0; u < m; u++) switch ((e = t[u]).type) {
            case"checkbox":
                e.checked || (a = !1, j(e, ne("invalid_required")));
                break;
            case"text":
            case"number":
            case"email":
            case"textarea":
                0 === e.value.length && (a = !1, j(e, ne("invalid_required")));
                break;
            case"select-multiple":
            case"select-one":
                0 !== e.value.length && "" !== e.value || (a = !1, j(e, ne("invalid_required")));
                break;
            case void 0:
                0 === e.querySelectorAll("input:checked").length && (a = !1, j(e, ne("invalid_required")))
        }
        for (m = o.length, u = 0; u < m; u++) e = o[u], i.email.test(e.value) || !Z(e, "amoforms-validate_required") && "" === e.value || (a = !1, j(e, ne("invalid_email")));
        for (m = r.length, u = 0; u < m; u++) e = r[u], i.number.test(e.value) || !Z(e, "amoforms-validate_required") && "" === e.value || (a = !1, j(e, ne("invalid_number")));
        for (m = n.length, u = 0; u < m; u++) e = n[u], i.phone.test(e.value) || !Z(e, "amoforms-validate_required") && "" === e.value || (a = !1, j(e, ne("invalid_phone")));
        return a
    }

    function x(e) {
        return (e = /fields\[([\w\_]+)\]/g.exec(e)) && e[1]
    }

    function k(e) {
        R = e
    }

    function q(t) {
        void 0 === t && (t = "to_value"), R && document.querySelectorAll(".amoforms_placeholder").forEach(function (e) {
            if ((!e.value || e.value === e.getAttribute("placeholder")) && "Y" === e.getAttribute("data-send-placeholder")) switch (t) {
                case"to_value":
                    e.value = e.getAttribute("placeholder");
                    break;
                case"from_value":
                    e.value = ""
            }
        })
    }

    var L = function () {
        var e = D();
        f.is_modal && (amoform_display = document.getElementById("amoform_display"), null !== amoform_display && (show_button = "N" !== amoform_display.value), show_button && (custom_btn_bg = document.getElementById("amoform_modal_button_bg_color").value, custom_btn_color = document.getElementById("amoform_modal_button_color").value, custom_btn_text = document.getElementById("amoform_modal_button_text").value, window.parent.postMessage('{ "iframe_id": "' + window.name + '", "func": "getFormInfo", "btn_background": "' + custom_btn_bg + '", "btn_text_color": "' + custom_btn_color + '", "btn_text": "' + custom_btn_text.replace('"', '\\"') + '", "version": 3, "height": ' + e + " }", f.location)))
    }, I = function () {
        (h = new Dropzone(".amoforms__field__control_file", {
            url: "/queue/add/",
            hiddenInputContainer: ".amoforms__field__control_file",
            previewTemplate: document.querySelector(".amoforms__field__file_dropzone").innerHTML,
            acceptedFiles: [".png", ".jpg", ".jpeg", ".gif", ".bmp", ".pdf", ".txt", ".rtf", ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".odt", ".ods", ".odp"].join(","),
            maxFilesize: 3,
            maxFiles: 1,
            createImageThumbnails: !1,
            autoProcessQueue: !1,
            autoQueue: !1,
            uploadMultiple: !1,
            clickable: ".amoforms__field__control_file, .amoforms__field__file_helper_text",
            dictFileTooBig: ne("too_large_file"),
            dictInvalidFileType: ne("invalid_file_type")
        })).on("addedfile", function (e) {
            for (var t = 0; t < h.files.length; t++) h.files[t] !== e && h.removeFile(h.files[t]);
            j(h.element), document.querySelector(".amoforms__field__file_helper_text").style.display = "none"
        }), h.on("removedfile", function (e) {
            j(h.element), document.querySelector(".amoforms__field__file_helper_text").style.display = "block"
        }), h.on("error", function (e, t) {
            j(h.element, t)
        })
    }, D = function () {
        var e, t;
        return "function" == typeof window.postMessage ? (t = window.getComputedStyle(document.forms[0].parentNode), e = document.body.offsetHeight, t = parseInt(t.maxWidth) || 0, f.is_modal || window.parent.postMessage('{ "iframe_id": "' + window.name + '", "func": "resizeForm", "height": ' + e + ', "max_width": ' + t + " }", f.location)) : (e = 10 * Math.ceil(document.forms[0].scrollHeight / 10), e += 20, window.name = "amo_h" + e), e
    }, T = function () {
        g.addEventListener("reset", function () {
            for (u = 0; u < n; u++) o[u].hasAttribute("data-selected") && o[u].setAttribute("data-selected", !1)
        })
    }, N = function () {
        for (var e = document.querySelectorAll(".checkboxes_dropdown__title_wrapper"), t = e.length, o = document.querySelectorAll(".checkboxes_dropdown__list"), n = 0; n < t; n++) {
            var r = e[n], a = r.nextElementSibling.querySelectorAll("input");
            r.addEventListener("click", function () {
                F(this), D()
            });
            for (var i = 0; i < a.length; i++) !function (e) {
                var t = a[e];
                0 === e && g.addEventListener("reset", function () {
                    a.forEach(function (e) {
                        e.checked = !1
                    }), P(t)
                }), t.addEventListener("change", function () {
                    P(this), this.classList.contains("js-master-checkbox") || C(this)
                })
            }(i)
        }
        document.addEventListener("click", function (e) {
            if (e.target.closest(".checkboxes_dropdown")) e.target.classList.contains("js-master-checkbox") && O(e.target); else for (var t = 0; t < o.length; t++) o[t].style.display = "none", o[t].closest(".amoforms__field__control_multiselect").classList.remove("dropdown_opened"), p = null;
            D()
        }), document.addEventListener("touchmove", function () {
            if (event.target.closest(".checkboxes_dropdown")) event.target.classList.contains("js-master-checkbox") && O(event.target); else for (var e = 0; e < o.length; e++) o[e].style.display = "none", o[e].closest(".amoforms__field__control_multiselect").classList.remove("dropdown_opened"), p = null;
            D()
        })
    }, O = function (e) {
        var t, o = e.closest(".checkboxes_dropdown"), n = o.querySelectorAll("input").length,
            r = o.querySelector(".checkboxes_dropdown__list").querySelectorAll("input:checked").length,
            a = new Event("change");
        if (e.checked) {
            if (r !== n) for (t = 0; t < n; t++) o.querySelectorAll("input")[t].checked = !0, o.querySelectorAll("input")[t].dispatchEvent(a)
        } else for (t = 0; t < n; t++) o.querySelectorAll("input")[t].checked = !1, o.querySelectorAll("input")[t].dispatchEvent(a)
    }, C = function (e) {
        var t = e.closest(".checkboxes_dropdown"), o = t.querySelectorAll("input:not(.js-master-checkbox)").length,
            e = t.querySelectorAll(".js-master-checkbox")[0],
            t = t.querySelector(".checkboxes_dropdown__list").querySelectorAll("input:checked:not(.js-master-checkbox)").length;
        e.checked ? t !== o && (e.checked = !1) : t === o && (e.checked = !0)
    }, F = function (e) {
        var t = e.closest(".checkboxes_dropdown"), o = t.closest(".amoforms__field__control_multiselect"),
            e = t.querySelector(".checkboxes_dropdown__list");
        p && (p.querySelector(".checkboxes_dropdown__list").style.display = "none", p.closest(".amoforms__field__control_multiselect").classList.remove("dropdown_opened"), p === t) ? p = null : ("block" === t.style.display ? (o.classList.remove("dropdown_opened"), e.style.display = "none") : (p = t, o.classList.add("dropdown_opened"), e.style.display = "block"), event.stopPropagation())
    }, P = function (e) {
        var t = e.closest(".checkboxes_dropdown"), o = t.querySelectorAll("input:not(.js-master-checkbox)").length,
            n = t.querySelector(".checkboxes_dropdown__list").querySelectorAll("input:checked:not(.js-master-checkbox)").length,
            e = t.querySelector(".checkboxes_dropdown__title");
        t.setAttribute("data-selected", 0 < n), e.textContent = n ? n === o ? ne("all_values") : B(n, e.getAttribute("data-numeral"), !0) : e.dataset.titleEmpty
    }, B = function (e, t, o) {
        var n, r = document.getElementById("amoform_iframe_lang").value;
        return t ? (n = t.toString().split(","), n = "ru" == r ? (r = (t = Math.abs(e) % 100) % 10, "all" == e ? n[3] : 10 < t && t < 20 ? n[2] : 1 < r && r < 5 ? n[1] : 1 == r ? n[0] : n[2]) : "all" == e ? _.isEmpty(n[2]) ? n[1] : n[2] : 1 != e ? n[1] : n[0], !0 === o && (n = e + " " + n), n) : ""
    }, j = function (e, t) {
        var o = e.closest(".amoforms__field__control"), e = x(e.name);
        "undefined" != typeof AMO_FIELDS_MAP && AMO_FIELDS_MAP[e] && AMO_FIELDS_MAP[e].error_text && (t = AMO_FIELDS_MAP[e].error_text), o.classList.contains("amoforms__field__error") ? t || (o.classList.remove("amoforms__field__error"), H(o)) : t && (o.classList.add("amoforms__field__error"), Y(o, t))
    }, Y = function (e, t) {
        var o = document.createElement("div");
        o.className = "amoforms__field__error_message", o.innerHTML = t, e.appendChild(o)
    }, H = function (e) {
        var t = e.querySelector(".amoforms__field__error_message");
        t && e.removeChild(t)
    }, R = !0;
    document.getElementById("button_submit").addEventListener("mouseover", q.bind(null, "to_value")), document.getElementById("button_submit").addEventListener("mouseout", q.bind(null, "from_value"));
    var z = {}, J = function (e) {
        var t = "", o = {};
        switch (!0) {
            case 500 === e.status:
                t = ne("invalid_server_response");
                break;
            case 403 === e.status:
                t = ne("auth_required");
                break;
            case 200 === e.status || 400 === e.status:
                try {
                    o = JSON.parse(e.responseText)
                } catch (e) {
                }
                t = 0 === o.error_code ? f.success_message || ne("form_sent_successfully") : ne(o.msg);
                break;
            default:
                t = ne("invalid_server_response")
        }
        return Object.assign({}, o, {msg: t})
    }, W = function (e) {
        var t = e.readyStateCb, o = e.beforeSendCb, n = G(),
            r = document.getElementById("amoforms__fields__error-required"),
            a = document.getElementById("amoforms__fields__error-typo");
        n.onreadystatechange = (t || function () {
        }).bind(null, n), g.action = window.location.origin + "/queue/add", n.open("POST", g.action, !0), e = new FormData(g), h && h.files.length && (t = document.querySelector(".amoforms__field__file_hidden_input").id, e.append(t, h.files[0])), "function" == typeof o && o(e), r.innerHTML = "", a.innerHTML = "", n.send(e)
    }, U = function () {
        document.querySelector(".amoforms__spinner-icon") && (document.querySelector(".amoforms__spinner-icon").style.display = "none"), document.querySelector(".amoforms__submit-button-text") && (document.querySelector(".amoforms__submit-button-text").style.display = "block")
    }, V = function () {
        document.querySelector(".amoforms__submit-button-text") && (document.querySelector(".amoforms__submit-button-text").style.display = "none"), document.querySelector(".amoforms__spinner-icon") && (document.querySelector(".amoforms__spinner-icon").style.display = "block")
    }, $ = function () {
        var e = document.getElementById("button_submit");
        e.classList.add("amoforms__submit_button_shake"), setTimeout(function () {
            e.classList.remove("amoforms__submit_button_shake")
        }, 300)
    }, X = function (e, t, o) {
        var n, r, a;
        document.getElementById("button_submit").disabled = !0, e = decodeURI(e), (n = document.createElement("div")).className = "amoforms-sended-message" + (o ? " blocked" : ""), n.style.opacity = 0, n.style.top = "-1px", n.style.right = "-1px", n.style.bottom = "-1px", n.style.left = "-1px";
        var i = document.createElement("div");
        if (i.className = "amoforms-sended-message_wrapper", (r = document.createElement("div")).className = "amoforms-sended-message_inner", t && 200 !== t) (a = document.createElement("div")).className = "amoforms-sended-message_icon", r.appendChild(a), error_message = document.createElement("div"), error_message.className = "amoforms-sended-message_error", r.appendChild(error_message), r.className += " error-message"; else {
            if (l.clear(), window.parent.postMessage('{ "iframe_id": "' + window.name + '", "func": "amoformsSuccessSubmit"}', f.location), f.has_redirect) return;
            c.tryUpdateProperties(), (a = document.createElement("div")).className = "amoforms-sended-message_icon", r.appendChild(a), o && (document.getElementById("button_submit").disabled = !0)
        }
        (a = document.createElement("div")).className = "amoforms-sended-message_text", i.appendChild(r), n.appendChild(i), r.appendChild(a), a.innerHTML = e, document.getElementById("amofroms_main_wrapper").appendChild(n);
        var s = 0;
        return n.style.zIndex = 25, window.parent.postMessage("getWindowHeightAndIframeTopPos", f.location), window.addEventListener("message", function (e) {
            try {
                JSON.parse(e.data)
            } catch (e) {
                return
            }
            var t = JSON.parse(e.data), o = n.querySelector(".amoforms-sended-message_wrapper");
            t.is_hidden && o && (t.bottom_indent = t.bottom_indent - o.offsetHeight / 2, o.style.bottom = (t.bottom_indent || 0) + "px")
        }, !1), void 0 !== window.form_type_gso && window.form_type_gso ? (setTimeout(function () {
            var e;
            n.style.opacity = 1, t && 200 !== t || ("function" == typeof window.parent.postMessage && (e = document.forms[0].scrollHeight + 15, window.parent.postMessage('{ "iframe_id": "' + window.name + '", "func": "pushGaForm", "height": ' + e + "}", f.location)), g.reset(), h && h.removeAllFiles(!0))
        }, 40), q("from_value"), setTimeout(function () {
            n.style.opacity = "0", n.style.display = "none", d(n) && n.parentNode.removeChild(n), document.getElementById("button_submit").disabled = !1
        }, 5e3), n.onclick = function () {
            n.style.opacity = "0", document.getElementById("button_submit").disabled = !1, n.style.display = "none", n.parentNode.removeChild(n)
        }) : setTimeout(function () {
            var e;
            s += .05, (n.style.opacity = s) < 1 ? setTimeout(arguments.callee, 10) : (t && 200 !== t || ("function" == typeof window.parent.postMessage && (e = document.forms[0].scrollHeight + 15, window.parent.postMessage('{ "iframe_id": "' + window.name + '", "func": "pushGaForm", "height": ' + e + "}", f.location)), g.reset(), h && h.removeAllFiles(!0)), q("from_value"), o || (n.onclick = function () {
                setTimeout(function () {
                    s -= .05, 0 < (n.style.opacity = s) ? setTimeout(arguments.callee, 10) : (document.getElementById("button_submit").disabled = !1, n.style.display = "none", n.parentNode && n.parentNode.removeChild(n))
                }, 10)
            }, setTimeout(function () {
                setTimeout(function () {
                    s -= .05, 0 < (n.style.opacity = s) ? setTimeout(arguments.callee, 10) : (n.style.display = "none", d(n) && n.parentNode.removeChild(n), document.getElementById("button_submit").disabled = !1, window.parent.postMessage('{ "iframe_id": "' + window.name + '", "func": "hideOverlay"}', f.location))
                }, 10)
            }, 2e3)))
        }, 10), !1
    }, G = function () {
        return new XMLHttpRequest
    }, K = function (e) {
        var t = e.keyCode, o = e.key, n = e.target.value, r = e.ctrlKey || e.metaKey;
        46 === t || 8 === t || 9 === t || 27 === t || 67 === t && !0 === r || 90 === t && !0 === r || 88 === t && !0 === r || 65 === t && !0 === r || 86 === t && !0 === r || 82 === t && !0 === r || 190 === t && (!0 === r || "." === o) || 191 === t && (!0 === r || "." === o) || 35 <= t && t <= 39 && 38 !== t ? 190 !== t && 191 !== t || !n.match(/^\d*\.{1}\d*$/) || e.preventDefault() : o.match(/^\d*\.?\d*$/) || e.preventDefault()
    };
    var Q = function (e) {
        var t = e.target.value, o = e.target.name,
            t = (o = o, (t = t) && !t.match(/^\d*\.?\d*$/) ? w.getPrevValue(o) : (w.setPrevValue(o, t), t));
        e.target.value = t
    };
    var Z = function (e, t) {
        return new RegExp("(\\s|^)" + t + "(\\s|$)").test(e.className)
    }, ee = {
        ru: {
            months: "РЇРЅРІР°СЂСЊ_Р¤РµРІСЂР°Р»СЊ_РњР°СЂС‚_РђРїСЂРµР»СЊ_РњР°Р№_РСЋРЅСЊ_РСЋР»СЊ_РђРІРіСѓСЃС‚_РЎРµРЅС‚СЏР±СЂСЊ_РћРєС‚СЏР±СЂСЊ_РќРѕСЏР±СЂСЊ_Р”РµРєР°Р±СЂСЊ".split("_"),
            weekdays: "Р’РѕСЃРєСЂРµСЃРµРЅСЊРµ_РџРѕРЅРµРґРµР»СЊРЅРёРє_Р’С‚РѕСЂРЅРёРє_РЎСЂРµРґР°_Р§РµС‚РІРµСЂРі_РџСЏС‚РЅРёС†Р°_РЎСѓР±Р±РѕС‚Р°".split("_"),
            weekdaysShort: "Р’СЃРє_РџРЅРґ_Р’С‚СЂ_РЎСЂРґ_Р§С‚РІ_РџС‚РЅ_РЎР±С‚".split("_"),
            timeLabel: "Р’СЂРµРјСЏ"
        },
        en: {
            months: "January_February_March_April_May_June_July_August_September_October_November_December".split("_"),
            weekdays: "Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),
            weekdaysShort: "Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"),
            midnight: "12AM",
            noon: "12PM",
            timeLabel: "Time"
        },
        es: {
            months: "Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre".split("_"),
            weekdays: "Domingo_Lunes_Martes_MiГ©rcoles_Jueves_Viernes_SГЎbado".split("_"),
            weekdaysShort: "Dom._Lun._Mar._MiГ©._Jue._Vie._SГЎb.".split("_"),
            midnight: "12AM",
            noon: "12PM",
            timeLabel: "Hora"
        }
    }, te = function (e) {
        var t, o, n = document.querySelectorAll(".amoform-input-pikaday, .amoform-input-pikaday-time"), r = {
            firstDay: e,
            minDate: new Date("1900-01-01"),
            maxDate: new Date("2030-12-31"),
            yearRange: [1900, 2030],
            defaultDate: new Date,
            i18n: ee[v]
        };
        for (u = 0, m = n.length; u < m; u++) {
            switch (o = n[u].classList.contains("amoform-input-pikaday-time"), t = Object.assign({
                field: n[u],
                showTime: o,
                incrementMinuteBy: 15,
                use24hour: "ru" === v,
                timeLabel: ee[v].timeLabel
            }, r), v) {
                case"ru":
                    t.format = o ? "DD.MM.YYYY HH:mm" : "DD.MM.YYYY";
                    break;
                case"es":
                    t.format = o ? "DD/MM/YYYY h:mmA" : "DD/MM/YYYY";
                    break;
                default:
                    t.format = o ? "MM/DD/YYYY h:mmA" : "MM/DD/YYYY"
            }
            new Pikaday(t), n[u].addEventListener("change", function () {
                j(this)
            })
        }
    }, oe = {
        Select: {en: "Select", es: "Elegir", ru: "Р’С‹Р±СЂР°С‚СЊ"},
        all_values: {en: "All Values", es: "Todos los valores", ru: "Р’СЃРµ Р·РЅР°С‡РµРЅРёСЏ"},
        required_field: {en: "Required field", es: "Campo obligatorio", ru: "РћР±СЏР·Р°С‚РµР»СЊРЅРѕРµ РїРѕР»Рµ"},
        form_sent_successfully: {
            en: "Form successfully submitted",
            es: "Formulario enviado con Г©xito",
            ru: "Р¤РѕСЂРјР° СѓСЃРїРµС€РЅРѕ РѕС‚РїСЂР°РІР»РµРЅР°"
        },
        error: {en: "Error", es: "Error", ru: "РћС€РёР±РєР°"},
        failed_to_send_the_form: {
            en: "Failed to send the form",
            es: "SurgiГі un error al enviar el formulario",
            ru: "РќРµ СѓРґР°Р»РѕСЃСЊ РѕС‚РїСЂР°РІРёС‚СЊ С„РѕСЂРјСѓ"
        },
        invalid_email: {
            en: "E-mail is not valid",
            es: "Correo electrГіnico invГЎlido",
            ru: "E-mail СѓРєР°Р·Р°РЅ РЅРµРІРµСЂРЅРѕ"
        },
        invalid_number: {en: "Invalid number", es: "NГєmero invГЎlido", ru: "РќРµРІРµСЂРЅРѕРµ С‡РёСЃР»Рѕ"},
        invalid_phone: {
            en: "Phone is not valid",
            es: "TelГ©fono no vГЎlido",
            ru: "РўРµР»РµС„РѕРЅ СѓРєР°Р·Р°РЅ РЅРµРІРµСЂРЅРѕ"
        },
        invalid_server_response: {
            en: "Invalid server response",
            es: "Respuesta del servidor invГЎlida",
            ru: "РќРµРІРµСЂРЅС‹Р№ РѕС‚РІРµС‚ СЃРµСЂРІРµСЂР°"
        },
        auth_required: {
            en: "Auth required",
            es: "Necesita autorizarse",
            ru: "РўСЂРµР±СѓРµС‚СЃСЏ Р°РІС‚РѕСЂРёР·Р°С†РёСЏ"
        },
        invalid_data: {
            en: "Invalid data",
            es: "Datos invГЎlidos",
            ru: "Р”Р°РЅРЅС‹Рµ РІРІРµРґРµРЅС‹ РЅРµРєРѕСЂСЂРµРєС‚РЅРѕ"
        },
        queue_duplicate: {en: "Duplicated data", es: "Datos duplicados", ru: "Р”СѓР±Р»РёСЂСѓСЋС‰РёРµСЃСЏ РґР°РЅРЅС‹Рµ"},
        empty_logo_name: {en: "Empty logo name", es: "Nombre del logotipo vacГ­o", ru: "РџСѓСЃС‚РѕР№ Р»РѕРіРѕС‚РёРї"},
        invalid_required: {
            en: "Invalid required field",
            es: "Campo obligatorio invГЎlido",
            ru: "РћР±СЏР·Р°С‚РµР»СЊРЅС‹Рµ РїРѕР»СЏ РЅРµ Р·Р°РїРѕР»РЅРµРЅС‹"
        },
        invalid_form: {
            en: "Invalid form",
            es: "formulario invГЎlido",
            ru: "Р¤РѕСЂРјР° Р·Р°РїРѕР»РЅРµРЅР° РЅРµРєРѕСЂСЂРµРєС‚РЅРѕ"
        },
        empty_data: {en: "Empty data", es: "Datos vacГ­os", ru: "РџСѓСЃС‚С‹Рµ РґР°РЅРЅС‹Рµ"},
        close_message: {en: "Close this message", es: "Cerrar mensaje", ru: "Р—Р°РєСЂС‹С‚СЊ СЃРѕРѕР±С‰РµРЅРёРµ"},
        too_large_file: {
            en: "The file is too big",
            es: "El archivo es demasiado grande",
            ru: "РЎР»РёС€РєРѕРј Р±РѕР»СЊС€РѕР№ С„Р°Р№Р»"
        },
        invalid_file_type: {
            en: "Invalid file type",
            es: "El formato del archivo es incorrecto",
            ru: "РќРµРІРµСЂРЅС‹Р№ С‚РёРї С„Р°Р№Р»Р°"
        },
        too_long_data: {
            en: "Too long text",
            es: "Texto demasiado largo",
            ru: "Р’РІРµРґРµРЅ СЃР»РёС€РєРѕРј РґР»РёРЅРЅС‹Р№ С‚РµРєСЃС‚"
        }
    }, ne = function (e) {
        return oe.hasOwnProperty(e) && oe[e].hasOwnProperty(v) ? oe[e][v] : e
    };
    window.addEventListener("message", function (e) {
        "amoforms:submit:disable" === e.data && (y = !0), "close:complete:fade" === e.data && (e = document.querySelector(".amoforms-sended-message"), d(e) && e.parentNode.removeChild(e), document.getElementById("button_submit").disabled = !1)
    }, !1);
    var re, ae = document.getElementById("button_messenger_submit");
    ae && ae.addEventListener("click", function (e) {
        var t, o, n, r, a, i = document.getElementById("button_messenger_submit"), s = M(),
            i = i.getAttribute("data-href"), l = function (e) {
                void 0 === e && (e = 21);
                for (var t = "", o = crypto.getRandomValues(new Uint8Array(e)); e--;) {
                    var n = 63 & o[e];
                    t += n < 36 ? n.toString(36) : n < 62 ? (n - 26).toString(36).toUpperCase() : n < 63 ? "_" : "-"
                }
                return t
            }(10), d = "";
        if (e.preventDefault(), c.sendInternalMetadata(), !s || y) return $(), X(ne("invalid_required"), 400), !1;
        if (i) {
            if (Object.keys(AMO_FIELDS_MAP).length) {
                for (r = g.elements, a = 0; a < r.length; a++) t = x(r[a].name), AMO_FIELDS_MAP[t] && (n = AMO_FIELDS_MAP[t], o = r[a].value, (o = n.enums && n.enums[o] ? AMO_FIELDS_MAP[t].enums[o] : o) && (d += [n.name, o].join(": ") + "\n"));
                z[d] || (z[d] = l), l = z[d]
            }
            d = "ID: " + l + " \n\n" + d, W({
                beforeSendCb: function (e) {
                    e.append("form_request_id", l), e.append("gso_session_uid", c.getSessionUid())
                }
            }), window.open(i + encodeURIComponent(d) + "&context=" + l, "_blank")
        }
    }), re = function () {
        !function () {
            var e, t;
            v = document.getElementById("amoform_iframe_lang").value;
            for (u = 0; u < n; u++) !function () {
                var t = o[u];
                t.addEventListener("input", function () {
                    j(this)
                }), t.classList.contains("amoforms-input-select") && "SELECT" === t.tagName && t.addEventListener("change", function (e) {
                    t.setAttribute("data-selected", "" !== e.currentTarget.value)
                })
            }();
            for (u = 0; u < b.length; u++) b[u].addEventListener("change", function () {
                j(this)
            });
            for (e = document.querySelectorAll(".amoforms-validate_number"), u = 0; u < e.length; u++) e[u].addEventListener("keydown", K);
            for (e = document.querySelectorAll(".amoforms-validate_number"), u = 0; u < e.length; u++) w.setPrevValue(e[u].name, ""), e[u].addEventListener("input", Q);
            t = "amo-brand__" + (f.is_dark_bg ? "dark" : "light"), document.getElementById("amo_brand").classList.add(t), L(), te("en" === v ? 0 : 1), T(), N(), document.querySelector(".amoforms__field__control_file") && I()
        }()
    }, "loading" != document.readyState ? re() : document.addEventListener("DOMContentLoaded", re), window.onload = function () {
        f.is_modal || L(), window.addEventListener("message", function (e) {
            var t;
            try {
                t = (JSON.parse(e.data) || {}).parent_window_width || "Nothing"
            } catch (e) {
                return
            }
            "Nothing" !== t && t <= 900 && (document.querySelector("body").classList.add = "MobileDevice", document.querySelector(".amoforms-sended-message").style.width = "420px", document.querySelector("#amofroms_main_wrapper").style.marginLeft = "0px")
        }, !1), f.is_modal ? (window.parent.postMessage("getWindowWidthIsModal", f.location), window.parent.postMessage("setMobileFormWidth", f.location)) : window.parent.postMessage("getWindowWidth", f.location)
    }, g.onsubmit = function (e) {
        return e.stopPropagation(), e.preventDefault(), k(!0), q("to_value"), k(!1), V(), c.sendInternalMetadata(), !M() || y ? (k(!0), q("from_value"), $(), X(ne("invalid_required"), 400), U()) : W({
            readyStateCb: function (t) {
                try {
                    if (4 !== t.readyState) return;
                    k(!0);
                    var e = J(t);
                    U(), X(e.msg, t.status, !!e.lock_form)
                } catch (e) {
                    U(), X(ne("invalid_server_response"), t.status)
                }
            }, beforeSendCb: function (e) {
                e.append("gso_session_uid", c.getSessionUid())
            }
        }), !1
    }
}();