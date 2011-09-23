<?php

/**
 * @file
 * Views integration for the views_field_view module.
 */

/**
 * Implements hook_views_data_alter().
 */
function views_field_view_views_data_alter(&$data) {
  $data['views']['view'] = array(
    'title' => t('View'),
    'help' => t('Embed a view as field, this can cause slow performance, so enable some caching.'),
    'field' => array(
      'handler' => 'views_field_view_handler_field_view',
    ),
    'area' => array(
      'help' => t('Embed a view in an Area, such as Header, Footer, Empty Text.'),
      'handler' => 'views_field_view_handler_field_view',
    ),
  );
}
