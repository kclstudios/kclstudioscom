

<!-- layout -->
<div id="outer">
<div id="matte"><img id="matte-img" src="/pixel-trans.gif" /></div>
<div id="background"></div>
<div id="midground"></div>
<div id="foreground"></div>

<div id="screen"></div>

<div id="readOut">
<noscript><p>To access KCL Studios you will need to enable Javascript for your browser and reload. Thanks.</p></noscript>
</div>

<div id="panelContainer">
<?php
//load the view by name
$view = 'featured_panels';
//output the view
print views_embed_view($view,'block');
?>
</div>



<div class="tabContainer">	
	<div class="tab">
		<div class="trans"></div>
		<div class="op">
		   <div class="customScrollBox">
     			<div class="container">
			<div class="tabContent clearfix">
				<div class="left">
	<?php print render($page['footer']); ?>
				</div>
				<div class="right">
<p>For general questions, project inquiries or proposal requests, feel free to contact KCL Studios using this form or via the following methods:</p>

<p><h3>Email:</h3> <a href="mailto:kcl@kclstudios.com">kcl@kclstudios.com</a></p>

<p><h3>Skype:</h3> kclstudios</p>				
				</div>

			</div>
		</div>
	<div class="dragger_container"><div class="dragger"></div></div>	
</div>
</div>

	</div>
</div>

<div id="headerShadow"><div class="effectsDiv"></div></div>
<div id="footerShadow"><div class="effectsDiv"></div></div>




<div id="bottom">
	<div id="footer">
<div id="animateControl"><a href="#" id="loop-terminate">Disable Animation</a></div>	
<!-- <div id="audioControl"><ul class="graphic"><li><a href="/kclstudioscom/sites/all/themes/kcl3/audio/kclstudios.mp3" class="sm2_button">Mime Type</a></li></ul></div> -->
	<div id="copyText">
		<span>&copy; 2012 KCL Studios - All Rights Reserved</span>
	</div>
</div><!-- /footer -->
</div><!-- /bottom -->



<div id="top">
<div id="header">
<a href="<?php print $front_page; ?>">
<div id="logoPanel">
<img id="logo" src="/sites/all/themes/kcl3/img/kcl-logo.png" />
<span id="siteName"><?php print $site_name ?></span>
<span id="sloganText">Web Design and Development</span>
</div>

<div id="logoOverlay"></div>
<div id="status" class="loading"></div>
</a>
	<ul id="panelMenu">
	<li><a href="#">Contact +</a></li>
	</ul>

</div><!-- end header -->
</div><!-- end top -->



</div>








</div>
<!-- /layout -->

<div id="sceneAssets">
</div><!-- end scene -->
