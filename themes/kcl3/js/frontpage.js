
(function ($) { //keeping it drupal js friendly

	$(document).ready(function(){ 	
	
var layerTimers = new Array()
var layerDelays = new Array()
var loopsOn = 1
var activeUrl
var activePanel
var activeIndex
var activeContainer
var activeDefault
var activeInner
var activeSceneId
var dirLevels
var loader
var soundReady = false
var panelActiveWidth = "44%" //((100/$('div.panel').length) * 200) + "%"
var panelInactiveWidth = "14%" //(((100 - panelActiveWidth)/($('div.panel').length) - 2))) * 100) + "%"
var myWidth // Calculated browser display width
var myHeight //Calculated browser display height
var hashReady = false
var resizeTimer
var contentTimer
var introTimer


function showAlert(msg){
	
	$("#alertScreen").empty().append("<div>" + msg + "</div>").css({left:0})

}

function hideAlert(msg){
	
	$("#alertScreen").css({left:"-100%"})

}

function formatHash(){

	if (location.hash == undefined || location.hash == "" || location.hash == "#/"){

		if(location.pathname == undefined || location.pathname == "" || location.pathname == "/"){

			location.hash = $(".panel > a.main").attr('href')
			hashReady = true

		} else {	

			if(location.pathname != "/user"){
			var hashfromPath = "/#" + location.pathname	
			location.href = hashfromPath

			}

		}

	} else {
		
		hashReady = true
	}	
	
}


var parseHash = function(){		
		
		activeUrl = window.location.hash.replace(/#\//,"")
		dirLevels = activeUrl.replace(/\?.*$/,"").split("\/") //remove the query and split the path
		activePanel = $('a[href=/' + dirLevels[0] + ']').parent('div.panel')			
		activeIndex = $(activePanel).index()
		activeContainer = $('.container',activePanel)
		activeContent = $('.panelContent',activePanel)
		
		if (activeIndex === -1){

				showAlert("Sorry for the mix-up, but you have tried to access content which is restricted or does not exist.")
									
		}else{
				hideAlert()
				$('#panelContainer').activatePanel()
				_gaq.push(['_trackEvent', 'Urls', 'Display', activeUrl]) // Log event for Google analytics event tracking
		}



}


$.fn.writeHash = function(){		
				
		location.hash = $(this).attr("href")		

}


$.fn.activatePanel = function(){
	//readOut("Activating panel " + activeIndex)
	
	hideScrollElem()
	$('.container').stop()//Stop any current function affecting a .container class 
	$(activeContainer).fadeTo(0,0)//fadeOut even if no change made to activePanel
	$('customScrollBox').removeClass('loading')
	
	
	if(!($(activePanel).hasClass("active"))) {	
		//if(soundReady == true){soundManager.play('panelSound')}
		$("#panelContainer .panel").addClass('inactive')

			readOutPosition()
			var mode = "start"
			loadScene(activeIndex,mode)			
			
			$("#panelContainer div.active").removeClass('active').animate({width:panelInactiveWidth},500,'easeOutExpo')
		
			$(activePanel).removeClass('inactive').addClass('active').animate({width:panelActiveWidth},500,'easeOutExpo', function(){				
				
				prepContent()
				//soundReady = true						
			
			})


	} else {
		
				prepContent()		

	}
		
}





/**
###### Stop scene animation functions and clear timers
*/
function resetScenes(){
	$("#scene .sceneLayer").each(function(){
		$(this).stop()
		//readOut("Stopped layer" + $(this).attr("id"))

	})
	for (var i = 0; i < layerTimers.length; i++)	{
		clearTimeout(layerTimers[i])
		    	
	}
	for (var i = 0; i < layerDelays.length; i++)	{
		clearTimeout(layerDelays[i])
		    	
	}
}



 
var loadScene = function(panel,mode){	
	
	sceneId = sceneData[panel][0]


		if(activeSceneId !== sceneId || (activeSceneId == sceneId && mode == "resume")){
		
		activeSceneId = sceneId		

		
		$("#sceneAssets").empty()

		matteImg = sceneData[panel][1] != '' ? sceneData[panel][1] : ''

		//readOut(matteImg)
		if(matteImg != ''){
			$("#sceneAssets").append('<img src="' + matteImg + '" />')
		}	
				
		
			
		layers = sceneData[panel][2]
		
			
		if (layers != null) {
			var count = 0
			layers.forEach(function(){
			
			
			
			bgImg = layers[count][0]  != '' ? layers[count][0] : ''
					
			

	
			$("#sceneAssets").append('<img src="' + bgImg + '" />')

		
			
		


			count++
			})//end forEach



		}//endif
		

		
		
		

			

		
	



		var assetCount = $("#sceneAssets > img").size()

		var assetsLoaded = 0

		//readOut("Intializing scene: " + sceneTitle)
		//readOut("Loading " + assetCount + " assets for '" + sceneTitle + "'' scene" )

		$("#sceneAssets > img").each(function(){			
			
			$(this).load(function(){
			
			assetsLoaded++

			//readOut("Asset " + assetsLoaded + " of " + assetCount + " loaded.")			

				if (assetsLoaded == assetCount) {
					resetScenes()
					$("#screen").stop().fadeIn(300,function(){							

			$("#scene div.sceneLayer").remove()

			if(matteImg != ''){
			$("#matteImg").attr("src", matteImg)
			$("#matte").css('display','block')
		} else {
			$("#matte").css('display','none')
		}	


		if (layers != null) {
			var count = 0
			layers.forEach(function(){
			
			$("#scene").append('<div class="sceneLayer" id="layer' + count + '"></div>')
			
			bgImg = layers[count][0]  != '' ? layers[count][0] : ''
			bgStartX = layers[count][1] != '' ? layers[count][1] : '0px'
			bgEndX = layers[count][2] != '' ? layers[count][2] : '0px'		
			bgStartY = layers[count][3] != '' ? layers[count][3] : '0px'
			bgEndY = layers[count][4] != '' ? layers[count][4] : '0px'
			bgRepeat = layers[count][5] != '' ? layers[count][5] : 'no-repeat'		
			bgDuration = layers[count][6] != '' ? layers[count][6] : '0'
			bgLoop = layers[count][7] != '' ? layers[count][7] : '0'
			bgInterval = layers[count][8] != '' ? layers[count][8] : '0'
			bgDelay = layers[count][9] != '' ? layers[count][9] : '0'
					
			$("#scene > #layer" + count).parallaxLayer(count,bgImg,bgRepeat,bgStartX,bgStartY,bgEndX,bgEndY,bgDuration,bgLoop,bgInterval,bgDelay)			
		
			count++

			})//end forEach

		}//endif



					
						$(this).fadeOut(300)

					})//end fadeIn
					
				}//end if assetsLoaded 

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
	$("#readOut").css('left',xPos)
}
	


/**
 *
 Write strings one character at a time
 *
 */
 $.fn.writeText = function(content,callback) {
        var contentArray = content.split("")
        var current = 0
        var elem = this		

		var loopsiloop = function(){
			        	
        	setTimeout(function() {            	
                elem.text(elem.text() + contentArray[current++])
                if(current < contentArray.length) {
	        	   	loopsiloop()
				}
            	else
            	{
            	callback()	
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
$.fn.parallaxLayer =  function(count,img,re,sx,sy,ex,ey,d,l,int,delay){  	

		var bg = img
		var loop = l
		var startPos = sx + " " + sy
		var endPos = ex + " " + ey
		var looper = null
		var self = $(this)	
		var bgRun = 0
		//if (bgRun == 0){var wait = delay}else{var wait=0}
		var wait = delay
			
 	 
 	    self.css('background', 'url("' + img + '") ' + re + ' ' + sx + ' ' + sy)

 		if(loopsOn == 1){ 

 			if(loop == 1){

				looper =  function(){

					layerTimers[count] = setTimeout(function(){

						self.parallaxLayer(count,img,re,sx,sy,ex,ey,d,l,int,delay)					

					}, int)	
								
				}

			} 

			

			layerDelays[count] = setTimeout(function(){
				
					$(self).animate({backgroundPosition: endPos},eval(d),'linear',looper)
								
			}, wait)	
			
		} 		
    	 
    	bgRun++
    	
     	//readOut("parallaxBack instance:" + bgRun)     	
      
}	


/**
 *
 Handle the content display, either default or dynamic
 *
 */
var prepContent = function(){
	$('.content .dynamic').removeClass('loading')
	$('.content .static',activeContainer).stop().css('opacity','0').hide(0)
	$('.content .dynamic',activeContainer).stop().css('opacity','0').hide(0)
	var loaded = false
	var hasQuery = location.href.match(/\?.*$/)
	var scrollBox = $('.customScrollBox',activePanel)
		
	if(dirLevels.length<2 && hasQuery == null){
		$('.content .static',activeContainer).show(0).css('opacity','1')
		displayContent('static')
	}
	else 
	{		
		clearTimeout(contentTimer)
		contentTimer = setTimeout(function(){
			$(scrollBox).addClass('loading')
		},500)
		
		loadUrl = window.location.hash.replace(/#/,"ajax")		
		
		$('.content .dynamic',activeContainer).empty().load(loadUrl, function(response, status, xhr){
			var int
			if($(scrollBox).hasClass('loading')){int=1200}else{int=0}
			
			setTimeout(function(){
				clearTimeout(contentTimer)
				$(scrollBox).removeClass('loading')	
			
				if (status == "error") {
    				var msg = "Sorry but there seems to have been an error: "
    				showAlert(msg + xhr.status + " " + xhr.statusText);
  				}else{
  					$('.content .dynamic',activeContainer).show(0).css('opacity','1')
					displayContent('dynamic')
				}

			},int)

		})		
						
	}//end if dirLevels

}//end prepContent


/**
 * Time to show the panel's default content or the newly loaded content.
 **/
function displayContent(div){
	scrollContentPadding()
	prebuildSlideMenu()
	editPagerLink()
	Shadowbox.clearCache()//Re-initialize Shadowbox to include any newly loaded images
	Shadowbox.setup()

		var imgLoaded = 0
		var contentBox = $(activeContainer).find('.'+div)
		var imgCount = $('img',contentBox).size()		
		
		
		$('img',contentBox).each(function(index,element){

			if(element.complete){

				imgLoaded ++

			} else {

				$(element).bind('load',function(){
					imgLoaded ++										
				})				

			}
	
		})		

		var scrollBuilder = setInterval(function(){			
			if(imgLoaded == imgCount){
				
				
					$(activePanel).mCustomScrollbar("vertical",400,"easeOutCirc",1.05,"fixed","yes","yes",20)	
				
				//readOut("Building slidemenu" + smId)
				//readOut($(activeContainer).css('width'))		
				clearInterval(scrollBuilder)
			}
		},250)


		
	$(activeContainer).fadeTo(1000,1)	 
}


/**
 * Stop all this looping animation and clear timeouts
 **/
$("a#loop-terminate").click(function(){

	if(!($(this).hasClass("disabled"))) {
		$(this).addClass("disabled").text("Enable")		
		resetScenes()
		loopsOn = 0
	} else {
		$(this).removeClass("disabled").text("Disable")
		var mode = "resume"		
		loopsOn = 1
		loadScene(activeIndex,mode)
	}

	return false
})


/**
 *
 * One-offs for closing tabs from a 'close' link within the tab
 *
*/ 

$("a.tabClose").click(function(){	
	var tabId = $(this).parents('.tab').attr('id')
	$('a.tabControl[href^=#'+tabId+']').trigger('click')
	//alert(tabId)
	return false
})

/**
 *
 * Control for tabs via tab menu
 *
*/ 


$('a.tabControl').click(function(){	

	if($(this).hasClass('on')){			
		$(this).removeClass('on')
	} else {
		$('a.tabControl').removeClass('on')			
		$(this).addClass('on')
	}

	
	$('a.tabControl').each(function() {

		var tabId = $(this).attr('href')
		var offText = $(this).text().replace(/.$/,"+")
		var onText = $(this).text().replace(/.$/,"-")

		if($(this).hasClass('on')){
			$(tabId).addClass('show')
			$(this).text(onText)
		}else{
			$(tabId).removeClass('show')
			$(this).text(offText)
		}		


	})

	return false
})



/**
 *
 * Establish dimension for SlideMenu prior to build
 *
*/ 
function prebuildSlideMenu(){
	
	$('.slideMenuContainer').fadeTo(0,0)
	$('ul.slidemenu',activeContainer).each(function(){

		var smId = $(this).attr('id')
		var smDiv = $(this).parents('div.slideMenuContainer')
		var imgCount = $("#" + smId + " li img").size()
		var imgLoaded = 0
		
		$("#" + smId + " li img").each(function(index,element){

			if(element.complete){

				imgLoaded ++
				//readOut("Loaded image " + imgLoaded + " of " + imgCount)

			} else {

				$(element).bind('load',function(){
					imgLoaded ++
					//readOut("Loaded image " + imgLoaded + " of " + imgCount)
					
				})				

			}
	
		})		

		var smBuilder = setInterval(function(){			
			if(imgLoaded == imgCount){
				
				setTimeout(function(){
					$(smDiv).fadeTo(1000,1)	
				},500)
				//readOut("Building slidemenu" + smId)
				//readOut($(activeContainer).css('width'))		
				slideMenu.build(smId,275,10,10)
				clearInterval(smBuilder)
			}
		},250)
		
	})

}



function scrollContentPadding(){
	var buffer = myHeight*0.10 + "px"
	$(".node-full").css({paddingTop:buffer})
	$(".tabContent").css({paddingTop:buffer})
}

/**
 *
 * Resize text depending on window size
 *
*/ 

function adjustResize(){

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
	
	if(myHeight > 770 && myWidth > 1024 ){
		$("body").css({fontSize: "16px"})
	} else {
		$("body").css({fontSize: "12px"})
	}

readOut(myWidth + " " + myHeight)
scrollContentPadding()

}

/**
 *
 * Initial ghosting of scrollbar elements
 *
*/ 

function hideScrollElem(){
	$('.dragger_container').hide(0)
	$(".scrollUpBtn").hide(0)
	$(".scrollDownBtn").hide(0)
}



function editPagerLink(){
	$("ul.pager li a").each(function(){
		var queryRegex = $(this).attr('href').match(/\?.*$/)
		$(this).addClass("ajax").attr('href', function(){ 
			if(queryRegex !== null){
				return "#/weblog" + queryRegex
			} else {
				return "#/weblog"
			}	
		})
	})	
	
}

/**
 *
 * Function to be initiated when document load is complete
 *
*/ 
function intro(){
	var int
	if($('#status').hasClass('loading')){int = 2000}else{int = 0}	
	setTimeout(function(){
		clearTimeout(introTimer)
		$('#status').removeClass('loading')	
		$('#status').empty().writeText('Site Initialization Complete', function(){
			
			$('#status').fadeOut(1000, function(){

				$('#top').animate({height:"6%"},1200,'easeOutExpo')
				$('#header').animate({top:"0"},1200,'easeOutExpo')	
				$('#bottom').animate({height:"6%"},1200,'easeOutExpo',function(){

					$('#panelMenu').fadeTo('3000',1)
					$('#footerLeft').fadeTo('3000',1)
					$('#footerRight').fadeTo('3000',1)

				})	

			})

		})

	},int)

	$(window).trigger('hashchange')	

} // end intro 


/**
 *
 * On-Ready functions...
 *
*/ 



formatHash()
adjustResize()

$("a.ajax").live("click",function(){	
	$(this).writeHash()
	return false
})
$("a.panelControl").bind('mouseenter',function(){	
	$(this).parent('.panel').addClass('hover')	
})
$("a.panelControl").mouseleave(function(){	
	$(this).parent('.panel').removeClass('hover')	
})

/**
 *
 * Toggle between #outer classes to alter color scheme
 *
*/ 
$('#cssControl a').click(function() { 
	$('#cssControl a').removeClass('on')
	$(this).addClass('on')                            
    document.getElementById('outer').className = $(this).attr('id')
    return false
});

/**
 *
 * Default to #outer.css2 for initial setting
 *
*/ 
$('#cssControl a#css2').trigger('click')


/**
 *
 * Adjust layout dimensions when browser window is resized
 *
*/ 
window.onresize = function(){

	if(resizeTimer != null) {
		clearTimeout(resizeTimer)
	}
	resizeTimer = setTimeout(function(){		
		adjustResize()
		prebuildSlideMenu()		
	}, 500);

}


/**
 *
 * Begin timer to determine if loading sequence will be shown. Timer might be cleared in intro() function
 *
*/ 
if (hashReady == true){
	
	clearTimeout(introTimer)	
	introTimer = setTimeout(function(){

		$('#status').addClass("loading")
				
	}, 500)	
		
}


/**
 *
 * All non-dynamic content has been loaded, so let's begin...
 *
*/ 
$(window).load(function(){	
	
	editPagerLink()
	$('#top').css({height:"50%"})
	$('#bottom').css({height:"50%"})
	$('#panelContainer .panel').css({width: panelInactiveWidth})
	$(window).bind('hashchange',parseHash)		
	intro()		

})







});

})(jQuery);