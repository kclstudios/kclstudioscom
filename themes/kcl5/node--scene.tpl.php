

<?php  
 
  
  $matteImg = isset($node->field_matte_img['und'][0]) ? image_style_url('original', $node->field_matte_img['und'][0]['uri']) : NULL; 

  print 'sceneData[' . $node->nid . '] = { "title" : "' . $node->title . '", "matte" : "' . $matteImg . '", "layers" : [ ';

  $layers = isset($node->field_layers['und']) ? $node->field_layers['und'] : NULL;

    if(count($layers)>0) :   
      $count = 0; 
      foreach($layers as $layer):    
       
        $layer_node = node_load($node->field_layers['und'][$count]['nid']); 
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


?>

