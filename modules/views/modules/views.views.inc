<?php
/**
 * @file
 * Provide views data and handlers that aren't tied to any other module.
 */

/**
 * @defgroup views_views_module miscellaneous handlers
 *
 * @{
 */

/**
 * Implements hook_views_data()
 */
function views_views_data() {
  $data['views']['table']['group'] = t('Global');
  $data['views']['table']['join'] = array(
    '#global' => array(),
  );

  $data['views']['random'] = array(
    'title' => t('Random'),
    'help' => t('Randomize the display order.'),
    'sort' => array(
      'handler' => 'views_handler_sort_random',
    ),
  );

  $data['views']['null'] = array(
    'title' => t('Null'),
    'help' => t('Allow a contextual filter value to be ignored. The query will not be altered by this contextual filter value. Can be used when contextual filter values come from the URL, and a part of the URL needs to be ignored.'),
    'argument' => array(
      'handler' => 'views_handler_argument_null',
    ),
  );

  $data['views']['nothing'] = array(
    'title' => t('Custom text'),
    'help' => t('Provide custom text or link.'),
    'field' => array(
      'handler' => 'views_handler_field_custom',
    ),
  );

  $data['views']['counter'] = array(
    'title' => t('View result counter'),
    'help' => t('Displays the actual position of the view result'),
    'field' => array(
      'handler' => 'views_handler_field_counter',
    ),
  );

  $data['views']['area'] = array(
    'title' => t('Text area'),
    'help' => t('Provide markup text for the area.'),
    'area' => array(
      'handler' => 'views_handler_area_text',
    ),
  );

  $data['views']['view'] = array(
    'title' => t('View area'),
    'help' => t('Insert a view inside an area.'),
    'area' => array(
      'handler' => 'views_handler_area_view',
    ),
  );

  if (module_invoke('ctools', 'api_version', '1.7.1')) {
    $data['views']['expression'] = array(
      'title' => t('Math expression'),
      'help' => t('Evaluates a mathematical expression and displays it.'),
      'field' => array(
        'handler' => 'views_handler_field_math',
        'float' => TRUE,
      ),
    );
  }

  return $data;
}

/**
 * @}
 */
