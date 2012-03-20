<?php
// $Id: phpbb_api_hooks.php,v 1.9 2010/03/03 16:38:47 vb Exp $
/**
 * @file
 * @copyright  Copyright (C) 2007-2011 Vadim G.B. (http://vgb.org.ru)
 */

if (!defined('IN_PHPBB')) {
  die('Hacking attempt...');
}

// Hooks

function phpbb_hook_init() {
  global $phpbb_hook, $cache, $phpbb_root_path, $phpEx, $phpbb_hook;
  if (empty($phpbb_hook)) {
    $phpbb_hook = new phpbb_hook(array('exit_handler', 'phpbb_user_session_handler', 'append_sid', array('template', 'display')));

    foreach ($cache->obtain_hooks() as $hook) {
      @include_once($phpbb_root_path . 'includes/hooks/' . $hook . '.' . $phpEx);
    }
  }
}

function phpbb_hook_register(&$hook) {
  $hook->register('append_sid', 'phpbb_hook_append_sid');
  $hook->register('exit_handler', 'phpbb_hook_exit_handler');
}

/**
 * Append session id to url
 */
function phpbb_hook_append_sid(&$hook, $url, $params = false, $is_amp = true, $session_id = false) {
  global $_SID, $_EXTRA_URL;
  global $phpbb_config, $phpbb_root_path, $phpEx, $phpbb_hook,
	  $site_base_url, $site_phpbb_page, $site_forum_url, $_phpbb_integration_mode;

  // Get possible previous results
  $result = $hook->previous_hook_result('append_sid');

  //if ($_phpbb_integration_mode == 1)
  //	$phpbb_url = $site_forum_url;
  //else
  $phpbb_url = $phpbb_config['forum_url'];
  $phpbb_url .= '/';

  //$phpbb_url_len = strlen($phpbb_url);

  $phpbb_root_path_len = strlen($phpbb_root_path);
  if ($url[0] != '.' && substr($url, 0, $phpbb_root_path_len) == $phpbb_root_path && strpos($url, $phpbb_url) === false) {
    $url = $phpbb_url . substr($url, $phpbb_root_path_len);
  }
  // Assign sid if session id is not specified
  if ($session_id === false) {
    $session_id = $_SID;
  }

  $amp_delim = ($is_amp) ? '&amp;' : '&';
  $url_delim = (strpos($url, '?') === false) ? '?' : $amp_delim;

  // Appending custom url parameter?
  $append_url = (!empty($_EXTRA_URL)) ? implode($amp_delim, $_EXTRA_URL) : '';

  $anchor = '';
  if (strpos($url, '#') !== false) {
    list($url, $anchor) = explode('#', $url, 2);
    $anchor = '#' . $anchor;
  }
  else if (!is_array($params) && strpos($params, '#') !== false) {
    list($params, $anchor) = explode('#', $params, 2);
    $anchor = '#' . $anchor;
  }

  // Use the short variant if possible ;)
  if ($params === false) {
    // Append session id
    if (!$session_id) {
      return $url . (($append_url) ? $url_delim . $append_url : '') . $anchor;
    }
    else {
      return $url . (($append_url) ? $url_delim . $append_url . $amp_delim : $url_delim) . 'sid=' . $session_id . $anchor;
    }
  }

  // Build string if parameters are specified as array
  if (is_array($params)) {
    $output = array();

    foreach ($params as $key => $item) {
      if ($item === NULL) {
        continue;
      }

      if ($key == '#') {
        $anchor = '#' . $item;
        continue;
      }

      $output[] = $key . '=' . $item;
    }

    $params = implode($amp_delim, $output);
  }

  // Append session id and parameters (even if they are empty)
  // If parameters are empty, the developer can still append his/her parameters without caring about the delimiter
  return $url . (($append_url) ? $url_delim . $append_url . $amp_delim : $url_delim) . $params . ((!$session_id) ? '' : $amp_delim . 'sid=' . $session_id) . $anchor;
}

/**
 * Handler for exit calls in phpBB.
 */
function phpbb_hook_exit_handler(&$hook) {
  global $config;
  // Get possible previous results
  $result = $hook->previous_hook_result('exit_handler');

  // As a pre-caution... some setups display a blank page if the flush() is not there.
  //(empty($config['gzip_compress'])) ? @flush() : @ob_flush();

  global $_phpbb_result;

  $_phpbb_result['output'] = ob_get_clean();
  $_phpbb_result['status'] = 'exit';
  $_phpbb_result['url'] = '';

  _phpbbforum_set_result($_phpbb_result);

  throw new PhpbbVBridgeException('exit', VBridgeException::THROW_OUTPUT);

  return true;
}

////////////////////////////////////////////////////////////////////////

function phpbbforum_redirect($url, $time = 0) {
  global $_phpbb_result, $_phpbbforum_comments_mode;

  $url = _phpbbforum_replace_urls($url);

  if ($time <= 0) {
    $_phpbb_result['status'] = 'redirect';
    $_phpbb_result['meta_refresh'] = 0;
  }
  else {
    $_phpbb_result['status'] = 'meta_refresh';
    $_phpbb_result['meta_refresh'] = $time;
  }

  $destination = _phpbbforum_get_comments_destination();
  $query = $destination['query'];
  if (!empty($query['comments_mode'])) {
    $_phpbbforum_comments_mode = $query['comments_mode'];
  }
  else {
    $_phpbbforum_comments_mode = 0;
  }

  if ($_phpbbforum_comments_mode) {
    $_phpbbforum_comments_mode = 0;
    $query['comments_mode'] = $_phpbbforum_comments_mode;
    _phpbbforum_set_comments_destination('', $query);

    $url = _phpbbforum_comments_destination($url, $destination['url']);
  }

  $_phpbb_result['destination'] = $url;

  _phpbbforum_set_result($_phpbb_result);
  _phpbbforum_set_destination($url);

  if ($_phpbb_result['status'] == 'redirect') {
    _phpbbforum_goto($url);
  }

  return $url;
}


/**
 * _phpbbforum_hook
 */
function _phpbb_api_hook($name, $data = array()) {

  global $_phpbb_result;

  if (empty($name)) {
    return;
  }

  $data['name'] = $name;
  $_phpbb_result['hook'] = $data;
  $_phpbb_result['redirect'] = $data['redirect'];

  $fn = '_phpbb_api_hook_' . $name;
  if (function_exists($fn)) {
    $fn($data);
  }
}

/**
 * _phpbb_hook_user_delete
 */
/*
 function _phpbb_hook_user_delete($data = array()) {
 global $_phpbb_result;
 //_phpbbforum_user_delete();
 }
 */

/**
 * replaces cp_action.
 */
function _phpbbforum_replace_cp_action($p_class, $output) {

  global $phpEx;

  $output = str_replace('../index.' . $phpEx, $p_class . '.' . $phpEx, $output);
  //$output = str_replace('../index.php', $p_class .'.php', $output);
  $output = str_replace('&amp;', '&', $output);

  return $output;
}

/**
 * set cp action.
 */
function _phpbbforum_get_cp_action_request($action, $clear = true) {

  if (empty($action)) {
    $request = _phpbbforum_get_request();
    if (!empty($request)) {
      if (!empty($request['action'])) {
        $_REQUEST['action'] = $request['action'];
        if (is_array($request['action'])) {
          $action = key($request['action']);
        }
        else {
          $action = $request['action'];
        }
      }
      if ($clear) {
        _phpbbforum_set_request();
      }
    }
  }
  return $action;
}

/**
 * phpbb_get_embed_style
 */
function phpbb_get_embed_style($style_id) {
  global $_phpbb_integration_mode;
  if ($_phpbb_integration_mode != 2) {
    return $style_id;
  }
  $mode = 'style';

  $style_name = phpbb_get_style_name($mode, $style_id);
  if (!empty($style_name)) {
    $_embed = '-embed';
    if (strpos($style_name, $_embed) === false) {
      $style_name_embed = $style_name . $_embed;
      $id = phpbb_get_style_id($mode, $style_name_embed);
      if ($id != 0) {
        return $id;
      }
      $_embed = '_embed';
      if (strpos($style_name, $_embed) === false) {
        $style_name_embed = $style_name . $_embed;
        $id = phpbb_get_style_id($mode, $style_name_embed);
        if ($id != 0) {
          return $id;
        }
      }
    }
  }

  return $style_id;
}


//function msg_handler($errno, $msg_text, $errfile, $errline)
function phpbb_error_msg_handler($errno, $msg_text, $errfile, $errline) {
  global $_phpbb_result;

  // Do not display notices if we suppress them via @
  if (error_reporting() == 0) {
    return;
  }

  $_phpbb_result['errno'] = $errno;
  $_phpbb_result['error_msg'] = $msg_text;

  // If we notice an error not handled here we pass this back to PHP by returning false
  // This may not work for all php versions
  return false;
}
