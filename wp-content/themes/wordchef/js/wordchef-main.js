jQuery(document).ready(function() {
  0 <= jQuery(window).scrollTop() - jQuery("#masthead").height() ? jQuery(".scroll-to-top").fadeIn() : jQuery(".scroll-to-top").fadeOut();
  jQuery(window).scroll(function() {
    0 <= jQuery(window).scrollTop() - jQuery("#masthead").height() ? jQuery(".scroll-to-top").fadeIn() : jQuery(".scroll-to-top").fadeOut();
  });
  jQuery(".scroll-to-top a").on("click", function(a) {
    a.preventDefault();
    jQuery("html,body").animate({scrollTop:0}, 500);
  });
  jQuery("#masthead .search-toggle").on("click", function() {
    jQuery(this).toggleClass("search-toggle-active");
    jQuery(this).hasClass("search-toggle-active") ? (jQuery(".search-toggle-container").animate({width:300}, {duration:225, easing:"swing"}), jQuery(".search-toggle-container .s").focus()) : jQuery(".search-toggle-container").animate({width:0}, {duration:225, easing:"linear"});
    return !1;
  });
  jQuery(".menu-item-has-children > a").after('<span class="toggle-sub-menu"></span>');
  jQuery("#site-navigation .toggle-sub-menu").on("click", function() {
    jQuery(this).toggleClass("toggle-sub-menu-active");
    jQuery(this).next().slideToggle("fast");
  });
  jQuery(".widget_nav_menu .toggle-sub-menu").on("click", function() {
    jQuery(this).toggleClass("toggle-sub-menu-active");
    jQuery(this).next().slideToggle("fast");
  });
  1200 >= jQuery("body").width() && jQuery("#site-navigation .menu").addClass("mobile-menu");
  jQuery(window).on("resize", function() {
    1200 >= jQuery("body").width() && jQuery("#site-navigation .menu").addClass("mobile-menu");
  });
  jQuery(window).on("resize", function() {
    1200 < jQuery("body").width() && (jQuery("#site-navigation .sub-menu").removeAttr("style"), jQuery("#site-navigation .toggle-sub-menu-active").removeClass("toggle-sub-menu-active"), jQuery("#site-navigation .menu").removeClass("mobile-menu"));
  });
  jQuery(window).scroll(function() {
    0 < jQuery(window).scrollTop() ? (jQuery("#site-navigation.fixed-nav").addClass("nav-shadow"), jQuery("#site-navigation.fixed-nav .sub-menu").addClass("nav-shadow-sub"), jQuery("#site-navigation.fixed-nav ~ .search-toggle-container").addClass("nav-shadow-sub")) : (jQuery("#site-navigation.fixed-nav").removeClass("nav-shadow"), jQuery("#site-navigation.fixed-nav .sub-menu").removeClass("nav-shadow-sub"), jQuery("#site-navigation.fixed-nav ~ .search-toggle-container").removeClass("nav-shadow-sub"));
  });
  for (var b = jQuery(".type-post.format-video").length, a = 0;a < b;a++) {
    var c = jQuery(".type-post.format-video").eq(a).attr("class").split(" ")[0];
    jQuery("." + c + " .entry-content iframe").first().unwrap().remove();
  }
  b = jQuery(".format-video .entry-content iframe").length;
  for (a = 0;a < b;a++) {
    jQuery(".type-post.format-video iframe").eq(a).attr("src", jQuery(".type-post.format-video iframe").eq(a).attr("src"));
  }
  b = jQuery(".type-post.format-audio").length;
  for (a = 0;a < b;a++) {
    c = jQuery(".type-post.format-audio").eq(a).attr("class").split(" ")[0], jQuery("." + c + " .entry-content iframe").first().unwrap().remove();
  }
  b = jQuery(".type-post.format-audio iframe").length;
  for (a = 0;a < b;a++) {
    jQuery(".type-post.format-audio iframe").eq(a).attr("src", jQuery(".type-post.format-audio iframe").eq(a).attr("src"));
  }
  jQuery.fn.fitVids && jQuery(".hentry").fitVids();
});
jQuery(window).load(function() {
  jQuery("#loading-screen").fadeOut("medium");
});
