<?php
// $Id: node--page.tpl.php,v 1.5 2012/1/23 12:00:00 goba Exp $
?>

<?php  if ($teaser) : ?>

		<div class="node-teaser"> 

<?php 

      $teaser_img = isset($node->field_teaser_img['und']) ? $node->field_teaser_img['und'] : NULL;  
      $images = isset($node->field_image['und']) ? $node->field_image['und'] : NULL;     
        
      if ($teaser_img) :        
          
          $thumb_path = image_style_url('thumbnail', $node->field_teaser_img['und'][0]['uri']);

          print '<img class="thumbImg" src="'. $thumb_path . '" >';
 
      elseif ($images) :
 
                
          $thumb_path = image_style_url('thumbnail', $node->field_image['und'][0]['uri']);

          print '<img class="thumbImg" src="'. $thumb_path . '" >'; 
        
      endif; 

 ?>              
 
     		<h2><a class="ajax" href="<?php print $node_url ?>"><?php print $title ?></a></h2>
           			  	
  	  	  <?php print render($content['body']) ?>
  	          
		</div>    		   
   
<?php else: /*else its a full node view*/ ?>

		<div class="node-full">     
   				
 
 <?php print theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())); ?>

 <h1><?php print render($title) ?></h1>
      		
<?php 

      $images = isset($node->field_image['und']) ? $node->field_image['und'] : NULL;   
        
      if (count($images)>0) : 

        print '<div class="imageContainer">';

		    $count = 0;

        foreach ($images as $img) :

          $large_path = image_style_url('large', $node->field_image['und'][$count]['uri']);
          $med_path = image_style_url('medium', $node->field_image['und'][$count]['uri']);
          $thumb_path = image_style_url('thumbnail', $node->field_image['und'][$count]['uri']);

          if ($count==0):

            print '<a href="' . $large_path . '" rel="shadowbox[' . $node->nid . ']">';
 
            print '<img class="medImg" src="'. $med_path . '" >';
 
            print '</a>';

          else:       

            print '<a href="' . $large_path . '" rel="shadowbox[' . $node->nid . ']">';
  
            print '<img class="thumbImg" src="'. $thumb_path . '" >';
 
            print '</a>';

          endif;

          $count++;
      
        endforeach;  

        print '</div>';
            
      endif; 

 ?>        
				
				<?php print render($content['body']) ?>
						 	       
					   
		</div>

<?php endif; /*end of full vs teaser check */ ?>
