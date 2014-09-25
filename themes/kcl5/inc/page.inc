<?php

// Implements hook_preprocess_page()

  function thewheel_preprocess_html(&$vars) {
    
    if (!empty($vars['classes_array'])) {
      //Find the node type from the list of classes associated with the page
      foreach($vars['classes_array'] as $key => $value) {
        if(substr($value, 0, 10) == 'node-type-') {
          $node_type = substr($value, 10);

          // Define node types to apply body class to
          $types_with_social_share = array(
            'page',
            'content-mirror',
            'event',
            'iframe',
            'job-opening',
            'letter',
            'media-coverage',
            'media-gallery',
            'news-release',
            'news-item',
            'newsletter',
            'organization-page'
          );
          
          if(in_array($node_type, $types_with_social_share)) {
            $vars['classes_array'][] = 'has-social-media-share'; 
          }
        }
      }
    } 
  }
