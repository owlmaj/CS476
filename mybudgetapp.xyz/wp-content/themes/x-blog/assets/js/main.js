(function ($) {
	"use strict";
    
    //document ready function
    jQuery(document).ready(function($){
		var menu      =  $('#baby-menu');
        menu.slicknav({
        	'allowParentLinks': true,
        	'nestedParentLinks': true
        });

        //search form show hide 
		$('.search-icon i').click(function() {
		  $('.header-search-form').toggleClass('show');
		});
		$('.slicknav_icon').click(function() {
		  $('.search-icon i').toggleClass('hide');
		});
		$('.site-branding, .site-content,.home-feature-slider').click(function() {
		  $('.header-search-form').removeClass('show');
		});
		 $("#baby-menu").xblogAccessibleDropDown();

        }); // end document ready

    	    $.fn.xblogAccessibleDropDown = function () {
			    var el = $(this);

			    /* Make dropdown menus keyboard accessible */

			    $("a", el).focus(function() {
			        $(this).parents("li").addClass("hover");
			    }).blur(function() {
			        $(this).parents("li").removeClass("hover");
			    });
			}

}(jQuery));	