(function ($) { //keeping it drupal js friendly

    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	$(document).ready(function(){ 	
	
	   
	    
var $element = $('#ajax_trigger');
        var base = $element.attr('id');
        var href = $element.attr('href');
       var element_settings = {
          url: href,
          event: 'click',
          progress: {
            type: 'throbber'
          }
        };
Drupal.ajax[base] = new Drupal.ajax(base, $element, element_settings);







// AJAX command to update and display cart block
Drupal.loadNodeScene = function(ajax, response, status) {
   	console.log(response.data);
 }


// Add our commands to the Drupal commands collection.
Drupal.ajax.prototype.commands.load_node_scene = Drupal.loadNodeScene;

/**
 * Add our commands to the Drupal commands collection.
 */
 
	    
	    
var layerTimers = new Array()
var layerDelays = new Array()
var animateOn = true
var activeUrl
//var activePanel
var activeIndex
var activeContainer
var activeDefault
var activeInner
var activeSceneId
var dirLevels
var loader
var soundReady = false
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
$.fn.writeHash = function(){						
	location.hash = $(this).attr("href")	
}

/********************
* Function
* formats a hash value from a url
********************/
function formatHash(){
	if (location.hash == undefined || location.hash == "" || location.hash == "#/"){
		if(location.pathname == undefined || location.pathname == "" || location.pathname == "/"){
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
 * Parse hash and determine layout and scene displays
********************/
var parseHash = function(){		
	activeUrl = window.location.hash.replace(/#\//,"")
	dirLevels = activeUrl.replace(/\?.*$/,"").split("\/") //remove any query and split the path
	var activePanel = $('a[href=/' + dirLevels[0] + ']').parent('div.panel')		
	console.log(activePanel)	
	activeIndex = $(activePanel).index()
	activeContainer = $('.container',activePanel)
	activeContent = $('.panelContent',activePanel)
	activeScene = 
	console.log(dirLevels[0])
	console.log(activeIndex)
	if (dirLevels[0] != "" && activeIndex === -1){
		showAlert("Sorry for the mix-up, but you have tried to access content which is restricted or does not exist.")
		return
	}
	hideAlert()
	if(activeIndex === -1){
		activeIndex = 1
		//loadScene(activeIndex)		
	} else {

		$('#panelContainer').activatePanel(activePanel,activeIndex)
	}
	_gaq.push(['_trackEvent', 'Urls', 'Display', activeUrl]) // Log event for Google analytics event tracking	
}


function getActiveIndex(id) {
	return($('#' + id).index())
}

/********************
* A main-interface panel has been clicked, so initiate some processes
********************/
$.fn.activatePanel = function(activePanel,index){	
	$('.container').stop()//Stop any current function affecting a .container class 
	//$('customScrollBox').removeClass('loading')	
	if(!($(activePanel).hasClass("active"))) {				
		$("#panelContainer .panel").removeClass('active').addClass('inactive')
		$(activePanel).removeClass('inactive').addClass('active')	
			activateContent(activePanel)
			soundReady = true		
			
		
		if(soundReady == true){soundManager.play('panelSound')}
		var mode = "start"
		console.log(activePanel.attr('id'))
		//loadScene(index,mode)			
		readOutPosition()
	} else {		
		activateContent(activePanel)		
	}		
}

/********************
* Stop scene animation functions and clear timers
*********************/
function resetScene(){
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
function calcScale(val,scale){	
  var v = val				
	//console.log(pattern)
	//var p = pattern
	var c = v.replace(/(px|%)/,'')	
	var u = RegExp.$1
	console.log(u)					
	if (u == 'px') {
	  val = (c * scale) + 'px'
	}	
	console.log('Original value: ' + c + '     New value: ' + val)			
	return val			
}	

/********************
* Function
********************/ 
var loadScene = function(panel,mode,sceneId){		

	var sceneId = sceneData[panel][0];
	if(activeSceneId !== sceneId || (activeSceneId == sceneId && mode == "resume")){		
		activeSceneId = sceneId;
		$("#screen").show(0, function(){
			resetScene();
		})
		$("#sceneAssets").empty()	
		$("#readOut").empty()
		$("#scene .scene-layer").remove()
		var outer = document.getElementById('outer'); 
		var outerWidth = outer.clientWidth; 
		var outerHeight = outer.clientHeight; 
		var boxSize 
		var scale = 1
		if (outerHeight > 2500 || outerWidth > 2500) {
			boxSize = 2500
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
		//console.log(scale)		

		matteImg = sceneData[panel][1] != '' ? sceneData[panel][1] : ''
		//readOut(matteImg)
		if(matteImg != ''){
			$("#matteImg").attr("src", matteImg)
			$("#matte").css('display','block')
		} else {
			$("#matte").css('display','none')
		}	
		if(matteImg != ''){
			$("#sceneAssets").append('<img src="' + matteImg + '" />')
		}		
		
		layers = sceneData[panel][2]			
		if (layers != null) {			
			var count = 0
			layers.forEach(function(){	
					
				var imgSrc = layers[count][0]  != '' ? layers[count][0] : ''		
				var bgRepeat = layers[count][5] != '' ? layers[count][5] : 'no-repeat'	
							
				if (imgSrc != '') {
					var layerImg = $('<img />', {
							src : imgSrc					
					})
					$("#sceneAssets").append(layerImg)
				}				

				count++
			}) // forEach								
		} // if layers
			
			
			
		var assetsLoaded = 0
		//readOut("Intializing scene: " + sceneTitle)
		//readOut("Loading " + assetCount + " assets for '" + sceneTitle + "'' scene" )		
		var assetCount = $("#sceneAssets > img").size()
		$("#sceneAssets > img").each(function(){			
			var layerImg = $(this)
			layerImg.load(function(){			
					assetsLoaded++		
					readOut("Asset " + assetsLoaded + " of " + assetCount + " loaded.")	
					if(assetsLoaded == assetCount) {
						readOut("Scene asset loading complete.")						
						animateScene(panel,scale,mode)				
						$("#screen").delay(300).fadeOut(300)
							
					}
			})
		}) // end each	
				
	
	} //end check for change in activeSceneId
}

/********************
* Function
********************/ 
function animateScene(panel,scale,mode){		

		layers = sceneData[panel][2]			
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
				var imgHeight					
	
				//scale coordinates to make responsive
				
				startX = calcScale(startX,scale)
				endX = calcScale(endX,scale)
				startY = calcScale(startY,scale)
				endY = calcScale(endY,scale)				
				
				if (imgSrc != ''){
					if (bgRepeat == 'no-repeat') {
						var elem = $('<img />', {
								'class' : 'scene-layer',
								src : imgSrc,
								left : startX,
								top : startY						
						})	
						$("#scene").append(elem)	
						elem.height(elem.height()*scale)
						elem.animateElement(count,startX,startY,endX,endY,duration,loop,interval,delay)			
					} else {			
						layerImg = $('#sceneAssets img[src=' + imgSrc + ']')
							imgHeight = layerImg.height();
							imgHeight = imgHeight*scale;
							console.log(imgHeight);
							var elem = $('<div/>', {
									'class' : 'scene-layer'
							})			
							elem.css({
									'background-image' : 'url('+imgSrc+')',
									'background-repeat' : bgRepeat,
									'background-size' : 'auto ' + imgHeight + 'px'
							})	
							$("#scene").append(elem)	
							$(elem).animateBg(count,startX,startY,endX,endY,duration,loop,interval,delay)	
					}
				} // if imgSrc
				count++		
				})	// end forEach						
			} // if layers				
		
	
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
			

$
/********************
* Scene element animation handler
********************/
$.fn.animateElement =  function(count,sx,sy,ex,ey,d,l,int,delay){ 
		var self = $(this)		
		var loop = l
		var looper = null
		var loopCounter = 0		
		self.css({left:sx,top:sy})	
		readOut('EndX: ' + ex) 
		//if (loopCounter == 0){var wait = delay}else{var wait=0}
		if(animateOn == true){ //global var check
 			if(loop == true){
 				loopCounter++
 				readOut("animateBg instance:" + loopCounter) 
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
 				loopCounter++    	
 				readOut("animateBg instance:" + loopCounter)       
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
   	
}	

/********************
 Handle the content display, either default or dynamic
********************/
var activateContent = function(activePanel){
	var activeContainer = $('.container', activePanel)
	$('.content .dynamic').removeClass('loading')
	$('.content .static', activeContainer).stop().css('opacity','0').hide(0)
	$('.content .dynamic',activeContainer).stop().css('opacity','0').hide(0)
	var loaded = false
	var hasQuery = location.href.match(/\?.*$/)
	//var scrollBox = $('.customScrollBox', activePanel)
		
	if(dirLevels.length<2 && hasQuery == null){
		$('.content .static', activeContainer).show(0).css('opacity','1')
		activeContainer.displayContent('static')
	}
	else 
	{		
		clearTimeout(contentTimer)
		contentTimer = setTimeout(function(){
			//$(scrollBox).addClass('loading')
		},500)
		
		loadUrl = window.location.hash.replace(/#/,"ajax")			
		Drupal.ajax['ajax_trigger'].options.url = loadUrl;
  	$('#ajax_trigger').trigger('click');			
  		
  

/**
		$('.content .dynamic',activeContainer).empty().load(loadUrl, function(response, status, xhr){
			var int
			//if($(scrollBox).hasClass('loading')){int=1200}else{int=0}
			
			setTimeout(function(){
				clearTimeout(contentTimer)
				//$(scrollBox).removeClass('loading')	
			
				if (status == "error") {
    				var msg = "Sorry but there seems to have been an error: "
    				showAlert(msg + xhr.status + " " + xhr.statusText);
  				}else{
  					$('.content .dynamic',activeContainer).show(0).css('opacity','1')
					activeContainer.displayContent('dynamic')
				}

			},int)
		})										
*/
	}//end if dirLevels
}//end activateContent


function ajaxxx () {

  var loadUrl = window.location.hash.replace(/#/,"ajax")
  var $element = $('#ajax_trigger');
  var base = $element.attr('id');  
  var href = $element.attr('href');
  var element_settings = {
          url: href,
          event: 'click',
          progress: {
            type: 'throbber'
          }
        };
        
  Drupal.ajax[base] = new Drupal.ajax(base, $element, element_settings);
  
 

  $element.unbind(Drupal.ajax[base].event);

  $element.bind(Drupal.ajax[base].event, function (event) {
      return Drupal.ajax[base].eventResponse($element, event);
  });
  
}


/**
 * Time to show the panel's default content or the newly loaded content.
 **/
$.fn.displayContent = function(div){
	var activeContainer = $(this)
	//scrollContentPadding()
	//prebuildSlideMenu()
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



$(activeContainer).fadeTo(1000,1)	 
		

}


/**
 * Stop all this looping animation and clear timeouts
 **/
 
$("a#loop-terminate").click(function(){
	if(!($(this).hasClass("disabled"))) {
		$(this).addClass("disabled").text("Enable")		
		resetScene()
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
		//$("body").css({fontSize: "20px"})
	} else {
		//$("body").css({fontSize: "12px"})
	}

//readOut(myWidth + " " + myHeight)
//scrollContentPadding()


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

				//$('#top').animate({height:"6%"},1200,'easeOutExpo')
				//$('#header').animate({top:"0"},1200,'easeOutExpo')	
				//$('#bottom').animate({height:"6%"},1200,'easeOutExpo',function(){

					$('#panelMenu').fadeTo('3000',1)
					$('#bottom-inner-one').fadeTo('3000',1)
					$('#bottom-inner-two').fadeTo('3000',1)

				//})	

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


// Turn incoming, non-hash urls into hashes
formatHash();

adjustResize();

$("a.ajax").live("click",function(){	
	$(this).writeHash();
	return false;
})

$("#main-menu li a").live("click",function(event){	
    event.preventDefault();
    $(this).writeHash(); 
})

   


/**
 *
 * Adjust layout dimensions when browser window is resized
 *
*/ 
window.onresize = function(){
	if(resizeTimer != null) {
		clearTimeout(resizeTimer);
	}
	resizeTimer = setTimeout(function(){	
	  resetScene();
		adjustResize();
		//prebuildSlideMenu();
		$(window).trigger('hashchange');	
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
	//$('#panelContainer .panel').css({width: panelInactiveWidth})
	$(window).bind('hashchange',parseHash)		
	intro()
})







});

})(jQuery);