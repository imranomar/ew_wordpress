/*
 Custom Js goes here....
*/

$(document).ready(function(){
    $(window).scroll(function(){
		if ($(window).scrollTop() >= 50) {
		   $('body').addClass('sticky-header');
		}
		else {
		   $('body').removeClass('sticky-header');
		}
	}); 
});