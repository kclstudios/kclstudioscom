
(function ($) { //keeping it drupal js friendly



	function drawTop(){		
		var containerWidth = document.getElementById("top").offsetWidth;
		var containerHeight = document.getElementById("top").offsetHeight;
		var canvas = document.getElementById("canvas")
		canvas.setAttribute("width",containerWidth)
		canvas.style.width = containerWidth + 'px'
		canvas.setAttribute("height",containerHeight)
		canvas.style.height = containerHeight + 'px'
	
		//Bottom Right

		var x1 = Math.round(containerWidth);  
		var y1 = Math.round(containerHeight); 
		
		//Bottom Right

		var x5 = Math.round(containerWidth);  
		var y5 = Math.round(containerHeight * 0.85); 

		var x6 = Math.round(containerWidth * 0.33);  
		var y6 = Math.round(containerHeight * 0.85); 		

		//Top Right

		var x2 = Math.round(containerWidth * 0.20);  
		var y2 = Math.round(containerHeight * 0); 

		//Top Left

		var x3 = Math.round(containerWidth * 0);  
		var y3 = Math.round(containerHeight * 0); 

		//Bottom Left

		var x4 = Math.round(containerWidth * 0);  
		var y4 = Math.round(containerHeight); 
	
		
		
	var canvas = document.getElementById("canvas");
 	if (canvas.getContext) {
 		//console.log('We are drawing.')
		var ctx = canvas.getContext("2d");
		ctx.moveTo(x1, y1);   // Same starting point as above.  
		ctx.lineTo(x5, y5);    
		ctx.arcTo(x6, y6,x2,y2, 50);     
		ctx.arcTo(x2,y2,x3,y3,50); // upper right arc.            
		ctx.arcTo(x3,y3,x4,y4,7); // upper left arc.
		// Style Me            
		ctx.arcTo(x4, y4,x1,y1,7);    // Continue with a vertical line of the rectangle.  
		//ctx.lineTo(x1, y1);    // Continue with a vertical line of the rectangle.  
		ctx.globalAlpha=0.85;
		ctx.fillStyle = '#6699cc';
		ctx.fill();   
		//ctx.strokeStyle = '#FFFFFF'; 
		//ctx.lineWidth = "1";                                             
		//ctx.stroke();
	}		

	}



	$(document).ready(function(){ 	

		/**
		drawTop()

		var sresizeTimer

		window.onresize = function(){
			if(sresizeTimer != null) {
				clearTimeout(sresizeTimer)
			}
			sresizeTimer = setTimeout( function(){		
				createShape()					
			}, 400);
		}			
   		
**/
	}); //end on-ready

})(jQuery);
