/*
 Custom Js goes here....
*/

$(function() {
	$('a[href="#search"]').on("click", function(event) {
	  event.preventDefault();
	  $("#search").addClass("open");
	  $('#search > form > input[type="search"]').focus();
	 

	  setTimeout(function() {   //calls click event after a certain time
		$("body").addClass("overflowrm");
	}, 350);

	});
 
	$("#search, #search button.close").on("click keyup", function(event) {
	  if (
		 
		 event.target.className == "close" ||
		 event.keyCode == 27
	  ) {
		 $(this).removeClass("open");
		 $("body").removeClass("overflowrm");
	  }
	});
 
	/*$("form").submit(function(event) {
	  event.preventDefault();
	  return false;
	});*/

 });


$(document).ready(function(){
	if ($(window).width() < 992) {
		$("body").removeClass("inner-page");
	}
	
    $(window).scroll(function(){
		if ($(window).scrollTop() >= 50) {
		   $('body').addClass('sticky-header');
		}
		else {
		   $('body').removeClass('sticky-header');
		}
	}); 
});