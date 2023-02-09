!function (t, e) {
    "object" == typeof exports && "undefined" != typeof module ? e(exports, require("jquery"), require("popper.js")) : "function" == typeof define && define.amd ? define(["exports", "jquery", "popper.js"], e) : e(t.bootstrap = {}, t.jQuery, t.Popper)
}(this, function (t, e, h) {
    "use strict";

    function i(t, e) {
        for (var n = 0; n < e.length; n++) {
            var i = e[n];
            i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i)
        }
    }

    function s(t, e, n) {
        return e && i(t.prototype, e), n && i(t, n), t
    }

    function l(r) {
        for (var t = 1; t < arguments.length; t++) {
            var o = null != arguments[t] ? arguments[t] : {}, e = Object.keys(o);
            "function" == typeof Object.getOwnPropertySymbols && (e = e.concat(Object.getOwnPropertySymbols(o).filter(function (t) {
                return Object.getOwnPropertyDescriptor(o, t).enumerable
            }))), e.forEach(function (t) {
                var e, n, i;
                e = r, i = o[n = t], n in e ? Object.defineProperty(e, n, {
                    value: i,
                    enumerable: !0,
                    configurable: !0,
                    writable: !0
                }) : e[n] = i
            })
        }
        return r
    }

    e = e && e.hasOwnProperty("default") ? e.default : e, h = h && h.hasOwnProperty("default") ? h.default : h;
    var r, n, o, a, c, u, f, d, g, _, m, p, v, y, E, T, C, b, S, I, D, A, w, N, O, k, P, j, H, L, R, F, x, U, W, q, M,
        K, B, Q, V, Y, G, z, J, Z, $, X, tt, et, nt, it, rt, ot, st, at, lt, ct, ht, ut, ft, dt, gt, _t, mt, pt, vt, yt,
        Et, Tt, Ct, bt, St, It, Dt, At, wt, Nt, Ot, kt, Pt, jt, Ht, Lt, Rt, Ft, xt, Ut, Wt, qt, Mt, Kt, Bt, Qt, Vt, Yt,
        Gt, zt, Jt, Zt, $t, Xt, te, ee, ne, ie, re, oe, se, ae, le, ce, he, ue, fe, de, ge, _e, me, pe, ve, ye, Ee, Te,
        Ce, be, Se, Ie, De, Ae, we, Ne, Oe, ke, Pe, je, He, Le, Re, Fe, xe, Ue, We, qe, Me, Ke, Be, Qe, Ve, Ye, Ge, ze,
        Je, Ze, $e, Xe, tn, en, nn, rn, on, sn, an, ln, cn, hn, un, fn, dn, gn, _n, mn, pn, vn, yn, En, Tn, Cn, bn, Sn,
        In, Dn, An, wn, Nn, On, kn, Pn, jn, Hn, Ln, Rn, Fn, xn, Un, Wn, qn = function (i) {
            var e = "transitionend";

            function t(t) {
                var e = this, n = !1;
                return i(this).one(l.TRANSITION_END, function () {
                    n = !0
                }), setTimeout(function () {
                    n || l.triggerTransitionEnd(e)
                }, t), this
            }

            var l = {
                TRANSITION_END: "bsTransitionEnd", getUID: function (t) {
                    for (; t += ~~(1e6 * Math.random()), document.getElementById(t);) ;
                    return t
                }, getSelectorFromElement: function (t) {
                    var e = t.getAttribute("data-target");
                    e && "#" !== e || (e = t.getAttribute("href") || "");
                    try {
                        return document.querySelector(e) ? e : null
                    } catch (t) {
                        return null
                    }
                }, getTransitionDurationFromElement: function (t) {
                    if (!t) return 0;
                    var e = i(t).css("transition-duration");
                    return parseFloat(e) ? (e = e.split(",")[0], 1e3 * parseFloat(e)) : 0
                }, reflow: function (t) {
                    return t.offsetHeight
                }, triggerTransitionEnd: function (t) {
                    i(t).trigger(e)
                }, supportsTransitionEnd: function () {
                    return Boolean(e)
                }, isElement: function (t) {
                    return (t[0] || t).nodeType
                }, typeCheckConfig: function (t, e, n) {
                    for (var i in n) if (Object.prototype.hasOwnProperty.call(n, i)) {
                        var r = n[i], o = e[i],
                            s = o && l.isElement(o) ? "element" : (a = o, {}.toString.call(a).match(/\s([a-z]+)/i)[1].toLowerCase());
                        if (!new RegExp(r).test(s)) throw new Error(t.toUpperCase() + ': Option "' + i + '" provided type "' + s + '" but expected type "' + r + '".')
                    }
                    var a
                }
            };
            return i.fn.emulateTransitionEnd = t, i.event.special[l.TRANSITION_END] = {
                bindType: e,
                delegateType: e,
                handle: function (t) {
                    if (i(t.target).is(this)) return t.handleObj.handler.apply(this, arguments)
                }
            }, l
        }(e), Mn = (n = "alert", a = "." + (o = "bs.alert"), c = (r = e).fn[n], u = {
            CLOSE: "close" + a,
            CLOSED: "closed" + a,
            CLICK_DATA_API: "click" + a + ".data-api"
        }, f = "alert", d = "fade", g = "show", _ = function () {
            function i(t) {
                this._element = t
            }

            var t = i.prototype;
            return t.close = function (t) {
                var e = this._element;
                t && (e = this._getRootElement(t)), this._triggerCloseEvent(e).isDefaultPrevented() || this._removeElement(e)
            }, t.dispose = function () {
                r.removeData(this._element, o), this._element = null
            }, t._getRootElement = function (t) {
                var e = qn.getSelectorFromElement(t), n = !1;
                return e && (n = document.querySelector(e)), n || (n = r(t).closest("." + f)[0]), n
            }, t._triggerCloseEvent = function (t) {
                var e = r.Event(u.CLOSE);
                return r(t).trigger(e), e
            }, t._removeElement = function (e) {
                var n = this;
                if (r(e).removeClass(g), r(e).hasClass(d)) {
                    var t = qn.getTransitionDurationFromElement(e);
                    r(e).one(qn.TRANSITION_END, function (t) {
                        return n._destroyElement(e, t)
                    }).emulateTransitionEnd(t)
                } else this._destroyElement(e)
            }, t._destroyElement = function (t) {
                r(t).detach().trigger(u.CLOSED).remove()
            }, i._jQueryInterface = function (n) {
                return this.each(function () {
                    var t = r(this), e = t.data(o);
                    e || (e = new i(this), t.data(o, e)), "close" === n && e[n](this)
                })
            }, i._handleDismiss = function (e) {
                return function (t) {
                    t && t.preventDefault(), e.close(this)
                }
            }, s(i, null, [{
                key: "VERSION", get: function () {
                    return "4.1.3"
                }
            }]), i
        }(), r(document).on(u.CLICK_DATA_API, '[data-dismiss="alert"]', _._handleDismiss(new _)), r.fn[n] = _._jQueryInterface, r.fn[n].Constructor = _, r.fn[n].noConflict = function () {
            return r.fn[n] = c, _._jQueryInterface
        }, _),
        Kn = (p = "button", y = "." + (v = "bs.button"), E = ".data-api", T = (m = e).fn[p], C = "active", b = "btn", I = '[data-toggle^="button"]', D = '[data-toggle="buttons"]', A = "input", w = ".active", N = ".btn", O = {
            CLICK_DATA_API: "click" + y + E,
            FOCUS_BLUR_DATA_API: (S = "focus") + y + E + " blur" + y + E
        }, k = function () {
            function n(t) {
                this._element = t
            }

            var t = n.prototype;
            return t.toggle = function () {
                var t = !0, e = !0, n = m(this._element).closest(D)[0];
                if (n) {
                    var i = this._element.querySelector(A);
                    if (i) {
                        if ("radio" === i.type) if (i.checked && this._element.classList.contains(C)) t = !1; else {
                            var r = n.querySelector(w);
                            r && m(r).removeClass(C)
                        }
                        if (t) {
                            if (i.hasAttribute("disabled") || n.hasAttribute("disabled") || i.classList.contains("disabled") || n.classList.contains("disabled")) return;
                            i.checked = !this._element.classList.contains(C), m(i).trigger("change")
                        }
                        i.focus(), e = !1
                    }
                }
                e && this._element.setAttribute("aria-pressed", !this._element.classList.contains(C)), t && m(this._element).toggleClass(C)
            }, t.dispose = function () {
                m.removeData(this._element, v), this._element = null
            }, n._jQueryInterface = function (e) {
                return this.each(function () {
                    var t = m(this).data(v);
                    t || (t = new n(this), m(this).data(v, t)), "toggle" === e && t[e]()
                })
            }, s(n, null, [{
                key: "VERSION", get: function () {
                    return "4.1.3"
                }
            }]), n
        }(), m(document).on(O.CLICK_DATA_API, I, function (t) {
            t.preventDefault();
            var e = t.target;
            m(e).hasClass(b) || (e = m(e).closest(N)), k._jQueryInterface.call(m(e), "toggle")
        }).on(O.FOCUS_BLUR_DATA_API, I, function (t) {
            var e = m(t.target).closest(N)[0];
            m(e).toggleClass(S, /^focus(in)?$/.test(t.type))
        }), m.fn[p] = k._jQueryInterface, m.fn[p].Constructor = k, m.fn[p].noConflict = function () {
            return m.fn[p] = T, k._jQueryInterface
        }, k), Bn = (j = "carousel", L = "." + (H = "bs.carousel"), R = ".data-api", F = (P = e).fn[j], x = {
            interval: 5e3,
            keyboard: !0,
            slide: !1,
            pause: "hover",
            wrap: !0
        }, U = {
            interval: "(number|boolean)",
            keyboard: "boolean",
            slide: "(boolean|string)",
            pause: "(string|boolean)",
            wrap: "boolean"
        }, W = "next", q = "prev", M = "left", K = "right", B = {
            SLIDE: "slide" + L,
            SLID: "slid" + L,
            KEYDOWN: "keydown" + L,
            MOUSEENTER: "mouseenter" + L,
            MOUSELEAVE: "mouseleave" + L,
            TOUCHEND: "touchend" + L,
            LOAD_DATA_API: "load" + L + R,
            CLICK_DATA_API: "click" + L + R
        }, Q = "carousel", V = "active", Y = "slide", G = "carousel-item-right", z = "carousel-item-left", J = "carousel-item-next", Z = "carousel-item-prev", $ = ".active", X = ".active.carousel-item", tt = ".carousel-item", et = ".carousel-item-next, .carousel-item-prev", nt = ".carousel-indicators", it = "[data-slide], [data-slide-to]", rt = '[data-ride="carousel"]', ot = function () {
            function o(t, e) {
                this._items = null, this._interval = null, this._activeElement = null, this._isPaused = !1, this._isSliding = !1, this.touchTimeout = null, this._config = this._getConfig(e), this._element = P(t)[0], this._indicatorsElement = this._element.querySelector(nt), this._addEventListeners()
            }

            var t = o.prototype;
            return t.next = function () {
                this._isSliding || this._slide(W)
            }, t.nextWhenVisible = function () {
                !document.hidden && P(this._element).is(":visible") && "hidden" !== P(this._element).css("visibility") && this.next()
            }, t.prev = function () {
                this._isSliding || this._slide(q)
            }, t.pause = function (t) {
                t || (this._isPaused = !0), this._element.querySelector(et) && (qn.triggerTransitionEnd(this._element), this.cycle(!0)), clearInterval(this._interval), this._interval = null
            }, t.cycle = function (t) {
                t || (this._isPaused = !1), this._interval && (clearInterval(this._interval), this._interval = null), this._config.interval && !this._isPaused && (this._interval = setInterval((document.visibilityState ? this.nextWhenVisible : this.next).bind(this), this._config.interval))
            }, t.to = function (t) {
                var e = this;
                this._activeElement = this._element.querySelector(X);
                var n = this._getItemIndex(this._activeElement);
                if (!(t > this._items.length - 1 || t < 0)) if (this._isSliding) P(this._element).one(B.SLID, function () {
                    return e.to(t)
                }); else {
                    if (n === t) return this.pause(), void this.cycle();
                    var i = n < t ? W : q;
                    this._slide(i, this._items[t])
                }
            }, t.dispose = function () {
                P(this._element).off(L), P.removeData(this._element, H), this._items = null, this._config = null, this._element = null, this._interval = null, this._isPaused = null, this._isSliding = null, this._activeElement = null, this._indicatorsElement = null
            }, t._getConfig = function (t) {
                return t = l({}, x, t), qn.typeCheckConfig(j, t, U), t
            }, t._addEventListeners = function () {
                var e = this;
                this._config.keyboard && P(this._element).on(B.KEYDOWN, function (t) {
                    return e._keydown(t)
                }), "hover" === this._config.pause && (P(this._element).on(B.MOUSEENTER, function (t) {
                    return e.pause(t)
                }).on(B.MOUSELEAVE, function (t) {
                    return e.cycle(t)
                }), "ontouchstart" in document.documentElement && P(this._element).on(B.TOUCHEND, function () {
                    e.pause(), e.touchTimeout && clearTimeout(e.touchTimeout), e.touchTimeout = setTimeout(function (t) {
                        return e.cycle(t)
                    }, 500 + e._config.interval)
                }))
            }, t._keydown = function (t) {
                if (!/input|textarea/i.test(t.target.tagName)) switch (t.which) {
                    case 37:
                        t.preventDefault(), this.prev();
                        break;
                    case 39:
                        t.preventDefault(), this.next()
                }
            }, t._getItemIndex = function (t) {
                return this._items = t && t.parentNode ? [].slice.call(t.parentNode.querySelectorAll(tt)) : [], this._items.indexOf(t)
            }, t._getItemByDirection = function (t, e) {
                var n = t === W, i = t === q, r = this._getItemIndex(e), o = this._items.length - 1;
                if ((i && 0 === r || n && r === o) && !this._config.wrap) return e;
                var s = (r + (t === q ? -1 : 1)) % this._items.length;
                return -1 === s ? this._items[this._items.length - 1] : this._items[s]
            }, t._triggerSlideEvent = function (t, e) {
                var n = this._getItemIndex(t), i = this._getItemIndex(this._element.querySelector(X)),
                    r = P.Event(B.SLIDE, {relatedTarget: t, direction: e, from: i, to: n});
                return P(this._element).trigger(r), r
            }, t._setActiveIndicatorElement = function (t) {
                if (this._indicatorsElement) {
                    var e = [].slice.call(this._indicatorsElement.querySelectorAll($));
                    P(e).removeClass(V);
                    var n = this._indicatorsElement.children[this._getItemIndex(t)];
                    n && P(n).addClass(V)
                }
            }, t._slide = function (t, e) {
                var n, i, r, o = this, s = this._element.querySelector(X), a = this._getItemIndex(s),
                    l = e || s && this._getItemByDirection(t, s), c = this._getItemIndex(l), h = Boolean(this._interval);
                if (t === W ? (n = z, i = J, r = M) : (n = G, i = Z, r = K), l && P(l).hasClass(V)) this._isSliding = !1; else if (!this._triggerSlideEvent(l, r).isDefaultPrevented() && s && l) {
                    this._isSliding = !0, h && this.pause(), this._setActiveIndicatorElement(l);
                    var u = P.Event(B.SLID, {relatedTarget: l, direction: r, from: a, to: c});
                    if (P(this._element).hasClass(Y)) {
                        P(l).addClass(i), qn.reflow(l), P(s).addClass(n), P(l).addClass(n);
                        var f = qn.getTransitionDurationFromElement(s);
                        P(s).one(qn.TRANSITION_END, function () {
                            P(l).removeClass(n + " " + i).addClass(V), P(s).removeClass(V + " " + i + " " + n), o._isSliding = !1, setTimeout(function () {
                                return P(o._element).trigger(u)
                            }, 0)
                        }).emulateTransitionEnd(f)
                    } else P(s).removeClass(V), P(l).addClass(V), this._isSliding = !1, P(this._element).trigger(u);
                    h && this.cycle()
                }
            }, o._jQueryInterface = function (i) {
                return this.each(function () {
                    var t = P(this).data(H), e = l({}, x, P(this).data());
                    "object" == typeof i && (e = l({}, e, i));
                    var n = "string" == typeof i ? i : e.slide;
                    if (t || (t = new o(this, e), P(this).data(H, t)), "number" == typeof i) t.to(i); else if ("string" == typeof n) {
                        if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');
                        t[n]()
                    } else e.interval && (t.pause(), t.cycle())
                })
            }, o._dataApiClickHandler = function (t) {
                var e = qn.getSelectorFromElement(this);
                if (e) {
                    var n = P(e)[0];
                    if (n && P(n).hasClass(Q)) {
                        var i = l({}, P(n).data(), P(this).data()), r = this.getAttribute("data-slide-to");
                        r && (i.interval = !1), o._jQueryInterface.call(P(n), i), r && P(n).data(H).to(r), t.preventDefault()
                    }
                }
            }, s(o, null, [{
                key: "VERSION", get: function () {
                    return "4.1.3"
                }
            }, {
                key: "Default", get: function () {
                    return x
                }
            }]), o
        }(), P(document).on(B.CLICK_DATA_API, it, ot._dataApiClickHandler), P(window).on(B.LOAD_DATA_API, function () {
            for (var t = [].slice.call(document.querySelectorAll(rt)), e = 0, n = t.length; e < n; e++) {
                var i = P(t[e]);
                ot._jQueryInterface.call(i, i.data())
            }
        }), P.fn[j] = ot._jQueryInterface, P.fn[j].Constructor = ot, P.fn[j].noConflict = function () {
            return P.fn[j] = F, ot._jQueryInterface
        }, ot), Qn = (at = "collapse", ct = "." + (lt = "bs.collapse"), ht = (st = e).fn[at], ut = {
            toggle: !0,
            parent: ""
        }, ft = {toggle: "boolean", parent: "(string|element)"}, dt = {
            SHOW: "show" + ct,
            SHOWN: "shown" + ct,
            HIDE: "hide" + ct,
            HIDDEN: "hidden" + ct,
            CLICK_DATA_API: "click" + ct + ".data-api"
        }, gt = "show", _t = "collapse", mt = "collapsing", pt = "collapsed", vt = "width", yt = "height", Et = ".show, .collapsing", Tt = '[data-toggle="collapse"]', Ct = function () {
            function a(e, t) {
                this._isTransitioning = !1, this._element = e, this._config = this._getConfig(t), this._triggerArray = st.makeArray(document.querySelectorAll('[data-toggle="collapse"][href="#' + e.id + '"],[data-toggle="collapse"][data-target="#' + e.id + '"]'));
                for (var n = [].slice.call(document.querySelectorAll(Tt)), i = 0, r = n.length; i < r; i++) {
                    var o = n[i], s = qn.getSelectorFromElement(o),
                        a = [].slice.call(document.querySelectorAll(s)).filter(function (t) {
                            return t === e
                        });
                    null !== s && 0 < a.length && (this._selector = s, this._triggerArray.push(o))
                }
                this._parent = this._config.parent ? this._getParent() : null, this._config.parent || this._addAriaAndCollapsedClass(this._element, this._triggerArray), this._config.toggle && this.toggle()
            }

            var t = a.prototype;
            return t.toggle = function () {
                st(this._element).hasClass(gt) ? this.hide() : this.show()
            }, t.show = function () {
                var t, e, n = this;
                if (!this._isTransitioning && !st(this._element).hasClass(gt) && (this._parent && 0 === (t = [].slice.call(this._parent.querySelectorAll(Et)).filter(function (t) {
                    return t.getAttribute("data-parent") === n._config.parent
                })).length && (t = null), !(t && (e = st(t).not(this._selector).data(lt)) && e._isTransitioning))) {
                    var i = st.Event(dt.SHOW);
                    if (st(this._element).trigger(i), !i.isDefaultPrevented()) {
                        t && (a._jQueryInterface.call(st(t).not(this._selector), "hide"), e || st(t).data(lt, null));
                        var r = this._getDimension();
                        st(this._element).removeClass(_t).addClass(mt), this._element.style[r] = 0, this._triggerArray.length && st(this._triggerArray).removeClass(pt).attr("aria-expanded", !0), this.setTransitioning(!0);
                        var o = "scroll" + (r[0].toUpperCase() + r.slice(1)),
                            s = qn.getTransitionDurationFromElement(this._element);
                        st(this._element).one(qn.TRANSITION_END, function () {
                            st(n._element).removeClass(mt).addClass(_t).addClass(gt), n._element.style[r] = "", n.setTransitioning(!1), st(n._element).trigger(dt.SHOWN)
                        }).emulateTransitionEnd(s), this._element.style[r] = this._element[o] + "px"
                    }
                }
            }, t.hide = function () {
                var t = this;
                if (!this._isTransitioning && st(this._element).hasClass(gt)) {
                    var e = st.Event(dt.HIDE);
                    if (st(this._element).trigger(e), !e.isDefaultPrevented()) {
                        var n = this._getDimension();
                        this._element.style[n] = this._element.getBoundingClientRect()[n] + "px", qn.reflow(this._element), st(this._element).addClass(mt).removeClass(_t).removeClass(gt);
                        var i = this._triggerArray.length;
                        if (0 < i) for (var r = 0; r < i; r++) {
                            var o = this._triggerArray[r], s = qn.getSelectorFromElement(o);
                            if (null !== s) st([].slice.call(document.querySelectorAll(s))).hasClass(gt) || st(o).addClass(pt).attr("aria-expanded", !1)
                        }
                        this.setTransitioning(!0);
                        this._element.style[n] = "";
                        var a = qn.getTransitionDurationFromElement(this._element);
                        st(this._element).one(qn.TRANSITION_END, function () {
                            t.setTransitioning(!1), st(t._element).removeClass(mt).addClass(_t).trigger(dt.HIDDEN)
                        }).emulateTransitionEnd(a)
                    }
                }
            }, t.setTransitioning = function (t) {
                this._isTransitioning = t
            }, t.dispose = function () {
                st.removeData(this._element, lt), this._config = null, this._parent = null, this._element = null, this._triggerArray = null, this._isTransitioning = null
            }, t._getConfig = function (t) {
                return (t = l({}, ut, t)).toggle = Boolean(t.toggle), qn.typeCheckConfig(at, t, ft), t
            }, t._getDimension = function () {
                return st(this._element).hasClass(vt) ? vt : yt
            }, t._getParent = function () {
                var n = this, t = null;
                qn.isElement(this._config.parent) ? (t = this._config.parent, "undefined" != typeof this._config.parent.jquery && (t = this._config.parent[0])) : t = document.querySelector(this._config.parent);
                var e = '[data-toggle="collapse"][data-parent="' + this._config.parent + '"]',
                    i = [].slice.call(t.querySelectorAll(e));
                return st(i).each(function (t, e) {
                    n._addAriaAndCollapsedClass(a._getTargetFromElement(e), [e])
                }), t
            }, t._addAriaAndCollapsedClass = function (t, e) {
                if (t) {
                    var n = st(t).hasClass(gt);
                    e.length && st(e).toggleClass(pt, !n).attr("aria-expanded", n)
                }
            }, a._getTargetFromElement = function (t) {
                var e = qn.getSelectorFromElement(t);
                return e ? document.querySelector(e) : null
            }, a._jQueryInterface = function (i) {
                return this.each(function () {
                    var t = st(this), e = t.data(lt), n = l({}, ut, t.data(), "object" == typeof i && i ? i : {});
                    if (!e && n.toggle && /show|hide/.test(i) && (n.toggle = !1), e || (e = new a(this, n), t.data(lt, e)), "string" == typeof i) {
                        if ("undefined" == typeof e[i]) throw new TypeError('No method named "' + i + '"');
                        e[i]()
                    }
                })
            }, s(a, null, [{
                key: "VERSION", get: function () {
                    return "4.1.3"
                }
            }, {
                key: "Default", get: function () {
                    return ut
                }
            }]), a
        }(), st(document).on(dt.CLICK_DATA_API, Tt, function (t) {
            "A" === t.currentTarget.tagName && t.preventDefault();
            var n = st(this), e = qn.getSelectorFromElement(this), i = [].slice.call(document.querySelectorAll(e));
            st(i).each(function () {
                var t = st(this), e = t.data(lt) ? "toggle" : n.data();
                Ct._jQueryInterface.call(t, e)
            })
        }), st.fn[at] = Ct._jQueryInterface, st.fn[at].Constructor = Ct, st.fn[at].noConflict = function () {
            return st.fn[at] = ht, Ct._jQueryInterface
        }, Ct),
        Vn = (It = "dropdown", At = "." + (Dt = "bs.dropdown"), wt = ".data-api", Nt = (bt = e).fn[It], Ot = new RegExp("38|40|27"), kt = "rtl" === document.documentElement.dir, Pt = {
            HIDE: "hide" + At,
            HIDDEN: "hidden" + At,
            SHOW: "show" + At,
            SHOWN: "shown" + At,
            CLICK: "click" + At,
            CLICK_DATA_API: "click" + At + wt,
            KEYDOWN_DATA_API: "keydown" + At + wt,
            KEYUP_DATA_API: "keyup" + At + wt
        }, jt = "disabled", Ht = "show", Lt = "dropup", Rt = "dropright", Ft = "dropleft", xt = "dropdown-menu-right", Ut = "position-static", Wt = '[data-toggle="dropdown"]', qt = ".dropdown form", Mt = ".dropdown-menu", Kt = ".navbar-nav", Bt = ".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)", (St = {})[kt ? "TOPEND" : "TOP"] = "top-start", St[kt ? "TOP" : "TOPEND"] = "top-end", St[kt ? "BOTTOMEND" : "BOTTOM"] = "bottom-start", St[kt ? "BOTTOM" : "BOTTOMEND"] = "bottom-end", St[kt ? "LEFT" : "RIGHT"] = "right-start", St[kt ? "LEFTEND" : "RIGHTEND"] = "right-end", St[kt ? "RIGHT" : "LEFT"] = "left-start", St[kt ? "RIGHTEND" : "LEFTEND"] = "left-end", Qt = St, Vt = {
            offset: 0,
            flip: !0,
            boundary: "scrollParent",
            reference: "toggle",
            display: "dynamic"
        }, Yt = {
            offset: "(number|string|function)",
            flip: "boolean",
            boundary: "(string|element)",
            reference: "(string|element)",
            display: "string"
        }, Gt = function () {
            function c(t, e) {
                this._element = t, this._popper = null, this._config = this._getConfig(e), this._menu = this._getMenuElement(), this._inNavbar = this._detectNavbar(), this._addEventListeners()
            }

            var t = c.prototype;
            return t.toggle = function () {
                if (!this._element.disabled && !bt(this._element).hasClass(jt)) {
                    var t = c._getParentFromElement(this._element), e = bt(this._menu).hasClass(Ht);
                    if (c._clearMenus(), !e) {
                        var n = {relatedTarget: this._element}, i = bt.Event(Pt.SHOW, n);
                        if (bt(t).trigger(i), !i.isDefaultPrevented()) {
                            if (!this._inNavbar) {
                                if ("undefined" == typeof h) throw new TypeError("Bootstrap dropdown require Popper.js (https://popper.js.org)");
                                var r = this._element;
                                "parent" === this._config.reference ? r = t : qn.isElement(this._config.reference) && (r = this._config.reference, "undefined" != typeof this._config.reference.jquery && (r = this._config.reference[0])), "scrollParent" !== this._config.boundary && bt(t).addClass(Ut), this._popper = new h(r, this._menu, this._getPopperConfig())
                            }
                            "ontouchstart" in document.documentElement && 0 === bt(t).closest(Kt).length && bt(document.body).children().on("mouseover", null, bt.noop), this._element.focus(), this._element.setAttribute("aria-expanded", !0), bt(this._menu).toggleClass(Ht), bt(t).toggleClass(Ht).trigger(bt.Event(Pt.SHOWN, n))
                        }
                    }
                }
            }, t.dispose = function () {
                bt.removeData(this._element, Dt), bt(this._element).off(At), this._element = null, (this._menu = null) !== this._popper && (this._popper.destroy(), this._popper = null)
            }, t.update = function () {
                this._inNavbar = this._detectNavbar(), null !== this._popper && this._popper.scheduleUpdate()
            }, t._addEventListeners = function () {
                var e = this;
                bt(this._element).on(Pt.CLICK, function (t) {
                    t.preventDefault(), t.stopPropagation(), e.toggle()
                })
            }, t._getConfig = function (t) {
                return t = l({}, this.constructor.Default, bt(this._element).data(), t), qn.typeCheckConfig(It, t, this.constructor.DefaultType), t
            }, t._getMenuElement = function () {
                if (!this._menu) {
                    var t = c._getParentFromElement(this._element);
                    t && (this._menu = t.querySelector(Mt))
                }
                return this._menu
            }, t._getPlacement = function () {
                var t = bt(this._element.parentNode), e = Qt.BOTTOM;
                return t.hasClass(Lt) ? (e = Qt.TOP, bt(this._menu).hasClass(xt) && (e = Qt.TOPEND)) : t.hasClass(Rt) ? e = Qt.RIGHT : t.hasClass(Ft) ? e = Qt.LEFT : bt(this._menu).hasClass(xt) && (e = Qt.BOTTOMEND), e
            }, t._detectNavbar = function () {
                return 0 < bt(this._element).closest(".navbar").length
            }, t._getPopperConfig = function () {
                var e = this, t = {};
                "function" == typeof this._config.offset ? t.fn = function (t) {
                    return t.offsets = l({}, t.offsets, e._config.offset(t.offsets) || {}), t
                } : t.offset = this._config.offset;
                var n = {
                    placement: this._getPlacement(),
                    modifiers: {
                        offset: t,
                        flip: {enabled: this._config.flip},
                        preventOverflow: {boundariesElement: this._config.boundary}
                    }
                };
                return "static" === this._config.display && (n.modifiers.applyStyle = {enabled: !1}), n
            }, c._jQueryInterface = function (e) {
                return this.each(function () {
                    var t = bt(this).data(Dt);
                    if (t || (t = new c(this, "object" == typeof e ? e : null), bt(this).data(Dt, t)), "string" == typeof e) {
                        if ("undefined" == typeof t[e]) throw new TypeError('No method named "' + e + '"');
                        t[e]()
                    }
                })
            }, c._clearMenus = function (t) {
                if (!t || 3 !== t.which && ("keyup" !== t.type || 9 === t.which)) for (var e = [].slice.call(document.querySelectorAll(Wt)), n = 0, i = e.length; n < i; n++) {
                    var r = c._getParentFromElement(e[n]), o = bt(e[n]).data(Dt), s = {relatedTarget: e[n]};
                    if (t && "click" === t.type && (s.clickEvent = t), o) {
                        var a = o._menu;
                        if (bt(r).hasClass(Ht) && !(t && ("click" === t.type && /input|textarea/i.test(t.target.tagName) || "keyup" === t.type && 9 === t.which) && bt.contains(r, t.target))) {
                            var l = bt.Event(Pt.HIDE, s);
                            bt(r).trigger(l), l.isDefaultPrevented() || ("ontouchstart" in document.documentElement && bt(document.body).children().off("mouseover", null, bt.noop), e[n].setAttribute("aria-expanded", "false"), bt(a).removeClass(Ht), bt(r).removeClass(Ht).trigger(bt.Event(Pt.HIDDEN, s)))
                        }
                    }
                }
            }, c._getParentFromElement = function (t) {
                var e, n = qn.getSelectorFromElement(t);
                return n && (e = document.querySelector(n)), e || t.parentNode
            }, c._dataApiKeydownHandler = function (t) {
                if ((/input|textarea/i.test(t.target.tagName) ? !(32 === t.which || 27 !== t.which && (40 !== t.which && 38 !== t.which || bt(t.target).closest(Mt).length)) : Ot.test(t.which)) && (t.preventDefault(), t.stopPropagation(), !this.disabled && !bt(this).hasClass(jt))) {
                    var e = c._getParentFromElement(this), n = bt(e).hasClass(Ht);
                    if ((n || 27 === t.which && 32 === t.which) && (!n || 27 !== t.which && 32 !== t.which)) {
                        var i = [].slice.call(e.querySelectorAll(Bt));
                        if (0 !== i.length) {
                            var r = i.indexOf(t.target);
                            38 === t.which && 0 < r && r--, 40 === t.which && r < i.length - 1 && r++, r < 0 && (r = 0), i[r].focus()
                        }
                    } else {
                        if (27 === t.which) {
                            var o = e.querySelector(Wt);
                            bt(o).trigger("focus")
                        }
                        bt(this).trigger("click")
                    }
                }
            }, s(c, null, [{
                key: "VERSION", get: function () {
                    return "4.1.3"
                }
            }, {
                key: "Default", get: function () {
                    return Vt
                }
            }, {
                key: "DefaultType", get: function () {
                    return Yt
                }
            }]), c
        }(), bt(document).on(Pt.KEYDOWN_DATA_API, Wt, Gt._dataApiKeydownHandler).on(Pt.KEYDOWN_DATA_API, Mt, Gt._dataApiKeydownHandler).on(Pt.CLICK_DATA_API + " " + Pt.KEYUP_DATA_API, Gt._clearMenus).on(Pt.CLICK_DATA_API, Wt, function (t) {
            t.preventDefault(), t.stopPropagation(), Gt._jQueryInterface.call(bt(this), "toggle")
        }).on(Pt.CLICK_DATA_API, qt, function (t) {
            t.stopPropagation()
        }), bt.fn[It] = Gt._jQueryInterface, bt.fn[It].Constructor = Gt, bt.fn[It].noConflict = function () {
            return bt.fn[It] = Nt, Gt._jQueryInterface
        }, Gt), Yn = (Jt = "modal", $t = "." + (Zt = "bs.modal"), Xt = (zt = e).fn[Jt], te = {
            backdrop: !0,
            keyboard: !0,
            focus: !0,
            show: !0
        }, ee = {
            backdrop: "(boolean|string)",
            keyboard: "boolean",
            focus: "boolean",
            show: "boolean"
        }, ne = {
            HIDE: "hide" + $t,
            HIDDEN: "hidden" + $t,
            SHOW: "show" + $t,
            SHOWN: "shown" + $t,
            FOCUSIN: "focusin" + $t,
            RESIZE: "resize" + $t,
            CLICK_DISMISS: "click.dismiss" + $t,
            KEYDOWN_DISMISS: "keydown.dismiss" + $t,
            MOUSEUP_DISMISS: "mouseup.dismiss" + $t,
            MOUSEDOWN_DISMISS: "mousedown.dismiss" + $t,
            CLICK_DATA_API: "click" + $t + ".data-api"
        }, ie = "modal-scrollbar-measure", re = "modal-backdrop", oe = "modal-open", se = "fade", ae = "show", le = ".modal-dialog", ce = '[data-toggle="modal"]', he = '[data-dismiss="modal"]', ue = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top", fe = ".sticky-top", de = function () {
            function r(t, e) {
                this._config = this._getConfig(e), this._element = t, this._dialog = t.querySelector(le), this._backdrop = null, this._isShown = !1, this._isBodyOverflowing = !1, this._ignoreBackdropClick = !1, this._scrollbarWidth = 0
            }

            var t = r.prototype;
            return t.toggle = function (t) {
                return this._isShown ? this.hide() : this.show(t)
            }, t.show = function (t) {
                var e = this;
                if (!this._isTransitioning && !this._isShown) {
                    zt(this._element).hasClass(se) && (this._isTransitioning = !0);
                    var n = zt.Event(ne.SHOW, {relatedTarget: t});
                    zt(this._element).trigger(n), this._isShown || n.isDefaultPrevented() || (this._isShown = !0, this._checkScrollbar(), this._setScrollbar(), this._adjustDialog(), zt(document.body).addClass(oe), this._setEscapeEvent(), this._setResizeEvent(), zt(this._element).on(ne.CLICK_DISMISS, he, function (t) {
                        return e.hide(t)
                    }), zt(this._dialog).on(ne.MOUSEDOWN_DISMISS, function () {
                        zt(e._element).one(ne.MOUSEUP_DISMISS, function (t) {
                            zt(t.target).is(e._element) && (e._ignoreBackdropClick = !0)
                        })
                    }), this._showBackdrop(function () {
                        return e._showElement(t)
                    }))
                }
            }, t.hide = function (t) {
                var e = this;
                if (t && t.preventDefault(), !this._isTransitioning && this._isShown) {
                    var n = zt.Event(ne.HIDE);
                    if (zt(this._element).trigger(n), this._isShown && !n.isDefaultPrevented()) {
                        this._isShown = !1;
                        var i = zt(this._element).hasClass(se);
                        if (i && (this._isTransitioning = !0), this._setEscapeEvent(), this._setResizeEvent(), zt(document).off(ne.FOCUSIN), zt(this._element).removeClass(ae), zt(this._element).off(ne.CLICK_DISMISS), zt(this._dialog).off(ne.MOUSEDOWN_DISMISS), i) {
                            var r = qn.getTransitionDurationFromElement(this._element);
                            zt(this._element).one(qn.TRANSITION_END, function (t) {
                                return e._hideModal(t)
                            }).emulateTransitionEnd(r)
                        } else this._hideModal()
                    }
                }
            }, t.dispose = function () {
                zt.removeData(this._element, Zt), zt(window, document, this._element, this._backdrop).off($t), this._config = null, this._element = null, this._dialog = null, this._backdrop = null, this._isShown = null, this._isBodyOverflowing = null, this._ignoreBackdropClick = null, this._scrollbarWidth = null
            }, t.handleUpdate = function () {
                this._adjustDialog()
            }, t._getConfig = function (t) {
                return t = l({}, te, t), qn.typeCheckConfig(Jt, t, ee), t
            }, t._showElement = function (t) {
                var e = this, n = zt(this._element).hasClass(se);
                this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE || document.body.appendChild(this._element), this._element.style.display = "block", this._element.removeAttribute("aria-hidden"), this._element.scrollTop = 0, n && qn.reflow(this._element), zt(this._element).addClass(ae), this._config.focus && this._enforceFocus();
                var i = zt.Event(ne.SHOWN, {relatedTarget: t}), r = function () {
                    e._config.focus && e._element.focus(), e._isTransitioning = !1, zt(e._element).trigger(i)
                };
                if (n) {
                    var o = qn.getTransitionDurationFromElement(this._element);
                    zt(this._dialog).one(qn.TRANSITION_END, r).emulateTransitionEnd(o)
                } else r()
            }, t._enforceFocus = function () {
                var e = this;
                zt(document).off(ne.FOCUSIN).on(ne.FOCUSIN, function (t) {
                    document !== t.target && e._element !== t.target && 0 === zt(e._element).has(t.target).length && e._element.focus()
                })
            }, t._setEscapeEvent = function () {
                var e = this;
                this._isShown && this._config.keyboard ? zt(this._element).on(ne.KEYDOWN_DISMISS, function (t) {
                    27 === t.which && (t.preventDefault(), e.hide())
                }) : this._isShown || zt(this._element).off(ne.KEYDOWN_DISMISS)
            }, t._setResizeEvent = function () {
                var e = this;
                this._isShown ? zt(window).on(ne.RESIZE, function (t) {
                    return e.handleUpdate(t)
                }) : zt(window).off(ne.RESIZE)
            }, t._hideModal = function () {
                var t = this;
                this._element.style.display = "none", this._element.setAttribute("aria-hidden", !0), this._isTransitioning = !1, this._showBackdrop(function () {
                    zt(document.body).removeClass(oe), t._resetAdjustments(), t._resetScrollbar(), zt(t._element).trigger(ne.HIDDEN)
                })
            }, t._removeBackdrop = function () {
                this._backdrop && (zt(this._backdrop).remove(), this._backdrop = null)
            }, t._showBackdrop = function (t) {
                var e = this, n = zt(this._element).hasClass(se) ? se : "";
                if (this._isShown && this._config.backdrop) {
                    if (this._backdrop = document.createElement("div"), this._backdrop.className = re, n && this._backdrop.classList.add(n), zt(this._backdrop).appendTo(document.body), zt(this._element).on(ne.CLICK_DISMISS, function (t) {
                        e._ignoreBackdropClick ? e._ignoreBackdropClick = !1 : t.target === t.currentTarget && ("static" === e._config.backdrop ? e._element.focus() : e.hide())
                    }), n && qn.reflow(this._backdrop), zt(this._backdrop).addClass(ae), !t) return;
                    if (!n) return void t();
                    var i = qn.getTransitionDurationFromElement(this._backdrop);
                    zt(this._backdrop).one(qn.TRANSITION_END, t).emulateTransitionEnd(i)
                } else if (!this._isShown && this._backdrop) {
                    zt(this._backdrop).removeClass(ae);
                    var r = function () {
                        e._removeBackdrop(), t && t()
                    };
                    if (zt(this._element).hasClass(se)) {
                        var o = qn.getTransitionDurationFromElement(this._backdrop);
                        zt(this._backdrop).one(qn.TRANSITION_END, r).emulateTransitionEnd(o)
                    } else r()
                } else t && t()
            }, t._adjustDialog = function () {
                var t = this._element.scrollHeight > document.documentElement.clientHeight;
                !this._isBodyOverflowing && t && (this._element.style.paddingLeft = this._scrollbarWidth + "px"), this._isBodyOverflowing && !t && (this._element.style.paddingRight = this._scrollbarWidth + "px")
            }, t._resetAdjustments = function () {
                this._element.style.paddingLeft = "", this._element.style.paddingRight = ""
            }, t._checkScrollbar = function () {
                var t = document.body.getBoundingClientRect();
                this._isBodyOverflowing = t.left + t.right < window.innerWidth, this._scrollbarWidth = this._getScrollbarWidth()
            }, t._setScrollbar = function () {
                var r = this;
                if (this._isBodyOverflowing) {
                    var t = [].slice.call(document.querySelectorAll(ue)), e = [].slice.call(document.querySelectorAll(fe));
                    zt(t).each(function (t, e) {
                        var n = e.style.paddingRight, i = zt(e).css("padding-right");
                        zt(e).data("padding-right", n).css("padding-right", parseFloat(i) + r._scrollbarWidth + "px")
                    }), zt(e).each(function (t, e) {
                        var n = e.style.marginRight, i = zt(e).css("margin-right");
                        zt(e).data("margin-right", n).css("margin-right", parseFloat(i) - r._scrollbarWidth + "px")
                    });
                    var n = document.body.style.paddingRight, i = zt(document.body).css("padding-right");
                    zt(document.body).data("padding-right", n).css("padding-right", parseFloat(i) + this._scrollbarWidth + "px")
                }
            }, t._resetScrollbar = function () {
                var t = [].slice.call(document.querySelectorAll(ue));
                zt(t).each(function (t, e) {
                    var n = zt(e).data("padding-right");
                    zt(e).removeData("padding-right"), e.style.paddingRight = n || ""
                });
                var e = [].slice.call(document.querySelectorAll("" + fe));
                zt(e).each(function (t, e) {
                    var n = zt(e).data("margin-right");
                    "undefined" != typeof n && zt(e).css("margin-right", n).removeData("margin-right")
                });
                var n = zt(document.body).data("padding-right");
                zt(document.body).removeData("padding-right"), document.body.style.paddingRight = n || ""
            }, t._getScrollbarWidth = function () {
                var t = document.createElement("div");
                t.className = ie, document.body.appendChild(t);
                var e = t.getBoundingClientRect().width - t.clientWidth;
                return document.body.removeChild(t), e
            }, r._jQueryInterface = function (n, i) {
                return this.each(function () {
                    var t = zt(this).data(Zt), e = l({}, te, zt(this).data(), "object" == typeof n && n ? n : {});
                    if (t || (t = new r(this, e), zt(this).data(Zt, t)), "string" == typeof n) {
                        if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');
                        t[n](i)
                    } else e.show && t.show(i)
                })
            }, s(r, null, [{
                key: "VERSION", get: function () {
                    return "4.1.3"
                }
            }, {
                key: "Default", get: function () {
                    return te
                }
            }]), r
        }(), zt(document).on(ne.CLICK_DATA_API, ce, function (t) {
            var e, n = this, i = qn.getSelectorFromElement(this);
            i && (e = document.querySelector(i));
            var r = zt(e).data(Zt) ? "toggle" : l({}, zt(e).data(), zt(this).data());
            "A" !== this.tagName && "AREA" !== this.tagName || t.preventDefault();
            var o = zt(e).one(ne.SHOW, function (t) {
                t.isDefaultPrevented() || o.one(ne.HIDDEN, function () {
                    zt(n).is(":visible") && n.focus()
                })
            });
            de._jQueryInterface.call(zt(e), r, this)
        }), zt.fn[Jt] = de._jQueryInterface, zt.fn[Jt].Constructor = de, zt.fn[Jt].noConflict = function () {
            return zt.fn[Jt] = Xt, de._jQueryInterface
        }, de),
        Gn = (me = "tooltip", ve = "." + (pe = "bs.tooltip"), ye = (ge = e).fn[me], Ee = "bs-tooltip", Te = new RegExp("(^|\\s)" + Ee + "\\S+", "g"), Ce = "rtl" === document.documentElement.dir, be = {
            animation: "boolean",
            template: "string",
            title: "(string|element|function)",
            trigger: "string",
            delay: "(number|object)",
            html: "boolean",
            selector: "(string|boolean)",
            placement: "(string|function)",
            offset: "(number|string)",
            container: "(string|element|boolean)",
            fallbackPlacement: "(string|array)",
            boundary: "(string|element)"
        }, (_e = {
            AUTO: "auto",
            TOP: "top"
        })[Ce ? "LEFT" : "RIGHT"] = "right", _e.BOTTOM = "bottom", _e[Ce ? "RIGHT" : "LEFT"] = "left", Se = _e, Ie = {
            animation: !0,
            template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
            trigger: "hover focus",
            title: "",
            delay: 0,
            html: !1,
            selector: !1,
            placement: "top",
            offset: 0,
            container: !1,
            fallbackPlacement: "flip",
            boundary: "scrollParent"
        }, Ae = "out", we = {
            HIDE: "hide" + ve,
            HIDDEN: "hidden" + ve,
            SHOW: (De = "show") + ve,
            SHOWN: "shown" + ve,
            INSERTED: "inserted" + ve,
            CLICK: "click" + ve,
            FOCUSIN: "focusin" + ve,
            FOCUSOUT: "focusout" + ve,
            MOUSEENTER: "mouseenter" + ve,
            MOUSELEAVE: "mouseleave" + ve
        }, Ne = "fade", Oe = "show", ke = ".tooltip-inner", Pe = ".arrow", je = "hover", He = "focus", Le = "click", Re = "manual", Fe = function () {
            function i(t, e) {
                if ("undefined" == typeof h) throw new TypeError("Bootstrap tooltips require Popper.js (https://popper.js.org)");
                this._isEnabled = !0, this._timeout = 0, this._hoverState = "", this._activeTrigger = {}, this._popper = null, this.element = t, this.config = this._getConfig(e), this.tip = null, this._setListeners()
            }

            var t = i.prototype;
            return t.enable = function () {
                this._isEnabled = !0
            }, t.disable = function () {
                this._isEnabled = !1
            }, t.toggleEnabled = function () {
                this._isEnabled = !this._isEnabled
            }, t.toggle = function (t) {
                if (this._isEnabled) if (t) {
                    var e = this.constructor.DATA_KEY, n = ge(t.currentTarget).data(e);
                    n || (n = new this.constructor(t.currentTarget, this._getDelegateConfig()), ge(t.currentTarget).data(e, n)), n._activeTrigger.click = !n._activeTrigger.click, n._isWithActiveTrigger() ? n._enter(null, n) : n._leave(null, n)
                } else {
                    if (ge(this.getTipElement()).hasClass(Oe)) return void this._leave(null, this);
                    this._enter(null, this)
                }
            }, t.dispose = function () {
                clearTimeout(this._timeout), ge.removeData(this.element, this.constructor.DATA_KEY), ge(this.element).off(this.constructor.EVENT_KEY), ge(this.element).closest(".modal").off("hide.bs.modal"), this.tip && ge(this.tip).remove(), this._isEnabled = null, this._timeout = null, this._hoverState = null, (this._activeTrigger = null) !== this._popper && this._popper.destroy(), this._popper = null, this.element = null, this.config = null, this.tip = null
            }, t.show = function () {
                var e = this;
                if ("none" === ge(this.element).css("display")) throw new Error("Please use show on visible elements");
                var t = ge.Event(this.constructor.Event.SHOW);
                if (this.isWithContent() && this._isEnabled) {
                    ge(this.element).trigger(t);
                    var n = ge.contains(this.element.ownerDocument.documentElement, this.element);
                    if (t.isDefaultPrevented() || !n) return;
                    var i = this.getTipElement(), r = qn.getUID(this.constructor.NAME);
                    i.setAttribute("id", r), this.element.setAttribute("aria-describedby", r), this.setContent(), this.config.animation && ge(i).addClass(Ne);
                    var o = "function" == typeof this.config.placement ? this.config.placement.call(this, i, this.element) : this.config.placement,
                        s = this._getAttachment(o);
                    this.addAttachmentClass(s);
                    var a = !1 === this.config.container ? document.body : ge(document).find(this.config.container);
                    ge(i).data(this.constructor.DATA_KEY, this), ge.contains(this.element.ownerDocument.documentElement, this.tip) || ge(i).appendTo(a), ge(this.element).trigger(this.constructor.Event.INSERTED), this._popper = new h(this.element, i, {
                        placement: s,
                        modifiers: {
                            offset: {offset: this.config.offset},
                            flip: {behavior: this.config.fallbackPlacement},
                            arrow: {element: Pe},
                            preventOverflow: {boundariesElement: this.config.boundary}
                        },
                        onCreate: function (t) {
                            t.originalPlacement !== t.placement && e._handlePopperPlacementChange(t)
                        },
                        onUpdate: function (t) {
                            e._handlePopperPlacementChange(t)
                        }
                    }), ge(i).addClass(Oe), "ontouchstart" in document.documentElement && ge(document.body).children().on("mouseover", null, ge.noop);
                    var l = function () {
                        e.config.animation && e._fixTransition();
                        var t = e._hoverState;
                        e._hoverState = null, ge(e.element).trigger(e.constructor.Event.SHOWN), t === Ae && e._leave(null, e)
                    };
                    if (ge(this.tip).hasClass(Ne)) {
                        var c = qn.getTransitionDurationFromElement(this.tip);
                        ge(this.tip).one(qn.TRANSITION_END, l).emulateTransitionEnd(c)
                    } else l()
                }
            }, t.hide = function (t) {
                var e = this, n = this.getTipElement(), i = ge.Event(this.constructor.Event.HIDE), r = function () {
                    e._hoverState !== De && n.parentNode && n.parentNode.removeChild(n), e._cleanTipClass(), e.element.removeAttribute("aria-describedby"), ge(e.element).trigger(e.constructor.Event.HIDDEN), null !== e._popper && e._popper.destroy(), t && t()
                };
                if (ge(this.element).trigger(i), !i.isDefaultPrevented()) {
                    if (ge(n).removeClass(Oe), "ontouchstart" in document.documentElement && ge(document.body).children().off("mouseover", null, ge.noop), this._activeTrigger[Le] = !1, this._activeTrigger[He] = !1, this._activeTrigger[je] = !1, ge(this.tip).hasClass(Ne)) {
                        var o = qn.getTransitionDurationFromElement(n);
                        ge(n).one(qn.TRANSITION_END, r).emulateTransitionEnd(o)
                    } else r();
                    this._hoverState = ""
                }
            }, t.update = function () {
                null !== this._popper && this._popper.scheduleUpdate()
            }, t.isWithContent = function () {
                return Boolean(this.getTitle())
            }, t.addAttachmentClass = function (t) {
                ge(this.getTipElement()).addClass(Ee + "-" + t)
            }, t.getTipElement = function () {
                return this.tip = this.tip || ge(this.config.template)[0], this.tip
            }, t.setContent = function () {
                var t = this.getTipElement();
                this.setElementContent(ge(t.querySelectorAll(ke)), this.getTitle()), ge(t).removeClass(Ne + " " + Oe)
            }, t.setElementContent = function (t, e) {
                var n = this.config.html;
                "object" == typeof e && (e.nodeType || e.jquery) ? n ? ge(e).parent().is(t) || t.empty().append(e) : t.text(ge(e).text()) : t[n ? "html" : "text"](e)
            }, t.getTitle = function () {
                var t = this.element.getAttribute("data-original-title");
                return t || (t = "function" == typeof this.config.title ? this.config.title.call(this.element) : this.config.title), t
            }, t._getAttachment = function (t) {
                return Se[t.toUpperCase()]
            }, t._setListeners = function () {
                var i = this;
                this.config.trigger.split(" ").forEach(function (t) {
                    if ("click" === t) ge(i.element).on(i.constructor.Event.CLICK, i.config.selector, function (t) {
                        return i.toggle(t)
                    }); else if (t !== Re) {
                        var e = t === je ? i.constructor.Event.MOUSEENTER : i.constructor.Event.FOCUSIN,
                            n = t === je ? i.constructor.Event.MOUSELEAVE : i.constructor.Event.FOCUSOUT;
                        ge(i.element).on(e, i.config.selector, function (t) {
                            return i._enter(t)
                        }).on(n, i.config.selector, function (t) {
                            return i._leave(t)
                        })
                    }
                    ge(i.element).closest(".modal").on("hide.bs.modal", function () {
                        return i.hide()
                    })
                }), this.config.selector ? this.config = l({}, this.config, {
                    trigger: "manual",
                    selector: ""
                }) : this._fixTitle()
            }, t._fixTitle = function () {
                var t = typeof this.element.getAttribute("data-original-title");
                (this.element.getAttribute("title") || "string" !== t) && (this.element.setAttribute("data-original-title", this.element.getAttribute("title") || ""), this.element.setAttribute("title", ""))
            }, t._enter = function (t, e) {
                var n = this.constructor.DATA_KEY;
                (e = e || ge(t.currentTarget).data(n)) || (e = new this.constructor(t.currentTarget, this._getDelegateConfig()), ge(t.currentTarget).data(n, e)), t && (e._activeTrigger["focusin" === t.type ? He : je] = !0), ge(e.getTipElement()).hasClass(Oe) || e._hoverState === De ? e._hoverState = De : (clearTimeout(e._timeout), e._hoverState = De, e.config.delay && e.config.delay.show ? e._timeout = setTimeout(function () {
                    e._hoverState === De && e.show()
                }, e.config.delay.show) : e.show())
            }, t._leave = function (t, e) {
                var n = this.constructor.DATA_KEY;
                (e = e || ge(t.currentTarget).data(n)) || (e = new this.constructor(t.currentTarget, this._getDelegateConfig()), ge(t.currentTarget).data(n, e)), t && (e._activeTrigger["focusout" === t.type ? He : je] = !1), e._isWithActiveTrigger() || (clearTimeout(e._timeout), e._hoverState = Ae, e.config.delay && e.config.delay.hide ? e._timeout = setTimeout(function () {
                    e._hoverState === Ae && e.hide()
                }, e.config.delay.hide) : e.hide())
            }, t._isWithActiveTrigger = function () {
                for (var t in this._activeTrigger) if (this._activeTrigger[t]) return !0;
                return !1
            }, t._getConfig = function (t) {
                return "number" == typeof (t = l({}, this.constructor.Default, ge(this.element).data(), "object" == typeof t && t ? t : {})).delay && (t.delay = {
                    show: t.delay,
                    hide: t.delay
                }), "number" == typeof t.title && (t.title = t.title.toString()), "number" == typeof t.content && (t.content = t.content.toString()), qn.typeCheckConfig(me, t, this.constructor.DefaultType), t
            }, t._getDelegateConfig = function () {
                var t = {};
                if (this.config) for (var e in this.config) this.constructor.Default[e] !== this.config[e] && (t[e] = this.config[e]);
                return t
            }, t._cleanTipClass = function () {
                var t = ge(this.getTipElement()), e = t.attr("class").match(Te);
                null !== e && e.length && t.removeClass(e.join(""))
            }, t._handlePopperPlacementChange = function (t) {
                var e = t.instance;
                this.tip = e.popper, this._cleanTipClass(), this.addAttachmentClass(this._getAttachment(Se[t.placement.toUpperCase()]))
            }, t._fixTransition = function () {
                var t = this.getTipElement(), e = this.config.animation;
                null === t.getAttribute("x-placement") && (ge(t).removeClass(Ne), this.config.animation = !1, this.hide(), this.show(), this.config.animation = e)
            }, i._jQueryInterface = function (n) {
                return this.each(function () {
                    var t = ge(this).data(pe), e = "object" == typeof n && n;
                    if ((t || !/dispose|hide/.test(n)) && (t || (t = new i(this, e), ge(this).data(pe, t)), "string" == typeof n)) {
                        if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');
                        t[n]()
                    }
                })
            }, s(i, null, [{
                key: "VERSION", get: function () {
                    return "4.1.3"
                }
            }, {
                key: "Default", get: function () {
                    return Ie
                }
            }, {
                key: "NAME", get: function () {
                    return me
                }
            }, {
                key: "DATA_KEY", get: function () {
                    return pe
                }
            }, {
                key: "Event", get: function () {
                    return we
                }
            }, {
                key: "EVENT_KEY", get: function () {
                    return ve
                }
            }, {
                key: "DefaultType", get: function () {
                    return be
                }
            }]), i
        }(), ge.fn[me] = Fe._jQueryInterface, ge.fn[me].Constructor = Fe, ge.fn[me].noConflict = function () {
            return ge.fn[me] = ye, Fe._jQueryInterface
        }, Fe),
        zn = (Ue = "popover", qe = "." + (We = "bs.popover"), Me = (xe = e).fn[Ue], Ke = "bs-popover", Be = new RegExp("(^|\\s)" + Ke + "\\S+", "g"), Qe = "rtl" === document.documentElement.dir, Ve = l({}, Gn.Default, {
            placement: "rtl" === Qe ? "left" : "right",
            trigger: "click",
            content: "",
            template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        }), Ye = l({}, Gn.DefaultType, {content: "(string|element|function)"}), Ge = "fade", Je = ".popover-header", Ze = ".popover-body", $e = {
            HIDE: "hide" + qe,
            HIDDEN: "hidden" + qe,
            SHOW: (ze = "show") + qe,
            SHOWN: "shown" + qe,
            INSERTED: "inserted" + qe,
            CLICK: "click" + qe,
            FOCUSIN: "focusin" + qe,
            FOCUSOUT: "focusout" + qe,
            MOUSEENTER: "mouseenter" + qe,
            MOUSELEAVE: "mouseleave" + qe
        }, Xe = function (t) {
            var e, n;

            function i() {
                return t.apply(this, arguments) || this
            }

            n = t, (e = i).prototype = Object.create(n.prototype), (e.prototype.constructor = e).__proto__ = n;
            var r = i.prototype;
            return r.isWithContent = function () {
                return this.getTitle() || this._getContent()
            }, r.addAttachmentClass = function (t) {
                xe(this.getTipElement()).addClass(Ke + "-" + t)
            }, r.getTipElement = function () {
                return this.tip = this.tip || xe(this.config.template)[0], this.tip
            }, r.setContent = function () {
                var t = xe(this.getTipElement());
                this.setElementContent(t.find(Je), this.getTitle());
                var e = this._getContent();
                "function" == typeof e && (e = e.call(this.element)), this.setElementContent(t.find(Ze), e), t.removeClass(Ge + " " + ze)
            }, r._getContent = function () {
                return this.element.getAttribute("data-content") || this.config.content
            }, r._cleanTipClass = function () {
                var t = xe(this.getTipElement()), e = t.attr("class").match(Be);
                null !== e && 0 < e.length && t.removeClass(e.join(""))
            }, i._jQueryInterface = function (n) {
                return this.each(function () {
                    var t = xe(this).data(We), e = "object" == typeof n ? n : null;
                    if ((t || !/destroy|hide/.test(n)) && (t || (t = new i(this, e), xe(this).data(We, t)), "string" == typeof n)) {
                        if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');
                        t[n]()
                    }
                })
            }, s(i, null, [{
                key: "VERSION", get: function () {
                    return "4.1.3"
                }
            }, {
                key: "Default", get: function () {
                    return Ve
                }
            }, {
                key: "NAME", get: function () {
                    return Ue
                }
            }, {
                key: "DATA_KEY", get: function () {
                    return We
                }
            }, {
                key: "Event", get: function () {
                    return $e
                }
            }, {
                key: "EVENT_KEY", get: function () {
                    return qe
                }
            }, {
                key: "DefaultType", get: function () {
                    return Ye
                }
            }]), i
        }(Gn), xe.fn[Ue] = Xe._jQueryInterface, xe.fn[Ue].Constructor = Xe, xe.fn[Ue].noConflict = function () {
            return xe.fn[Ue] = Me, Xe._jQueryInterface
        }, Xe), Jn = (en = "scrollspy", rn = "." + (nn = "bs.scrollspy"), on = (tn = e).fn[en], sn = {
            offset: 10,
            method: "auto",
            target: ""
        }, an = {offset: "number", method: "string", target: "(string|element)"}, ln = {
            ACTIVATE: "activate" + rn,
            SCROLL: "scroll" + rn,
            LOAD_DATA_API: "load" + rn + ".data-api"
        }, cn = "dropdown-item", hn = "active", un = '[data-spy="scroll"]', fn = ".active", dn = ".nav, .list-group", gn = ".nav-link", _n = ".nav-item", mn = ".list-group-item", pn = ".dropdown", vn = ".dropdown-item", yn = ".dropdown-toggle", En = "offset", Tn = "position", Cn = function () {
            function n(t, e) {
                var n = this;
                this._element = t, this._scrollElement = "BODY" === t.tagName ? window : t, this._config = this._getConfig(e), this._selector = this._config.target + " " + gn + "," + this._config.target + " " + mn + "," + this._config.target + " " + vn, this._offsets = [], this._targets = [], this._activeTarget = null, this._scrollHeight = 0, tn(this._scrollElement).on(ln.SCROLL, function (t) {
                    return n._process(t)
                }), this.refresh(), this._process()
            }

            var t = n.prototype;
            return t.refresh = function () {
                var e = this, t = this._scrollElement === this._scrollElement.window ? En : Tn,
                    r = "auto" === this._config.method ? t : this._config.method, o = r === Tn ? this._getScrollTop() : 0;
                this._offsets = [], this._targets = [], this._scrollHeight = this._getScrollHeight(), [].slice.call(document.querySelectorAll(this._selector)).map(function (t) {
                    var e, n = qn.getSelectorFromElement(t);
                    if (n && (e = document.querySelector(n)), e) {
                        var i = e.getBoundingClientRect();
                        if (i.width || i.height) return [tn(e)[r]().top + o, n]
                    }
                    return null
                }).filter(function (t) {
                    return t
                }).sort(function (t, e) {
                    return t[0] - e[0]
                }).forEach(function (t) {
                    e._offsets.push(t[0]), e._targets.push(t[1])
                })
            }, t.dispose = function () {
                tn.removeData(this._element, nn), tn(this._scrollElement).off(rn), this._element = null, this._scrollElement = null, this._config = null, this._selector = null, this._offsets = null, this._targets = null, this._activeTarget = null, this._scrollHeight = null
            }, t._getConfig = function (t) {
                if ("string" != typeof (t = l({}, sn, "object" == typeof t && t ? t : {})).target) {
                    var e = tn(t.target).attr("id");
                    e || (e = qn.getUID(en), tn(t.target).attr("id", e)), t.target = "#" + e
                }
                return qn.typeCheckConfig(en, t, an), t
            }, t._getScrollTop = function () {
                return this._scrollElement === window ? this._scrollElement.pageYOffset : this._scrollElement.scrollTop
            }, t._getScrollHeight = function () {
                return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight)
            }, t._getOffsetHeight = function () {
                return this._scrollElement === window ? window.innerHeight : this._scrollElement.getBoundingClientRect().height
            }, t._process = function () {
                var t = this._getScrollTop() + this._config.offset, e = this._getScrollHeight(),
                    n = this._config.offset + e - this._getOffsetHeight();
                if (this._scrollHeight !== e && this.refresh(), n <= t) {
                    var i = this._targets[this._targets.length - 1];
                    this._activeTarget !== i && this._activate(i)
                } else {
                    if (this._activeTarget && t < this._offsets[0] && 0 < this._offsets[0]) return this._activeTarget = null, void this._clear();
                    for (var r = this._offsets.length; r--;) {
                        this._activeTarget !== this._targets[r] && t >= this._offsets[r] && ("undefined" == typeof this._offsets[r + 1] || t < this._offsets[r + 1]) && this._activate(this._targets[r])
                    }
                }
            }, t._activate = function (e) {
                this._activeTarget = e, this._clear();
                var t = this._selector.split(",");
                t = t.map(function (t) {
                    return t + '[data-target="' + e + '"],' + t + '[href="' + e + '"]'
                });
                var n = tn([].slice.call(document.querySelectorAll(t.join(","))));
                n.hasClass(cn) ? (n.closest(pn).find(yn).addClass(hn), n.addClass(hn)) : (n.addClass(hn), n.parents(dn).prev(gn + ", " + mn).addClass(hn), n.parents(dn).prev(_n).children(gn).addClass(hn)), tn(this._scrollElement).trigger(ln.ACTIVATE, {relatedTarget: e})
            }, t._clear = function () {
                var t = [].slice.call(document.querySelectorAll(this._selector));
                tn(t).filter(fn).removeClass(hn)
            }, n._jQueryInterface = function (e) {
                return this.each(function () {
                    var t = tn(this).data(nn);
                    if (t || (t = new n(this, "object" == typeof e && e), tn(this).data(nn, t)), "string" == typeof e) {
                        if ("undefined" == typeof t[e]) throw new TypeError('No method named "' + e + '"');
                        t[e]()
                    }
                })
            }, s(n, null, [{
                key: "VERSION", get: function () {
                    return "4.1.3"
                }
            }, {
                key: "Default", get: function () {
                    return sn
                }
            }]), n
        }(), tn(window).on(ln.LOAD_DATA_API, function () {
            for (var t = [].slice.call(document.querySelectorAll(un)), e = t.length; e--;) {
                var n = tn(t[e]);
                Cn._jQueryInterface.call(n, n.data())
            }
        }), tn.fn[en] = Cn._jQueryInterface, tn.fn[en].Constructor = Cn, tn.fn[en].noConflict = function () {
            return tn.fn[en] = on, Cn._jQueryInterface
        }, Cn), Zn = (In = "." + (Sn = "bs.tab"), Dn = (bn = e).fn.tab, An = {
            HIDE: "hide" + In,
            HIDDEN: "hidden" + In,
            SHOW: "show" + In,
            SHOWN: "shown" + In,
            CLICK_DATA_API: "click" + In + ".data-api"
        }, wn = "dropdown-menu", Nn = "active", On = "disabled", kn = "fade", Pn = "show", jn = ".dropdown", Hn = ".nav, .list-group", Ln = ".active", Rn = "> li > .active", Fn = '[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]', xn = ".dropdown-toggle", Un = "> .dropdown-menu .active", Wn = function () {
            function i(t) {
                this._element = t
            }

            var t = i.prototype;
            return t.show = function () {
                var n = this;
                if (!(this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && bn(this._element).hasClass(Nn) || bn(this._element).hasClass(On))) {
                    var t, i, e = bn(this._element).closest(Hn)[0], r = qn.getSelectorFromElement(this._element);
                    if (e) {
                        var o = "UL" === e.nodeName ? Rn : Ln;
                        i = (i = bn.makeArray(bn(e).find(o)))[i.length - 1]
                    }
                    var s = bn.Event(An.HIDE, {relatedTarget: this._element}), a = bn.Event(An.SHOW, {relatedTarget: i});
                    if (i && bn(i).trigger(s), bn(this._element).trigger(a), !a.isDefaultPrevented() && !s.isDefaultPrevented()) {
                        r && (t = document.querySelector(r)), this._activate(this._element, e);
                        var l = function () {
                            var t = bn.Event(An.HIDDEN, {relatedTarget: n._element}),
                                e = bn.Event(An.SHOWN, {relatedTarget: i});
                            bn(i).trigger(t), bn(n._element).trigger(e)
                        };
                        t ? this._activate(t, t.parentNode, l) : l()
                    }
                }
            }, t.dispose = function () {
                bn.removeData(this._element, Sn), this._element = null
            }, t._activate = function (t, e, n) {
                var i = this, r = ("UL" === e.nodeName ? bn(e).find(Rn) : bn(e).children(Ln))[0],
                    o = n && r && bn(r).hasClass(kn), s = function () {
                        return i._transitionComplete(t, r, n)
                    };
                if (r && o) {
                    var a = qn.getTransitionDurationFromElement(r);
                    bn(r).one(qn.TRANSITION_END, s).emulateTransitionEnd(a)
                } else s()
            }, t._transitionComplete = function (t, e, n) {
                if (e) {
                    bn(e).removeClass(Pn + " " + Nn);
                    var i = bn(e.parentNode).find(Un)[0];
                    i && bn(i).removeClass(Nn), "tab" === e.getAttribute("role") && e.setAttribute("aria-selected", !1)
                }
                if (bn(t).addClass(Nn), "tab" === t.getAttribute("role") && t.setAttribute("aria-selected", !0), qn.reflow(t), bn(t).addClass(Pn), t.parentNode && bn(t.parentNode).hasClass(wn)) {
                    var r = bn(t).closest(jn)[0];
                    if (r) {
                        var o = [].slice.call(r.querySelectorAll(xn));
                        bn(o).addClass(Nn)
                    }
                    t.setAttribute("aria-expanded", !0)
                }
                n && n()
            }, i._jQueryInterface = function (n) {
                return this.each(function () {
                    var t = bn(this), e = t.data(Sn);
                    if (e || (e = new i(this), t.data(Sn, e)), "string" == typeof n) {
                        if ("undefined" == typeof e[n]) throw new TypeError('No method named "' + n + '"');
                        e[n]()
                    }
                })
            }, s(i, null, [{
                key: "VERSION", get: function () {
                    return "4.1.3"
                }
            }]), i
        }(), bn(document).on(An.CLICK_DATA_API, Fn, function (t) {
            t.preventDefault(), Wn._jQueryInterface.call(bn(this), "show")
        }), bn.fn.tab = Wn._jQueryInterface, bn.fn.tab.Constructor = Wn, bn.fn.tab.noConflict = function () {
            return bn.fn.tab = Dn, Wn._jQueryInterface
        }, Wn);
    !function (t) {
        if ("undefined" == typeof t) throw new TypeError("Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");
        var e = t.fn.jquery.split(" ")[0].split(".");
        if (e[0] < 2 && e[1] < 9 || 1 === e[0] && 9 === e[1] && e[2] < 1 || 4 <= e[0]) throw new Error("Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0")
    }(e), t.Util = qn, t.Alert = Mn, t.Button = Kn, t.Carousel = Bn, t.Collapse = Qn, t.Dropdown = Vn, t.Modal = Yn, t.Popover = zn, t.Scrollspy = Jn, t.Tab = Zn, t.Tooltip = Gn, Object.defineProperty(t, "__esModule", {value: !0})
});
