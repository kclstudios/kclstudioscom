/**
 * @file
 * This script handles the initialization and behavior of the top-level items found in the 
 * block display of the main-menu and is used in conjunction with classes added in template.php
 * 
 */

(function ($) { // jQuery <3 Drupal

	function layoutMainMenu(i) {		
		if($('#block-menu-block-1').css('display') == 'block') {
			$("#block-menu-block-1 .menu-block-wrapper > ul.menu > li.has-menu-board").each(function(){
			var ul = $(this).children('ul.menu');		
			var ulHeight = ul.outerHeight(true);			
			var mb = $(this).children('div.menu-board');
			var mbHeight = mb.outerHeight(true);
			var newHeight = ulHeight >= mbHeight ? ulHeight : mbHeight;			
			mb.css('height', newHeight+'px');
			ul.css('height', newHeight+'px');
			ul.find('ul.menu').css('height', newHeight+'px');			
			});
		}
	}		
	
  //	Fire on window.load so that we get image dims
	$(window).load(function() {
		layoutMainMenu();
  });	
  
	$(document).ready(function() {		
		
		// Rebuild menu on resize with time buffer
		window.onresize = function(){
			var resizeTimer;
			if(resizeTimer != null) {
				clearTimeout(resizeTimer);
			}
			resizeTimer = setTimeout(function(){		
				layoutMainMenu();
			}, 500);
		}
		
		var mainMenuTimer = null;

		// Handler for top level main-menu items
		$("#main-menu div.li-expand").click(function(event) {		    
		    var $activeItem = $(this).parent();  
		    $activeItem.siblings().each(function(){
		        if($(this).hasClass('on')) {
		          $("#main-menu").addClass('has-li-on');
		        }
		        $(this).removeClass('on timer');				
		    })	
		    $activeItem.toggleClass('on');		    
		    clearTimeout(mainMenuTimer);
		    mainMenuTimer = null;				
		    event.stopPropagation();
		});
			
			$("ul").delegate("li.on","mouseenter", function() {			    
			    //console.log('Mousenter li.on');
			    clearTimeout(mainMenuTimer);
			    mainMenuTimer = null;		
			    $(this).removeClass('timer');
			});  
			
			$("ul").delegate("li.on","mouseleave", function() {
			    
					//console.log('Mouseleave li.on');
			   // clearTimeout(mainMenuTimer);
			   // mainMenuTimer = null;	
			  //  $(this).addClass('timer');		  		
			  //   mainMenuTimer = setTimeout(function(){	
			         //console.log('mainMenuTimer set on mouseleave menu-li.on.');
			  //       $("#main-menu ul.menu li.on").removeClass('on timer');
			  //       $("#main-menu").removeClass('has-li-on');
				//   }, 1000);			   	
			    
			});  			


			
		$("html").click(function() {
	$("#main-menu li.on").removeClass('on'); 
	});		

	  
	  // Mobile Toggle
	  
	  	$("#main-menu-mobile-toggle").click(function(e) {
	  	    e.preventDefault();
	  	    $(this).toggleClass('on');
	  	    $("#main-menu").toggleClass('on');   
	  	  }); 	
		
	});  	

})(jQuery); // End jQuery <3 Drupal