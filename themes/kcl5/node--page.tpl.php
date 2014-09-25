<?php
// $Id: node--page.tpl.php,v 1.5 2012/1/23 12:00:00 goba Exp $
$summary = isset($node->body['und']) ? $node->body['und'][0]['safe_summary'] : $node->nid;
$horiz_align = isset($node->field_horiz_align['und']) ? $node->field_horiz_align['und'][0]['value'] : 'center';
dpm($node);

?>

<?php  

  switch ($view_mode) {
    case "teaser" :
    
?>

		<div class="node-teaser node-type-<?php print $node->type;?> clearfix"> 
      <div class="node-inner clearfix">

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
 
     		<h2><a class="ajax" href="<?php print $node_url ?>"><?php print strip_tags($summary) ?></a></h2>
           			  	
      </div>  	  	
  	          
		</div>    

<?php 

      break;
    case "scrape" : 
    
?>		
   
		<div class="node-scrape node-type-<?php print $node->type;?> clearfix"> 
      <div class="node-inner clearfix">

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
 
     		<div class="icon">d</div><h2><a class="ajax" href="<?php print $node_url ?>"><?php print strip_tags($summary) ?></a></h2>
           			  	
      </div>  	  	
  	          
		</div>    



<?php 

      break;    
    default:  /*else its a full node view*/
    
?>

<div class="node node-full node-type-<?php print $node->type;?> node-align-<?php print $horiz_align;?> clearfix">  
 
	<?php kcl5_siblings_menu($nid); ?>		 
	
	<?php print theme('breadcrumb', array('breadcrumb'=>drupal_get_breadcrumb())); ?>
   		
	<div class="node-section-field-headline clearfix">
    <?php print render($content['field_headline']) ?>
  </div>  
	
  <div class="node-section-content clearfix">
  
	<div class="node-inner clearfix">

	  <?php 

	    $display_img = isset($node->field_display_img['und']) ? $node->field_display_img['und'] : NULL; 

	    if($display_img) {  
	      print '<img class="displayImg" src="'. image_style_url('original', $node->field_display_img['und'][0]['uri']) . '" >';
	    } 

	  ?> 
	  
	  <?php 

      $images = isset($node->field_image['und']) ? $node->field_image['und'] : NULL;   
        
      if (count($images)>0) : 

        print '<div class="imageContainer">';

		    $count = 0;

        foreach ($images as $img) :

          $img_title = $node->field_image['und'][$count]['title'];
          $large_path = image_style_url('large', $node->field_image['und'][$count]['uri']);
          $med_path = image_style_url('medium', $node->field_image['und'][$count]['uri']);
          $thumb_path = image_style_url('thumbnail', $node->field_image['und'][$count]['uri']);

          if ($count==0 && $display_img ==''):

            $img_details = image_get_info(image_style_path('medium', $node->field_image['und'][$count]['uri']));

            print '<a title="' . $img_title . '" href="' . $large_path . '" rel="shadowbox[' . $node->nid . ']">';
 
            print '<img class="medImg" src="' . $med_path . '" title="' .  $img_title . '" width="' . $img_details['width'] . '">';
 
            print '</a>';

          else:       

            print '<a title="' . $img_title . '" href="' . $large_path . '" rel="shadowbox[' . $node->nid . ']">';
  
            print '<img class="thumbImg" src="' . $thumb_path . '" title="' .  $img_title . '">';
 
            print '</a>';

          endif;

          $count++;
      
        endforeach;  

        print '</div>';
            
      endif; 

    ?>        
		
    <?php print render($content['field_drophead']) ?>
		
		<?php print render($content['body']) ?>

<?php if($title == "The Power of the Drupal CMS"): ?>
    <div class="feedContainer">
      <h3>Latest from Drupal.org</h3> - <a href="http://www.drupal.org" target="_blank">http://www.drupal.org</a>

<?php
$block = module_invoke('aggregator', 'block_view', 'feed-1'); 
print render($block['content']); 
?></h3>

    </div>
  
<?php endif; ?>

  </div>
	</div>
	
	<div class="node-section-children">
	  <?php kcl5_child_menu($nid); ?>	
	</div>		
		
</div>		
<?php
    
  } /*end view_mode switch */ 
  
?>
