(function(f) {
  "function" === typeof define && define.amd ? define(["jquery"], f) : "undefined" !== typeof exports ? module.exports = f(require("jquery")) : f(jQuery);
})(function(f) {
  var e = window.Slick || {}, e = function() {
    var a = 0;
    return function(b, c) {
      var d;
      this.defaults = {accessibility:!0, adaptiveHeight:!1, appendArrows:f(b), appendDots:f(b), arrows:!0, asNavFor:null, prevArrow:'<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button">Previous</button>', nextArrow:'<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button">Next</button>', autoplay:!1, autoplaySpeed:3E3, centerMode:!1, centerPadding:"50px", cssEase:"ease", customPaging:function(a, b) {
        return '<button type="button" data-role="none" role="button" aria-required="false" tabindex="0">' + (b + 1) + "</button>";
      }, dots:!1, dotsClass:"slick-dots", draggable:!0, easing:"linear", edgeFriction:.35, fade:!1, focusOnSelect:!1, infinite:!0, initialSlide:0, lazyLoad:"ondemand", mobileFirst:!1, pauseOnHover:!0, pauseOnDotsHover:!1, respondTo:"window", responsive:null, rows:1, rtl:!1, slide:"", slidesPerRow:1, slidesToShow:1, slidesToScroll:1, speed:500, swipe:!0, swipeToSlide:!1, touchMove:!0, touchThreshold:5, useCSS:!0, variableWidth:!1, vertical:!1, verticalSwiping:!1, waitForAnimate:!0, zIndex:1E3};
      this.initials = {animating:!1, dragging:!1, autoPlayTimer:null, currentDirection:0, currentLeft:null, currentSlide:0, direction:1, $dots:null, listWidth:null, listHeight:null, loadIndex:0, $nextArrow:null, $prevArrow:null, slideCount:null, slideWidth:null, $slideTrack:null, $slides:null, sliding:!1, slideOffset:0, swipeLeft:null, $list:null, touchObject:{}, transformsEnabled:!1, unslicked:!1};
      f.extend(this, this.initials);
      this.animProp = this.animType = this.activeBreakpoint = null;
      this.breakpoints = [];
      this.breakpointSettings = [];
      this.cssTransitions = !1;
      this.hidden = "hidden";
      this.paused = !1;
      this.respondTo = this.positionProp = null;
      this.rowCount = 1;
      this.shouldClick = !0;
      this.$slider = f(b);
      this.transitionType = this.transformType = this.$slidesCache = null;
      this.visibilityChange = "visibilitychange";
      this.windowWidth = 0;
      this.windowTimer = null;
      d = f(b).data("slick") || {};
      this.options = f.extend({}, this.defaults, d, c);
      this.currentSlide = this.options.initialSlide;
      this.originalSettings = this.options;
      "undefined" !== typeof document.mozHidden ? (this.hidden = "mozHidden", this.visibilityChange = "mozvisibilitychange") : "undefined" !== typeof document.webkitHidden && (this.hidden = "webkitHidden", this.visibilityChange = "webkitvisibilitychange");
      this.autoPlay = f.proxy(this.autoPlay, this);
      this.autoPlayClear = f.proxy(this.autoPlayClear, this);
      this.changeSlide = f.proxy(this.changeSlide, this);
      this.clickHandler = f.proxy(this.clickHandler, this);
      this.selectHandler = f.proxy(this.selectHandler, this);
      this.setPosition = f.proxy(this.setPosition, this);
      this.swipeHandler = f.proxy(this.swipeHandler, this);
      this.dragHandler = f.proxy(this.dragHandler, this);
      this.keyHandler = f.proxy(this.keyHandler, this);
      this.autoPlayIterator = f.proxy(this.autoPlayIterator, this);
      this.instanceUid = a++;
      this.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/;
      this.registerBreakpoints();
      this.init(!0);
      this.checkResponsive(!0);
    };
  }();
  e.prototype.addSlide = e.prototype.slickAdd = function(a, b, c) {
    if ("boolean" === typeof b) {
      c = b, b = null;
    } else {
      if (0 > b || b >= this.slideCount) {
        return !1;
      }
    }
    this.unload();
    "number" === typeof b ? 0 === b && 0 === this.$slides.length ? f(a).appendTo(this.$slideTrack) : c ? f(a).insertBefore(this.$slides.eq(b)) : f(a).insertAfter(this.$slides.eq(b)) : !0 === c ? f(a).prependTo(this.$slideTrack) : f(a).appendTo(this.$slideTrack);
    this.$slides = this.$slideTrack.children(this.options.slide);
    this.$slideTrack.children(this.options.slide).detach();
    this.$slideTrack.append(this.$slides);
    this.$slides.each(function(a, b) {
      f(b).attr("data-slick-index", a);
    });
    this.$slidesCache = this.$slides;
    this.reinit();
  };
  e.prototype.animateHeight = function() {
    if (1 === this.options.slidesToShow && !0 === this.options.adaptiveHeight && !1 === this.options.vertical) {
      var a = this.$slides.eq(this.currentSlide).outerHeight(!0);
      this.$list.animate({height:a}, this.options.speed);
    }
  };
  e.prototype.animateSlide = function(a, b) {
    var c = {}, d = this;
    d.animateHeight();
    !0 === d.options.rtl && !1 === d.options.vertical && (a = -a);
    !1 === d.transformsEnabled ? !1 === d.options.vertical ? d.$slideTrack.animate({left:a}, d.options.speed, d.options.easing, b) : d.$slideTrack.animate({top:a}, d.options.speed, d.options.easing, b) : !1 === d.cssTransitions ? (!0 === d.options.rtl && (d.currentLeft = -d.currentLeft), f({animStart:d.currentLeft}).animate({animStart:a}, {duration:d.options.speed, easing:d.options.easing, step:function(a) {
      a = Math.ceil(a);
      c[d.animType] = !1 === d.options.vertical ? "translate(" + a + "px, 0px)" : "translate(0px," + a + "px)";
      d.$slideTrack.css(c);
    }, complete:function() {
      b && b.call();
    }})) : (d.applyTransition(), a = Math.ceil(a), c[d.animType] = !1 === d.options.vertical ? "translate3d(" + a + "px, 0px, 0px)" : "translate3d(0px," + a + "px, 0px)", d.$slideTrack.css(c), b && setTimeout(function() {
      d.disableTransition();
      b.call();
    }, d.options.speed));
  };
  e.prototype.asNavFor = function(a) {
    var b = this.options.asNavFor;
    b && null !== b && (b = f(b).not(this.$slider));
    null !== b && "object" === typeof b && b.each(function() {
      var b = f(this).slick("getSlick");
      b.unslicked || b.slideHandler(a, !0);
    });
  };
  e.prototype.applyTransition = function(a) {
    var b = {};
    b[this.transitionType] = !1 === this.options.fade ? this.transformType + " " + this.options.speed + "ms " + this.options.cssEase : "opacity " + this.options.speed + "ms " + this.options.cssEase;
    !1 === this.options.fade ? this.$slideTrack.css(b) : this.$slides.eq(a).css(b);
  };
  e.prototype.autoPlay = function() {
    this.autoPlayTimer && clearInterval(this.autoPlayTimer);
    this.slideCount > this.options.slidesToShow && !0 !== this.paused && (this.autoPlayTimer = setInterval(this.autoPlayIterator, this.options.autoplaySpeed));
  };
  e.prototype.autoPlayClear = function() {
    this.autoPlayTimer && clearInterval(this.autoPlayTimer);
  };
  e.prototype.autoPlayIterator = function() {
    !1 === this.options.infinite ? 1 === this.direction ? (this.currentSlide + 1 === this.slideCount - 1 && (this.direction = 0), this.slideHandler(this.currentSlide + this.options.slidesToScroll)) : (0 === this.currentSlide - 1 && (this.direction = 1), this.slideHandler(this.currentSlide - this.options.slidesToScroll)) : this.slideHandler(this.currentSlide + this.options.slidesToScroll);
  };
  e.prototype.buildArrows = function() {
    !0 === this.options.arrows && (this.$prevArrow = f(this.options.prevArrow).addClass("slick-arrow"), this.$nextArrow = f(this.options.nextArrow).addClass("slick-arrow"), this.slideCount > this.options.slidesToShow ? (this.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), this.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), this.htmlExpr.test(this.options.prevArrow) && this.$prevArrow.prependTo(this.options.appendArrows), this.htmlExpr.test(this.options.nextArrow) && 
    this.$nextArrow.appendTo(this.options.appendArrows), !0 !== this.options.infinite && this.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true")) : this.$prevArrow.add(this.$nextArrow).addClass("slick-hidden").attr({"aria-disabled":"true", tabindex:"-1"}));
  };
  e.prototype.buildDots = function() {
    var a, b;
    if (!0 === this.options.dots && this.slideCount > this.options.slidesToShow) {
      b = '<ul class="' + this.options.dotsClass + '">';
      for (a = 0;a <= this.getDotCount();a += 1) {
        b += "<li>" + this.options.customPaging.call(this, this, a) + "</li>";
      }
      this.$dots = f(b + "</ul>").appendTo(this.options.appendDots);
      this.$dots.find("li").first().addClass("slick-active").attr("aria-hidden", "false");
    }
  };
  e.prototype.buildOut = function() {
    this.$slides = this.$slider.children(this.options.slide + ":not(.slick-cloned)").addClass("slick-slide");
    this.slideCount = this.$slides.length;
    this.$slides.each(function(a, b) {
      f(b).attr("data-slick-index", a).data("originalStyling", f(b).attr("style") || "");
    });
    this.$slidesCache = this.$slides;
    this.$slider.addClass("slick-slider");
    this.$slideTrack = 0 === this.slideCount ? f('<div class="slick-track"/>').appendTo(this.$slider) : this.$slides.wrapAll('<div class="slick-track"/>').parent();
    this.$list = this.$slideTrack.wrap('<div aria-live="polite" class="slick-list"/>').parent();
    this.$slideTrack.css("opacity", 0);
    if (!0 === this.options.centerMode || !0 === this.options.swipeToSlide) {
      this.options.slidesToScroll = 1;
    }
    f("img[data-lazy]", this.$slider).not("[src]").addClass("slick-loading");
    this.setupInfinite();
    this.buildArrows();
    this.buildDots();
    this.updateDots();
    this.setSlideClasses("number" === typeof this.currentSlide ? this.currentSlide : 0);
    !0 === this.options.draggable && this.$list.addClass("draggable");
  };
  e.prototype.buildRows = function() {
    var a, b, c, d, f, e, g;
    d = document.createDocumentFragment();
    e = this.$slider.children();
    if (1 < this.options.rows) {
      g = this.options.slidesPerRow * this.options.rows;
      f = Math.ceil(e.length / g);
      for (a = 0;a < f;a++) {
        var k = document.createElement("div");
        for (b = 0;b < this.options.rows;b++) {
          var l = document.createElement("div");
          for (c = 0;c < this.options.slidesPerRow;c++) {
            var m = a * g + (b * this.options.slidesPerRow + c);
            e.get(m) && l.appendChild(e.get(m));
          }
          k.appendChild(l);
        }
        d.appendChild(k);
      }
      this.$slider.html(d);
      this.$slider.children().children().children().css({width:100 / this.options.slidesPerRow + "%", display:"inline-block"});
    }
  };
  e.prototype.checkResponsive = function(a, b) {
    var c, d, e, h = !1;
    d = this.$slider.width();
    var g = window.innerWidth || f(window).width();
    "window" === this.respondTo ? e = g : "slider" === this.respondTo ? e = d : "min" === this.respondTo && (e = Math.min(g, d));
    if (this.options.responsive && this.options.responsive.length && null !== this.options.responsive) {
      d = null;
      for (c in this.breakpoints) {
        this.breakpoints.hasOwnProperty(c) && (!1 === this.originalSettings.mobileFirst ? e < this.breakpoints[c] && (d = this.breakpoints[c]) : e > this.breakpoints[c] && (d = this.breakpoints[c]));
      }
      if (null !== d) {
        if (null !== this.activeBreakpoint) {
          if (d !== this.activeBreakpoint || b) {
            this.activeBreakpoint = d, "unslick" === this.breakpointSettings[d] ? this.unslick(d) : (this.options = f.extend({}, this.originalSettings, this.breakpointSettings[d]), !0 === a && (this.currentSlide = this.options.initialSlide), this.refresh(a)), h = d;
          }
        } else {
          this.activeBreakpoint = d, "unslick" === this.breakpointSettings[d] ? this.unslick(d) : (this.options = f.extend({}, this.originalSettings, this.breakpointSettings[d]), !0 === a && (this.currentSlide = this.options.initialSlide), this.refresh(a)), h = d;
        }
      } else {
        null !== this.activeBreakpoint && (this.activeBreakpoint = null, this.options = this.originalSettings, !0 === a && (this.currentSlide = this.options.initialSlide), this.refresh(a), h = d);
      }
      a || !1 === h || this.$slider.trigger("breakpoint", [this, h]);
    }
  };
  e.prototype.changeSlide = function(a, b) {
    var c = f(a.target), d;
    c.is("a") && a.preventDefault();
    c.is("li") || (c = c.closest("li"));
    d = 0 !== this.slideCount % this.options.slidesToScroll ? 0 : (this.slideCount - this.currentSlide) % this.options.slidesToScroll;
    switch(a.data.message) {
      case "previous":
        c = 0 === d ? this.options.slidesToScroll : this.options.slidesToShow - d;
        this.slideCount > this.options.slidesToShow && this.slideHandler(this.currentSlide - c, !1, b);
        break;
      case "next":
        c = 0 === d ? this.options.slidesToScroll : d;
        this.slideCount > this.options.slidesToShow && this.slideHandler(this.currentSlide + c, !1, b);
        break;
      case "index":
        d = 0 === a.data.index ? 0 : a.data.index || c.index() * this.options.slidesToScroll, this.slideHandler(this.checkNavigable(d), !1, b), c.children().trigger("focus");
    }
  };
  e.prototype.checkNavigable = function(a) {
    var b, c;
    b = this.getNavigableIndexes();
    c = 0;
    if (a > b[b.length - 1]) {
      a = b[b.length - 1];
    } else {
      for (var d in b) {
        if (a < b[d]) {
          a = c;
          break;
        }
        c = b[d];
      }
    }
    return a;
  };
  e.prototype.cleanUpEvents = function() {
    this.options.dots && null !== this.$dots && (f("li", this.$dots).off("click.slick", this.changeSlide), !0 === this.options.pauseOnDotsHover && !0 === this.options.autoplay && f("li", this.$dots).off("mouseenter.slick", f.proxy(this.setPaused, this, !0)).off("mouseleave.slick", f.proxy(this.setPaused, this, !1)));
    !0 === this.options.arrows && this.slideCount > this.options.slidesToShow && (this.$prevArrow && this.$prevArrow.off("click.slick", this.changeSlide), this.$nextArrow && this.$nextArrow.off("click.slick", this.changeSlide));
    this.$list.off("touchstart.slick mousedown.slick", this.swipeHandler);
    this.$list.off("touchmove.slick mousemove.slick", this.swipeHandler);
    this.$list.off("touchend.slick mouseup.slick", this.swipeHandler);
    this.$list.off("touchcancel.slick mouseleave.slick", this.swipeHandler);
    this.$list.off("click.slick", this.clickHandler);
    f(document).off(this.visibilityChange, this.visibility);
    this.$list.off("mouseenter.slick", f.proxy(this.setPaused, this, !0));
    this.$list.off("mouseleave.slick", f.proxy(this.setPaused, this, !1));
    !0 === this.options.accessibility && this.$list.off("keydown.slick", this.keyHandler);
    !0 === this.options.focusOnSelect && f(this.$slideTrack).children().off("click.slick", this.selectHandler);
    f(window).off("orientationchange.slick.slick-" + this.instanceUid, this.orientationChange);
    f(window).off("resize.slick.slick-" + this.instanceUid, this.resize);
    f("[draggable!=true]", this.$slideTrack).off("dragstart", this.preventDefault);
    f(window).off("load.slick.slick-" + this.instanceUid, this.setPosition);
    f(document).off("ready.slick.slick-" + this.instanceUid, this.setPosition);
  };
  e.prototype.cleanUpRows = function() {
    var a;
    1 < this.options.rows && (a = this.$slides.children().children(), a.removeAttr("style"), this.$slider.html(a));
  };
  e.prototype.clickHandler = function(a) {
    !1 === this.shouldClick && (a.stopImmediatePropagation(), a.stopPropagation(), a.preventDefault());
  };
  e.prototype.destroy = function(a) {
    this.autoPlayClear();
    this.touchObject = {};
    this.cleanUpEvents();
    f(".slick-cloned", this.$slider).detach();
    this.$dots && this.$dots.remove();
    !0 === this.options.arrows && (this.$prevArrow && this.$prevArrow.length && (this.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), this.htmlExpr.test(this.options.prevArrow) && this.$prevArrow.remove()), this.$nextArrow && this.$nextArrow.length && (this.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), this.htmlExpr.test(this.options.nextArrow) && 
    this.$nextArrow.remove()));
    this.$slides && (this.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function() {
      f(this).attr("style", f(this).data("originalStyling"));
    }), this.$slideTrack.children(this.options.slide).detach(), this.$slideTrack.detach(), this.$list.detach(), this.$slider.append(this.$slides));
    this.cleanUpRows();
    this.$slider.removeClass("slick-slider");
    this.$slider.removeClass("slick-initialized");
    this.unslicked = !0;
    a || this.$slider.trigger("destroy", [this]);
  };
  e.prototype.disableTransition = function(a) {
    var b = {};
    b[this.transitionType] = "";
    !1 === this.options.fade ? this.$slideTrack.css(b) : this.$slides.eq(a).css(b);
  };
  e.prototype.fadeSlide = function(a, b) {
    var c = this;
    !1 === c.cssTransitions ? (c.$slides.eq(a).css({zIndex:c.options.zIndex}), c.$slides.eq(a).animate({opacity:1}, c.options.speed, c.options.easing, b)) : (c.applyTransition(a), c.$slides.eq(a).css({opacity:1, zIndex:c.options.zIndex}), b && setTimeout(function() {
      c.disableTransition(a);
      b.call();
    }, c.options.speed));
  };
  e.prototype.fadeSlideOut = function(a) {
    !1 === this.cssTransitions ? this.$slides.eq(a).animate({opacity:0, zIndex:this.options.zIndex - 2}, this.options.speed, this.options.easing) : (this.applyTransition(a), this.$slides.eq(a).css({opacity:0, zIndex:this.options.zIndex - 2}));
  };
  e.prototype.filterSlides = e.prototype.slickFilter = function(a) {
    null !== a && (this.unload(), this.$slideTrack.children(this.options.slide).detach(), this.$slidesCache.filter(a).appendTo(this.$slideTrack), this.reinit());
  };
  e.prototype.getCurrent = e.prototype.slickCurrentSlide = function() {
    return this.currentSlide;
  };
  e.prototype.getDotCount = function() {
    var a = 0, b = 0, c = 0;
    if (!0 === this.options.infinite) {
      for (;a < this.slideCount;) {
        ++c, a = b + this.options.slidesToShow, b += this.options.slidesToScroll <= this.options.slidesToShow ? this.options.slidesToScroll : this.options.slidesToShow;
      }
    } else {
      if (!0 === this.options.centerMode) {
        c = this.slideCount;
      } else {
        for (;a < this.slideCount;) {
          ++c, a = b + this.options.slidesToShow, b += this.options.slidesToScroll <= this.options.slidesToShow ? this.options.slidesToScroll : this.options.slidesToShow;
        }
      }
    }
    return c - 1;
  };
  e.prototype.getLeft = function(a) {
    var b, c = 0;
    this.slideOffset = 0;
    b = this.$slides.first().outerHeight(!0);
    !0 === this.options.infinite ? (this.slideCount > this.options.slidesToShow && (this.slideOffset = this.slideWidth * this.options.slidesToShow * -1, c = b * this.options.slidesToShow * -1), 0 !== this.slideCount % this.options.slidesToScroll && a + this.options.slidesToScroll > this.slideCount && this.slideCount > this.options.slidesToShow && (a > this.slideCount ? (this.slideOffset = (this.options.slidesToShow - (a - this.slideCount)) * this.slideWidth * -1, c = (this.options.slidesToShow - 
    (a - this.slideCount)) * b * -1) : (this.slideOffset = this.slideCount % this.options.slidesToScroll * this.slideWidth * -1, c = this.slideCount % this.options.slidesToScroll * b * -1))) : a + this.options.slidesToShow > this.slideCount && (this.slideOffset = (a + this.options.slidesToShow - this.slideCount) * this.slideWidth, c = (a + this.options.slidesToShow - this.slideCount) * b);
    this.slideCount <= this.options.slidesToShow && (c = this.slideOffset = 0);
    !0 === this.options.centerMode && !0 === this.options.infinite ? this.slideOffset += this.slideWidth * Math.floor(this.options.slidesToShow / 2) - this.slideWidth : !0 === this.options.centerMode && (this.slideOffset = 0, this.slideOffset += this.slideWidth * Math.floor(this.options.slidesToShow / 2));
    b = !1 === this.options.vertical ? a * this.slideWidth * -1 + this.slideOffset : a * b * -1 + c;
    !0 === this.options.variableWidth && (c = this.slideCount <= this.options.slidesToShow || !1 === this.options.infinite ? this.$slideTrack.children(".slick-slide").eq(a) : this.$slideTrack.children(".slick-slide").eq(a + this.options.slidesToShow), b = c[0] ? -1 * c[0].offsetLeft : 0, !0 === this.options.centerMode && (c = !1 === this.options.infinite ? this.$slideTrack.children(".slick-slide").eq(a) : this.$slideTrack.children(".slick-slide").eq(a + this.options.slidesToShow + 1), b = c[0] ? 
    -1 * c[0].offsetLeft : 0, b += (this.$list.width() - c.outerWidth()) / 2));
    return b;
  };
  e.prototype.getOption = e.prototype.slickGetOption = function(a) {
    return this.options[a];
  };
  e.prototype.getNavigableIndexes = function() {
    var a = 0, b = 0, c = [], d;
    !1 === this.options.infinite ? d = this.slideCount : (a = -1 * this.options.slidesToScroll, b = -1 * this.options.slidesToScroll, d = 2 * this.slideCount);
    for (;a < d;) {
      c.push(a), a = b + this.options.slidesToScroll, b += this.options.slidesToScroll <= this.options.slidesToShow ? this.options.slidesToScroll : this.options.slidesToShow;
    }
    return c;
  };
  e.prototype.getSlick = function() {
    return this;
  };
  e.prototype.getSlideCount = function() {
    var a = this, b, c, d;
    d = !0 === a.options.centerMode ? a.slideWidth * Math.floor(a.options.slidesToShow / 2) : 0;
    return !0 === a.options.swipeToSlide ? (a.$slideTrack.find(".slick-slide").each(function(b, e) {
      if (e.offsetLeft - d + f(e).outerWidth() / 2 > -1 * a.swipeLeft) {
        return c = e, !1;
      }
    }), b = Math.abs(f(c).attr("data-slick-index") - a.currentSlide) || 1) : a.options.slidesToScroll;
  };
  e.prototype.goTo = e.prototype.slickGoTo = function(a, b) {
    this.changeSlide({data:{message:"index", index:parseInt(a)}}, b);
  };
  e.prototype.init = function(a) {
    f(this.$slider).hasClass("slick-initialized") || (f(this.$slider).addClass("slick-initialized"), this.buildRows(), this.buildOut(), this.setProps(), this.startLoad(), this.loadSlider(), this.initializeEvents(), this.updateArrows(), this.updateDots());
    a && this.$slider.trigger("init", [this]);
    !0 === this.options.accessibility && this.initADA();
  };
  e.prototype.initArrowEvents = function() {
    !0 === this.options.arrows && this.slideCount > this.options.slidesToShow && (this.$prevArrow.on("click.slick", {message:"previous"}, this.changeSlide), this.$nextArrow.on("click.slick", {message:"next"}, this.changeSlide));
  };
  e.prototype.initDotEvents = function() {
    if (!0 === this.options.dots && this.slideCount > this.options.slidesToShow) {
      f("li", this.$dots).on("click.slick", {message:"index"}, this.changeSlide);
    }
    if (!0 === this.options.dots && !0 === this.options.pauseOnDotsHover && !0 === this.options.autoplay) {
      f("li", this.$dots).on("mouseenter.slick", f.proxy(this.setPaused, this, !0)).on("mouseleave.slick", f.proxy(this.setPaused, this, !1));
    }
  };
  e.prototype.initializeEvents = function() {
    this.initArrowEvents();
    this.initDotEvents();
    this.$list.on("touchstart.slick mousedown.slick", {action:"start"}, this.swipeHandler);
    this.$list.on("touchmove.slick mousemove.slick", {action:"move"}, this.swipeHandler);
    this.$list.on("touchend.slick mouseup.slick", {action:"end"}, this.swipeHandler);
    this.$list.on("touchcancel.slick mouseleave.slick", {action:"end"}, this.swipeHandler);
    this.$list.on("click.slick", this.clickHandler);
    f(document).on(this.visibilityChange, f.proxy(this.visibility, this));
    this.$list.on("mouseenter.slick", f.proxy(this.setPaused, this, !0));
    this.$list.on("mouseleave.slick", f.proxy(this.setPaused, this, !1));
    if (!0 === this.options.accessibility) {
      this.$list.on("keydown.slick", this.keyHandler);
    }
    if (!0 === this.options.focusOnSelect) {
      f(this.$slideTrack).children().on("click.slick", this.selectHandler);
    }
    f(window).on("orientationchange.slick.slick-" + this.instanceUid, f.proxy(this.orientationChange, this));
    f(window).on("resize.slick.slick-" + this.instanceUid, f.proxy(this.resize, this));
    f("[draggable!=true]", this.$slideTrack).on("dragstart", this.preventDefault);
    f(window).on("load.slick.slick-" + this.instanceUid, this.setPosition);
    f(document).on("ready.slick.slick-" + this.instanceUid, this.setPosition);
  };
  e.prototype.initUI = function() {
    !0 === this.options.arrows && this.slideCount > this.options.slidesToShow && (this.$prevArrow.show(), this.$nextArrow.show());
    !0 === this.options.dots && this.slideCount > this.options.slidesToShow && this.$dots.show();
    !0 === this.options.autoplay && this.autoPlay();
  };
  e.prototype.keyHandler = function(a) {
    a.target.tagName.match("TEXTAREA|INPUT|SELECT") || (37 === a.keyCode && !0 === this.options.accessibility ? this.changeSlide({data:{message:"previous"}}) : 39 === a.keyCode && !0 === this.options.accessibility && this.changeSlide({data:{message:"next"}}));
  };
  e.prototype.lazyLoad = function() {
    function a(a) {
      f("img[data-lazy]", a).each(function() {
        var a = f(this), b = f(this).attr("data-lazy"), c = document.createElement("img");
        c.onload = function() {
          a.animate({opacity:0}, 100, function() {
            a.attr("src", b).animate({opacity:1}, 200, function() {
              a.removeAttr("data-lazy").removeClass("slick-loading");
            });
          });
        };
        c.src = b;
      });
    }
    var b, c;
    !0 === this.options.centerMode ? !0 === this.options.infinite ? (b = this.currentSlide + (this.options.slidesToShow / 2 + 1), c = b + this.options.slidesToShow + 2) : (b = Math.max(0, this.currentSlide - (this.options.slidesToShow / 2 + 1)), c = 2 + (this.options.slidesToShow / 2 + 1) + this.currentSlide) : (b = this.options.infinite ? this.options.slidesToShow + this.currentSlide : this.currentSlide, c = b + this.options.slidesToShow, !0 === this.options.fade && (0 < b && b--, c <= this.slideCount && 
    c++));
    b = this.$slider.find(".slick-slide").slice(b, c);
    a(b);
    this.slideCount <= this.options.slidesToShow ? (b = this.$slider.find(".slick-slide"), a(b)) : this.currentSlide >= this.slideCount - this.options.slidesToShow ? (b = this.$slider.find(".slick-cloned").slice(0, this.options.slidesToShow), a(b)) : 0 === this.currentSlide && (b = this.$slider.find(".slick-cloned").slice(-1 * this.options.slidesToShow), a(b));
  };
  e.prototype.loadSlider = function() {
    this.setPosition();
    this.$slideTrack.css({opacity:1});
    this.$slider.removeClass("slick-loading");
    this.initUI();
    "progressive" === this.options.lazyLoad && this.progressiveLazyLoad();
  };
  e.prototype.next = e.prototype.slickNext = function() {
    this.changeSlide({data:{message:"next"}});
  };
  e.prototype.orientationChange = function() {
    this.checkResponsive();
    this.setPosition();
  };
  e.prototype.pause = e.prototype.slickPause = function() {
    this.autoPlayClear();
    this.paused = !0;
  };
  e.prototype.play = e.prototype.slickPlay = function() {
    this.paused = !1;
    this.autoPlay();
  };
  e.prototype.postSlide = function(a) {
    this.$slider.trigger("afterChange", [this, a]);
    this.animating = !1;
    this.setPosition();
    this.swipeLeft = null;
    !0 === this.options.autoplay && !1 === this.paused && this.autoPlay();
    !0 === this.options.accessibility && this.initADA();
  };
  e.prototype.prev = e.prototype.slickPrev = function() {
    this.changeSlide({data:{message:"previous"}});
  };
  e.prototype.preventDefault = function(a) {
    a.preventDefault();
  };
  e.prototype.progressiveLazyLoad = function() {
    var a = this, b;
    0 < f("img[data-lazy]", a.$slider).length && (b = f("img[data-lazy]", a.$slider).first(), b.attr("src", b.attr("data-lazy")).removeClass("slick-loading").load(function() {
      b.removeAttr("data-lazy");
      a.progressiveLazyLoad();
      !0 === a.options.adaptiveHeight && a.setPosition();
    }).error(function() {
      b.removeAttr("data-lazy");
      a.progressiveLazyLoad();
    }));
  };
  e.prototype.refresh = function(a) {
    var b = this.currentSlide;
    this.destroy(!0);
    f.extend(this, this.initials, {currentSlide:b});
    this.init();
    a || this.changeSlide({data:{message:"index", index:b}}, !1);
  };
  e.prototype.registerBreakpoints = function() {
    var a = this, b, c, d, e = a.options.responsive || null;
    if ("array" === f.type(e) && e.length) {
      a.respondTo = a.options.respondTo || "window";
      for (b in e) {
        if (d = a.breakpoints.length - 1, c = e[b].breakpoint, e.hasOwnProperty(b)) {
          for (;0 <= d;) {
            a.breakpoints[d] && a.breakpoints[d] === c && a.breakpoints.splice(d, 1), d--;
          }
          a.breakpoints.push(c);
          a.breakpointSettings[c] = e[b].settings;
        }
      }
      a.breakpoints.sort(function(b, c) {
        return a.options.mobileFirst ? b - c : c - b;
      });
    }
  };
  e.prototype.reinit = function() {
    this.$slides = this.$slideTrack.children(this.options.slide).addClass("slick-slide");
    this.slideCount = this.$slides.length;
    this.currentSlide >= this.slideCount && 0 !== this.currentSlide && (this.currentSlide -= this.options.slidesToScroll);
    this.slideCount <= this.options.slidesToShow && (this.currentSlide = 0);
    this.registerBreakpoints();
    this.setProps();
    this.setupInfinite();
    this.buildArrows();
    this.updateArrows();
    this.initArrowEvents();
    this.buildDots();
    this.updateDots();
    this.initDotEvents();
    this.checkResponsive(!1, !0);
    if (!0 === this.options.focusOnSelect) {
      f(this.$slideTrack).children().on("click.slick", this.selectHandler);
    }
    this.setSlideClasses(0);
    this.setPosition();
    this.$slider.trigger("reInit", [this]);
    !0 === this.options.autoplay && this.focusHandler();
  };
  e.prototype.resize = function() {
    var a = this;
    f(window).width() !== a.windowWidth && (clearTimeout(a.windowDelay), a.windowDelay = window.setTimeout(function() {
      a.windowWidth = f(window).width();
      a.checkResponsive();
      a.unslicked || a.setPosition();
    }, 50));
  };
  e.prototype.removeSlide = e.prototype.slickRemove = function(a, b, c) {
    a = "boolean" === typeof a ? !0 === a ? 0 : this.slideCount - 1 : !0 === b ? --a : a;
    if (1 > this.slideCount || 0 > a || a > this.slideCount - 1) {
      return !1;
    }
    this.unload();
    !0 === c ? this.$slideTrack.children().remove() : this.$slideTrack.children(this.options.slide).eq(a).remove();
    this.$slides = this.$slideTrack.children(this.options.slide);
    this.$slideTrack.children(this.options.slide).detach();
    this.$slideTrack.append(this.$slides);
    this.$slidesCache = this.$slides;
    this.reinit();
  };
  e.prototype.setCSS = function(a) {
    var b = {}, c, d;
    !0 === this.options.rtl && (a = -a);
    c = "left" == this.positionProp ? Math.ceil(a) + "px" : "0px";
    d = "top" == this.positionProp ? Math.ceil(a) + "px" : "0px";
    b[this.positionProp] = a;
    !1 !== this.transformsEnabled && (b = {}, b[this.animType] = !1 === this.cssTransitions ? "translate(" + c + ", " + d + ")" : "translate3d(" + c + ", " + d + ", 0px)");
    this.$slideTrack.css(b);
  };
  e.prototype.setDimensions = function() {
    !1 === this.options.vertical ? !0 === this.options.centerMode && this.$list.css({padding:"0px " + this.options.centerPadding}) : (this.$list.height(this.$slides.first().outerHeight(!0) * this.options.slidesToShow), !0 === this.options.centerMode && this.$list.css({padding:this.options.centerPadding + " 0px"}));
    this.listWidth = this.$list.width();
    this.listHeight = this.$list.height();
    !1 === this.options.vertical && !1 === this.options.variableWidth ? (this.slideWidth = Math.ceil(this.listWidth / this.options.slidesToShow), this.$slideTrack.width(Math.ceil(this.slideWidth * this.$slideTrack.children(".slick-slide").length))) : !0 === this.options.variableWidth ? this.$slideTrack.width(5E3 * this.slideCount) : (this.slideWidth = Math.ceil(this.listWidth), this.$slideTrack.height(Math.ceil(this.$slides.first().outerHeight(!0) * this.$slideTrack.children(".slick-slide").length)));
    var a = this.$slides.first().outerWidth(!0) - this.$slides.first().width();
    !1 === this.options.variableWidth && this.$slideTrack.children(".slick-slide").width(this.slideWidth - a);
  };
  e.prototype.setFade = function() {
    var a = this, b;
    a.$slides.each(function(c, d) {
      b = a.slideWidth * c * -1;
      !0 === a.options.rtl ? f(d).css({position:"relative", right:b, top:0, zIndex:a.options.zIndex - 2, opacity:0}) : f(d).css({position:"relative", left:b, top:0, zIndex:a.options.zIndex - 2, opacity:0});
    });
    a.$slides.eq(a.currentSlide).css({zIndex:a.options.zIndex - 1, opacity:1});
  };
  e.prototype.setHeight = function() {
    if (1 === this.options.slidesToShow && !0 === this.options.adaptiveHeight && !1 === this.options.vertical) {
      var a = this.$slides.eq(this.currentSlide).outerHeight(!0);
      this.$list.css("height", a);
    }
  };
  e.prototype.setOption = e.prototype.slickSetOption = function(a, b, c) {
    var d;
    if ("responsive" === a && "array" === f.type(b)) {
      for (d in b) {
        if ("array" !== f.type(this.options.responsive)) {
          this.options.responsive = [b[d]];
        } else {
          for (a = this.options.responsive.length - 1;0 <= a;) {
            this.options.responsive[a].breakpoint === b[d].breakpoint && this.options.responsive.splice(a, 1), a--;
          }
          this.options.responsive.push(b[d]);
        }
      }
    } else {
      this.options[a] = b;
    }
    !0 === c && (this.unload(), this.reinit());
  };
  e.prototype.setPosition = function() {
    this.setDimensions();
    this.setHeight();
    !1 === this.options.fade ? this.setCSS(this.getLeft(this.currentSlide)) : this.setFade();
    this.$slider.trigger("setPosition", [this]);
  };
  e.prototype.setProps = function() {
    var a = document.body.style;
    this.positionProp = !0 === this.options.vertical ? "top" : "left";
    "top" === this.positionProp ? this.$slider.addClass("slick-vertical") : this.$slider.removeClass("slick-vertical");
    void 0 === a.WebkitTransition && void 0 === a.MozTransition && void 0 === a.msTransition || !0 !== this.options.useCSS || (this.cssTransitions = !0);
    this.options.fade && ("number" === typeof this.options.zIndex ? 3 > this.options.zIndex && (this.options.zIndex = 3) : this.options.zIndex = this.defaults.zIndex);
    void 0 !== a.OTransform && (this.animType = "OTransform", this.transformType = "-o-transform", this.transitionType = "OTransition", void 0 === a.perspectiveProperty && void 0 === a.webkitPerspective && (this.animType = !1));
    void 0 !== a.MozTransform && (this.animType = "MozTransform", this.transformType = "-moz-transform", this.transitionType = "MozTransition", void 0 === a.perspectiveProperty && void 0 === a.MozPerspective && (this.animType = !1));
    void 0 !== a.webkitTransform && (this.animType = "webkitTransform", this.transformType = "-webkit-transform", this.transitionType = "webkitTransition", void 0 === a.perspectiveProperty && void 0 === a.webkitPerspective && (this.animType = !1));
    void 0 !== a.msTransform && (this.animType = "msTransform", this.transformType = "-ms-transform", this.transitionType = "msTransition", void 0 === a.msTransform && (this.animType = !1));
    void 0 !== a.transform && !1 !== this.animType && (this.transformType = this.animType = "transform", this.transitionType = "transition");
    this.transformsEnabled = null !== this.animType && !1 !== this.animType;
  };
  e.prototype.setSlideClasses = function(a) {
    var b, c, d;
    c = this.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden", "true");
    this.$slides.eq(a).addClass("slick-current");
    !0 === this.options.centerMode ? (b = Math.floor(this.options.slidesToShow / 2), !0 === this.options.infinite && (a >= b && a <= this.slideCount - 1 - b ? this.$slides.slice(a - b, a + b + 1).addClass("slick-active").attr("aria-hidden", "false") : (d = this.options.slidesToShow + a, c.slice(d - b + 1, d + b + 2).addClass("slick-active").attr("aria-hidden", "false")), 0 === a ? c.eq(c.length - 1 - this.options.slidesToShow).addClass("slick-center") : a === this.slideCount - 1 && c.eq(this.options.slidesToShow).addClass("slick-center")), 
    this.$slides.eq(a).addClass("slick-center")) : 0 <= a && a <= this.slideCount - this.options.slidesToShow ? this.$slides.slice(a, a + this.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false") : c.length <= this.options.slidesToShow ? c.addClass("slick-active").attr("aria-hidden", "false") : (b = this.slideCount % this.options.slidesToShow, d = !0 === this.options.infinite ? this.options.slidesToShow + a : a, this.options.slidesToShow == this.options.slidesToScroll && this.slideCount - 
    a < this.options.slidesToShow ? c.slice(d - (this.options.slidesToShow - b), d + b).addClass("slick-active").attr("aria-hidden", "false") : c.slice(d, d + this.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false"));
    "ondemand" === this.options.lazyLoad && this.lazyLoad();
  };
  e.prototype.setupInfinite = function() {
    var a, b, c;
    !0 === this.options.fade && (this.options.centerMode = !1);
    if (!0 === this.options.infinite && !1 === this.options.fade && (b = null, this.slideCount > this.options.slidesToShow)) {
      c = !0 === this.options.centerMode ? this.options.slidesToShow + 1 : this.options.slidesToShow;
      for (a = this.slideCount;a > this.slideCount - c;--a) {
        b = a - 1, f(this.$slides[b]).clone(!0).attr("id", "").attr("data-slick-index", b - this.slideCount).prependTo(this.$slideTrack).addClass("slick-cloned");
      }
      for (a = 0;a < c;a += 1) {
        b = a, f(this.$slides[b]).clone(!0).attr("id", "").attr("data-slick-index", b + this.slideCount).appendTo(this.$slideTrack).addClass("slick-cloned");
      }
      this.$slideTrack.find(".slick-cloned").find("[id]").each(function() {
        f(this).attr("id", "");
      });
    }
  };
  e.prototype.setPaused = function(a) {
    !0 === this.options.autoplay && !0 === this.options.pauseOnHover && ((this.paused = a) ? this.autoPlayClear() : this.autoPlay());
  };
  e.prototype.selectHandler = function(a) {
    a = f(a.target).is(".slick-slide") ? f(a.target) : f(a.target).parents(".slick-slide");
    (a = parseInt(a.attr("data-slick-index"))) || (a = 0);
    this.slideCount <= this.options.slidesToShow ? (this.setSlideClasses(a), this.asNavFor(a)) : this.slideHandler(a);
  };
  e.prototype.slideHandler = function(a, b, c) {
    var d, e, f = null, g = this;
    !0 === g.animating && !0 === g.options.waitForAnimate || !0 === g.options.fade && g.currentSlide === a || g.slideCount <= g.options.slidesToShow || (!1 === (b || !1) && g.asNavFor(a), d = a, f = g.getLeft(d), b = g.getLeft(g.currentSlide), g.currentLeft = null === g.swipeLeft ? b : g.swipeLeft, !1 === g.options.infinite && !1 === g.options.centerMode && (0 > a || a > g.getDotCount() * g.options.slidesToScroll) ? !1 === g.options.fade && (d = g.currentSlide, !0 !== c ? g.animateSlide(b, function() {
      g.postSlide(d);
    }) : g.postSlide(d)) : !1 === g.options.infinite && !0 === g.options.centerMode && (0 > a || a > g.slideCount - g.options.slidesToScroll) ? !1 === g.options.fade && (d = g.currentSlide, !0 !== c ? g.animateSlide(b, function() {
      g.postSlide(d);
    }) : g.postSlide(d)) : (!0 === g.options.autoplay && clearInterval(g.autoPlayTimer), e = 0 > d ? 0 !== g.slideCount % g.options.slidesToScroll ? g.slideCount - g.slideCount % g.options.slidesToScroll : g.slideCount + d : d >= g.slideCount ? 0 !== g.slideCount % g.options.slidesToScroll ? 0 : d - g.slideCount : d, g.animating = !0, g.$slider.trigger("beforeChange", [g, g.currentSlide, e]), a = g.currentSlide, g.currentSlide = e, g.setSlideClasses(g.currentSlide), g.updateDots(), g.updateArrows(), 
    !0 === g.options.fade ? (!0 !== c ? (g.fadeSlideOut(a), g.fadeSlide(e, function() {
      g.postSlide(e);
    })) : g.postSlide(e), g.animateHeight()) : !0 !== c ? g.animateSlide(f, function() {
      g.postSlide(e);
    }) : g.postSlide(e)));
  };
  e.prototype.startLoad = function() {
    !0 === this.options.arrows && this.slideCount > this.options.slidesToShow && (this.$prevArrow.hide(), this.$nextArrow.hide());
    !0 === this.options.dots && this.slideCount > this.options.slidesToShow && this.$dots.hide();
    this.$slider.addClass("slick-loading");
  };
  e.prototype.swipeDirection = function() {
    var a;
    a = Math.round(180 * Math.atan2(this.touchObject.startY - this.touchObject.curY, this.touchObject.startX - this.touchObject.curX) / Math.PI);
    0 > a && (a = 360 - Math.abs(a));
    return 45 >= a && 0 <= a || 360 >= a && 315 <= a ? !1 === this.options.rtl ? "left" : "right" : 135 <= a && 225 >= a ? !1 === this.options.rtl ? "right" : "left" : !0 === this.options.verticalSwiping ? 35 <= a && 135 >= a ? "left" : "right" : "vertical";
  };
  e.prototype.swipeEnd = function(a) {
    this.dragging = !1;
    this.shouldClick = 10 < this.touchObject.swipeLength ? !1 : !0;
    if (void 0 === this.touchObject.curX) {
      return !1;
    }
    !0 === this.touchObject.edgeHit && this.$slider.trigger("edge", [this, this.swipeDirection()]);
    if (this.touchObject.swipeLength >= this.touchObject.minSwipe) {
      switch(this.swipeDirection()) {
        case "left":
          a = this.options.swipeToSlide ? this.checkNavigable(this.currentSlide + this.getSlideCount()) : this.currentSlide + this.getSlideCount();
          this.slideHandler(a);
          this.currentDirection = 0;
          this.touchObject = {};
          this.$slider.trigger("swipe", [this, "left"]);
          break;
        case "right":
          a = this.options.swipeToSlide ? this.checkNavigable(this.currentSlide - this.getSlideCount()) : this.currentSlide - this.getSlideCount(), this.slideHandler(a), this.currentDirection = 1, this.touchObject = {}, this.$slider.trigger("swipe", [this, "right"]);
      }
    } else {
      this.touchObject.startX !== this.touchObject.curX && (this.slideHandler(this.currentSlide), this.touchObject = {});
    }
  };
  e.prototype.swipeHandler = function(a) {
    if (!(!1 === this.options.swipe || "ontouchend" in document && !1 === this.options.swipe || !1 === this.options.draggable && -1 !== a.type.indexOf("mouse"))) {
      switch(this.touchObject.fingerCount = a.originalEvent && void 0 !== a.originalEvent.touches ? a.originalEvent.touches.length : 1, this.touchObject.minSwipe = this.listWidth / this.options.touchThreshold, !0 === this.options.verticalSwiping && (this.touchObject.minSwipe = this.listHeight / this.options.touchThreshold), a.data.action) {
        case "start":
          this.swipeStart(a);
          break;
        case "move":
          this.swipeMove(a);
          break;
        case "end":
          this.swipeEnd(a);
      }
    }
  };
  e.prototype.swipeMove = function(a) {
    var b, c, d;
    c = void 0 !== a.originalEvent ? a.originalEvent.touches : null;
    if (!this.dragging || c && 1 !== c.length) {
      return !1;
    }
    b = this.getLeft(this.currentSlide);
    this.touchObject.curX = void 0 !== c ? c[0].pageX : a.clientX;
    this.touchObject.curY = void 0 !== c ? c[0].pageY : a.clientY;
    this.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(this.touchObject.curX - this.touchObject.startX, 2)));
    !0 === this.options.verticalSwiping && (this.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(this.touchObject.curY - this.touchObject.startY, 2))));
    c = this.swipeDirection();
    if ("vertical" !== c) {
      void 0 !== a.originalEvent && 4 < this.touchObject.swipeLength && a.preventDefault();
      d = (!1 === this.options.rtl ? 1 : -1) * (this.touchObject.curX > this.touchObject.startX ? 1 : -1);
      !0 === this.options.verticalSwiping && (d = this.touchObject.curY > this.touchObject.startY ? 1 : -1);
      a = this.touchObject.swipeLength;
      this.touchObject.edgeHit = !1;
      !1 === this.options.infinite && (0 === this.currentSlide && "right" === c || this.currentSlide >= this.getDotCount() && "left" === c) && (a = this.touchObject.swipeLength * this.options.edgeFriction, this.touchObject.edgeHit = !0);
      this.swipeLeft = !1 === this.options.vertical ? b + a * d : b + a * (this.$list.height() / this.listWidth) * d;
      !0 === this.options.verticalSwiping && (this.swipeLeft = b + a * d);
      if (!0 === this.options.fade || !1 === this.options.touchMove) {
        return !1;
      }
      if (!0 === this.animating) {
        return this.swipeLeft = null, !1;
      }
      this.setCSS(this.swipeLeft);
    }
  };
  e.prototype.swipeStart = function(a) {
    var b;
    if (1 !== this.touchObject.fingerCount || this.slideCount <= this.options.slidesToShow) {
      return this.touchObject = {}, !1;
    }
    void 0 !== a.originalEvent && void 0 !== a.originalEvent.touches && (b = a.originalEvent.touches[0]);
    this.touchObject.startX = this.touchObject.curX = void 0 !== b ? b.pageX : a.clientX;
    this.touchObject.startY = this.touchObject.curY = void 0 !== b ? b.pageY : a.clientY;
    this.dragging = !0;
  };
  e.prototype.unfilterSlides = e.prototype.slickUnfilter = function() {
    null !== this.$slidesCache && (this.unload(), this.$slideTrack.children(this.options.slide).detach(), this.$slidesCache.appendTo(this.$slideTrack), this.reinit());
  };
  e.prototype.unload = function() {
    f(".slick-cloned", this.$slider).remove();
    this.$dots && this.$dots.remove();
    this.$prevArrow && this.htmlExpr.test(this.options.prevArrow) && this.$prevArrow.remove();
    this.$nextArrow && this.htmlExpr.test(this.options.nextArrow) && this.$nextArrow.remove();
    this.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "");
  };
  e.prototype.unslick = function(a) {
    this.$slider.trigger("unslick", [this, a]);
    this.destroy();
  };
  e.prototype.updateArrows = function() {
    !0 === this.options.arrows && this.slideCount > this.options.slidesToShow && !this.options.infinite && (this.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), this.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), 0 === this.currentSlide ? (this.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), this.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : this.currentSlide >= this.slideCount - this.options.slidesToShow && 
    !1 === this.options.centerMode ? (this.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), this.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : this.currentSlide >= this.slideCount - 1 && !0 === this.options.centerMode && (this.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), this.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")));
  };
  e.prototype.updateDots = function() {
    null !== this.$dots && (this.$dots.find("li").removeClass("slick-active").attr("aria-hidden", "true"), this.$dots.find("li").eq(Math.floor(this.currentSlide / this.options.slidesToScroll)).addClass("slick-active").attr("aria-hidden", "false"));
  };
  e.prototype.visibility = function() {
    document[this.hidden] ? (this.paused = !0, this.autoPlayClear()) : !0 === this.options.autoplay && (this.paused = !1, this.autoPlay());
  };
  e.prototype.initADA = function() {
    var a = this;
    a.$slides.add(a.$slideTrack.find(".slick-cloned")).attr({"aria-hidden":"true", tabindex:"-1"}).find("a, input, button, select").attr({tabindex:"-1"});
    a.$slideTrack.attr("role", "listbox");
    a.$slides.not(a.$slideTrack.find(".slick-cloned")).each(function(b) {
      f(this).attr({role:"option", "aria-describedby":"slick-slide" + a.instanceUid + b + ""});
    });
    null !== a.$dots && a.$dots.attr("role", "tablist").find("li").each(function(b) {
      f(this).attr({role:"presentation", "aria-selected":"false", "aria-controls":"navigation" + a.instanceUid + b + "", id:"slick-slide" + a.instanceUid + b + ""});
    }).first().attr("aria-selected", "true").end().find("button").attr("role", "button").end().closest("div").attr("role", "toolbar");
    a.activateADA();
  };
  e.prototype.activateADA = function() {
    var a = this.$slider.find("*").is(":focus");
    this.$slideTrack.find(".slick-active").attr({"aria-hidden":"false", tabindex:"0"}).find("a, input, button, select").attr({tabindex:"0"});
    a && this.$slideTrack.find(".slick-active").focus();
  };
  e.prototype.focusHandler = function() {
    var a = this;
    a.$slider.on("focus.slick blur.slick", "*", function(b) {
      b.stopImmediatePropagation();
      var c = f(this);
      setTimeout(function() {
        a.isPlay && (c.is(":focus") ? (a.autoPlayClear(), a.paused = !0) : (a.paused = !1, a.autoPlay()));
      }, 0);
    });
  };
  f.fn.slick = function() {
    var a = arguments[0], b = Array.prototype.slice.call(arguments, 1), c = this.length, d = 0, f;
    for (d;d < c;d++) {
      if ("object" == typeof a || "undefined" == typeof a ? this[d].slick = new e(this[d], a) : f = this[d].slick[a].apply(this[d].slick, b), "undefined" != typeof f) {
        return f;
      }
    }
    return this;
  };
});
