<?php
// $Id: template.php,v 1.16.2.2 2009/08/10 11:32:54 goba Exp $
/**
 * Sets the body-tag class attribute.
 *
 * Adds 'sidebar-left', 'sidebar-right' or 'sidebars' classes as needed.
 */

drupal_add_js('sites/all/themes/kcl4/js/jquery.ba-bbq.min.js'); 
drupal_add_js('sites/all/themes/kcl4/js/jquery.backgroundpos.js');
//drupal_add_js('sites/all/themes/kcl4/js/jquery.backgroundPosition.js');
//drupal_add_js('sites/all/themes/kcl4/js/jquery.timers-1.1.2.js'); 
drupal_add_js('sites/all/themes/kcl4/js/jquery-ui-1.8.17.custom.min.js');
drupal_add_js('sites/all/themes/kcl4/js/jquery.mousewheel.min.js');
drupal_add_js('sites/all/themes/kcl4/js/jquery.mCustomScrollbar.js'); 
drupal_add_js('sites/all/themes/kcl4/js/frontpage.js'); 
drupal_add_js('sites/all/themes/kcl4/js/slidemenu.js'); 
drupal_add_js('sites/all/themes/kcl4/js/soundmanager/script/soundmanager2-nodebug-jsmin.js'); 
drupal_add_js('sites/all/modules/webform/js/webform.js');
drupal_add_js('misc/jquery.cookie.js');
drupal_add_js('misc/jquery.form.js');
drupal_add_js('misc/ajax.js');



/**
 *
 * Add links to the Google Web Font API in the header
 *
 */
$element1 = array(
  '#tag' => 'link', // The #tag is the html tag - <link />
  '#attributes' => array( // Set up an array of attributes inside the tag
    'href' => 'http://fonts.googleapis.com/css?family=Play:700', 
    'rel' => 'stylesheet',
    'type' => 'text/css',
  ),
);
$element2 = array(
  '#tag' => 'link', // The #tag is the html tag - <link />
  '#attributes' => array( // Set up an array of attributes inside the tag
    'href' => 'http://fonts.googleapis.com/css?family=Orbitron', 
    'rel' => 'stylesheet',
    'type' => 'text/css',
  ),
);

drupal_add_html_head($element1, 'google_font_play');
drupal_add_html_head($element2, 'google_font_orbitron');
 
/**
 *
 * Free node fields from Drupal divitis 
 * Implemented with: $content['field_headline']['#theme'] = "nomarkup";
 * 
 */

 function kcl4_nomarkup($variables) {
  $output = '';
  // Render the items.
  foreach ($variables['items'] as $delta => $item) {
    $output .=  drupal_render($item);
  }

  return $output;
}
 

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */

function kcl4_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  if (!empty($breadcrumb)) {
    array_shift($breadcrumb); // Removes the first/home item
    $themed_breadcrumb = '<div class="breadcrumb">';
    $array_size = count($breadcrumb);
    $i = 0;
    while ( $i < $array_size ) {

      if ( $i + 1 != $array_size ){
        $class = '';
        $seperator =  ' <span>&raquo</span> ';
        $tag = 'span';
      }else{
        $class = ' last';
        $seperator =  '';
        $tag = 'h1';
        $breadcrumb[$i] = strip_tags($breadcrumb[$i]);
      }
      $themed_breadcrumb .= '<';
      $themed_breadcrumb .= $tag;
      $themed_breadcrumb .= ' class="breadcrumb-';
      $themed_breadcrumb .= $i;
      $themed_breadcrumb .= $class;     
      $themed_breadcrumb .= '">' . $breadcrumb[$i] . '</';
      $themed_breadcrumb .= $tag;
      $themed_breadcrumb .= '>';
      $themed_breadcrumb .= $seperator;
      $i++;
    }
    $themed_breadcrumb .= '</div>';
    return $themed_breadcrumb;
  } else {
    return $themed_breadcrumb = '<div class="breadcrumb"></div>';
  }
  
}


/**
 * Override or insert PHPTemplate variables into the templates.
 */
function kcl4_preprocess_page(&$vars) {
  $vars['tabs2'] = menu_secondary_local_tasks();

  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($vars);
  }
}

/**
 * Add a "Comments" heading above comments except on forum pages.
 */
function kcl4_preprocess_comment_wrapper(&$vars) {
  if ($vars['content'] && $vars['node']->type != 'forum') {
    $vars['content'] = '<h2 class="comments">'. t('Comments') .'</h2>'.  $vars['content'];
  }
}

/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs. Overridden to split the secondary tasks.
 *
 * @ingroup themeable
 */
function kcl4_menu_local_tasks() {
  return menu_primary_local_tasks();
}

function kcl4_comment_submitted($comment) {
  return t('!datetime ? !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

function kcl4_node_submitted($node) {
  return t('!datetime ? !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}

/**
 * Generates IE CSS links for LTR and RTL languages.
 */
function kcl4_get_ie_styles() {
  global $language;

  $iecss = '<link type="text/css" rel="stylesheet" media="all" href="'. base_path() . path_to_theme() .'/fix-ie.css" />';
  if ($language->direction == LANGUAGE_RTL) {
    $iecss .= '<style type="text/css" media="all">@import "'. base_path() . path_to_theme() .'/fix-ie-rtl.css";</style>';
  }

  return $iecss;
}



function kcl4_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
  $class = ($menu ? 'expanded' : ($has_children ? 'collapsed' : 'leaf'));
  if (!empty($extra_class)) {
    $class .= ' ' . $extra_class;
  }
  if ($in_active_trail) {
    $class .= ' active-trail';
  }
  return '<li class="' . $class . '">' . $link . $menu . "<div></div></li>\n";
}

/**
* Return a multidimensional array of links for a navigation menu.
*/
function kcl4_navigation_links($menu_name, $level = 0) {
  // Don't even bother querying the menu table if no menu is specified.
  if (empty($menu_name)) {
    return array();
  }

  // Get the menu hierarchy for the current page.
  $tree_page = menu_tree_page_data($menu_name);
  // Also get the full menu hierarchy.
  $tree_all = menu_tree_all_data($menu_name);

  // Go down the active trail until the right level is reached.
  while ($level-- > 0 && $tree_page) {
    // Loop through the current level's items until we find one that is in trail.
    while ($item = array_shift($tree_page)) {
      if ($item['link']['in_active_trail']) {
        // If the item is in the active trail, we continue in the subtree.
        $tree_page = empty($item['below']) ? array() : $item['below'];
        break;
      }
    }
  }

  return kcl4_navigation_links_level($tree_page, $tree_all);
}


/**
* Helper function for themename_navigation_links to recursively create an array of links.
* (Both trees are required in order to include every menu item and active trail info.)
*/
function kcl4_navigation_links_level($tree_page, $tree_all) {
  $links = array();
  foreach ($tree_all as $key => $item) {
    $item_page = $tree_page[$key];
    $item_all = $tree_all[$key];
    if (!$item_all['link']['hidden']) {
        $class = '';
      $l = $item_all['link']['localized_options'];
      $l['href'] = $item_all['link']['href'];
      $l['title'] = $item_all['link']['title'];
      if ($item_page['link']['in_active_trail']) {
          $class = ' active-trail';
      }
      if ($item_all['below']) {
        $l['children'] = themename_navigation_links_level($item_page['below'], $item_all['below']);
      }
      // Keyed with the unique mlid to generate classes in theme_links().
      $links['menu-'. $item_all['link']['mlid'] . $class] = $l;
    }
  }
  return $links;
}

/**
* Return a themed set of links. (Extended to support multidimensional arrays of links.)
*/
function kcl4_links($links, $attributes = array('class' => 'links')) {
  $output = '';

  if (count($links) > 0) {
    $output = '<ul'. drupal_attributes($attributes) .'>';

    $num_links = count($links);
    $i = 1;

    foreach ($links as $key => $link) {
      $class = $key;

      // Add first, last and active classes to the list of links to help out themers.
      if ($i == 1) {
        $class .= ' first';
      }
      if ($i == $num_links) {
        $class .= ' last';
      }
      if (isset($link['href']) && ($link['href'] == $_GET['q'] || ($link['href'] == '<front>' && drupal_is_front_page()))) {
        $class .= ' active';
      }
      // Added: if the link has child items, add a haschildren class
      if (isset($link['children'])) {
        $class .= ' haschildren';
      }
      $output .= '<li'. drupal_attributes(array('class' => $class)) .'>';

      if (isset($link['href'])) {
        // Pass in $link as $options, they share the same keys.
        $output .= l($link['title'], $link['href'], $link);
      }
      else if (!empty($link['title'])) {
        // Some links are actually not links, but we wrap these in <span> for adding title and class attributes
        if (empty($link['html'])) {
          $link['title'] = check_plain($link['title']);
        }
        $span_attributes = '';
        if (isset($link['attributes'])) {
          $span_attributes = drupal_attributes($link['attributes']);
        }
        $output .= '<span'. $span_attributes .'>'. $link['title'] .'</span>';
      }
     
      // Added: if the link has child items, print them out recursively
      if (isset($link['children'])) {
        $output .= "\n" . theme('links', $link['children'], array('class' =>'sublinks'));
      }

      $i++;
      $output .= "</li>\n";
    }

    $output .= '</ul>';
  }

  return $output;
}





#########################################################

function kcl4_child_menu($menu = 'main-menu', $id) {

$path = 'node/'. $id;
$parent = menu_link_get_preferred($path);
$mlid = $parent['mlid'];
$tree = menu_tree_all_data($menu);
$subtree = kcl_get_subtree($tree,$mlid);
$numKeys = array_values($subtree);
$children = $numKeys[0]['below'];
//print_r($parent);
if($children) :
  $count = 0;
  foreach($children as $child){  
    // print($child['link']['link_title']); 
    $child_id = str_ireplace("node/",'',$child['link']['link_path']);
    $child_node = node_load($child_id);
    $child_view = node_view($child_node, $view_mode = 'teaser');
    print render($child_view); 
    //print $child_id;
    //print $child['link']['link_path'];
    //}
    //print_r($subtree);
    $count++; 
    if($count % 3 == 0) print '<br clear="all" />';  
  }
endif; 

}//end function kcl4_child_menu
 






 /**
 * Extract a specific subtree from a menu tree based on a menu link id (mlid)
 *
 * @param array $tree
 *   A menu tree data structure as returned by menu_tree_all_data() or menu_tree_page_data()
 * @param int $mlid
 *   The menu link id of the menu entry for which to return the subtree
 * @return array
 *   The found subtree, or NULL if no entry matched the mlid
 */
function kcl_get_subtree($tree, $mlid) {
  // Check all top level entries
  foreach ($tree as $key => $element) {
    // Is this the entry we are looking for?
    if ($mlid == $element['link']['mlid'])  {
      // Yes, return while keeping the key
      return array($key => $element);
    }
    else {
      // No, recurse to children, if any
      if ($element['below']) {
        $submatch = kcl_get_subtree($element['below'], $mlid);
        // Found wanted entry within the children?
        if ($submatch) {
          // Yes, return it and stop looking any further
          return $submatch;
        }
      }
    }
  }
  // No match at all
  return NULL;
}