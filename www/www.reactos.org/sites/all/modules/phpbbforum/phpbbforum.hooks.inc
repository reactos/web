<?php
// $Id: phpbbforum.hooks.inc,v 1.7 2010/02/20 11:01:25 vb Exp $
/**
 * @file
 * @copyright  Copyright (C) 2007-2011 Vadim G.B. (http://vgb.org.ru)
 */

//if (variable_get("phpbbforum_page_frame", 0) == '1' || variable_get("phpbbforum_page_frame", 0) == '2') {

/**
 * replaces msg links.
 */
function _phpbbforum_replace_msg_links($output) {
  //global $site_forum_url;

  //if (strpos($output, $site_forum_url) === false) {
  $output = _phpbbforum_replace_links($output);
  //}
  return $output;
}


/**
 * replaces urls.
 */
function _phpbbforum_replace_urls($output, $decode = false) {
  global $phpbb_config, $site_forum_url, $site_base_url, $site_phpbb_page, $site_phpbb_page_lang, $phpbb_root_path;

  if (strpos($output, $site_base_url . $phpbb_root_path) !== false) {
    $output = str_replace($site_base_url, '', $output);
  }

  $phpbb_url = $phpbb_config['forum_url'];
  $q_phpbbforum = 'q=' . $site_phpbb_page;
  $q_phpbbforum_lang = 'q=' . $site_phpbb_page_lang;
  $str = array('../', '/index.php?' . $q_phpbbforum_lang, '/index.php?' . $q_phpbbforum);
  if ($decode) {
    $output = urldecode($output);
  }
  $output = str_replace($str, '', $output);
  if (strpos($output, $site_forum_url) === false) {
    $output = str_replace($phpbb_url, $site_forum_url, $output);
    $output = str_replace($phpbb_root_path, $site_forum_url . '/', $output);
  }

  return $output;
}

/**
 * _phpbbforum_variable_get
 */
function _phpbbforum_variable_get($var, $val = null) {
  if (!empty($var) && isset($_SESSION[$var])) {
    return $_SESSION[$var];
  }
  return $val;
}

/**
 * _phpbbforum_variable_set
 */
function _phpbbforum_variable_set($var, $val = null) {
  if (!empty($var)) {
    $_SESSION[$var] = $val;
  }
  return $val;
}

/**
 * _phpbbforum_set_result.
 */
function _phpbbforum_set_result($result = array()) {
  $_SESSION['phpbbforum_result'] = $result;
  return $result;
}

/**
 * _phpbbforum_get_result.
 */
function _phpbbforum_get_result() {
  if (isset($_SESSION['phpbbforum_result'])) {
    return $_SESSION['phpbbforum_result'];
  }
  return array();
}

/**
 * _phpbbforum_set_request.
 */
function _phpbbforum_set_request($request = array()) {
  $_SESSION['phpbbforum_request'] = $request;
  return $request;
}

/**
 * _phpbbforum_get_request.
 */
function _phpbbforum_get_request() {
  if (isset($_SESSION['phpbbforum_request'])) {
    return $_SESSION['phpbbforum_request'];
  }
  return array();
}

/**
 * _phpbbforum_set_destination.
 */
function _phpbbforum_set_destination($url = '', $query = array()) {
  $destination = array(
    'url' => $url,
    'query' => $query,
  );
  $_SESSION['phpbbforum_destination'] = $destination;
  return $destination;
}

/**
 * _phpbbforum_get_destination.
 */
function _phpbbforum_get_destination() {
  if (isset($_SESSION['phpbbforum_destination'])) {
    return $_SESSION['phpbbforum_destination'];
  }
  return array();
}
/**
 * _phpbbforum_set_comments_destination.
 */
function _phpbbforum_set_comments_destination($url = '', $query = array()) {
  $destination = array(
    'url' => $url,
    'query' => $query,
  );
  $_SESSION['phpbbforum_comments_destination'] = $destination;
  return $destination;
}

/**
 * _phpbbforum_get_comments_destination.
 */
function _phpbbforum_get_comments_destination() {
  if (isset($_SESSION['phpbbforum_comments_destination'])) {
    return $_SESSION['phpbbforum_comments_destination'];
  }
  return array();
}

/**
 * _phpbbforum_goto.
 */
function _phpbbforum_goto($url, $drupal = true) {
  @restore_error_handler();
  phpbb_load();

  if ($drupal) {
    drupal_goto($url);
  }
  header('Location: ' . $url);
  exit;
}

/**
 * phpbbforum_hook_login_link
 */
function phpbbforum_get_drupal_login_register_link() {
  $link = l(t('Create new account'), 'user/register', array('attributes' => array('absolute' => TRUE, 'title' => t('Create a new user account.'))));
  return $link;
}

////////////////////////////////////////////////////////////////////////////////

/**
 * _phpbbforum_hook
 */
function _phpbbforum_hook($hook) {
  $name = $hook['name'];
  $fn = '_phpbbforum_hook_' . $name;
  if (function_exists($fn)) {
    $fn($hook);
  }
}

/**
 * _phpbbforum_hook_login
 */
function _phpbbforum_hook_login($hook) {
  $redirect = _phpbbforum_replace_urls($hook['redirect']);
  _phpbbforum_login_external($redirect);
}

/**
 * _phpbbforum_hook_logout
 */
function _phpbbforum_hook_logout($hook) {
  $redirect = _phpbbforum_replace_forum_url($hook['redirect']);
  _phpbbforum_logout_external($redirect);
}

/**
 * _phpbbforum_hook_user_delete
 */
function _phpbbforum_hook_user_delete($hook) {
  _phpbbforum_user_delete($hook['username']);
}

//} // if (variable_get("phpbbforum_page_frame", 0) == '1' || variable_get("phpbbforum_page_frame", 0) == '2') {

////////////////////////////////////////////////////////////////////////////////

function _phpbbforum_login_external($redirect = '') {
  if (_phpbbforum_drupal_login()) {
    $url = $redirect;
    if (variable_get("phpbbforum_page_frame", 0) == '2') {
      $destination = _phpbbforum_get_destination();
      $url = $destination['url'];
      _phpbbforum_set_destination();
    }
    // When redirecting the user without a URL,
    // send them back to the current page instead of the homepage.
    if (empty($url)) {
      $url = $_GET['q'];
    }
    drupal_goto($url);
  }
}

function _phpbbforum_logout_external($redirect = '') {
  _phpbbforum_drupal_logout($redirect);
}

function _phpbbforum_user_delete($username) {
  $account = array_shift(user_load_multiple(array(), array('name' => $username)));
  if ($account) {
    user_cancel($account, $account->uid, $method = 'user_cancel_block' /* TODO Set this variable */);
  }
}

