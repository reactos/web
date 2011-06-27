<?php
/**
 * @file
 * answers.features.inc
 */

/**
 * Implementation of hook_ctools_plugin_api().
 */
function answers_ctools_plugin_api() {
  list($module, $api) = func_get_args();
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => 1);
  }
}

/**
 * Implementation of hook_views_api().
 */
function answers_views_api() {
  list($module, $api) = func_get_args();
  if ($module == "views" && $api == "views_default") {
    return array("version" => 3.0);
  }
}

/**
 * Implementation of hook_node_info().
 */
function answers_node_info() {
  $items = array(
    'answer' => array(
      'name' => t('Answer'),
      'base' => 'node_content',
      'description' => t('An answer provided to question asked by a member of the community'),
      'has_title' => '1',
      'title_label' => t('Answer'),
      'help' => '',
    ),
    'question' => array(
      'name' => t('Question'),
      'base' => 'node_content',
      'description' => t('A question which can be answered by other users'),
      'has_title' => '1',
      'title_label' => t('Question'),
      'help' => '',
    ),
  );
  return $items;
}
