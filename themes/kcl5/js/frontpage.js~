(function ($) { //keeping it drupal js friendly

	$(document).ready(function(){ 	
	
var layerTimers = new Array()
var layerDelays = new Array()
var animateOn = true
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

/********************
* Function
********************/
function showAlert(msg){	
	$("#alertScreen").empty().append("<div>" + msg + "</div>").css({left:0})
}

/********************
* Function
********************/
function hideAlert(msg){	
	$("#alertScreen").css({left:"-100%"})
}

/********************
* Function
********************/
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

/********************
* Function
********************/
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

/********************
* Stop scene animation functions and clear timers
********************/
$.fn.writeHash = function(){						
	location.hash = $(this).attr("href")	
}

/********************
* A main-interface panel has been clicked, so initiate some processes
********************/
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

/********************
* Stop scene animation functions and clear timers
*********************/
function resetScenes(){
	$("#scene .scene-layer").each(function(){
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

/********************
* Define our scene area
*********************/
function matteDim() {	
	var outer = document.getElementById('outer'); 
	var outerWidth = outer.clientWidth; 
	var outerHeight = outer.clientHeight; 
	var boxSize
	var scale
	if (outerHeight > 2500 || outerWidth > 2500) {
		boxSize = 2500
		scale = 1		
	} else {
		if (outerHeight < outerWidth) {
			boxSize = outerWidth
		} else {
			boxSize = outerHeight
		}
		scale = outerWidth/2500
	}
	//$('#scenesContainer').height(boxSize+'px')
	//$('#scenesContainer').width(boxSize+'px')
	//console.log('Outer Height: ' + outerHeight + '  Width: ' + outerWidth)
	//console.log('Scenes Height: ' + $('#scenesContainer').height() + '  Width: ' + $('#scenesContainer').width())
	var hoffset = (outerWidth - boxSize)/2
	var voffset = (outerHeight - boxSize)/2
	//console.log(hoffset)
	$('#scenesContainer').css({left:hoffset,top:voffset})
	return(scale)	
}

/********************
* Function
********************/ 
var loadScene = function(panel,mode){		
	
	var outer = document.getElementById('outer'); 
	var outerWidth = outer.clientWidth; 
	var outerHeight = outer.clientHeight; 
	var boxSize
	var scale
	if (outerHeight > 2500 || outerWidth > 2500) {
		boxSize = 2500
		scale = 1		
	} else {
		if (outerHeight < outerWidth) {
			boxSize = outerWidth
		} else {
			boxSize = outerHeight
		}
		scale = outerWidth/2500
	}
	$('#scenesContainer').height(boxSize+'px')
	$('#scenesContainer').width(boxSize+'px')
	//console.log('Outer Height: ' + outerHeight + '  Width: ' + outerWidth)
	//console.log('Scenes Height: ' + $('#scenesContainer').height() + '  Width: ' + $('#scenesContainer').width())
	var hoffset = (outerWidth - boxSize)/2
	var voffset = (outerHeight - boxSize)/2
	//console.log(hoffset)
	$('#scenesContainer').css({left:hoffset,top:voffset})	
	var ratio = scale
	//console.log(ratio)
	
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

			$("#scene .scene-layer").remove()

			if(matteImg != ''){
			$("#matteImg").attr("src", matteImg)
			$("#matte").css('display','block')
		} else {
			$("#matte").css('display','none')
		}	
		

		if (layers != null) {
			var count = 0
			layers.forEach(function(){	
				var imgSrc = layers[count][0]  != '' ? layers[count][0] : ''
				var startX = layers[count][1] != '' ? layers[count][1] : '0px'
				var endX = layers[count][2] != '' ? layers[count][2] : '0px'		
				var startY = layers[count][3] != '' ? layers[count][3] : '0px'
				var endY = layers[count][4] != '' ? layers[count][4] : '0px'
				var duration = layers[count][6] != '' ? layers[count][6] : '0'
				var loop = layers[count][7] != '' ? layers[count][7] : '0'
				var interval = layers[count][8] != '' ? layers[count][8] : '0'
				var delay = layers[count][9] != '' ? layers[count][9] : '0'		
				var bgRepeat = layers[count][5] != '' ? layers[count][5] : 'no-repeat'		
				if (bgRepeat == 'no-repeat') {
					var elem = $('<img>', {
						'class' : 'scene-layer',
						src : imgSrc						
					})	
					$("#scene").append(elem)	
					elem.height(elem.height()*ratio)
					elem.animateElement(count,startX,startY,endX,endY,duration,loop,interval,delay)			
				} else {
					var elem = $('<div/>', {
						'class' : 'scene-layer'
					})	
					elem.css({
						'background-image' : 'url('+imgSrc+')',
						'background-repeat' : bgRepeat,
						'background-size' : (ratio*100) + '%'
					})	
					$("#scene").append(elem)	
					$(elem).animateBg(count,startX,startY,endX,endY,duration,loop,interval,delay)			
				}				
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

/********************
* Write output to front end 
********************/
var readOut = function(output){	
	$("#readOut").append("<div>" + output + "</div>")
}

/********************
* Move readOut display away from active content panel
********************/
var readOutPosition = function(){	
	if(activeIndex > 0){ var xPos = (14 * (activeIndex - 1)) + "%" } else {var xPos = (100 - 14) + "%"}
	$("#readOut").css('left',xPos)
}

/********************
* Write strings one character at a time
********************/
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
				
/********************
* Scene element animation handler
********************/
$.fn.animateElement =  function(count,sx,sy,ex,ey,d,l,int,delay){ 
		var self = $(this)		
		var loop = l
		var looper = null
		var loopCounter = 0		
		self.css({left:sx,top:sy})	
	
		//if (loopCounter == 0){var wait = delay}else{var wait=0}
		if(animateOn == true){ //global var check
 			if(loop == true){
				looper =  function(){
					layerTimers[count] = setTimeout(function(){
						self.animateElement(count,sx,sy,ex,ey,d,l,int,delay)
					}, int)									
				}
			} 
			layerDelays[count] = setTimeout(function(){			//Here's the actual animation function to be called				
				self.animate({left:ex,top:ey},eval(d),'linear',looper)				
			}, delay)			
		} 		
   	loopCounter++    	
    readOut("animateElement instance:" + loopCounter)       
}	


/********************
* Scene background animation handler
********************/
$.fn.animateBg =  function(count,sx,sy,ex,ey,d,l,int,delay){ 
		var self = $(this)		
		var loop = l
		var looper = null
		var loopCounter = 0		
		var startPos = sx + " " + sy
		var endPos = ex + " " + ey		
		self.css('background-position', startPos)		
		//if (loopCounter == 0){var wait = delay}else{var wait=0}
		var wait = delay 	 
		if(animateOn == true){ //global var check
 			if(loop == true){
				looper =  function(){
					layerTimers[count] = setTimeout(function(){
						self.animateBg(count,sx,sy,ex,ey,d,l,int,delay)
					}, int)									
				}
			} 
			layerDelays[count] = setTimeout(function(){			//Here's the actual animation function to be called					
				$(self).animate({'background-position': endPos},eval(d),'linear',looper)			
			}, wait)			
		} 		
   	loopCounter++    	
    readOut("animateBg instance:" + loopCounter)       
}	

/********************
 Handle the content display, either default or dynamic
********************/
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
		animateOn = false
	} else {
		$(this).removeClass("disabled").text("Disable")	
		animateOn = true
		loadScene(activeIndex,"resume")
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
	$('#panelContainer').removeClass('ghost')
	if($(this).hasClass('on')){			
		$(this).removeClass('on')
	} else {
		$('a.tabControl').removeClass('on')			
		$(this).addClass('on')
		$('#panelContainer').addClass('ghost')
	}	
	$('a.tabControl').each(function() {
		var tabId = $(this).attr('href')
		var offText = $(this).text().replace(/.$/,"+")
		var onText = $(this).text().replace(/.$/,"-")
		if($(this).hasClass('on')){
			$(tabId).fadeIn('1500').addClass('show')
			$(this).text(onText)
		}else{
			$(tabId).fadeOut(0).removeClass('show')
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
			if(imgLoaded == imgCount && !($('#panelContainer').hasClass('ghost'))){ //check to see if containing element hasLayout before rebuilding
				
				setTimeout(function(){
					$(smDiv).fadeTo(1000,1)	
				},500)
				//readOut("Building slidemenu" + smId)
				//readOut($(activeContainer).css('width'))		
				slideMenu.build(smId,250,10,10)
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

//readOut(myWidth + " " + myHeight)
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
$('#cssControl a#css2').trigger('click');


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