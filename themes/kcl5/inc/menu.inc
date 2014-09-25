<?php
/**
 * @file
 * Menu hooks.
 */


//
// Implements theme_menu_tree().
//

  // See https://drupal.org/node/1934824
  
  function thewheel_menu_tree__menu_block__3($variables) {
    return '<ul class="menu menu--dropdown-slide group">' . $variables['tree'] . '</ul>';
  }


  function kcl5_menu_link(array $variables) {
    
    $element = $variables['element'];
    $sub_menu = '';
    // Load the node to check for scene id reference
    //$node = menu_node_get_node($element['#original_link']['mlid']);
    
  
    if ($element['#below']) {
      $sub_menu = drupal_render($element['#below']);
      $sub_menu .= '<div class="li-expand icon"><span class="open">+</span><span class="close ">-</span></div>';
    }
    
    $pattern = '/node\/(\d+)/';
    $string = $variables['element']['#href'];
    preg_match($pattern, $string, $matches);
    //if(!empty($matches)) {
      $element['#localized_options']['attributes']['data-node-id'] = $matches[1];
      //$element['#localized_options']['attributes']['class'][] = 'use-ajax';
    //}
//$pre = $element['#original_link']['mlid'] == 524 ? '<pre>' . print_r($variables,true) . '</pre>' : '';    
    
    $output = l($element['#title'], $element['#href'], $element['#localized_options']);
    return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
  }



// 
// Implements hook_preprocess_menu_link().
//

  // THEMENAME_preprocess_menu_link();

  /* function thewheel_preprocess_menu_link(&$vars) {
  
    // Set shortcut variables. Hooray for less typing!
    $menu = $vars['element']['#original_link']['menu_name'];
    $mlid = $vars['element']['#original_link']['mlid'];
    $item_classes = &$vars['element']['#attributes']['class'];
    $link_classes = &$vars['element']['#localized_options']['attributes']['class'];
  
    // Add global classes to all menu links.
    $item_classes[] = 'nav-item';
    $link_classes[] = 'nav-link';
  }*/





// 
// Implements theme_menu_link();
// 

  // THEMENAME_menu_link__menu_block__MENU_NAME();
  // See https://drupal.org/node/1934824
  
  /*function thewheel_menu_link__menu_block__3(array $variables) {
    $element = $variables['element'];
    $sub_menu = '';
  
    if ($element['#below']) {
      $sub_menu = drupal_render($element['#below']);
    }
    
    $output = l($element['#title'], $element['#href'], $element['#localized_options']);
    return '<li' . drupal_attributes($element['#attributes']) . '><div class="item-wrapper"><span>+</span></div>' . $output . $sub_menu . "</li>\n";
  }*/