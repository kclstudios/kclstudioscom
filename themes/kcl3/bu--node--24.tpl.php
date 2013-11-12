<div id="mcs_container_<?php print $nid ?>" class="panel">
  <div class="trans"></div>

  <div class="op">
 
    <div class="customScrollBox">
     <div class="container">
        <div class="content">


        <div class="contentDefault">
          <div class="breadcrumb"><?php print $title ?></div>

         
          
          <h1><?php $content['field_headline']['#theme'] = "nomarkup"; print render($content['field_headline']) ?></h1>
          <?php print render($content['field_drophead']) ?>
          <?php print render($content['body']) ?>
          




<?php 

      $images = isset($node->field_image['und'])? $node->field_image['und'] : NULL;   
      if (count($images)>0) :

      $count = 0;

?>

        <div class="imageGallery">
    
 
<?php  
        foreach ($images as $img) :
    
 
    
      //$img_caption = $img['data']['field_extend_img_caption']['body'];  
        
          $full_path = image_style_url('large', $node->field_image['und'][$count]['uri']);

          $thumb_path = image_style_url('thumbnail', $node->field_image['und'][$count]['uri']);

          print '<a href="' . $full_path . '" rel="shadowbox[localgallery]">';
 
          print '<img src="'. $thumb_path . '" >';
 
          print '</a>';
      

     
        $count++;
      
        endforeach;      
?>
 
          </div>


   <?php endif; ?>                        
 
         <ul id="projectSlideMenu" class="slidemenu">
 <?php 
if (isset($node->field_child_pages['und'])) :
 $children = $node->field_child_pages['und']; $count = 0;

    foreach($children as $child): 

      $child_id = $node->field_child_pages['und'][$count]['nid'];
      $child_node = node_load($child_id);
      $child_url = url('node/' . $child_node->nid);
      




      $child_images = isset($child_node->field_image['und'])? $child_node->field_image['und'] : NULL;   
      if ($child_images) :

          $full_path = image_style_url('large', $child_node->field_image['und'][0]['uri']);
          $thumb_path = image_style_url('thumbnail', $child_node->field_image['und'][0]['uri']);



?>

      <li class="clearfix"><a href="<?php print $child_url; ?>" class="ajax"><?php print '<img src="'. $thumb_path . '" >'; ?></a>
      <!--<div class="slideText"><?php /*print $fields['title']->content;*/ ?></div>-->
      <div class="slideShadow"></div>
      </li>
 
<?php  
       
 
    
 
         // print '<li><a href="' . $full_path . '" rel="shadowbox[localgallery]">';
 
 
      
?>
 
         


   <?php 

   endif;   














////////////////////////////////////////////////
      
  
      $count++;

    endforeach; 
endif;
?>
  </ul>   


</div> <!--//end default-->
<div class="contentInner"></div>


        </div>

 
      </div><!--// end container -->   
      
         <div class="dragger_container">
        <div class="dragger"></div>
      </div>  
             <a href="#" class="scrollUpBtn"><img src="sites/all/themes/kcl3/img/mcs_btnUp.png" /></a> <a href="#" class="scrollDownBtn"><img src="sites/all/themes/kcl3/img/mcs_btnDown.png" /></a>                 
    </div>

  </div><!--// end op -->
  <a class="panelControl" href="<?php print $node_url ?>" title="<?php print $node->field_panel_name['und'][0]['safe_value']; ?>"><div><span><?php print $node->field_panel_name['und'][0]['safe_value']; ?></span></div></a>
  <div class="panelBorder"></div>
</div>