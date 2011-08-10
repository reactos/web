<?php
// $Id: switchtheme.admin.inc,v 1.3 2011/01/07 23:41:22 sun Exp $

/**
 * @file
 * Administrative functionality for Switchtheme.
 */

/**
 * Form constructor for theme settings.
 */
function switchtheme_admin_settings($form, &$form_state) {
  $options = switchtheme_options();
  foreach ($options as $name => $label) {
    $form['switchtheme']['switchtheme_' . $name] = array(
      '#type' => 'textfield',
      '#title' => $label,
      '#default_value' => variable_get('switchtheme_' . $name, $label),
    );
  }
  return system_settings_form($form);
}

/**
 * Form constructor for browser settings.
 */
function switchtheme_admin_browser_settings($form, &$form_state) {
  $form['switchtheme_browser_enabled'] = array(
    '#type' => 'checkbox',
    '#title' => t('Switch theme based on the browser of the visitor'),
    '#default_value' => variable_get('switchtheme_browser_enabled', FALSE),
  );

  $themes = array('default' => t('Default'));
  $themes += switchtheme_options();
  $useragents = array();
  $result = db_query('SELECT data FROM {browscap}')->fetchCol();
  foreach ($result as $data) {
    $data = unserialize($data);
    if (isset($data['parent'])) {
      $useragents[trim($data['parent'])][] = isset($data['platform']) ? $data['platform'] : '';
    }
  }
  $form['switchtheme_browser'] = array(
    '#type' => 'fieldset',
    '#title' => t('Browsers'),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );
  foreach ($useragents as $parent => $platforms) {
    $form['switchtheme_browser']['switchtheme_browser_' . md5($parent)] = array(
      '#type' => 'select',
      '#title' => $parent,
      '#options' => $themes,
      '#default_value' => variable_get('switchtheme_browser_' . md5($parent), 'default'),
    );
  }
  return system_settings_form($form);
}

