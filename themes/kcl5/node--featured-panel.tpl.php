<?php
// $Id: node--featured-panel.tpl.php,v 1.5 2014/11/13 12:00:00 goba Exp $
$summary = isset($node->body['und']) ? $node->body['und'][0]['safe_summary'] : $node->nid;
$horiz_align = isset($node->field_horiz_align['und']) ? $node->field_horiz_align['und'][0]['value'] : 'center';
$teaser_img = isset($node->field_teaser_img['und']) ? $node->field_teaser_img['und'] : NULL;  
$images = isset($node->field_image['und']) ? $node->field_image['und'] : NULL;   
$display_img = isset($node->field_display_img['und']) ? $node->field_display_img['und'] : NULL; 

?>

<?php  

  switch($view_mode) {
    case "teaser" : /*display node in teaser format*/?>

<?php

if (isset($node->field_scene['und'])) :

  $scene = $node->field_scene['und']; 
  $scene_node = node_load($node->field_scene['und'][0]['nid']);
  
  $matteImg = isset($scene_node->field_matte_img['und'][0]) ? image_style_url('original', $scene_node->field_matte_img['und'][0]['uri']) : NULL; 

  print 'sceneData[' . $node->field_scene['und'][0]['nid'] . '] = { "matte" : "' . $matteImg . '", "layers" : [ ';

  $layers = isset($scene_node->field_layers['und']) ? $scene_node->field_layers['und'] : NULL;

    if(count($layers)>0) :   
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
                              
        if($count>0) : print ', '; endif;
        print ' ['; 
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
        print ']';     
        $count++;

      endforeach;  
    endif;

    print ']}';
    print ';';

endif;
?>

<?php
      break;
    default: /*else its a full node view*/ 
?>


 

<div class="<?php print $classes; ?> clearfix">	

  <div class="node-inner-one">   
    <?php print render($content['field_headline']); ?>
  </div>   
  
  <div class="node-inner-two">
  
    <div class="inner">

  
  <?php if(!empty($content['field_drophead']) || !empty($content['body']) || !empty($content['form'])) : ?> 

  <div class="node-section-content clearfix">  
          
     <?php 

      $images = isset($node->field_image['und']) ? $node->field_image['und'] : NULL;   
        
      if (count($images)>0) : 

        print '<div class="imageContainer">';

        $count = 0;

        foreach ($images as $img) :
          $img_title = $node->field_image['und'][$count]['title'];
          $large_path = image_style_url('large', $node->field_image['und'][$count]['uri']);
          $med_path = image_style_url('medium', $node->field_image['und'][$count]['uri']);
          $thumb_path = image_style_path('thumbnail', $node->field_image['und'][$count]['uri']);
          
          if ($count==0):
            $img_details = image_get_info(image_style_path('medium', $node->field_image['und'][$count]['uri']));
            print '<img class="img-style-medium" src="'. $med_path . '" title="' . $img_title . '" width="' . $img_details['width'] . '">';       

          else:             
            $img_details = image_get_info($thumb_path);
            print '<img class="img-style-thumbnail" src="'. $thumb_path . '" >';            

          endif;

          $count++;
      
        endforeach;  

        print '</div>';
            
      endif; 

    ?>   
    
    <?php print render($content['field_drophead']) ?>
    <?php print render($content['body']) ?>
    <?php print render($content['form']) ?> 

  </div>
  
  <?php endif; ?>  
  
	<div class="node-section-field-node-links">
	  <?php print render($content['field_node_links']) ?>
	</div>

	</div>
		</div>
		
	<div class="node-breadcrumb">
    <div class="breadcrumb"><span class="breadcrumb-0"><a href="/#/">#</a></span><span class="separator">/</span><span class="breadcrumb-1 last"><?php print $title ?></span></div> 
  </div>  
  

  
</div>		
<?php 
    break;
  }
?>