<?php
// $Id: phpbbforum.pages.inc,v 1.22 2010/11/24 20:53:34 vb Exp $
/**
 * @file
 * User page callbacks for the forum module.
 * @copyright  Copyright (C) 2007-2011 Vadim G.B. (http://vgb.org.ru)
 */

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_page() {
  if (!_phpbbforum_settings()) {
    $message = _phpbbforum_page_disable_board_msg();
    if (!empty($message)) {
      return $message;
    }
    return '';
  }
  if ($_REQUEST['form_id'] == 'user_login_block' && $_REQUEST['op'] == 'Log in') {
    return '';
  }
  $query_string = _phpbbforum_page_get_query();
  parse_str($query_string, $query);
  $output = _phpbbforum_page($query_string, $query);
  return $output;
}

function _phpbbforum_page_get_query() {
  global $language;

  $path = urldecode(request_uri());
  $path = drupal_substr($path, drupal_strlen(base_path()));
  // i18n start by Subcomandante
  if (variable_get('phpbbforum_language', 0) && !empty($language->prefix)) {
    // Rebuild $path with the language removed.
    $prefix_ = $language->prefix . '/';
    $l = strlen($prefix_);
    if (substr($path, 0, $l) == $prefix_) {
      $path = substr($path, $l);
    }
  }

  if (!variable_get('clean_url', 0) && strpos($path, '?q=') === 0) {
    $path = preg_replace('/^\?q=/', '', $path, 1);
  }
  
  $query_string = "q=" . $path;

  $tags = array(
    '<iframe>',
    '</iframe>',
    '/iframe',
    '&lt;iframe&gt;',
    '&lt;/iframe&gt;',
    '<script>',
    '</script>',
    '&lt;script&gt;',
    '&lt;/script&gt;',
  );
  $query_string = str_replace($tags, '', $query_string);
  $query_string = check_plain($query_string);
  $query_string = str_replace('&amp;', '&', $query_string);
  // if (PHPBB_MODULE_DEBUG)
  //drupal_set_message('QUERY_STRING:'.$query_string .' q= '. $_GET['q']);
  return $query_string;
}

/**
 * prints board_disable_msg.
 */
function _phpbbforum_page_disable_board_msg() {
  global $phpbb_config, $phpbb_user, $user;
  if ($phpbb_config['board_disable'] && 
      ($phpbb_user->data['user_id'] != variable_get('phpbbforum_admin_user_id', 2) ||
        $user->uid != 1)) {
    drupal_set_title(t('Information'));
    $message = (!empty($phpbb_config['board_disable_msg'])) ? $phpbb_config['board_disable_msg'] :
      //t('Sorry but this board is currently unavailable.');
      t('This board is currently disabled.');
    return $message;
  }
  return '';
}

function _phpbbforum_page($phpbbaction, $query = array()) {
  global $phpbb_config, $phpbb_user, $user, $phpbb_root_path, $phpEx, $_phpbb_base_path,
    $site_base_url, $site_forum_url, $site_phpbb_page, $_phpbb_result, $_phpbb_embed_mode,
    $_phpbb_integration_mode, $_phpbb_acp_integration_mode, $_phpbbforum_comments_mode;

  phpbb_api_session_begin();
  
  $message = _phpbbforum_page_disable_board_msg();
  if (!empty($message)) {
    return $message;
  }

  $comments_mode = $_phpbbforum_comments_mode;

  $args = array(
    "/viewonline.php",
    "/memberlist.php",
    "/viewtopic.php",
    "/viewforum.php",
    "/posting.php",
    "/search.php",
    "/ucp.php",
    "/report.php",
    "/mcp.php",
    "/adm/index.php",
    "/index.php",
    "/faq.php",
    "/feed.php",
  );

  $isamp = false;
  $isamp1 = false;
  $strfound = false;

  $str = 'q=' . $site_phpbb_page;
  //$strq = $str;
  $len = strlen($str);
  $stra = $str . '&';
  $lena = $len + 1;
  if (substr($phpbbaction, 0, $lena) == $stra) {
    $phpbbaction = substr($phpbbaction, $lena);
    $isamp1 = true;
  }
  elseif (substr($phpbbaction, 0, $len) == $str) {
    $phpbbaction = substr($phpbbaction, $len);
  }
  //if (PHPBB_MODULE_DEBUG)
  //drupal_set_message('QUERY_STRING='.$phpbbaction);

  foreach ($args as $str) {
    $isamp = false;
    $len = strlen($str);
    $stra = $str . '&';
    $lena = $len + 1;
    if (substr($phpbbaction, 0, $lena) == $stra) {
      $phpbbaction = substr($phpbbaction, $lena);
      $isamp = true;
      $strfound = true;
      break;
    }
    elseif (substr($phpbbaction, 0, $len) == $str) {
      $phpbbaction = substr($phpbbaction, $len);
      $strfound = true;
      break;
    }
  }

  if (!$strfound) {
    $str = '';
  }
  //if (PHPBB_MODULE_DEBUG)
  //  drupal_set_message('pa='.$phpbbaction);

  $path = $phpbb_config['forum_url'];
  $phpbbforum_url = $site_forum_url;
  /*
   if (variable_get('clean_url', 0)) {
   $phpbbforum_url = $site_forum_url;
   }
   else {
   $phpbbforum_url = $site_base_url;
   $phpbbforum_url .= '/'. $strq;
   }
   */
  //if (PHPBB_MODULE_DEBUG)
  //  drupal_set_message('path='.$path);
  //if (PHPBB_MODULE_DEBUG)
  //  $path = "http://phpbb.vgb.net.ru";

  if ($strfound) {
    $path .= $str;
    $phpbbforum_url .= $str;
  }

  if ($phpbbaction != "") {
    if ($isamp1 || $isamp) {
      $qa = '?';
      /*
       if (variable_get('clean_url', 0)) {
       $qa = '?';
       }
       else {
       $qa = '&';
       }
       */
      $path .= $qa;
      $phpbbforum_url .= $qa;
    }
    $path .= $phpbbaction;
    $phpbbforum_url .= $phpbbaction;
  }

  /*
   //if (PHPBB_MODULE_DEBUG) {
   if ($isamp1 || $isamp)
   $amp = $qa;
   else
   $amp = '';
   //drupal_set_message('path='.$path.' str='.$str.' action='.$str.$amp.$phpbbaction);
   drupal_set_message('phpbbforum='.$phpbbforum_url);
   //}
   */
  //$output .= $path;
  //return $output;

  //drupal_set_message('1 str='.$str.' Frame='. $path);

  if ($str == '/adm/index.php') {
    if ($_phpbb_acp_integration_mode == '0') {
      drupal_goto($path);
    }
    elseif ($_phpbb_acp_integration_mode == '1') {
      return _phpbbforum_page_inframe($path);
    }
  }

  if ($_phpbb_integration_mode == '1') {
    return _phpbbforum_page_inframe($path);
  }

  $_phpbb_result = _phpbbforum_get_result();
  if (!empty($_phpbb_result)) {
    _phpbbforum_set_result();
  }

  if (isset($_phpbb_result['hook']) && $_phpbb_result['status'] == 'redirect') {
    // execute hook
    _phpbbforum_hook($_phpbb_result['hook']);

    unset($_phpbb_result['hook']);
  }
  if ($_phpbb_result['status'] == 'feed') {
    unset($_phpbb_result['feed']);
    if ($str == '/feed') {
      $str = '';
    }
  }

  if (phpbb_user_new_privmsg()) {
    //$url = $site_base_url .'/'. $site_phpbb_page .'/ucp.php?i=pm&mode=popup';
    //drupal_goto($url);
    $str = '/ucp.php';
    $_REQUEST['i'] = 'pm';
    $_REQUEST['mode'] = 'popup';
  }
  if (isset($_phpbb_result['status']) && $_phpbb_result['status'] == 'exit') {
    // get previous output
    $output = $_phpbb_result['output'];
  }
  else {

    $query['path'] = $str;
    $_phpbb_result['query'] = $query;
    $_phpbb_embed_mode['query'] = $query;
    $_phpbb_embed_mode['redirect'] = variable_get('phpbbforum_redirect', 0);
    $destination_prev = _phpbbforum_get_destination();
    _phpbbforum_set_destination($phpbbforum_url, $query);

    switch ($str) {

      case '/index.php':
      case '':
        _phpbbforum_set_comments_destination();
        $output = phpbb_api_index('/index.php');
        break;

      case '/viewforum.php':
        _phpbbforum_set_comments_destination();
        $output = phpbb_api_index($str);
        break;
      case '/viewtopic.php':
        //$query['path'] = $str;
        //_phpbbforum_set_destination($phpbbforum_url, $query);
        _phpbbforum_set_extra($query);

        $update_topic_view = false;
        $query_prev = $destination_prev['query'];
        //$start_prev = $query_prev['start'];
        $start = $query['start'];
        if ($query_prev['path'] != $str || $query_prev['t'] != $query['t'] || $query_prev['f'] != $query['f'] || !isset($start)) {
          $update_topic_view = true;
        }
        $_phpbb_embed_mode['update_topic_view'] = $update_topic_view;

        $output = phpbb_api_index($str);
        break;
      case '/viewonline.php':
        _phpbbforum_set_comments_destination();
        $output = phpbb_api_index($str);
        break;

      case '/memberlist.php':
        _phpbbforum_set_comments_destination();
        $output = phpbb_api_index($str);
        break;

      case '/ucp.php':
        //$query['path'] = $str;
        //_phpbbforum_set_destination($phpbbforum_url, $query);
        $output = phpbb_api_index($str);
        break;

      case '/mcp.php':
        $query_prev = $destination_prev['query'];
        $t = $query_prev['t'];
        if ($t) {
          $query['t'] = $t;
        }
        $query['path'] = $str;
        _phpbbforum_set_destination($phpbbforum_url, $query);
        _phpbbforum_set_extra($query);
        $request['action'] = $_REQUEST['action'];
        _phpbbforum_set_request($request);
        $output = phpbb_api_index($str);
        break;

      case '/search.php':
        $output = phpbb_api_index($str);
        break;

      case '/posting.php':
        $output = phpbb_api_index($str);
        break;

      case '/report.php':
        $output = phpbb_api_index($str);
        break;

      case '/faq.php':
        _phpbbforum_set_comments_destination();
        $output = phpbb_api_index($str);
        break;

      case '/feed.php':
        _phpbbforum_set_comments_destination();
        $output = phpbb_api_index($str);
        phpbbforum_feeds($output);

        break;

      default:
        $output = _phpbbforum_page_inframe($path);
        return $output;
    }

    $_phpbb_result = _phpbbforum_get_result();

    if (isset($_phpbb_result['hook'])) {
      // execute hook
      _phpbbforum_hook($_phpbb_result['hook']);
    }

  } //***

  if (!empty($output)) {
    $_phpbb_theme_base_path = $_phpbb_base_path . 'styles/' . $phpbb_user->theme['theme_path'];
    $output = theme('phpbbforum_style', array('style' => $phpbb_user->theme['theme_path'], 'phpbb_theme_path' => $_phpbb_theme_base_path, 'output' => $output));
    $_phpbb_result = _phpbbforum_set_result(array());
  }

  return $output;
}

/**
 * prints page in a iframe.
 */
function _phpbbforum_page_inframe($path) {

  // Added this to allow the iframe to resize dynamically according to the
  // page height. -- Daen
  drupal_add_js(drupal_get_path('module', PHPBB_DRUPAL_MODULE) . '/js/phpbbframe.js');

  $width = variable_get("phpbbforum_page_width", "100%");
  $height = variable_get("phpbbforum_page_height", "1024");
  $scrolling = variable_get("phpbbforum_page_scroll", 0);

  $output = '<iframe id="forumFrame" src="' . $path . '"'; // name="phpbbforum"';

  if ($width && $height) {
    $output .= ' width="' . $width . '"' . ' height="' . $height . '"';
  }
  $output .= ' frameborder="0" framespacing="0" marginwidth="0" marginheight="0" vspace="0" hspace="0"';
  if ($scrolling == 2) {
    $output .= ' scrolling="auto"';
  }
  elseif ($scrolling == 1) {
    $output .= ' scrolling="yes"';
  }
  else {
    $output .= ' style="display:none; width:' . $width . '"';
    //$output .= ' style="width:' . $width . '"' . ' height="' . $height . '"' . ' overflow:visible;' ;
    $output .= ' scrolling="no"';
  }
  $output .= ' allowtransparency="false"';

  $output .= '><p>' . t('Sorry your browser does not work') . '</p></iframe>';

  return $output;
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_feeds($output) {

  global $phpbb_config, $phpbb_root_path, $_phpbb_result;

  $phpbb_url = $phpbb_config['forum_url'] . '/';

  $output = str_replace($phpbb_root_path, $phpbb_url, $output);
  $output = _phpbbforum_replace_links($output);

  $_phpbb_result['output'] = '';
  $_phpbb_result['status'] = 'feed';
  $_phpbb_result['url'] = '';
  _phpbbforum_set_result($_phpbb_result);

  ob_start();
  print $output;
  ob_end_flush();

  exit();
}

/**
 * replaces forum url.
 */
function _phpbbforum_replace_forum_url($output) {
  global $phpbb_config, $site_forum_url;

  $phpbb_url = $phpbb_config['forum_url'];
  $output = str_replace($phpbb_url, $site_forum_url, $output);
  return $output;
}

/**
 * replaces block links.
 */
function _phpbbforum_replace_block_links($output) {
  $output = _phpbbforum_replace_forum_url($output);
  $output = _phpbbforum_restore_block_links($output);
  return $output;
}
/**
 * restore block links.
 */
function _phpbbforum_restore_block_links($output) {
  global $phpbb_config, $site_forum_url, $site_phpbb_page;

  $phpbb_url = $phpbb_config['forum_url'];

  // replace back phpbb images
  $frameurl = $site_forum_url;
  $imgsrc = '<img src="';
  $frameurl = $imgsrc . $frameurl;
  $phpbburl = $imgsrc . $phpbb_url;
  $output = str_replace($frameurl, $phpbburl, $output);

  $path = '/images';
  $frameurl = $site_forum_url . $path;
  $phpbburl = $phpbb_url . $path;
  $output = str_replace($frameurl, $phpbburl, $output);

  // replace relative phpbb images paths
  $relurl = '<img src="images';
  $phpbburl = '<img src="' . $phpbb_url . '/images';
  $output = str_replace($relurl, $phpbburl, $output);

  return $output;
}

/**
 * replaces links.
 */
function _phpbbforum_replace_links($output) {
  $output = _phpbbforum_replace_forum_url($output);
  $output = _phpbbforum_restore_links($output);
  return $output;
}

/**
 * restore links.
 */
function _phpbbforum_restore_links($output) {
  global $phpbb_config, $site_forum_url, $site_phpbb_page,
  $_phpbb_result, $_phpbb_embed_mode, $_phpbb_acp_integration_mode;

  $phpbb_url = $phpbb_config['forum_url'];
  //$str = $_phpbb_embed_mode['path'];

  // replace back phpbb images
  $frameurl = $site_forum_url;
  $imgsrc = '<img src="';
  $frameurl = $imgsrc . $frameurl;
  $phpbburl = $imgsrc . $phpbb_url;
  $output = str_replace($frameurl, $phpbburl, $output);

  $path = '/styles';
  $frameurl = $site_forum_url . $path;
  $phpbburl = $phpbb_url . $path;
  $output = str_replace($frameurl, $phpbburl, $output);

  $path = '/images';
  $frameurl = $site_forum_url . $path;
  $phpbburl = $phpbb_url . $path;
  $output = str_replace($frameurl, $phpbburl, $output);

  // replace relative phpbb images paths
  $relurl = '<img src="images';
  $phpbburl = '<img src="' . $phpbb_url . '/images';
  $output = str_replace($relurl, $phpbburl, $output);

  // Find a member in popup
  // No popup for
  //$mode = '/memberlist.php?mode=searchuser';
  $mode = '/memberlist.php?mode=searchuser&amp;form='; 
  $frameurl = $site_forum_url . $mode;
  $phpbburl = $phpbb_url . $mode;
  $output = str_replace($frameurl, $phpbburl, $output);
  
  //http://drupalbridge.org/forum/posting.php?mode=smilies&f=3
  $mode = '/posting.php?mode=smilies';
  $frameurl = $site_forum_url . $mode;
  $phpbburl = $phpbb_url . $mode;
  $output = str_replace($frameurl, $phpbburl, $output);

  if (/*$str == '/adm/index.php' &&*/ $_phpbb_acp_integration_mode == '0') {
    $mode = '/adm/index.php';
    $frameurl = $site_forum_url . $mode;
    $phpbburl = $phpbb_url . $mode;
    $output = str_replace($frameurl, $phpbburl, $output);
  }
  // Download
  $path = '/download';
  $frameurl = $site_forum_url . $path;
  $phpbburl = $phpbb_url . $path;
  $output = str_replace($frameurl, $phpbburl, $output);
  // gallery2
  $path = '/g2is.php';
  $frameurl = $site_forum_url . $path;
  $phpbburl = $phpbb_url . $path;
  $output = str_replace($frameurl, $phpbburl, $output);

  return $output;
}

/**
 * Internal function to split a path string into path, query and fragment.
 */
function _phpbbforum_split_path($path) {
  global $site_base_url;
  //$path = strtr($path, array('<front>' => variable_get('site_frontpage', 'node')));
  if (variable_get('clean_url', 0) && strpos($path, '?q=') === 0) {
    $path = preg_replace('/^\?q=/', '', $path, 1);
  }
  if (strpos($path, '?') === FALSE && strpos($path, '&') !== FALSE) {
    $path = preg_replace('/&/', '?', $path, 1);
  }

  $parsed = parse_url($path) + array(
    'query' => NULL,
    'fragment' => NULL,
  );
  $result = array(
    'path' => preg_replace('/[\?\#].*$/', '', $path),
    'query' => $parsed['query'],
    'fragment' => $parsed['fragment'],
  );
  return $result;
}

/**
 * replaces comments url.
 */
/*
 function _phpbbforum_replace_comments_url($output) {
 global $phpbb_config, $site_forum_url;

 $phpbb_url = $phpbb_config['forum_url'];
 $output = str_replace($phpbb_url, $site_forum_url, $output);
 return $output;
 }
 */

/**
 * creates comments destination url.
 */
function _phpbbforum_comments_destination($url, $destination_url) {
  global $site_base_url;

  $parsed = parse_url($url);
  if (!empty($parsed['fragment'])) {
    $fragment = '#' . $parsed['fragment'];
  }
  else {
    $fragment = '';
  }

  $url = $site_base_url . '/' . $destination_url . $fragment;

  return $url;
}

/**
 * creates posting destination url.
 */
function _phpbbforum_posting_destination($query) {
  global $site_base_url, $site_phpbb_page_lang, $site_forum_url, $phpbb_config, $_phpbb_integration_mode;

  if (!empty($query['f'])) {
    $f = '&f=' . $query['f'];
  }
  else {
    $f = '';
  }
  if (!empty($query['t'])) {
    $t = '&t=' . $query['t'];
  }
  else {
    $t = '';
  }

  if ($_phpbb_integration_mode == 2) {
    $url = $site_base_url . '/' . $site_phpbb_page_lang;
  }
  else {
    $url = $phpbb_config['forum_url'];
  }
  $url .= '/posting.php?mode=reply' . $f . $t;

  return $url;
}

/**
 * prints comment page in comments.
 */
function _phpbbforum_comment_render($node, $href, $render, &$query) {
  global $base_url, $language, $phpbb_root_path,
         $site_base_url, $site_phpbb_page, $site_forum_url, $_phpbb_integration_mode, $_phpbbforum_comments_mode;

  $output = '';

  $path_string = str_replace($site_base_url, '', $href);
  $path_string = str_replace('?', '&', $path_string);

  $query_string = str_replace($site_base_url . '/', 'q=', $href);
  $query_string = str_replace('?', '&', $query_string);

  $path = $path_string;
  $path = drupal_substr($path, drupal_strlen(base_path()));

  if (variable_get('phpbbforum_language', 0) && !empty($language->prefix)) {
    // Rebuild $path with the language removed.
    $prefix_ = $language->prefix . '/';
    $l = strlen($prefix_);
    if (substr($path, 0, $l) == $prefix_) {
      $path = substr($path, $l);
    }
    $query_string = "q=" . $path;
  }

  $path_parsed = _phpbbforum_split_path($path);
  $path_pquery = $path_parsed['query'];

  parse_str($query_string, $query);

  if ($render) {
    $comment_query = array();
    $comment_query['comments_mode'] = $_phpbbforum_comments_mode = 1;
    $comment_query['q'] = $_REQUEST['q'];
    _phpbbforum_set_comments_destination($comment_query['q'], $comment_query);

    $request = array();
    foreach ($query as $key => $val) {
      $request[$key] = $val;
      $_REQUEST[$key] = $val;
    }

    $output = _phpbbforum_page($query_string, $query);

    foreach ($request as $key => $val) {
      $_REQUEST[$key] = $val;
    }
  }

  return $output;
}

/**
 * sets extra vars.
 */
function _phpbbforum_set_extra($query) {
  global $forum_id, $topic_id, $post_id, $user_id;

  if ($query['f']) {
    $forum_id = $query['f'];
  }
  if ($query['t']) {
    $topic_id = $query['t'];
  }
  if ($query['p']) {
    $post_id = $query['p'];
  }
  if ($query['u']) {
    $user_id = $query['u'];
  }
}


