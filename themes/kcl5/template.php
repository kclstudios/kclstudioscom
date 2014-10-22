<?php
// $Id: template.php,v 1.16.2.2 2009/08/10 11:32:54 goba Exp $


//include 'inc/page.inc';
//include 'inc/block.inc';
//include 'inc/field.inc';
//include 'inc/form.inc';
include 'inc/menu.inc';
//include 'inc/node.inc';

/**
 * 
 */

drupal_add_js('sites/all/themes/kcl5/js/jquery.ba-bbq.min.js'); 
drupal_add_js('sites/all/themes/kcl5/js/jquery.backgroundpos.js');
drupal_add_js('sites/all/themes/kcl5/js/jquery-ui-1.8.17.custom.min.js');
//drupal_add_js('sites/all/themes/kcl5/js/jquery.mousewheel.min.js');
//drupal_add_js('sites/all/themes/kcl5/js/jquery.mCustomScrollbar.js');
//drupal_add_js('sites/all/themes/kcl5/js/jquery.nicescroll/jquery.nicescroll.min.js'); 
drupal_add_js('sites/all/themes/kcl5/js/frontpage.js'); 
//drupal_add_js('sites/all/themes/kcl5/js/shapes.js');
drupal_add_js('sites/all/themes/kcl5/js/main-menu.js'); 
drupal_add_js('sites/all/themes/kcl5/js/soundmanager/script/soundmanager2-nodebug-jsmin.js'); 
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
    'href' => 'http://fonts.googleapis.com/css?family=Play:400,700', 
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

 function kcl5_nomarkup($variables) {
  $output = '';
  // Render the items.
  foreach ($variables['items'] as $delta => $item) {
    $output .=  drupal_render($item);
  }

  return $output;
}
 

/**
 *
 * Return markup for our menu-based ajax framework 
 * 
 */
function kcl5_main_menu_as_panels() {
 $branch = menu_tree_all_data('main-menu',NULL,1);
 if (!empty($branch)) {
   $out = '<div id="panelContainer">';
   foreach($branch as $item){    
     
     //print "<pre>" . print_r($node, TRUE) . "</pre>";
     //print "<pre>" . print_r($branch, TRUE) . "</pre>";  
     $node =  $item['link']['link_path'] !== '<front>' ? menu_get_object('node', 1, $item['link']['link_path']) : node_load(98);     
     $panel_display_name = !empty($node->field_panel_name) ? $node->field_panel_name['und'][0]['safe_value'] : 'Panel Name';
     $current_path = drupal_lookup_path('alias',"node/". $node->nid);
     
     
 
     $out .= '<div id="mcs_container_' . $node->nid . '" class="panel">'; 		
     $out .= '  <div class="container">';
     //$out .= '    <div class="content">';
     $out .= '      <div class="content-static">'; 
     $out .= drupal_render(node_view($node));
     $out .= '      </div>';
     $out .= '      <div class="content-dynamic"></div>';
 		// $out .= '    </div>';  
     $out .= '</div>';   
     $out .= '<a class="panelControl ajax" href="/' . $current_path . '" title="' . $panel_display_name . '"><div><span>' . $panel_display_name . '</span></div></a>';
     $out .= '</div>';
  

 
 }
 $out .= '<div class="loading-icon icon">L</div></div>';
 print $out;
 }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */

function kcl5_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  if (!empty($breadcrumb)) {
    //array_shift($breadcrumb); //Removes the first/home item
    //array_pop($breadcrumb);
    $themed_breadcrumb = '<div class="breadcrumb">';
    $array_size = count($breadcrumb);
    $i = 0;
    while ( $i < $array_size ) {
      if ( $i + 1 != $array_size ){
        $class = '';
        $separator =  ' <span class="separator">/</span> ';
        $tag = 'span';
      } else {
        $class = ' last';
        $separator =  '';
        $tag = 'span';
        $breadcrumb[$i] = strip_tags($breadcrumb[$i]);
        watchdog('breadcrumb',$breadcrumb[$i]);
      }
      $themed_breadcrumb .= '<';
      $themed_breadcrumb .= $tag;
      $themed_breadcrumb .= ' class="breadcrumb-';
      $themed_breadcrumb .= $i;
      $themed_breadcrumb .= $class;     
      $themed_breadcrumb .= '">' . $breadcrumb[$i] . '</';
      $themed_breadcrumb .= $tag;
      $themed_breadcrumb .= '>';
      $themed_breadcrumb .= $separator;
      $i++;
    }
    $themed_breadcrumb .= '</div>';
    return $themed_breadcrumb;
  } else {
    return $themed_breadcrumb = '<div class="breadcrumb"></div>';
  }
  
}


function kcl5_preprocess_node(&$vars) {  
  if ($vars['nid'] == 20) {
    //load the view by name
    $view = 'blog';
    //output the view  
    $vars['content']['views'] = views_embed_view($view,'block');
  }
  if ($vars['nid'] == 24) {
    //load the view by name
    $view = 'projects';
    //output the view  
    $vars['content']['views'] = views_embed_view($view,'block');
  }  
}

/**
 * Override or insert PHPTemplate variables into the templates.
 */
function kcl5_preprocess_page(&$vars) {
  $vars['tabs2'] = menu_secondary_local_tasks();

  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($vars);
  }
}

/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs. Overridden to split the secondary tasks.
 *
 * @ingroup themeable
 */
function kcl5_menu_local_tasks() {
  return menu_primary_local_tasks();
}

function kcl5_comment_submitted($comment) {
  return t('!datetime ? !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

function kcl5_node_submitted($node) {
  return t('!datetime ? !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}

/**
 * Instance of theme HOOK_menu_item
 */
function kcl5_menu_item($link, $has_children, $menu = '', $in_active_trail = FALSE, $extra_class = NULL) {
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
function kcl5_navigation_links($menu_name, $level = 0) {
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

  return kcl5_navigation_links_level($tree_page, $tree_all);
}


/**
* Helper function for themename_navigation_links to recursively create an array of links.
* (Both trees are required in order to include every menu item and active trail info.)
*/
function kcl5_navigation_links_level($tree_page, $tree_all) {
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
function kcl5_links($links, $attributes = array('class' => 'links')) {
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





/*
 * Custom function to display immediate menu children of current node 
 */
function kcl5_child_menu($id, $menu = 'main-menu') {

  $path = 'node/'. $id;
  $parent = menu_link_get_preferred($path);
  $mlid = $parent['mlid'];
  $tree = menu_tree_all_data($menu);

  //print_r(array_keys($tree['49956 Web Development 579']['link']['mlid'])); return;

  $subtree = kcl5_get_subtree($tree,$mlid);
  $num_keys = array_values($subtree);
  $children = $num_keys[0]['below'];
  //print_r($parent);
  if($children) {
    $count = 0;
    foreach($children as $child){  
      // print($child['link']['link_title']); 
      $child_id = str_ireplace("node/",'',$child['link']['link_path']);
      $child_node = node_load($child_id);
      $child_node->attributes_array['class'][] = 'poop';
      $child_view = node_view($child_node, $view_mode = 'scrape');
      $row = ($count % 2 == 0) ? 'even' : 'odd';    
      print '<div class="row ' . $row . '">';
      print render($child_view);
      print '</div>';
      //print $child_id;
      //print $child['link']['link_path']; 
      //print_r($subtree);
      $count++; 
      
     
    }
  }
}//end function kcl5_child_menu
 

/*
 * Custom function to display menu siblings of current node 
 */
function kcl5_siblings_menu($id, $menu = 'main-menu') {
  // System path
	$path = 'node/'. $id;
	// Get alias for system path, if exists
	$menu_link = menu_link_get_preferred($path);
	$mlid = $menu_link['mlid'];
	$tree = menu_tree_all_data($menu);
	$branch = kcl5_get_branch($tree,$mlid);	
	$num_keys = array_values($branch);
	$count = -1;
	$out = '';	
	foreach($num_keys as $num_key) {
		$classes = array();
		$classes[] = 'ajax';
		$count++;	
		if($num_keys[$count]['link']['mlid'] == $mlid) {
			$active = $count;
			$classes[] = 'active';	
			//print "<pre>" . print_r($num_keys[$count], TRUE) . "</pre>";
			//print "<pre>" . print_r($num_keys[$count]['link']['plid'], TRUE) . "</pre>";
			//kcl5_get_menu_item_parents($tree,$num_keys[$count]['link']['plid']);
		}
		$out .= '<a class="' . implode($classes, ' ') . '" href="/' . drupal_get_path_alias($num_keys[$count]['link']['href']) . '"><span>' . $num_keys[$count]['link']['title'] . '</span></a>';					
	}	
	print '<div class="menu-custom-siblings-menu">';
	$prev = $num_keys[$active - 1]; 
	print $out;
	$next = $num_keys[$active + 1]; 	
	print '</div>';
	if (!empty($prev)) { print '<a class="prev-link ajax icon" href="/' . drupal_get_path_alias($prev['link']['href']) . '">l</a>'; }
	if (!empty($next)) { print '<a class="next-link ajax icon" href="/' . drupal_get_path_alias($next['link']['href']) . '">r</a>'; }
}	


/*
 * Custom function to return a branch (all menu items belonging to the same parent at a certain level) from a menu tree
 */
function kcl5_get_branch($tree, $mlid, $level = -1) {
	$level++;
  // Check all top level entries
  foreach ($tree as $key => $element) { 
    // Is this the entry we are looking for?
    if ($mlid == $element['link']['mlid'])  {
      // Yes, return while keeping the key
      //return array($key => $element);
      //return $level;
      return $tree;
    } else {
      // No, recurse to children, if any
      if ($element['below']) {      	
        $submatch = kcl5_get_branch($element['below'], $mlid, $level);
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
function kcl5_get_subtree($tree, $mlid) {
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
        $submatch = kcl5_get_subtree($element['below'], $mlid);
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