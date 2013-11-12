<?php
// $Id: node.tpl.php,v 1.5 2010/12/15 12:00:00 goba Exp $
?>

<?php  if ($teaser) : ?>
	<?php if ($sticky) : ?>
	<?php if ($node->field_back_image[0]) : $thisImg = imagecache_create_url('full', $node->field_back_image[0]['filepath']);	?>
		

		
	<?php endif; ?>
		<div class="node-sticky"> 
 
     		<?php print render($content['body']) ?>   
  	          
		</div> 
	<?php else : ?>
		<div class="node-teaser"> 
 
    
     		<h3><a class="innerControl default" href="<?php print $node_url ?>"><?php print $title ?></a></h3>
           			  	
  	  	<?php print render($content['body']) ?>  
  	          
		</div>    		   
	<?php endif; ?>    
<?php else: /*else its a full node view*/ ?>

		<div class="node-full">     
   				
      		
   			<?php if ($node->field_image[0]['view']) : ?>
	
				<img src="<?php print imagecache_create_url('full', $node->field_images[0]['filepath']); ?>" class="imagecache-full" alt="<?php print $title ?>">
	  
				<?php endif; ?>
				
				<?php print render($content['body']) ?>
				
						 	       
					   
		</div>

<?php endif; /*end of full vs teaser check */ ?>
