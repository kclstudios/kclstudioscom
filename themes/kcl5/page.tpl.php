
<div id="outer">
	<div id="siteName">
		<?php if($is_front) : ?><h1 id="sloganText"><?php print $site_slogan ?></h1><?php endif; ?>
		<span><?php print $site_name ?></span>
	</div>

	
	<div id="scene-container">
		<div id="scene">
			<div id="matte"><img id="matteImg" src="" /></div>
		</div><!-- /#scene -->
	</div><!-- /#scenesContainer -->

	<div id="screen"><div id="screen-frame"></div></div>


	<?php print render($page['content']); ?>


  <div id="alert-screen"></div>
  <div id="readOut"><div class="inner"></div></div>




<div id="bottom">
	<div id="bottom-inner-one">					
		<div id="animateControl"><a href="/" id="loop-terminate">Disable</a> <span class="label">Animation</span></div>			
		<!-- <div id="audioControl"><span class="label">Audio:</span><ul class="graphic"><li><a href="/kclstudioscom/sites/all/themes/kcl4/audio/kclstudios.mp3" class="sm2_button">Mime Type</a></li></ul></div> -->
	</div>
	<div id="bottom-inner-two">		
		<div id="copyText"><span>&copy; KCL Studios <?php print(date("Y")); ?> &nbsp; - &nbsp; Powered by <a href="http://www.drupal.org" target="_blank">Drupal</a></span></div>		
	</div>
</div>


	<?php /*print $messages;*/ ?>

<div id="top">

	<a id="site-logo" class="ajax" href="<?php print $front_page; ?>" ><img src="/sites/all/themes/kcl5/img/kcl-logo.png" /></a>

  <a id="main-menu-mobile-toggle">
    <span class="icon action-show">m</span><span class="icon action-hide">-</span><span class="text">Menu</span>
  </a>

	<a id="contact-toggle">
	  <span class="icon action-show">q</span><span class="icon action-hide">-</span><span class="text">Contact</span>
	</a>
	
</div><!-- end top -->



  <div id="main-menu">  
    <?php
      $main_menu = menu_tree_output(menu_tree_all_data('main-menu'));
      print drupal_render($main_menu); 
    ?>   
  </div>



	<div id="status"><noscript><div id="noscript">Please enable Javascript to access KCLStudios.com.</div></noscript></div>		


</div><!-- /outer -->


<a id="ajax_trigger" href="/ajax/"></a>

<div id="sceneAssets"></div><!-- /sceneAssets -->


<script type="text/javascript">
<!-- configure Soundmanager2 -->
soundManager.debugMode = true; // disable or enable debug output
soundManager.preferFlash = true; // use HTML5 audio for MP3/MP4, if available
soundManager.useFlashBlock = false;
soundManager.url = 'sites/all/themes/kcl5/js/soundmanager/swf/'; // path to directory containing SM2 SWF

// optional: enable MPEG-4/AAC support (requires flash 9)
soundManager.flashVersion = 9;
soundManager.useMovieStar = true;

// ----

soundManager.onready(function() {
  // soundManager.createSound() etc. may now be called
    var panelSound = soundManager.createSound({
      id: 'panelSound',
      url: 'sites/all/themes/kcl5/audio/activatePanel.mp3',
      onload: function() { console.log('sound loaded!', this); }
      // other options here..
    });
    var loadSound = soundManager.createSound({
      id: 'loadSound',
      url: 'sites/all/themes/kcl5/audio/pageLoad.mp3',
      onload: function() { console.log('sound loaded!', this); }
      // other options here..
    });
});
</script>