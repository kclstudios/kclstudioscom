<?php
// $Id: node--page.tpl.php,v 1.5 2012/1/23 12:00:00 goba Exp $
$summary = isset($node->body['und']) ? $node->body['und'][0]['safe_summary'] : $node->nid;
$horiz_align = isset($node->field_horiz_align['und']) ? $node->field_horiz_align['und'][0]['value'] : 'center';
$teaser_img = isset($node->field_teaser_img['und']) ? $node->field_teaser_img['und'] : NULL;  
$images = isset($node->field_image['und']) ? $node->field_image['und'] : NULL;   
$display_img = isset($node->field_display_img['und']) ? $node->field_display_img['und'] : NULL; 



//dpm($node);

?>

<?php  

  switch ($view_mode) {
    case "teaser" :
    
?>

		<div class="<?php print $classes; ?> clearfix"> 
		  <div class="node-back"></div>
      <div class="node-content node-teaser-content clearfix">

<?php   
        
      if ($teaser_img) :        
          
          $thumb_path = image_style_url('thumbnail', $node->field_teaser_img['und'][0]['uri']);

          print '<div class="field-name-teaser-img"><img class="thumbImg" src="'. $thumb_path . '" ></div>';
 
      elseif ($images) :
 
                
          $thumb_path = image_style_url('thumbnail', $node->field_image['und'][0]['uri']);

          print '<div class="field-name-image"><img class="thumbImg" src="'. $thumb_path . '" ></div>'; 
        
      endif; 

 ?>       
 
  	     <div class="node-section-field-title clearfix">
  	      <h3 class="node-title"><a class="ajax" href="<?php print $node_url ?>"><?php print $title; ?></a></h3>
  	     </div> 
 
  	     <div class="node-section-content">
  	       <p><?php print strip_tags($summary) ?></p>
  	     </div>
  	     
      </div>   	          
		</div>    

<?php 

      break;
    case "scrape" : 
    
?>		
   
		<div class="node-scrape node-type-<?php print $node->type;?> clearfix"> 
		 
		  
		  <div class="node-teaser-img">
		    <div class="field-name-teaser-img">
		  <?php 

      $teaser_img = isset($node->field_teaser_img['und']) ? $node->field_teaser_img['und'] : NULL;  
      $images = isset($node->field_image['und']) ? $node->field_image['und'] : NULL;     
        
     
      if ($teaser_img) :        
          
          $thumb_path = image_style_url('thumbnail', $node->field_teaser_img['und'][0]['uri']);

          print '<img src="'. $thumb_path . '" >';
 
      elseif ($images) :
 
                
          $thumb_path = image_style_url('thumbnail', $node->field_image['und'][0]['uri']);

          print '<img src="'. $thumb_path . '" >'; 
        
      endif; 

 ?>     
        </div>   
      </div>
      <div class="node-content node-scrape-content clearfix">

        <div class="node-section-content">         
          <div class="node-field-title">
            <h3 class="node-title"><a class="ajax" href="<?php print $node_url ?>"><?php print $title ?></a></h3>
          </div> 
     		</div>
           			  	
      </div>  	  	
  	          
		</div>    

<?php 

      break;    
    default:  /*else its a full node view*/
    
?>


<div class="<?php print $classes; ?> clearfix">  
 



	
	<div class="node-content node-full-content">
 

	
	<div class="node-section-field-headline clearfix">
	 
    <?php print render($content['field_headline']) ?>
  </div>  
	
 
 

	

	  <?php 

	  

	    if($display_img) {  
	      print '<div class="node-section-field-display-img"><div class="node-back"></div><img class="displayImg" src="'. image_style_url('original', $node->field_display_img['und'][0]['uri']) . '" ></div>';
	    } 

	  ?> 
	  
		  <?php     
        
      if (count($images)>0) : 

        print '<div class="node-section-field-image imageContainer"><div class="node-back"></div>';

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
	  
	  
	  
	  
    <?php if(!empty($content['field_drophead']) || !empty($content['body'])) : ?>
  <div class="node-section-content clearfix">
   <div class="node-back"></div>		
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
	<?php endif; ?>	  
	  
	  
	  
	  
	  
	  
	  
	  
	  

    


	
	<div class="node-section-children">
	  <?php kcl5_child_menu($nid); ?>	
	</div>	
</div>	

	<div class="node-breadcrumb">
    <div class="breadcrumb"><span class="breadcrumb-0"><a href="/#/">#</a></span><span class="separator">/</span><span class="breadcrumb-1 last"><?php print $title ?></span></div> 
  </div>  
  
	<div class="node-sibling-menu">
    <?php kcl5_siblings_menu($nid); ?> 
  </div>  	
		
</div>		
<?php
    
  } /*end view_mode switch */ 
  
?>
