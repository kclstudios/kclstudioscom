
<div id="outer">
	<div id="siteName">
		<?php if($is_front) : ?><h1 id="sloganText"><?php print $site_slogan ?></h1><?php endif; ?>
		<span><?php print $site_name ?></span>
	</div>
	<?php if(!$is_front) : ?>
	<div id="pageContent"><?php print render($page['content']); ?></div>
	<?php endif; ?>
	<div id="scenesContainer">
		<div id="scene">
			<div id="matte"><img id="matteImg" src="" /></div>
		</div><!-- /#scene -->
	</div><!-- /#scenesContainer -->

	<!--<div id="screen"></div>-->

	<div id="readOut"></div>

<?php if($is_front): ?>
  <?php kcl5_main_menu_top(); ?>
	
<?php
//load the view by name
//$view = 'featured_panels';
//output the view
//print views_embed_view($view,'block');
?>

<?php endif; ?>

  <div id="alertScreen"></div>

  <div id="contactTab" class="tab">
	  <div class="inner">
			<div class="tabContent content clearfix">
				
			<a class="tabClose" href="/">[close]</a>
				<div class="left clearfix">
	<?php print render($page['tab1']); ?>
				</div>
				<div class="right clearfix">
<p>For general questions, project inquiries or proposal requests, feel free to contact KCL Studios using this form.</p>

				</div>
				</div><!-- /tabContent -->
	  </div>			
	</div>




















<div id="bottom">
	<div id="bottom-inner-one">	
			
		<!-- <div id="cssControl"><span class="label">Screen Display:</span><a id="def" href="/">Dark</a> | <a id="css2" href="/">Light</a></div> -->			
		<div id="animateControl"><span class="label">Animation:</span><a href="/" id="loop-terminate">Disable</a></div>			
		<!-- <div id="audioControl"><span class="label">Audio:</span><ul class="graphic"><li><a href="/kclstudioscom/sites/all/themes/kcl4/audio/kclstudios.mp3" class="sm2_button">Mime Type</a></li></ul></div> -->

	</div><!-- /footerLeft -->	
	<div id="bottom-inner-two">	
	
		<div id="copyText"><span>&copy; KCL Studios <?php print(date("Y")); ?> &nbsp; - &nbsp; Powered by <a href="http://www.drupal.org" target="_blank">Drupal</a></span></div>
		
	</div><!-- /footerRight -->		
</div><!-- /bottom -->





<div id="top">

	<a id="site-logo" class="ajax" href="<?php print $front_page; ?>" ><img src="/sites/all/themes/kcl5/img/kcl-logo.png" /></a>

  <div id="main-menu">
    <a id="main-menu-mobile-toggle"><div class="icon">m</div><span>Menu</span></a>
    <?php
      $main_menu = menu_tree_output(menu_tree_all_data('main-menu'));
      print drupal_render($main_menu); 
    ?>
   
  </div>


	<div id="status"><noscript><div id="noscript">Please enable Javascript to access KCLStudios.com.</div></noscript></div>		
	<ul id="panelMenu">
	  <li><a class="tabControl" href="#contactTab">Contact +</a></li>
	</ul>
	
</div><!-- end top -->






</div><!-- /outer -->


<a id="ajax_trigger" href="/ajax/"></a>

<div id="sceneAssets"></div><!-- /sceneAssets -->

<!-- configure SM2 for your use -->
<script type="text/javascript">

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