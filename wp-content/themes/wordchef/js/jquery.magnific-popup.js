/*! Magnific Popup - v1.0.0 - 2015-01-03
* http://dimsemenov.com/plugins/magnific-popup/
* Copyright (c) 2015 Dmitry Semenov; */

(function(e) {
  "function" === typeof define && define.amd ? define(["jquery"], e) : "object" === typeof exports ? e(require("jquery")) : e(window.jQuery || window.Zepto);
})(function(e) {
  var a, x = function() {
  }, B = !!window.jQuery, C, l = e(window), p, y, r, J, k = function(b, c) {
    a.ev.on("mfp" + b + ".mfp", c);
  }, n = function(a, c, d, f) {
    var g = document.createElement("div");
    g.className = "mfp-" + a;
    d && (g.innerHTML = d);
    f ? c && c.appendChild(g) : (g = e(g), c && g.appendTo(c));
    return g;
  }, h = function(b, c) {
    a.ev.triggerHandler("mfp" + b, c);
    a.st.callbacks && (b = b.charAt(0).toLowerCase() + b.slice(1), a.st.callbacks[b] && a.st.callbacks[b].apply(a, e.isArray(c) ? c : [c]));
  }, D = function(b) {
    b === J && a.currTemplate.closeBtn || (a.currTemplate.closeBtn = e(a.st.closeMarkup.replace("%title%", a.st.tClose)), J = b);
    return a.currTemplate.closeBtn;
  }, E = function() {
    e.magnificPopup.instance || (a = new x, a.init(), e.magnificPopup.instance = a);
  }, N = function() {
    var a = document.createElement("p").style, c = ["ms", "O", "Moz", "Webkit"];
    if (void 0 !== a.transition) {
      return !0;
    }
    for (;c.length;) {
      if (c.pop() + "Transition" in a) {
        return !0;
      }
    }
    return !1;
  };
  x.prototype = {constructor:x, init:function() {
    var b = navigator.appVersion;
    a.isIE7 = -1 !== b.indexOf("MSIE 7.");
    a.isIE8 = -1 !== b.indexOf("MSIE 8.");
    a.isLowIE = a.isIE7 || a.isIE8;
    a.isAndroid = /android/gi.test(b);
    a.isIOS = /iphone|ipad|ipod/gi.test(b);
    a.supportsTransition = N();
    a.probablyMobile = a.isAndroid || a.isIOS || /(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent);
    p = e(document);
    a.popupsCache = {};
  }, open:function(b) {
    var c;
    if (!1 === b.isObj) {
      a.items = b.items.toArray();
      a.index = 0;
      var d = b.items, f;
      for (c = 0;c < d.length;c++) {
        if (f = d[c], f.parsed && (f = f.el[0]), f === b.el[0]) {
          a.index = c;
          break;
        }
      }
    } else {
      a.items = e.isArray(b.items) ? b.items : [b.items], a.index = b.index || 0;
    }
    if (a.isOpen) {
      a.updateItemHTML();
    } else {
      a.types = [];
      r = "";
      a.ev = b.mainEl && b.mainEl.length ? b.mainEl.eq(0) : p;
      b.key ? (a.popupsCache[b.key] || (a.popupsCache[b.key] = {}), a.currTemplate = a.popupsCache[b.key]) : a.currTemplate = {};
      a.st = e.extend(!0, {}, e.magnificPopup.defaults, b);
      a.fixedContentPos = "auto" === a.st.fixedContentPos ? !a.probablyMobile : a.st.fixedContentPos;
      a.st.modal && (a.st.closeOnContentClick = !1, a.st.closeOnBgClick = !1, a.st.showCloseBtn = !1, a.st.enableEscapeKey = !1);
      a.bgOverlay || (a.bgOverlay = n("bg").on("click.mfp", function() {
        a.close();
      }), a.wrap = n("wrap").attr("tabindex", -1).on("click.mfp", function(b) {
        a._checkIfClose(b.target) && a.close();
      }), a.container = n("container", a.wrap));
      a.contentContainer = n("content");
      a.st.preloader && (a.preloader = n("preloader", a.container, a.st.tLoading));
      d = e.magnificPopup.modules;
      for (c = 0;c < d.length;c++) {
        f = d[c], f = f.charAt(0).toUpperCase() + f.slice(1), a["init" + f].call(a);
      }
      h("BeforeOpen");
      a.st.showCloseBtn && (a.st.closeBtnInside ? (k("MarkupParse", function(a, b, c, d) {
        c.close_replaceWith = D(d.type);
      }), r += " mfp-close-btn-in") : a.wrap.append(D()));
      a.st.alignTop && (r += " mfp-align-top");
      a.fixedContentPos ? a.wrap.css({overflow:a.st.overflowY, overflowX:"hidden", overflowY:a.st.overflowY}) : a.wrap.css({top:l.scrollTop(), position:"absolute"});
      (!1 === a.st.fixedBgPos || "auto" === a.st.fixedBgPos && !a.fixedContentPos) && a.bgOverlay.css({height:p.height(), position:"absolute"});
      if (a.st.enableEscapeKey) {
        p.on("keyup.mfp", function(b) {
          27 === b.keyCode && a.close();
        });
      }
      l.on("resize.mfp", function() {
        a.updateSize();
      });
      a.st.closeOnContentClick || (r += " mfp-auto-cursor");
      r && a.wrap.addClass(r);
      c = a.wH = l.height();
      d = {};
      a.fixedContentPos && a._hasScrollBar(c) && (f = a._getScrollbarSize()) && (d.marginRight = f);
      a.fixedContentPos && (a.isIE7 ? e("body, html").css("overflow", "hidden") : d.overflow = "hidden");
      f = a.st.mainClass;
      a.isIE7 && (f += " mfp-ie7");
      f && a._addClassToMFP(f);
      a.updateItemHTML();
      h("BuildControls");
      e("html").css(d);
      a.bgOverlay.add(a.wrap).prependTo(a.st.prependTo || e(document.body));
      a._lastFocusedEl = document.activeElement;
      setTimeout(function() {
        a.content ? (a._addClassToMFP("mfp-ready"), a._setFocus()) : a.bgOverlay.addClass("mfp-ready");
        p.on("focusin.mfp", a._onFocusIn);
      }, 16);
      a.isOpen = !0;
      a.updateSize(c);
      h("Open");
      return b;
    }
  }, close:function() {
    a.isOpen && (h("BeforeClose"), a.isOpen = !1, a.st.removalDelay && !a.isLowIE && a.supportsTransition ? (a._addClassToMFP("mfp-removing"), setTimeout(function() {
      a._close();
    }, a.st.removalDelay)) : a._close());
  }, _close:function() {
    h("Close");
    var b = "mfp-removing mfp-ready ";
    a.bgOverlay.detach();
    a.wrap.detach();
    a.container.empty();
    a.st.mainClass && (b += a.st.mainClass + " ");
    a._removeClassFromMFP(b);
    a.fixedContentPos && (b = {marginRight:""}, a.isIE7 ? e("body, html").css("overflow", "") : b.overflow = "", e("html").css(b));
    p.off("keyup.mfp focusin.mfp");
    a.ev.off(".mfp");
    a.wrap.attr("class", "mfp-wrap").removeAttr("style");
    a.bgOverlay.attr("class", "mfp-bg");
    a.container.attr("class", "mfp-container");
    !a.st.showCloseBtn || a.st.closeBtnInside && !0 !== a.currTemplate[a.currItem.type] || a.currTemplate.closeBtn && a.currTemplate.closeBtn.detach();
    a._lastFocusedEl && e(a._lastFocusedEl).focus();
    a.currItem = null;
    a.content = null;
    a.currTemplate = null;
    a.prevHeight = 0;
    h("AfterClose");
  }, updateSize:function(b) {
    a.isIOS ? (b = document.documentElement.clientWidth / window.innerWidth * window.innerHeight, a.wrap.css("height", b), a.wH = b) : a.wH = b || l.height();
    a.fixedContentPos || a.wrap.css("height", a.wH);
    h("Resize");
  }, updateItemHTML:function() {
    var b = a.items[a.index];
    a.contentContainer.detach();
    a.content && a.content.detach();
    b.parsed || (b = a.parseEl(a.index));
    var c = b.type;
    h("BeforeChange", [a.currItem ? a.currItem.type : "", c]);
    a.currItem = b;
    if (!a.currTemplate[c]) {
      var d = a.st[c] ? a.st[c].markup : !1;
      h("FirstMarkupParse", d);
      a.currTemplate[c] = d ? e(d) : !0;
    }
    y && y !== b.type && a.container.removeClass("mfp-" + y + "-holder");
    d = a["get" + c.charAt(0).toUpperCase() + c.slice(1)](b, a.currTemplate[c]);
    a.appendContent(d, c);
    b.preloaded = !0;
    h("Change", b);
    y = b.type;
    a.container.prepend(a.contentContainer);
    h("AfterChange");
  }, appendContent:function(b, c) {
    (a.content = b) ? a.st.showCloseBtn && a.st.closeBtnInside && !0 === a.currTemplate[c] ? a.content.find(".mfp-close").length || a.content.append(D()) : a.content = b : a.content = "";
    h("BeforeAppend");
    a.container.addClass("mfp-" + c + "-holder");
    a.contentContainer.append(a.content);
  }, parseEl:function(b) {
    var c = a.items[b], d;
    c.tagName ? c = {el:e(c)} : (d = c.type, c = {data:c, src:c.src});
    if (c.el) {
      for (var f = a.types, g = 0;g < f.length;g++) {
        if (c.el.hasClass("mfp-" + f[g])) {
          d = f[g];
          break;
        }
      }
      c.src = c.el.attr("data-mfp-src");
      c.src || (c.src = c.el.attr("href"));
    }
    c.type = d || a.st.type || "inline";
    c.index = b;
    c.parsed = !0;
    a.items[b] = c;
    h("ElementParse", c);
    return a.items[b];
  }, addGroup:function(b, c) {
    var d = function(d) {
      d.mfpEl = this;
      a._openClick(d, b, c);
    };
    c || (c = {});
    c.mainEl = b;
    if (c.items) {
      c.isObj = !0, b.off("click.magnificPopup").on("click.magnificPopup", d);
    } else {
      if (c.isObj = !1, c.delegate) {
        b.off("click.magnificPopup").on("click.magnificPopup", c.delegate, d);
      } else {
        c.items = b, b.off("click.magnificPopup").on("click.magnificPopup", d);
      }
    }
  }, _openClick:function(b, c, d) {
    if ((void 0 !== d.midClick ? d.midClick : e.magnificPopup.defaults.midClick) || 2 !== b.which && !b.ctrlKey && !b.metaKey) {
      var f = void 0 !== d.disableOn ? d.disableOn : e.magnificPopup.defaults.disableOn;
      if (f) {
        if (e.isFunction(f)) {
          if (!f.call(a)) {
            return !0;
          }
        } else {
          if (l.width() < f) {
            return !0;
          }
        }
      }
      b.type && (b.preventDefault(), a.isOpen && b.stopPropagation());
      d.el = e(b.mfpEl);
      d.delegate && (d.items = c.find(d.delegate));
      a.open(d);
    }
  }, updateStatus:function(b, c) {
    if (a.preloader) {
      C !== b && a.container.removeClass("mfp-s-" + C);
      c || "loading" !== b || (c = a.st.tLoading);
      var d = {status:b, text:c};
      h("UpdateStatus", d);
      b = d.status;
      c = d.text;
      a.preloader.html(c);
      a.preloader.find("a").on("click", function(a) {
        a.stopImmediatePropagation();
      });
      a.container.addClass("mfp-s-" + b);
      C = b;
    }
  }, _checkIfClose:function(b) {
    if (!e(b).hasClass("mfp-prevent-close")) {
      var c = a.st.closeOnContentClick, d = a.st.closeOnBgClick;
      if (c && d || !a.content || e(b).hasClass("mfp-close") || a.preloader && b === a.preloader[0]) {
        return !0;
      }
      if (b !== a.content[0] && !e.contains(a.content[0], b)) {
        if (d && e.contains(document, b)) {
          return !0;
        }
      } else {
        if (c) {
          return !0;
        }
      }
      return !1;
    }
  }, _addClassToMFP:function(b) {
    a.bgOverlay.addClass(b);
    a.wrap.addClass(b);
  }, _removeClassFromMFP:function(b) {
    this.bgOverlay.removeClass(b);
    a.wrap.removeClass(b);
  }, _hasScrollBar:function(b) {
    return (a.isIE7 ? p.height() : document.body.scrollHeight) > (b || l.height());
  }, _setFocus:function() {
    (a.st.focus ? a.content.find(a.st.focus).eq(0) : a.wrap).focus();
  }, _onFocusIn:function(b) {
    if (b.target !== a.wrap[0] && !e.contains(a.wrap[0], b.target)) {
      return a._setFocus(), !1;
    }
  }, _parseMarkup:function(a, c, d) {
    var f;
    d.data && (c = e.extend(d.data, c));
    h("MarkupParse", [a, c, d]);
    e.each(c, function(c, d) {
      if (void 0 === d || !1 === d) {
        return !0;
      }
      f = c.split("_");
      if (1 < f.length) {
        var e = a.find(".mfp-" + f[0]);
        if (0 < e.length) {
          var h = f[1];
          "replaceWith" === h ? e[0] !== d[0] && e.replaceWith(d) : "img" === h ? e.is("img") ? e.attr("src", d) : e.replaceWith('<img src="' + d + '" class="' + e.attr("class") + '" />') : e.attr(f[1], d);
        }
      } else {
        a.find(".mfp-" + c).html(d);
      }
    });
  }, _getScrollbarSize:function() {
    if (void 0 === a.scrollbarSize) {
      var b = document.createElement("div");
      b.style.cssText = "width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;";
      document.body.appendChild(b);
      a.scrollbarSize = b.offsetWidth - b.clientWidth;
      document.body.removeChild(b);
    }
    return a.scrollbarSize;
  }};
  e.magnificPopup = {instance:null, proto:x.prototype, modules:[], open:function(a, c) {
    E();
    a = a ? e.extend(!0, {}, a) : {};
    a.isObj = !0;
    a.index = c || 0;
    return this.instance.open(a);
  }, close:function() {
    return e.magnificPopup.instance && e.magnificPopup.instance.close();
  }, registerModule:function(a, c) {
    c.options && (e.magnificPopup.defaults[a] = c.options);
    e.extend(this.proto, c.proto);
    this.modules.push(a);
  }, defaults:{disableOn:0, key:null, midClick:!1, mainClass:"", preloader:!0, focus:"", closeOnContentClick:!1, closeOnBgClick:!0, closeBtnInside:!0, showCloseBtn:!0, enableEscapeKey:!0, modal:!1, alignTop:!1, removalDelay:0, prependTo:null, fixedContentPos:"auto", fixedBgPos:"auto", overflowY:"auto", closeMarkup:'<button title="%title%" type="button" class="mfp-close">&times;</button>', tClose:"Close (Esc)", tLoading:"Loading..."}};
  e.fn.magnificPopup = function(b) {
    E();
    var c = e(this);
    if ("string" === typeof b) {
      if ("open" === b) {
        var d, f = B ? c.data("magnificPopup") : c[0].magnificPopup, g = parseInt(arguments[1], 10) || 0;
        f.items ? d = f.items[g] : (d = c, f.delegate && (d = d.find(f.delegate)), d = d.eq(g));
        a._openClick({mfpEl:d}, c, f);
      } else {
        a.isOpen && a[b].apply(a, Array.prototype.slice.call(arguments, 1));
      }
    } else {
      b = e.extend(!0, {}, b), B ? c.data("magnificPopup", b) : c[0].magnificPopup = b, a.addGroup(c, b);
    }
    return c;
  };
  var v, z, A, K = function() {
    A && (z.after(A.addClass(v)).detach(), A = null);
  };
  e.magnificPopup.registerModule("inline", {options:{hiddenClass:"hide", markup:"", tNotFound:"Content not found"}, proto:{initInline:function() {
    a.types.push("inline");
    k("Close.inline", function() {
      K();
    });
  }, getInline:function(b, c) {
    K();
    if (b.src) {
      var d = a.st.inline, f = e(b.src);
      if (f.length) {
        var g = f[0].parentNode;
        g && g.tagName && (z || (v = d.hiddenClass, z = n(v), v = "mfp-" + v), A = f.after(z).detach().removeClass(v));
        a.updateStatus("ready");
      } else {
        a.updateStatus("error", d.tNotFound), f = e("<div>");
      }
      return b.inlineElement = f;
    }
    a.updateStatus("ready");
    a._parseMarkup(c, {}, b);
    return c;
  }}});
  var w, F = function() {
    w && e(document.body).removeClass(w);
  }, L = function() {
    F();
    a.req && a.req.abort();
  };
  e.magnificPopup.registerModule("ajax", {options:{settings:null, cursor:"mfp-ajax-cur", tError:'<a href="%url%">The content</a> could not be loaded.'}, proto:{initAjax:function() {
    a.types.push("ajax");
    w = a.st.ajax.cursor;
    k("Close.ajax", L);
    k("BeforeChange.ajax", L);
  }, getAjax:function(b) {
    w && e(document.body).addClass(w);
    a.updateStatus("loading");
    var c = e.extend({url:b.src, success:function(c, f, g) {
      c = {data:c, xhr:g};
      h("ParseAjax", c);
      a.appendContent(e(c.data), "ajax");
      b.finished = !0;
      F();
      a._setFocus();
      setTimeout(function() {
        a.wrap.addClass("mfp-ready");
      }, 16);
      a.updateStatus("ready");
      h("AjaxContentAdded");
    }, error:function() {
      F();
      b.finished = b.loadError = !0;
      a.updateStatus("error", a.st.ajax.tError.replace("%url%", b.src));
    }}, a.st.ajax.settings);
    a.req = e.ajax(c);
    return "";
  }}});
  var q, O = function(b) {
    if (b.data && void 0 !== b.data.title) {
      return b.data.title;
    }
    var c = a.st.image.titleSrc;
    if (c) {
      if (e.isFunction(c)) {
        return c.call(a, b);
      }
      if (b.el) {
        return b.el.attr(c) || "";
      }
    }
    return "";
  };
  e.magnificPopup.registerModule("image", {options:{markup:'<div class="mfp-figure"><div class="mfp-close"></div><figure><div class="mfp-img"></div><figcaption><div class="mfp-bottom-bar"><div class="mfp-title"></div><div class="mfp-counter"></div></div></figcaption></figure></div>', cursor:"mfp-zoom-out-cur", titleSrc:"title", verticalFit:!0, tError:'<a href="%url%">The image</a> could not be loaded.'}, proto:{initImage:function() {
    var b = a.st.image;
    a.types.push("image");
    k("Open.image", function() {
      "image" === a.currItem.type && b.cursor && e(document.body).addClass(b.cursor);
    });
    k("Close.image", function() {
      b.cursor && e(document.body).removeClass(b.cursor);
      l.off("resize.mfp");
    });
    k("Resize.image", a.resizeImage);
    a.isLowIE && k("AfterChange", a.resizeImage);
  }, resizeImage:function() {
    var b = a.currItem;
    if (b && b.img && a.st.image.verticalFit) {
      var c = 0;
      a.isLowIE && (c = parseInt(b.img.css("padding-top"), 10) + parseInt(b.img.css("padding-bottom"), 10));
      b.img.css("max-height", a.wH - c);
    }
  }, _onImageHasSize:function(b) {
    b.img && (b.hasSize = !0, q && clearInterval(q), b.isCheckingImgSize = !1, h("ImageHasSize", b), b.imgHidden && (a.content && a.content.removeClass("mfp-loading"), b.imgHidden = !1));
  }, findImageSize:function(b) {
    var c = 0, d = b.img[0], f = function(e) {
      q && clearInterval(q);
      q = setInterval(function() {
        0 < d.naturalWidth ? a._onImageHasSize(b) : (200 < c && clearInterval(q), c++, 3 === c ? f(10) : 40 === c ? f(50) : 100 === c && f(500));
      }, e);
    };
    f(1);
  }, getImage:function(b, c) {
    var d = 0, f = function() {
      b && (b.img[0].complete ? (b.img.off(".mfploader"), b === a.currItem && (a._onImageHasSize(b), a.updateStatus("ready")), b.hasSize = !0, b.loaded = !0, h("ImageLoadComplete")) : (d++, 200 > d ? setTimeout(f, 100) : g()));
    }, g = function() {
      b && (b.img.off(".mfploader"), b === a.currItem && (a._onImageHasSize(b), a.updateStatus("error", k.tError.replace("%url%", b.src))), b.hasSize = !0, b.loaded = !0, b.loadError = !0);
    }, k = a.st.image, m = c.find(".mfp-img");
    if (m.length) {
      var u = document.createElement("img");
      u.className = "mfp-img";
      b.el && b.el.find("img").length && (u.alt = b.el.find("img").attr("alt"));
      b.img = e(u).on("load.mfploader", f).on("error.mfploader", g);
      u.src = b.src;
      m.is("img") && (b.img = b.img.clone());
      u = b.img[0];
      0 < u.naturalWidth ? b.hasSize = !0 : u.width || (b.hasSize = !1);
    }
    a._parseMarkup(c, {title:O(b), img_replaceWith:b.img}, b);
    a.resizeImage();
    if (b.hasSize) {
      return q && clearInterval(q), b.loadError ? (c.addClass("mfp-loading"), a.updateStatus("error", k.tError.replace("%url%", b.src))) : (c.removeClass("mfp-loading"), a.updateStatus("ready")), c;
    }
    a.updateStatus("loading");
    b.loading = !0;
    b.hasSize || (b.imgHidden = !0, c.addClass("mfp-loading"), a.findImageSize(b));
    return c;
  }}});
  var G;
  e.magnificPopup.registerModule("zoom", {options:{enabled:!1, easing:"ease-in-out", duration:300, opener:function(a) {
    return a.is("img") ? a : a.find("img");
  }}, proto:{initZoom:function() {
    var b = a.st.zoom, c;
    if (b.enabled && a.supportsTransition) {
      var d = b.duration, e = function(a) {
        a = a.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image");
        var c = {position:"fixed", zIndex:9999, left:0, top:0, "-webkit-backface-visibility":"hidden"};
        c["-webkit-transition"] = c["-moz-transition"] = c["-o-transition"] = c.transition = "all " + b.duration / 1E3 + "s " + b.easing;
        a.css(c);
        return a;
      }, g = function() {
        a.content.css("visibility", "visible");
      }, l, m;
      k("BuildControls.zoom", function() {
        a._allowZoom() && (clearTimeout(l), a.content.css("visibility", "hidden"), (c = a._getItemToZoom()) ? (m = e(c), m.css(a._getOffset()), a.wrap.append(m), l = setTimeout(function() {
          m.css(a._getOffset(!0));
          l = setTimeout(function() {
            g();
            setTimeout(function() {
              m.remove();
              c = m = null;
              h("ZoomAnimationEnded");
            }, 16);
          }, d);
        }, 16)) : g());
      });
      k("BeforeClose.zoom", function() {
        if (a._allowZoom()) {
          clearTimeout(l);
          a.st.removalDelay = d;
          if (!c) {
            c = a._getItemToZoom();
            if (!c) {
              return;
            }
            m = e(c);
          }
          m.css(a._getOffset(!0));
          a.wrap.append(m);
          a.content.css("visibility", "hidden");
          setTimeout(function() {
            m.css(a._getOffset());
          }, 16);
        }
      });
      k("Close.zoom", function() {
        a._allowZoom() && (g(), m && m.remove(), c = null);
      });
    }
  }, _allowZoom:function() {
    return "image" === a.currItem.type;
  }, _getItemToZoom:function() {
    return a.currItem.hasSize ? a.currItem.img : !1;
  }, _getOffset:function(b) {
    var c;
    c = b ? a.currItem.img : a.st.zoom.opener(a.currItem.el || a.currItem);
    b = c.offset();
    var d = parseInt(c.css("padding-top"), 10), f = parseInt(c.css("padding-bottom"), 10);
    b.top -= e(window).scrollTop() - d;
    c = {width:c.width(), height:(B ? c.innerHeight() : c[0].offsetHeight) - f - d};
    void 0 === G && (G = void 0 !== document.createElement("p").style.MozTransform);
    G ? c["-moz-transform"] = c.transform = "translate(" + b.left + "px," + b.top + "px)" : (c.left = b.left, c.top = b.top);
    return c;
  }}});
  var H = function(b) {
    if (a.currTemplate.iframe) {
      var c = a.currTemplate.iframe.find("iframe");
      c.length && (b || (c[0].src = "//about:blank"), a.isIE8 && c.css("display", b ? "block" : "none"));
    }
  };
  e.magnificPopup.registerModule("iframe", {options:{markup:'<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>', srcAction:"iframe_src", patterns:{youtube:{index:"youtube.com", id:"v=", src:"//www.youtube.com/embed/%id%?autoplay=1"}, vimeo:{index:"vimeo.com/", id:"/", src:"//player.vimeo.com/video/%id%?autoplay=1"}, gmaps:{index:"//maps.google.", src:"%id%&output=embed"}}}, proto:{initIframe:function() {
    a.types.push("iframe");
    k("BeforeChange", function(a, c, d) {
      c !== d && ("iframe" === c ? H() : "iframe" === d && H(!0));
    });
    k("Close.iframe", function() {
      H();
    });
  }, getIframe:function(b, c) {
    var d = b.src, f = a.st.iframe;
    e.each(f.patterns, function() {
      if (-1 < d.indexOf(this.index)) {
        return this.id && (d = "string" === typeof this.id ? d.substr(d.lastIndexOf(this.id) + this.id.length, d.length) : this.id.call(this, d)), d = this.src.replace("%id%", d), !1;
      }
    });
    var g = {};
    f.srcAction && (g[f.srcAction] = d);
    a._parseMarkup(c, g, b);
    a.updateStatus("ready");
    return c;
  }}});
  var I = function(b) {
    var c = a.items.length;
    return b > c - 1 ? b - c : 0 > b ? c + b : b;
  }, M = function(a, c, d) {
    return a.replace(/%curr%/gi, c + 1).replace(/%total%/gi, d);
  };
  e.magnificPopup.registerModule("gallery", {options:{enabled:!1, arrowMarkup:'<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>', preload:[0, 2], navigateByImgClick:!0, arrows:!0, tPrev:"Previous (Left arrow key)", tNext:"Next (Right arrow key)", tCounter:"%curr% of %total%"}, proto:{initGallery:function() {
    var b = a.st.gallery, c = !!e.fn.mfpFastClick;
    a.direction = !0;
    if (!b || !b.enabled) {
      return !1;
    }
    r += " mfp-gallery";
    k("Open.mfp-gallery", function() {
      if (b.navigateByImgClick) {
        a.wrap.on("click.mfp-gallery", ".mfp-img", function() {
          if (1 < a.items.length) {
            return a.next(), !1;
          }
        });
      }
      p.on("keydown.mfp-gallery", function(b) {
        37 === b.keyCode ? a.prev() : 39 === b.keyCode && a.next();
      });
    });
    k("UpdateStatus.mfp-gallery", function(b, c) {
      c.text && (c.text = M(c.text, a.currItem.index, a.items.length));
    });
    k("MarkupParse.mfp-gallery", function(c, e, g, h) {
      c = a.items.length;
      g.counter = 1 < c ? M(b.tCounter, h.index, c) : "";
    });
    k("BuildControls.mfp-gallery", function() {
      if (1 < a.items.length && b.arrows && !a.arrowLeft) {
        var d = b.arrowMarkup, f = a.arrowLeft = e(d.replace(/%title%/gi, b.tPrev).replace(/%dir%/gi, "left")).addClass("mfp-prevent-close"), d = a.arrowRight = e(d.replace(/%title%/gi, b.tNext).replace(/%dir%/gi, "right")).addClass("mfp-prevent-close"), g = c ? "mfpFastClick" : "click";
        f[g](function() {
          a.prev();
        });
        d[g](function() {
          a.next();
        });
        a.isIE7 && (n("b", f[0], !1, !0), n("a", f[0], !1, !0), n("b", d[0], !1, !0), n("a", d[0], !1, !0));
        a.container.append(f.add(d));
      }
    });
    k("Change.mfp-gallery", function() {
      a._preloadTimeout && clearTimeout(a._preloadTimeout);
      a._preloadTimeout = setTimeout(function() {
        a.preloadNearbyImages();
        a._preloadTimeout = null;
      }, 16);
    });
    k("Close.mfp-gallery", function() {
      p.off(".mfp-gallery");
      a.wrap.off("click.mfp-gallery");
      a.arrowLeft && c && a.arrowLeft.add(a.arrowRight).destroyMfpFastClick();
      a.arrowRight = a.arrowLeft = null;
    });
  }, next:function() {
    a.direction = !0;
    a.index = I(a.index + 1);
    a.updateItemHTML();
  }, prev:function() {
    a.direction = !1;
    a.index = I(a.index - 1);
    a.updateItemHTML();
  }, goTo:function(b) {
    a.direction = b >= a.index;
    a.index = b;
    a.updateItemHTML();
  }, preloadNearbyImages:function() {
    var b = a.st.gallery.preload, c = Math.min(b[0], a.items.length), b = Math.min(b[1], a.items.length), d;
    for (d = 1;d <= (a.direction ? b : c);d++) {
      a._preloadItem(a.index + d);
    }
    for (d = 1;d <= (a.direction ? c : b);d++) {
      a._preloadItem(a.index - d);
    }
  }, _preloadItem:function(b) {
    b = I(b);
    if (!a.items[b].preloaded) {
      var c = a.items[b];
      c.parsed || (c = a.parseEl(b));
      h("LazyLoad", c);
      "image" === c.type && (c.img = e('<img class="mfp-img" />').on("load.mfploader", function() {
        c.hasSize = !0;
      }).on("error.mfploader", function() {
        c.hasSize = !0;
        c.loadError = !0;
        h("LazyLoadError", c);
      }).attr("src", c.src));
      c.preloaded = !0;
    }
  }}});
  e.magnificPopup.registerModule("retina", {options:{replaceSrc:function(a) {
    return a.src.replace(/\.\w+$/, function(a) {
      return "@2x" + a;
    });
  }, ratio:1}, proto:{initRetina:function() {
    if (1 < window.devicePixelRatio) {
      var b = a.st.retina, c = b.ratio, c = isNaN(c) ? c() : c;
      1 < c && (k("ImageHasSize.retina", function(a, b) {
        b.img.css({"max-width":b.img[0].naturalWidth / c, width:"100%"});
      }), k("ElementParse.retina", function(a, e) {
        e.src = b.replaceSrc(e, c);
      }));
    }
  }}});
  (function() {
    var a = "ontouchstart" in window, c = function() {
      l.off("touchmove" + d + " touchend" + d);
    }, d = ".mfpFastClick";
    e.fn.mfpFastClick = function(f) {
      return e(this).each(function() {
        var g = e(this), h;
        if (a) {
          var k, n, p, q, t, r;
          g.on("touchstart" + d, function(a) {
            q = !1;
            r = 1;
            t = a.originalEvent ? a.originalEvent.touches[0] : a.touches[0];
            n = t.clientX;
            p = t.clientY;
            l.on("touchmove" + d, function(a) {
              t = a.originalEvent ? a.originalEvent.touches : a.touches;
              r = t.length;
              t = t[0];
              if (10 < Math.abs(t.clientX - n) || 10 < Math.abs(t.clientY - p)) {
                q = !0, c();
              }
            }).on("touchend" + d, function(a) {
              c();
              q || 1 < r || (h = !0, a.preventDefault(), clearTimeout(k), k = setTimeout(function() {
                h = !1;
              }, 1E3), f());
            });
          });
        }
        g.on("click" + d, function() {
          h || f();
        });
      });
    };
    e.fn.destroyMfpFastClick = function() {
      e(this).off("touchstart" + d + " click" + d);
      a && l.off("touchmove" + d + " touchend" + d);
    };
  })();
  E();
});
