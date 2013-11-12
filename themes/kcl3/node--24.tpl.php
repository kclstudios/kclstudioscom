<?php  if ($teaser) : /*display node in teaser format*/?>

<?php

if (isset($node->field_scene['und'])) :

  $scene = $node->field_scene['und']; 
  $scene_node = node_load($node->field_scene['und'][0]['nid']);
  
  $matteImg = isset($scene_node->field_matte_img['und'][0]) ? image_style_url('original', $scene_node->field_matte_img['und'][0]['uri']) : NULL; 

  print 'sceneData.push(new Array("' . $node->field_scene['und'][0]['nid'] . '","' . $matteImg . '"';

  $layers = isset($scene_node->field_layers['und']) ? $scene_node->field_layers['und'] : NULL;

    if(count($layers)>0) :      
      print ', new Array(';  
      $count = 0; 
      foreach($layers as $layer): 

        //$layer_id = isset($scene_node->field_layers['und'][$count]['nid']) ? $scene_node->field_layers['und'][$count]['nid'] : NULL;
        $layer_node = isset($scene_node->field_layers['und'][$count]['nid']) ? node_load($scene_node->field_layers['und'][$count]['nid']) : NULL; 
        $bg = image_style_url('original', $layer_node->field_bg['und'][0]['uri']);
        $x_start = isset($layer_node->field_bg_x_start['und'][0]['value']) ? $layer_node->field_bg_x_start['und'][0]['value'] : NULL;
        $x_end = isset($layer_node->field_bg_x_end['und'][0]['value']) ? $layer_node->field_bg_x_end['und'][0]['value'] : NULL;
        $y_start = isset($layer_node->field_bg_y_start['und'][0]['value']) ? $layer_node->field_bg_y_start['und'][0]['value'] : NULL;
        $y_end = isset($layer_node->field_bg_y_end['und'][0]['value']) ? $layer_node->field_bg_y_end['und'][0]['value'] : NULL;
        $repeat = isset($layer_node->field_bg_repeat['und'][0]['value']) ? $layer_node->field_bg_repeat['und'][0]['value'] : NULL;
        $duration = isset($layer_node->field_bg_duration['und'][0]['value']) ? $layer_node->field_bg_duration['und'][0]['value'] : NULL;
        $loop = isset($layer_node->field_bg_loop['und'][0]['value']) ? $layer_node->field_bg_loop['und'][0]['value'] : NULL;
        $interval = isset($layer_node->field_bg_interval['und'][0]['value']) ? $layer_node->field_bg_interval['und'][0]['value'] : NULL;
        $delay = isset($layer_node->field_bg_delay['und'][0]['value']) ? $layer_node->field_bg_delay['und'][0]['value'] : NULL;
                              
        if($count>0) : print ','; endif;
        print 'new Array('; 
        print '"' . $bg . '"';        
        print ',"' . $x_start . '"';
        print ',"' . $x_end . '"';
        print ',"' . $y_start . '"';
        print ',"' . $y_end . '"';
        print ',"' . $repeat . '"';
        print ',"' . $duration . '"';
        print ',"' . $loop . '"';
        print ',"' . $interval . '"'; 
        print ',"' . $delay . '"';                                       
        print ')';     
        $count++;

      endforeach; 
    print ')';
    endif;

    print ')';
    print ');';

endif;

else: /*else its a full node view*/ ?>

        <div class="node-full">


          <div class="breadcrumb"><h1><?php print $title ?></h1></div>

         
          
          <?php print render($content['field_headline']) ?>
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
 
 <div class="slideMenuContainer">

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

          $full_path = image_style_url('original', $child_node->field_image['und'][0]['uri']);
          $thumb_path = image_style_url('slide', $child_node->field_image['und'][0]['uri']);



?>

      <li>
        <a href="<?php print $child_url; ?>" class="ajax"><?php print '<img src="'. $thumb_path . '" >'; ?></a>      
        <div class="slideShadow"></div>
      </li>
 

         


   <?php 

   endif;   

    
  
      $count++;

    endforeach; 
endif;
?>
  </ul>   
  
</div>




        </div>

<?php endif; ?> 
