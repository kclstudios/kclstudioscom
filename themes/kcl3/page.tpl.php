

<div id="outer">
	<div id="siteName">
		<?php if($is_front) : ?><h1 id="sloganText"><?php print $site_slogan ?></h1><?php endif; ?>
		<span><?php print $site_name ?></span>
	</div>
	<div id="pageContent"><?php print render($page['content']); ?></div>
	<div id="scenesContainer">
		<div id="scene">
			<div id="matte"><img id="matteImg" src="" /></div>
		</div><!-- /#scene -->
	</div><!-- /#scenesContainer -->

	<div id="screen"></div>

	<div id="readOut"></div>

<?php if($is_front): ?>
	<div id="panelContainer">
<?php
//load the view by name
$view = 'featured_panels';
//output the view
print views_embed_view($view,'block');
?>
	</div>
<?php endif; ?>

<div id="alertScreen"><div id="alertInner"></div></div>

	<div id="contactTab" class="tab">
			<img class="tabBack" src="/sites/all/themes/kcl3/img/contact-array.jpg" />	
			<div class="tabContent clearfix">
			<a class="tabClose" href="/">[close]</a>
				<div class="left clearfix">
	<?php print render($page['tab1']); ?>
				</div>
				<div class="right clearfix">
<p>For general questions, project inquiries or proposal requests, feel free to contact KCL Studios using this form or via the following methods:</p>

<p><h3>Email:</h3> <a href="mailto:kcl@kclstudios.com">kcl@kclstudios.com</a></p>

<p><h3>Skype:</h3> kclstudios</p>				
				</div>
				</div><!-- /tabContent -->


	</div>










<div id="headerShadow"></div>
<div id="footerShadow"></div>


<div id="bottom"></div><!-- /bottom -->


<div id="top"></div><!-- end top -->


<div id="footer">
	<div id="footerLeft">	
			
		<div id="cssControl"><span class="label">Color Scheme:</span><a id="css2" href="/">Light</a> | <a id="def" href="/">Dark</a></div>			
		<div id="animateControl"><span class="label">Animation:</span><a href="/" id="loop-terminate">Disable</a></div>			
		<!-- <div id="audioControl"><span class="label">Audio:</span><ul class="graphic"><li><a href="/kclstudioscom/sites/all/themes/kcl3/audio/kclstudios.mp3" class="sm2_button">Mime Type</a></li></ul></div> -->

	</div><!-- /footerLeft -->	
	<div id="footerRight">		
		<div id="copyText"><span>&copy; KCL Studios 2012 &nbsp; - &nbsp; Powered by <a href="http://www.drupal.org" target="_blank">Drupal</a></span></div>
	</div><!-- /footerRight -->		
</div><!-- /footer -->


<div id="header">
	<div id="headerInner">
<a href="<?php print $front_page; ?>">
<img id="logo" src="/sites/all/themes/kcl3/img/kcl-logo.png" />
</a>
		<div id="status"><noscript><div id="noscript">Please enable Javascript to access KCLStudios.com.</div></noscript></div>
		
		<ul id="panelMenu">
			<li><a class="tabControl" href="#contactTab">Contact KCL Studios +</a></li>
		</ul>
	</div><!-- /headerInner -->
</div><!-- /header -->


</div><!-- /outer -->

<div id="sceneAssets"></div><!-- /sceneAssets -->

<!-- configure SM2 for your use -->
<script type="text/javascript">

soundManager.debugMode = true; // disable or enable debug output
soundManager.preferFlash = true; // use HTML5 audio for MP3/MP4, if available
soundManager.useFlashBlock = false;
soundManager.url = 'sites/all/themes/kcl3/js/soundmanager/swf/'; // path to directory containing SM2 SWF

// optional: enable MPEG-4/AAC support (requires flash 9)
soundManager.flashVersion = 9;
soundManager.useMovieStar = true;

// ----

soundManager.onready(function() {
  // soundManager.createSound() etc. may now be called
    var panelSound = soundManager.createSound({
      id: 'panelSound',
      url: 'sites/all/themes/kcl3/audio/activatePanel.mp3',
      onload: function() { console.log('sound loaded!', this); }
      // other options here..
    });
    var loadSound = soundManager.createSound({
      id: 'loadSound',
      url: 'sites/all/themes/kcl3/audio/pageLoad.mp3',
      onload: function() { console.log('sound loaded!', this); }
      // other options here..
    });
});
</script>