
(function ($) { //keeping it drupal js friendly

	$(document).ready(function(){ 	
	
var backGround = $("#background")

var midGround = $("#midground")

var foreGround = $("#foreground")

var bgLooper

var fgLooper

var mgLooper

var activeUrl

var activePanel

var activeIndex

var activeContainer

var activeDefault

var activeInner

var activeSceneId

var dirLevels

var loader

var panelActiveWidth = "44%" //((100/$('div.panel').length) * 200) + "%"

var panelInactiveWidth = "14%" //(((100 - panelActiveWidth)/($('div.panel').length) - 2))) * 100) + "%"

var myWidth // Calculated browser display width

var myHeight //Calculated browser display height





var parseHash = function(){

		

		activeUrl = window.location.hash.replace(/#\//,"")
		dirLevels = activeUrl.split("\/")
		activePanel = $('a[href=#/' + dirLevels[0] + ']').parents('div.panel')			
		activeIndex = $(activePanel).index()
		activeContainer = $(activePanel).find(".container")
		activeDefault = $(activePanel).find(".contentDefault")
		activeInner = $(activePanel).find(".contentInner")			
		$('#panelContainer').activatePanel()

}





$.fn.activatePanel = function(){
	
	$(".dragger_container").css({display:"none"})
	$(activeContainer).fadeOut(0)
	
	
	if(!($(activePanel).hasClass("active"))) {	

		$("#panelContainer .panel").addClass('inactive')

			var mode = "start"

			loadScene(activeIndex,mode)
		
			readOutPosition()
		
			$("#panelContainer div.active").removeClass('active').animate({width:panelInactiveWidth},300,'linear')

		
			$(activePanel).removeClass('inactive').addClass('active').animate({width:panelActiveWidth},300,'linear', function(){	
			
				
				displayContent()	
						
			
		})


	} else {
		
				displayContent()		

	}
		
}










 
var loadScene = function(panel,mode){	
		
	sceneId = sceneData[panel][0]

		if(activeSceneId !== sceneId || (activeSceneId == sceneId && mode == "resume")){	

				
		backGround.stop()
		clearTimeout(bgLooper)
		midGround.stop()
		clearTimeout(mgLooper)
		foreGround.stop()
		clearTimeout(fgLooper)	
				
			
		matteImg = sceneData[panel][1] != '' ? sceneData[panel][1] : ''
		bgImg = sceneData[panel][2]  != '' ? sceneData[panel][2] : ''
		bgStartX = sceneData[panel][3] != '' ? sceneData[panel][3] : '0px'
		bgEndX = sceneData[panel][4] != '' ? sceneData[panel][4] : '0px'		
		bgStartY = sceneData[panel][5] != '' ? sceneData[panel][5] : '0px'
		bgEndY = sceneData[panel][6] != '' ? sceneData[panel][6] : '0px'
		bgRepeat = sceneData[panel][7] != '' ? sceneData[panel][7] : 'no-repeat'		
		bgDuration = sceneData[panel][8] != '' ? sceneData[panel][8] : '0'
		bgLoop = sceneData[panel][9] != '' ? sceneData[panel][9] : '0'
		bgInterval = sceneData[panel][10] != '' ? sceneData[panel][10] : '0'

		mgImg = sceneData[panel][11]
		mgStartX = sceneData[panel][12] != '' ? sceneData[panel][12] : '0px'
		mgEndX = sceneData[panel][13] != '' ? sceneData[panel][13] : '0px'		
		mgStartY = sceneData[panel][14] != '' ? sceneData[panel][14] : '0px'
		mgEndY = sceneData[panel][15] != '' ? sceneData[panel][15] : '0px'
		mgRepeat = sceneData[panel][16]	!= '' ? sceneData[panel][16] : 'no-repeat'			
		mgDuration = sceneData[panel][17] != '' ? sceneData[panel][17] : '0'
		mgLoop = sceneData[panel][18] != '' ? sceneData[panel][18] : '0'
		mgInterval = sceneData[panel][19] != '' ? sceneData[panel][19] : '0'
						
		fgImg = sceneData[panel][20]
		fgStartX = sceneData[panel][21] != '' ? sceneData[panel][21] : '0px'
		fgEndX = sceneData[panel][22] != '' ? sceneData[panel][22] : '0px'
		fgStartY = sceneData[panel][23] != '' ? sceneData[panel][23] : '0px'
		fgEndY = sceneData[panel][24] != '' ? sceneData[panel][24] : '0px'				
		fgRepeat = sceneData[panel][25] != '' ? sceneData[panel][25] : 'no-repeat'
		fgDuration = sceneData[panel][26] != '' ? sceneData[panel][26] : '0'		
		fgLoop = sceneData[panel][27] != '' ? sceneData[panel][27] : '0'
		fgInterval = sceneData[panel][28] != '' ? sceneData[panel][28] : '0'

		sceneTitle = sceneData[panel][29]

		activeSceneId = sceneId

		$('#screen').show(0).fadeIn(0)

		$("#readOut").empty()
		
		readOut("Loading " + sceneTitle)

		$("#sceneAssets").empty()

		if(matteImg != ''){
			$("#sceneAssets").append('<img id="matteImg" src="' + matteImg + '" />')			
			$("#matte-img").attr("src", matteImg)
			$("#matte").css('display','block')
		} else {
			$("#matte").css('display','none')
		}			

		if(bgImg != ''){
			$("#sceneAssets").append('<img id="bgImg" src="' + bgImg + '" />')
			$("#background").css('background', 'url("' + bgImg + '") ' + bgRepeat + ' ' + bgStartX + ' ' + bgStartY)	
			
		}else{
			$("#background").css('background','none')			
		} 

		if(mgImg != ''){
			$("#sceneAssets").append('<img id="mgImg" src="' + mgImg + '" />')
			$("#midground").css('background', 'url("' + mgImg + '") ' + mgRepeat + ' ' + mgStartX + ' ' + mgStartY)					
			
		}else{
			$("#midground").css('background','none')
		} 

		if(fgImg != ''){
			$("#sceneAssets").append('<img id="fgImg" src="' + fgImg + '" />')	
			$("#foreground").css('background', 'url("' + fgImg + '") ' + fgRepeat + ' ' + fgStartX + ' ' + fgStartY)
			
		}else{
			$("#foreground").css('background','none')
		}	



		var assetCount = $("#sceneAssets > img").size()

		var assetsLoaded = 0

		//readOut("Loading assets...")

		$("#sceneAssets > img").each(function(){			
			
			$(this).load(function(){
			
			assetsLoaded++

			readOut("Asset " + assetsLoaded + " of " + assetCount + " loaded.")
			

				if (assetsLoaded == assetCount) {
					if (!($("a#loop-terminate").hasClass("disabled"))) {
						if(bgDuration > 0 && bgImg != ''){ $("#background").stop(true).parallaxBack(bgImg,bgStartX,bgStartY,bgEndX,bgEndY,bgDuration,bgLoop) }
						if(mgDuration > 0 && mgImg != ''){ $("#midground").stop(true).parallaxMid(mgImg,mgStartX,mgStartY,mgEndX,mgEndY,mgDuration,mgLoop,mgInterval) }
						if(fgDuration > 0 && fgImg != ''){ $("#foreground").stop(true).parallaxFore(fgImg,fgStartX,fgStartY,fgEndX,fgEndY,fgDuration,fgLoop,fgInterval) }					
					}	
					$('#screen').fadeOut(800).hide(0)
				}

			})
			
		}) 

		} //end check for change in activeSceneId

}


     



var readOut = function(output){	
	$("#readOut").append("<div>" + output + "</div>")
}

var readOutPosition = function(){
	//var myArray = new Array("bottom","top")
	//var myArrayIndex = Math.round(Math.random())
	//var yPos = myArray[myArrayIndex]
	if(activeIndex > 0){ var xPos = (14 * (activeIndex - 1)) + "%" } else {var xPos = (100 - 14) + "%"}
	//$("#readOut").css('top','','bottom','').css('left',xPos).css(yPos,'0px')
	$("#readOut").css('top','0px').css('left',xPos)
}
	




/**
 *
 Write strings one character at a time
 *
 */
 $.fn.writeText = function(content) {
        var contentArray = content.split("")
        var current = 0
        var elem = this
		

		var loopsiloop = function(){

			        	
        	setTimeout(function() {            	
                elem.text(elem.text() + contentArray[current++])
                if(current < contentArray.length) {
	        	   	loopsiloop()
				}
            	
        	}, 25)

        	
    	}

    	loopsiloop()
}
    


/**
 *
 Background animation handler
 *
 */
$.fn.parallaxBack =  function(img,sx,sy,ex,ey,d,l,int){  	

		var bg = img
		var loop = l
		var startPosition = sx + " " + sy
		var endPosition = ex + " " + ey
 	 
 	  	var bgstartPos = {
      		'background-position' : startPosition
    	}

 	 	var bgendPos = {
      		'background-position' : endPosition
    	}    	

		if(loop == 1){
			var self = $(this)
			clearTimeout(bgLooper) 
			bgLooper =   function(){

					setTimeout(function(){

					self.parallaxBack(img,sx,sy,ex,ey,d,l,int)
					//readOut("Background loop completed.")	

					}, int)				
				}

		} else { 

			bgLooper = null
		}

		
    	$(this).css(bgstartPos).animate(bgendPos, eval(d), 'linear', bgLooper)      	
    	
      
}	


/**
 *
 Midground animation handler
 *
 */
$.fn.parallaxMid =  function(img,sx,sy,ex,ey,d,l,int){   

		var mg = img
		var loop = l
		var startPosition = sx + " " + sy
		var endPosition = ex + " " + ey
 	 
 	  	var mgstartPos = {
      		'background-position' : startPosition
    	}

 	 	var mgendPos = {
      		'background-position' : endPosition
    	}    	

		if(loop == 1){
			var self = $(this)
			clearTimeout(mgLooper) 
			mgLooper =   function(){

					setTimeout(function(){

					self.parallaxMid(img,sx,sy,ex,ey,d,l,int)
					//readOut("Midground loop completed.")	

					}, int)				
				}

		} else { 

			mgLooper = null
		}

    	$(this).css(mgstartPos).animate(mgendPos, eval(d),'linear', mgLooper)    	     		
   

}	

	
/**
 *
 Foreground animation handler
 *
 */
$.fn.parallaxFore = function(img,sx,sy,ex,ey,d,l,int){ 
		
		var fg = img
		var loop = l
		var startPosition = sx + " " + sy
		var endPosition = ex + " " + ey
 	 
 	  	var startPos = {
      		'background-position' : startPosition
    	}

 	 	var endPos = {
      		'background-position' : endPosition
    	}

 		if(loop == 1){ 
			var self = $(this)
			clearTimeout(fgLooper)
			fgLooper =  function(){

					setTimeout(function(){

					self.parallaxFore(img,sx,sy,ex,ey,d,l,int)
					//readOut("Foreground loop completed.")	

					}, int)				
				}

		} else { 

			fgLooper = null
		}

     	$(this).css(startPos).animate(endPos, eval(d),'linear', fgLooper) 
   
  	  		
}	
				

$.fn.showLoading = function(int){
	var self = $(this)
	loader = setTimeout(function(){

			self.addClass("loading")
				
	}, int)				
}

$.fn.clearLoading = function(){
	var self = $(this)
	self.removeClass("loading")
	clearTimeout(loader)			
}

/**
 *
 Handle the content display, either default or dynamic
 *
 */
var displayContent = function(){


	if(dirLevels[1] == undefined || dirLevels[1] == ""){	

		$(activeInner).addClass("inactive")
		$(activeDefault).removeClass("inactive")				
		$(activeContainer).fadeIn(900)
		$(activePanel).mCustomScrollbar("vertical",400,"easeOutCirc",1.5,"auto")		
				
					
	}else{		
				
		loadUrl = window.location.hash.replace(/#/,"ajax")
		
		var scrollBox = $(activePanel).find('.op .customScrollBox')
		$(scrollBox).showLoading(500)

				
		$(activeDefault).addClass("inactive")
		$(activeInner).empty().removeClass("inactive").load(loadUrl, function(){

			$(scrollBox).clearLoading()		
			$(activePanel).mCustomScrollbar("vertical",400,"easeOutCirc",1.5,"auto")
			$(".breadcrumb a").addHash()
			$(activeContainer).fadeIn(900)
			Shadowbox.clearCache();Shadowbox.setup();//Re-initialize Shadowbox to include any newly loaded images			

		})
													
		
		

		
						
	} //endif

}//end displayContent




$.fn.addHash = function(){
	
$(this).attr('href', function()
   { 
      return "#" + $(this).attr('href')
   })

}



		
$(window).bind('hashchange',parseHash)

$(".panelControl a").addHash()

$("a.ajax").addHash()


/**
 * Stop all this looping animation and such
 **/
$("a#loop-terminate").click(function(){

	if(!($(this).hasClass("disabled"))) {
		$(this).addClass("disabled").text("Enable Animation")		
		foreGround.stop()
		clearTimeout(fgLooper)
		midGround.stop()
		clearTimeout(mgLooper)
		backGround.stop()
		clearTimeout(bgLooper)
	} else {
		$(this).removeClass("disabled").text("Disable Animation")
		var mode = "resume"
		loadScene(activeIndex,mode)
	}

	return false
})


$("#panelMenu li a").click(function(){

	$("#panelMenu li a").each(function() {
		var thisText = $(this).text().replace(/.$/,"+")
		$(this).text(thisText)
	})
	$("div.tabContainer").fadeOut(100)


	if(!($(this).hasClass("on"))){
		var tabIndex = $(this).parent().index()
		var innerText = $(this).text().replace(/.$/,"-")
		$(this).text(innerText)
		$("#panelMenu li a").removeClass("on")
		$(this).addClass("on")
		$("div.tabContainer").eq(tabIndex).delay(200).fadeIn(200)
		//readOut("Indexed tab is " + tabIndex)
		//readOut("Inner text is " + innerText)
	} else {
		$(this).removeClass("on")
	}
	return false
})

var prebuildSlideMenu = function(width){
	var smWidth = Math.floor(((width/5) * 2) * 0.86)
	$("#projectSlideMenu").css({width: smWidth})
	slideMenu.build('projectSlideMenu',200,10,10)

}

/**
 *
 * Resize text depending on window size
 *
*/ 

var adjustResize = function(){



if( typeof( window.innerWidth ) == 'number' ) { 

//Non-IE 

myWidth = window.innerWidth;
myHeight = window.innerHeight; 

} else if( document.documentElement && 

( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) { 

//IE 6+ in 'standards compliant mode' 

myWidth = document.documentElement.clientWidth; 
myHeight = document.documentElement.clientHeight; 

} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) { 

//IE 4 compatible 

myWidth = document.body.clientWidth; 
myHeight = document.body.clientHeight; 

} 	
	
	if(myHeight > 800){
		$("body").css({fontSize: "16px"})
	} else {
		$("body").css({fontSize: "12px"})
	}

prebuildSlideMenu(myWidth)

}


adjustResize()
window.onresize = adjustResize





$(window).load(function(){


	$('#top').css({height:"50%"})
	$('#bottom').css({height:"50%"})
	$('.dragger_container').hide()
	$('#panelContainer .panel').css({width: panelInactiveWidth})

	

    

	if (location.hash == undefined || location.hash == ""){
		
		location.hash = $("#mcs_container_28 div.panelControl a").attr('href')

	}

	$("#status").removeClass('loading').writeText("Site Initialization Complete")
	$("#status").fadeOut(3000)		







//prebuildSlideMenu()  






	var intro = function(){

		setTimeout(function(){
			$(window).trigger('hashchange')
			
			$('#top').animate({height:"6%"},2000,'easeOutQuint')	
			$('#bottom').animate({height:"6%"},2000,'easeOutQuint',function(){

						
				$("#logoOverlay").fadeIn('4500')
				$("#panelMenu").fadeTo('3000',1)
				$("#copyText").fadeTo('3000',1)
				$("#animateControl").fadeTo('3000',1)
				

			})	
		},3500)
	}

	intro()

})





});

})(jQuery);