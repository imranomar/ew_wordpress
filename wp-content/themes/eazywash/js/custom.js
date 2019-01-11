/*
 Custom Js goes here....
*/

jQuery(function() {
  jQuery('a[href*="\\#"]').click(function(event) {
    var at_offset = jQuery.attr(this, "href");
    var at_navbar = jQuery(".nav");

    at_offset = at_offset.replace("/", "");

    var id = at_offset.substring(1, at_offset.length);
    if (!document.getElementById(id)) {
      return;
    }
    if (jQuery(at_offset).offset()) {
      var offset_height = at_navbar.height() * 2 + 30;
      if (at_navbar.closest("body").hasClass("sticky-header")) {
        offset_height = (offset_height - 30) / 2;
      }
      jQuery("html, body").animate(
        {
          scrollTop: jQuery(at_offset).offset().top - offset_height
        },
        1000
      );
      event.preventDefault();
    }
  });

  jQuery('a[href="#search"]').on("click", function(event) {
    event.preventDefault();
    jQuery("#search").addClass("open");
    jQuery('#search > form > input[type="search"]').focus();

    setTimeout(function() {
      //calls click event after a certain time
      jQuery("body").addClass("overflowrm");
    }, 350);
  });

  jQuery("#search, #search button.close").on("click keyup", function(event) {
    if (event.target.className == "close" || event.keyCode == 27) {
      jQuery(this).removeClass("open");
      jQuery("body").removeClass("overflowrm");
    }
  });

  /*jQuery("form").submit(function(event) {
	  event.preventDefault();
	  return false;
	});*/
});

jQuery(document).ready(function() {
  if (jQuery(window).width() < 992) {
    jQuery("body").removeClass("inner-page");
  }

  jQuery(window).scroll(function() {
    if (jQuery(window).scrollTop() >= 50) {
      jQuery("body").addClass("sticky-header");
    } else {
      jQuery("body").removeClass("sticky-header");
    }
  });
});
